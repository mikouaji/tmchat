<?php
/**
 * Created by PhpStorm.
 * User: mikouaji
 * Date: 2/22/19
 * Time: 1:48 PM
 */

namespace app\core\services;

use Hashids\Hashids;

class Hash
{
	private $length;
	private $alphabet;
	private $salts = [];
	private $hashids = [];

	public function __construct()
	{
		$config = config_item('hashids');
		$this->length = $config['length'];
		$this->alphabet = $config['alphabet'];
		$this->salts = $config['salts'];
	}

	/**
	 * @param int $id
	 * @param string $type
	 * @return string
	 */
	public function encode(int $id, string $type) : string
	{
		return $this->get($type)->encode($id);
	}

	/**
	 * @param string $hash
	 * @param string $type
	 * @return int|null
	 */
	public function decode(string $hash, string $type)
	{
		$decoded = $this->get($type)->decode($hash);
		return (!empty($decoded)) ? $decoded[0] : NULL;
	}

	/**
	 * @param string $type
	 * @return Hashids
	 */
	private function get(string $type) : Hashids
	{
		if(!isset($this->hashids[$type]))
			$this->hashids[$type] = new Hashids($this->salts[$type], $this->length, $this->alphabet);
		return $this->hashids[$type];
	}
}
