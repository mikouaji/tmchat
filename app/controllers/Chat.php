<?php

use app\core\APP_Controller as Controller;
use app\libraries\SocketManager;

class Chat extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view->setLayout("chat");
    }

    public function index(){
        $this->view->user = $this->service->auth->getLoggedUser();
    }

    public function upload(){
        $this->view->disable(FALSE);
        //todo
    }

    public function test(){
        //testowanie socketow
		$this->view->disable();
		$manager = new SocketManager();
		var_dump($manager->create("asdff", 33));
//		var_dump($manager->start("asdff"));
//
//		var_dump($manager->testMessage("test papa phpa222"));
//
//		var_dump($manager->stop("asdff"));
//		$manager->delete('asdff');
//		die();
    }

    public function logout(){
        $this->view->disable();
        $this->service->auth->logout();
        $this->service->redirect->go("/");
    }
}