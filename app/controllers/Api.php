<?php

use app\core\REST_Controller as Controller;
use app\core\repositories\ChatRepository;

class Api extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->repository = new ChatRepository();
    }

    public function get($id = null){
        $responseData = [
            'obj' => [],
            'messages' => ['Error getting data.'],
        ];
        $responseCode = 400;
        $data = $this->repository->findAll();
        if(!is_null($data)){
            $response = [];
            foreach($data as $topic){
                $response[] = $topic->toArray(TRUE);
            }
            $responseData =[
                'obj' => $response,
                'messages' => ['OK']
            ];
            $responseCode = 200;
        }
        $this->view->setJsonResponse($responseData, $responseCode);
    }
}