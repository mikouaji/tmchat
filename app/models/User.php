<?php
/**
 * Created by PhpStorm.
 * User: mikouaji
 * Date: 2/15/19
 * Time: 2:27 PM
 */

namespace app\models;

use app\core\APP_Model as Model;

class User extends Model
{
	protected $table = 'users';

	const HASH_SALT = 'user';

	const GUEST = "GUEST";
	const MEMBER = "MEMBER";
	const ADMIN = "ADMIN";

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
		return [
		    'id' => $this->hideId(self::HASH_SALT)->getId(),
		    'login' => $this->getLogin(),
        ];
	}

    /**
     * @param string $token
     * @return User
     */
	public function setRememberToken(string $token) : User {
	    $this->remember_token = $token;
	    return $this;
    }

    /**
     * @return string|NULL
     */
	public function getRememberToken() {
	    return $this->remember_token;
    }


    /**
     * @param bool $rememeber
     * @return User
     */
	public function setRemember(bool $rememeber) : User {
	    $this->remember = $rememeber;
	    return $this;
    }

    /**
     * @return bool
     */
	public function getRemember() : bool {
	    return $this->remember;
    }

    /**
     * @param Topic $topic
     * @return User
     */
	public function setLastTopic(Topic $topic) : User {
	    $this->last_topic = $topic->getRealId();
	    return $this;
    }

    /**
     * @return Topic|NULL
     */
    public function getLastTopic(){
	    return Topic::findOne($this->last_topic);
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password) : User {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
	public function getPassword() : string {
	    return $this->password;
    }

    /**
     * @return string
     */
	public function getLogin() : string {
	    return $this->login;
    }

    /**
     * @param string $login
     * @return User
     */
    public function setLogin(string $login) : User {
	    $this->login = $login;
	    return $this;
    }

    /**
     * @return string
     */
	public function getType() : string{
	    return $this->type;
    }

}
