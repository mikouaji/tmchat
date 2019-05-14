<?php
/**
 * Created by PhpStorm.
 * User: mikouaji
 * Date: 2/19/19
 * Time: 10:34 AM
 */

namespace app\core\services;


class Redirect
{
	public function go($url, $code=302)
	{
		if(strpos($url, "http")!==FALSE)
			redirect($url);
		else
			redirect($url, 'location', $code);
	}
}
