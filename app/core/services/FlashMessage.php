<?php
/**
 * Created by PhpStorm.
 * User: mikouaji
 * Date: 2/15/19
 * Time: 10:43 AM
 */

namespace app\core\services;

class FlashMessage
{
	const INFO = "INFO";
	const DANGER = "DANGER";
	const SUCCESS = "SUCCESS";
	const WARNING = "WARNING";

	const SESSION_NAME = 'flashMessages';

	protected $session;

	public function __construct(\CI_Session $session)
	{
		$this->session = $session;
	}

	public function add($message, $type=NULL)
	{
		$type = strtoupper($type);
		$type == "ERROR" ? $type = self::DANGER : false ;
		if(!in_array($type, [self::DANGER, self::INFO, self::SUCCESS, self::WARNING]))
			$type = self::INFO;
		$allMessages = $this->session->userdata(self::SESSION_NAME);
		$allMessages[] = ['message'=>$message, 'type'=>strtolower($type)];
		$this->session->set_userdata(self::SESSION_NAME, $allMessages);
	}

	public function get()
	{
		$messages = $this->session->userdata(self::SESSION_NAME);
		$this->session->unset_userdata(self::SESSION_NAME);
		return $messages;
	}
}
