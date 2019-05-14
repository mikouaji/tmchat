<?php
/**
 * Created by PhpStorm.
 * User: mikouaji
 * Date: 2/1/19
 * Time: 3:02 PM
 */


use app\core\APP_Controller as Controller;
use app\core\services\FlashMessage;
use app\models\User;

class Home extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->view->setLayout('default');;
	}

	public function index()
	{
        if($this->form_validation->run('login')!==FALSE){
            $formData = $this->input->post();
            $user = User::findOne(['login'=>$formData['login']]);
            if($user and $this->service->auth->checkPassword($user, $formData['password'])){
                $this->service->auth->login($user);
                $this->service->redirect->go('chat');
            }else{
                $this->service->flash->add("Incorrect credentials", FlashMessage::DANGER);
            }
        }
	}
}
