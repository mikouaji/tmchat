<?php


namespace app\models;

use app\core\APP_Model as Model;

class File extends Model
{
    protected $table = 'files';

    const HASH_SALT = 'file';

    const TYPE_URL = "URL";
    const TYPE_IMG = "IMG";
    const TYPE_DOC = "DOC";

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

    public function toArray(bool $full = TRUE)
    {
        $array = [
            'id' => $this->hideId(self::HASH_SALT)->getId(),
            'created'=> $this->getCreatedDate(),
            'type' => $this->getType(),
            'path' => $this->getPath(),
            'size' => $this->getSize(),
            'label' => $this->getLabel(),
        ];
        if($full)
            $array['message'] = is_null($this->getMessage()) ? NULL : $this->getMessage()->hideId()->getId();
        return $array;
    }

    public function setMessage(Message $message) : File{
        $this->message = $message->getRealId();
        return $this;
    }

    /**
     * @param float $size
     * @return File
     */
    public function setSize(float $size) : File {
        $this->size = $size;
        return $this;
    }

    /**
     * @return float|NULL
     */
    public function getSize() {
        return $this->size;
    }

    /**
     * @return Message|NULL
     */
    public function getMessage() {
        return is_null($this->message) ? NULL : Message::findOne($this->message);
    }

    public function message(){
        return $this->hasOne('app\models\Message', 'id', 'message');
    }

    /**
     * @return string
     */
    public function getCreatedDate() : string {
        return $this->added;
    }

    /**
     * @param string $type
     * @return File
     */
    public function setType(string $type) : File {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getType() : string {
        return $this->type;
    }

    /**
     * @param string $path
     * @return File
     */
    public function setPath(string $path) : File {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath() : string {
        return $this->path;
    }

    /**
     * @param string $label
     * @return File
     */
    public function setLabel(string $label) : File {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel() : string {
        return $this->label;
    }
}