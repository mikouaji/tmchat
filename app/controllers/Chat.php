<?php

use app\core\APP_Controller as Controller;

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

    public function logout(){
        $this->view->disable();
        $this->service->auth->logout();
        $this->service->redirect->go("/");
    }
}