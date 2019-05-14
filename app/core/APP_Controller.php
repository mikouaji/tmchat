<?php
/**
 * Created by PhpStorm.
 * User: mikouaji
 * Date: 2/1/19
 * Time: 3:08 PM
 */

namespace app\core;

use app\libraries\View;
use app\libraries\Assets;
use app\libraries\Twig;
use app\libraries\ACL;
use app\libraries\ServiceProvider;

use app\core\services\Auth;
use app\core\services\FlashMessage;
use app\core\services\Redirect;
use app\core\services\Hash;
use app\core\services\Mail;

class APP_Controller extends \CI_Controller
{
	private $acl;
	private $twig;

	protected $assets;
	protected $service;
	protected $view;

	protected $controller;
	protected $action;

	public function __construct()
	{
		parent::__construct();

		$this->controller = strtolower($this->router->fetch_class());
		$this->action = strtolower($this->router->fetch_method());

		$this->service = new ServiceProvider();
		$this->service->add(new Hash(),'hash')->add(new Auth($this->session, $this->service->hash), 'auth')
			->add(new FlashMessage($this->session),'flash')
			->add(new Redirect(), 'redirect')
			->add(new Mail($this->email), 'mail');

		$this->acl = new ACL();
		$this->_checkAccess();

		$this->assets = new Assets();
		$this->twig = new Twig($this->config->item('twig_functions'));
		$this->view = new View($this->output);

		$this->view->controller = $this->controller;
		$this->view->action = $this->action;
	}

	public function _output($output)
	{
		//render view
		if($this->view->enabled())
		{
			$this->view->setView($this->controller."/".$this->action);
			$params = [
				'page'=>$this->view->getView(),
				'data'=>$this->view->getData(),
				'styles'=>$this->assets->getStyles(),
				'scripts'=>$this->assets->getScripts(),
				'helpers'=>$this->view->getHelpers(),
			];
			if($this->service->exists('flash'))
				$params['flashMessages'] = $this->service->flash->get();

			$output = $this->twig->render($this->view->getLayout(), $params);
		}

		//render json response
		if($this->view->hasJsonResponse())
		{
			$jsonData = $this->view->getJsonResponse();
			$this->output->set_content_type('application/json')
				->set_output(json_encode($jsonData['data']))
				->set_status_header($jsonData['code']);
			if(!$this->view->profilerEnabled())
				echo $this->output->get_output();
		}

		echo $output;

		//show profiler
		if($this->view->profilerEnabled())
			echo $this->view->getProfiler();
	}

	private function _checkAccess()
	{
		$access = $this->acl->isAllowed($this->service->auth->getType(),$this->controller, $this->action);
		if(!$access['allowed']) {
			$this->service->flash->add('Access denied.', FlashMessage::INFO);
			$this->service->redirect->go($access['redirect']);
		}
	}
}
