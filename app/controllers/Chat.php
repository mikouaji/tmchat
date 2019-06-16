<?php

use app\core\APP_Controller as Controller;

use app\core\repositories\ChatRepository;
use app\models\User;
use app\core\services\FlashMessage;

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

    public function settings(){
        $this->view->setLayout('default');
        $user = $this->service->auth->getLoggedUser();
        if($this->form_validation->run('settings')!==FALSE){
            $formData = $this->input->post();
            $login = $user->getLogin();
            if(is_null(User::findOne(['login'=>$formData['login']])))
                $login = $formData['login'];
            elseif($formData['login']!==$user->getLogin())
                    $this->service->flash->add("this login is taken", FlashMessage::DANGER);

            $token = NULL;
            if(isset($formData['remember']) && $formData['remember'] === 'yes'){
                $token = $this->service->auth->generateAndSetRememberToken($user);
                $remember = TRUE;
            }else
                $remember = FALSE;

            if(!empty($formData['password']))
                $user->setPassword($this->service->auth->hashPassword($formData['password']));

            $success = $user->setLogin($login)
                ->setRemember($remember)
                ->setRememberToken($token)
                ->save();
            if($success)
                $this->service->flash->add('data saved', FlashMessage::SUCCESS);
        }
        $this->view->user = $user;
    }

    public function upload(){
        $this->view->disable(FALSE);
        $config = config_item('upload');
        $form = $this->input->post();
        $responseData = [
            'csrf' => [
                'name'=>$this->security->get_csrf_token_name(),
                'value'=>$this->security->get_csrf_hash(),
            ],
        ];
        $this->form_validation->set_data($form);
        if($this->form_validation->run('attachment') !== FALSE){
            $this->load->library('upload', $config[$form['type']]);
            if(!$this->upload->do_upload('files')){
                $responseData['messages'] = [$this->upload->display_errors("","")];
                $responseCode = 400;
            }else{
                $cr = new ChatRepository($this->service->auth);
                $file = $cr->saveFile(
                    $this->upload->data('file_name'),
                    $this->upload->data('file_size'),
                    $form['type'],
                    $form['label']
                );
                $responseData['obj'] = [
                  'id'=>$file->hideId()->getId(),
                  'type'=>$file->getType(),
                  'name'=>$file->getLabel(),
                  'size'=>$file->getSize(),
                ];
                $responseCode = 200;
            }
        }else{
            $responseData['messages'] = [$this->form_validation->error_string()];
            $responseCode = 400;
        }
        $this->view->setJsonResponse($responseData, $responseCode);
    }

    public function logout(){
        $this->view->disable();
        $this->service->auth->logout();
        $this->service->redirect->go("/");
    }
}