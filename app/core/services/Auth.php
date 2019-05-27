<?php
/**
 * Created by PhpStorm.
 * User: mikouaji
 * Date: 2/12/19
 * Time: 10:32 PM
 */

namespace app\core\services;

use app\models\User;

class Auth
{
	const LOST_PWD_CODE_LEN = 40;
	const ACTIVATE_CODE_LEN = 40;
	const HASH_SALT = 'auth';

	protected $session;

	public $logged = 0;
	public $type;
	public $id = 0;

	private $hash;

	public function __construct(\CI_Session $session, Hash $hash)
	{
		$this->session = $session;
		$this->hash = $hash;
		if(!$this->_hasSessionData())
			$this->type = User::GUEST;
	}

	public function getHashService(){
	    return $this->hash;
    }

	public function generatePassword() : string
	{
		return $this->hash->encode(rand(0,10000)*3, self::HASH_SALT);
	}

	public function checkPassword(User $user, $plainPassword) : bool
	{
		return password_verify($plainPassword, $user->getPassword());
	}

	public function hashPassword(string $plainPassword) : string
	{
		return password_hash($plainPassword, PASSWORD_BCRYPT);
	}

	/**
	 * @return int|null
	 */
	public function getId()
	{
		return $this->hash->decode($this->id, self::HASH_SALT);
	}

	/**
	 * @return User
	 */
	public function getLoggedUser() : User
	{
		$user = new User();
		return $user->findOne($this->getId());
	}

	/**
	 * @return bool
	 */
	public function isLogged(): bool
	{
		return $this->logged;
	}

	/**
	 * @return string
	 */
	public function getType(): string
	{
		return $this->type;
	}

	private function _checkRememberCookie()
	{
		return false;
	}

	private function _hasSessionData() : bool
	{
		if($this->session->has_userdata('logged') and $this->session->userdata('logged')===1)
		{
			$this->set(
				$this->hash->decode($this->session->userdata('id'), self::HASH_SALT),
				$this->session->userdata('type')
			);
			return true;
		}else{
			return false;
		}
	}

	public function login(User $user)
	{
		$this->set($user->getId(), $user->getType());
	}

	public function set($userId, $userType)
	{
		$idHash = $this->hash->encode($userId,self::HASH_SALT);
		$this->logged = 1;
		$this->id = $idHash;
		$this->type = $userType;
		$this->session->set_userdata([
			'id'=>$idHash,
			'type'=>$userType,
			'logged'=>1,
		]);
	}

	public function logout()
	{
		$this->clear();
	}

	public function clear()
	{
		$this->id = $this->hash->encode(0,self::HASH_SALT);
		$this->type = User::GUEST;
		$this->logged = 0;
		$this->session->unset_userdata(['id','logged','type']);
	}
}
