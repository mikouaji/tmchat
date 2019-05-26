<?php


namespace app\models;

use app\core\APP_Model as Model;


class Visit extends Model
{
    protected $table = 'topic_visits';

    /**
     * @return User
     */
    public function getUser() : User {
        return User::findOne($this->user);
    }

    /**
     * @param User $user
     * @return Visit
     */
    public function setUser(User $user) : Visit{
        $this->user = $user->getRealId();
        return $this;
    }

    /**
     * @return Topic
     */
    public function getTopic() : Topic{
        return Topic::findOne($this->topic);
    }

    /**
     * @param Topic $topic
     * @return Visit
     */
    public function setTopic(Topic $topic) : Visit{
        $this->topic = $topic->getRealId();
        return $this;
    }

    /**
     * @return string|NULL
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * @param string $date
     * @return Visit
     */
    public function setDate(string $date) : Visit{
        $this->date = $date;
        return $this;
    }

}