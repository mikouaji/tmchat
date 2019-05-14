<?php


namespace app\core\repositories;
use app\models\Topic;

class ChatRepository extends Repository
{
    public function __construct()
    {
        $this->model = new Topic();
    }
}