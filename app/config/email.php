<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = [
	'mailtype' => 'text',
	'crlf' => '\r\n',
	'newline' => '\r\n',
	'mail_service' => [
		'from'=> [
			'address' => 'e@mail',
			'name' => 'Sender Name',
		],
		'templates' => [
			"example" => [
				'subject' =>"Example",
				'message' =>"Url: %VALUE%",
			],
		],
	],
];
