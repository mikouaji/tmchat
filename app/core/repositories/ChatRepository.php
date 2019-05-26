<?php

namespace app\core\repositories;

use app\core\services\Auth;
use app\models\Message;
use app\models\Topic;
use app\models\User;
use app\models\Visit;
use app\models\File;
use app\libraries\SocketManager;

class ChatRepository extends Repository
{
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
        $this->model = new Topic();
    }

    /**
     * @param object $data
     * @return bool
     * @throws \Exception
     */
    public function sendMessage(object $data) : bool {
        $user = $this->auth->getLoggedUser();
        $topic = $user->getLastTopic();
        $text = $data->value;
        $files = $data->files;
        $message = new Message();
        $message->setUser($user)
            ->setTopic($topic)
            ->setValue($text)
            ->save();
        $this->updateVisitTime($topic->getRealId());
        foreach($files as $file){
            $this->addFile($file, $message);
        }
        $response = [
            'topic' => $topic->hideId(Topic::HASH_SALT)->getId(),
            'message' => Message::findOne($message->getRealId())->toArray(),
        ];
        return SocketManager::message($response);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getFiles() : array{
        $output = [
            File::TYPE_URL => [],
            File::TYPE_IMG => [],
            File::TYPE_DOC => [],
        ];
        $files = File::findAll();
        foreach($files as $file){
            $output[$file->getType()][] = $file->toArray();
        }
        return $output;
    }

    /**
     * @param object $file
     * @param Message $message
     */
    public function addFile($file, Message $message){
        switch(strtoupper($file->type)){
            case File::TYPE_URL: $this->addUrl($file->value, $file->href, $message); break;
        }
    }

    /**
     * @param string $label
     * @param string $url
     * @param Message $message
     */
    private function addUrl(string $label, string $url, Message $message){
        $file = new File();
        $file->setMessage($message)
            ->setLabel($label)
            ->setPath($url)
            ->setType(File::TYPE_URL)
            ->save();
    }

    private function addDoc(){

    }

    private function addImg(){

    }

    /**
     * @param int $topicId
     * @param bool $earlier
     * @return bool
     * @throws \Exception
     */
    public function updateVisitTime(int $topicId, bool $earlier = FALSE) : bool{
        $date = new \DateTime();
        if(!$earlier)
            $date->add(new \DateInterval("PT1S"));
        return Visit::findOne(['user'=>$this->auth->getId(), 'topic'=>$topicId])->setDate($date->format("Y-m-d H:i:s"))->save();
    }

    /**
     * @param string $name
     * @return Topic|null
     * @throws \Exception
     */
    public function addTopic(string $name){
        $topic = new Topic();
        if($topic->setName($name)->save()){
            $users = User::findAll();
            foreach($users as $user){
                $visit = new Visit();
                $visit->setTopic($topic)
                    ->setUser($user)
                    ->save();
            }
            return $topic;
        }
        return NULL;

    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getTopicsWithCurrentAndUnread() : array{
        $output = [];
        $user = $this->auth->getLoggedUser();
        $query = $this->model->db
            ->query("SELECT t.* 
                    FROM topics t LEFT JOIN topic_visits v 
                    ON t.id = v.topic 
                    WHERE user = 1 
                    ORDER BY v.date DESC, t.id DESC");
        foreach($query->result('app\models\Topic') as $topic){
            $topic->hideId(Topic::HASH_SALT);
            $active = $topic->getRealId() === $user->getLastTopic()->getId();
            $temp = $topic->toArray($active);
            $temp['active'] = $active;
            $temp['unread'] = $this->getUnreadCount($topic, $user);
            Topic::MAIN == $topic->getName() ? array_unshift($output, $temp) : $output[] = $temp;
        }
        return $output;
    }

    /**
     * @param Topic $topic
     * @param User $user
     * @return int
     */
    private function getUnreadCount(Topic $topic, User $user) : int{
        $date = Visit::findOne([
                'topic'=>$topic->getRealId(),
                'user'=>$user->getRealId()
        ])->getDate();
        $message = new Message();
        $query = $message->find()->where('topic', $topic->getRealId());
        if(!is_null($date))
            $query->where("sent >", $date);
        return $message->count();
    }
}