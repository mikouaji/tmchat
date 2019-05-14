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
     * @return string
     */
	public function getType() : string{
	    return $this->type;
    }

}
