<?php
/**
 * Created by PhpStorm.
 * User: mikouaji
 * Date: 2/15/19
 * Time: 10:36 AM
 */

namespace app\libraries;

class ServiceProvider
{
	protected $loadedServices = [];

	/**
	 * @param mixed $object
	 * @param string $name
	 * @return ServiceProvider
	 */
	public function add($object, string $name) : ServiceProvider
	{
		$this->loadedServices[] = $name;
		$this->$name = $object;
		return $this;
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function exists(string $name) : bool
	{
		return in_array($name, $this->loadedServices);
	}
}
