<?php

class APP_Form_validation extends \CI_Form_validation
{

	protected $CI;
	public function __construct($rules = array())
	{
		parent::__construct($rules);
		$this->CI =& get_instance();
	}
}
