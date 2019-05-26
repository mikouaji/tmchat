<?php
namespace server;

define('FCPATH', dirname(__DIR__).DIRECTORY_SEPARATOR);
include_once(FCPATH."/vendor/autoload.php");
include_once(FCPATH."/app/config/socket.php");

use Workerman\Worker;
use PHPSocketIO\SocketIO;

$config = $config['socket'];

Worker::$pidFile = __DIR__."/pid/chat.pid";

$io = new SocketIO($config['port']);
$io->on('connection', function($socket)use($io){
	$socket->on('message', function($msg)use($io){
		$io->emit('message', $msg);
	});
});

Worker::runAll();
