<?php


namespace app\models;

use app\core\APP_Model as Model;

class Message extends Model
{
    protected $table = 'messages';

    const HASH_SALT = 'message';

    /**
     * @param string $hashSalt
     * @return Model
     */
    public function hideId($hashSalt = NULL) : Model
    {
        if(is_null($hashSalt))
            $hashSalt = self::HASH_SALT;
        return parent::hideId($hashSalt);
    }

    public function toArray()
    {
        $files = $this->getFiles();
        foreach($files as &$file)
            $file = $file->toArray(FALSE);
        return [
            'id'=> $this->hideId(self::HASH_SALT)->getId(),
            'value'=>$this->getValue(),
            'sent'=>$this->getSentDate(),
            'author'=>$this->getUser()->getLogin(),
            'files'=> $files,
        ];
    }

    /**
     * @return array
     */
    public function getFiles() {
        return $this->files;
    }

    public function files(){
        return $this->hasMany("app\models\File", 'message', 'id');
    }

    /**
     * @param Topic $topic
     * @return Message
     */
    public function setTopic(Topic $topic) : Message{
        $this->topic = $topic->getRealId();
        return $this;
    }

    /**
     * @return Topic
     */
    public function getTopic() : Topic{
        return Topic::findOne($this->topic);
    }

    public function topic(){
        return $this->hasOne("app\models\Topic", 'id', 'topic');
    }

    /**
     * @param User $user
     * @return Message
     */
    public function setUser(User $user) : Message{
        $this->user = $user->getRealId();
        return $this;
    }

    /**
     * @return User
     */
    public function getUser() : User {
        return User::findOne($this->user);
    }

    public function user(){
        return $this->hasOne('app\models\User', 'id', 'user');
    }

    /**
     * @return string
     */
    public function getSentDate() : string {
        return $this->sent;
    }

    /**
     * @param string $value
     * @return Message
     */
    public function setValue(string $value) : Message {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue() : string {
        return $this->value;
    }

}