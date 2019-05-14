<?php
/**
 * Created by PhpStorm.
 * User: mikouaji
 * Date: 2/22/19
 * Time: 5:25 PM
 */

namespace app\core;


interface REST_ControllerInterface
{
	public function get($id = NULL);

	public function post();

	public function delete($id);

	public function patch();

	public function put();

	public function error();
}
