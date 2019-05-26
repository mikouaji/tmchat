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
        $socketCfg = config_item('socket');
        $this->view->socketAddr = $socketCfg['address']. ":" . $socketCfg['port'];
    }

    public function upload(){
        $this->view->disable(FALSE);
        echo "TODO";
        //todo
    }

    public function logout(){
        $this->view->disable();
        $this->service->auth->logout();
        $this->service->redirect->go("/");
    }
}