<?php
/**
 * Created by PhpStorm.
 * User: mikouaji
 * Date: 2/15/19
 * Time: 1:11 PM
 */

namespace app\core;

use app\core\services\Hash;
use yidas\Model;

class APP_Model extends Model
{
	protected $primaryKey = 'id';
	protected $timestamps = FALSE;

	private $hashId = '';
	private $hideId = FALSE;

	/**
	 * @return int
	 */
	public function getRealId() : int
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getHashId() : string
	{
		return $this->hashId;
	}

	public function getId()
	{
		return $this->hideId ? $this->getHashId() : $this->getRealId();
	}

	/**
	 * @param int $id
	 * @return APP_Model
	 */
	public function setRealId(int $id): APP_Model
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * @param string $hashId
	 * @return APP_Model
	 */
	public function setHashId(string $hashId) : APP_Model{
		$this->hashId = $hashId;
		return $this;
	}

	/**
	 * @param $id
	 * @return APP_Model
	 */
	public function setId($id) : APP_Model
	{
		$this->hideId ? $this->setHashId($id) : $this->setRealId($id);
		return $this;
	}

	public function showId() : APP_Model
	{
		$this->hideId = FALSE;
		return $this;
	}

	public function hideId($hashSalt) : APP_Model
	{
		$this->hideId = TRUE;
		$hash = new Hash();
		$this->setId($hash->encode($this->getRealId(), $hashSalt));
		return $this;
	}
}
