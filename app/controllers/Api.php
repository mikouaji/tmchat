<?php

use app\core\REST_Controller as Controller;
use app\core\repositories\ChatRepository;
use app\models\Topic;

class Api extends Controller
{
    const PUT_TOPIC = 'topic';
    const PUT_MESSAGE = 'message';

    public function __construct()
    {
        parent::__construct();
        $this->repository = new ChatRepository($this->service->auth);
    }

    public function get($id = null){
        if(!is_null($id)) {
            $user = $this->service->auth->getLoggedUser();

            if(!is_null($user->getLastTopic()))
                $this->repository->updateVisitTime($user->getLastTopic()->getRealId(), TRUE);

            $topicId = $this->service->hash->decode($id, Topic::HASH_SALT);
            if (!is_null($topicId)) {
                $this->repository->updateVisitTime($topicId);
                $user->setLastTopic(Topic::findOne($topicId))->save();
            }
        }
        $data = $this->repository->getTopicsWithCurrentAndUnread();
        $responseData =[
            'obj' => $data,
            'messages' => ['ok']
        ];
        $responseCode = 200;
        $this->view->setJsonResponse($responseData, $responseCode);
    }

    public function put(){
        $responseData =[
            'obj' => [],
            'messages' => ['error getting data']
        ];
        $responseCode = 400;
        $data = json_decode($this->input->raw_input_stream);
        $this->form_validation->set_data((array)$data);
        if($data->type === self::PUT_TOPIC)
            if($this->form_validation->run("addTopic") !== FALSE){
                $data = $this->repository->addTopic($data->name);
                $data = $data->toArray();
                $responseData =[
                    'obj' => $data,
                    'messages' => ['ok']
                ];
                $responseCode = 200;
            }else{
                $responseData['obj'] = $data->name;
                $responseData['messages'] = [$this->form_validation->error_string()];
            }

        $this->view->setJsonResponse($responseData, $responseCode);
    }
}