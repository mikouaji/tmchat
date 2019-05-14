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
		return [];
	}

}
