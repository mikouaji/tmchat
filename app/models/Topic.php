<?php


namespace app\models;

use app\core\APP_Model as Model;

class Topic extends Model
{
    protected $table = 'topics';

    const HASH_SALT = 'topic';

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

    public function toArray(bool $full = FALSE)
    {
        $array = [
            'id' => $this->hideId(self::HASH_SALT)->getId(),
            'name' => $this->getName(),
            'lastMessage' => $this->getLastMessageDate(),
        ];
        if($full){
            $temp = $this->getMessages();
            foreach($temp as &$item)
                $item = $item->hideId(Message::HASH_SALT)->toArray();
            $array['messages'] = $temp;
        }
        return $array;
    }

    /**
     * @return array
     */
    public function getMessages() : array {
        return $this->messages;
    }

    public function messages(){
        return $this->hasMany("app\models\Message", "topic" , "id");
    }

    /**
     * @param string $date
     * @return Topic
     */
    public function setLastMessageDate(string $date) : Topic {
        $this->last_message = $date;
        return $this;
    }

    /**
     * @return string|NULL
     */
    public function getLastMessageDate() {
        return $this->last_message;
    }

    /**
     * @param string $name
     * @return Topic
     */
    public function setName(string $name) : Topic {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName() : string {
        return $this->name;
    }
}