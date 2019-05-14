<?php
/**
 * Created by PhpStorm.
 * User: mikouaji
 * Date: 2/22/19
 * Time: 5:22 PM
 */

namespace app\core;

use app\core\APP_Controller as Controller;
use app\core\REST_ControllerInterface as REST_Interface;

class REST_Controller extends Controller implements REST_Interface
{
	const ERROR_ACTION = "error";
	protected $repository;

	public function __construct()
	{
		parent::__construct();
		$this->view->disable(FALSE);
		if($this->action!==self::ERROR_ACTION and $this->input->method()!==$this->action) {
			$this->service->redirect->go($this->controller.'/error');
		}
	}

	public function get($id = NULL)
	{
		$this->view->setJsonResponse(FALSE);
	}

	public function post()
	{
		$this->view->setJsonResponse(FALSE);
	}

	public function patch()
	{
		$this->view->setJsonResponse(FALSE);
	}

	public function put()
	{
		$this->view->setJsonResponse(FALSE);
	}

	public function delete($id)
	{
		$this->view->setJsonResponse(FALSE);
	}

	public function error()
	{
		$this->view->setJsonResponse(['messages'=>["access denied"]], 401);
	}
}
