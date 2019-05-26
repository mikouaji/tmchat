<?php

use app\models\Topic;

class APP_Form_validation extends \CI_Form_validation
{

	protected $CI;
	public function __construct($rules = array())
	{
		parent::__construct($rules);
		$this->CI =& get_instance();
	}

    /**
     * @param string $name
     * @return bool
     */
	public function uniqueTopicName(string $name) : bool{
	    return is_null(Topic::findOne(['name'=>$name])) ? TRUE : FALSE;
    }
}
