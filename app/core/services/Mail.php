<?php

namespace app\core\services;

class Mail
{
	protected $CI_mail;

	private $sender;
	private $templates;

	const VALUE_STR = "%VALUE%";

	const EXAMPLE_URL = "example";

	public function __construct(\CI_Email $mail)
	{
		$this->CI_mail = $mail;
		$config = config_item('mail_service');
		$this->sender = $config['from'];
		$this->templates = $config['templates'];
		$this->CI_mail->from($this->sender['address'], $this->sender['name']);
	}

	/**
	 * @param string $to
	 * @param string $type
	 * @param string|NULL $value
	 * @return bool
	 */
	public function send(string $to, string $type, string $value = NULL) : bool {
		$this->CI_mail->to($to);
		$subject = $this->getSubject($type);
		$message = $this->getMessage($type, $value);
		$this->CI_mail->subject($subject);
		$this->CI_mail->message($message);
		return $this->CI_mail->send();
	}

	/**
	 * @param string $type
	 * @return string
	 */
	private function getSubject(string $type) : string{
		return $this->templates[$type]['subject'];
	}

	/**
	 * @param string $type
	 * @param string|NULL $value
	 * @return string
	 */
	private function getMessage(string $type, string $value = NULL) : string {
		return str_replace(self::VALUE_STR, $value, $this->templates[$type]['message']);
	}
}
