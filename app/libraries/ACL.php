<?php
/**
 * Created by PhpStorm.
 * User: mikouaji
 * Date: 2/13/19
 * Time: 4:14 PM
 */

namespace app\libraries;

class ACL
{
	private $enabled = FALSE;
	private $defaultRedirect = "/";
	private $rules;

	public function __construct()
	{
		$config = config_item('acl');
		$this->enabled = $config['enabled'];
		$this->defaultRedirect = $config['default_redirect'];
		$this->rules = $config['rules'];
	}

	public function isAllowed($userType, $controller, $action)
	{
		if(!$this->enabled)
			return ['allowed'=>TRUE, 'redirect'=>NULL];
		return in_array($userType, $this->rules[$controller][$action]['allow'])
			? ['allowed'=>TRUE, 'redirect'=>NULL]
			: ['allowed'=>FALSE, 'redirect'=>(
				isset($this->rules[$controller][$action]['redirect'])
					? $this->rules[$controller][$action]['redirect']
					: $this->defaultRedirect
				)];
	}


}
