<?php
namespace server;

include_once("../vendor/autoload.php");

use Workerman\Worker;
use PHPSocketIO\SocketIO;


$pid = "###PID###";
$port = ###PORT###;

Worker::$pidFile = __DIR__."/pid/".$pid.".pid";

$io = new SocketIO($port);
$io->on('connection', function($socket)use($io){
	$socket->on('message', function($msg)use($io){
		$io->emit('message', $msg);
	});
});

Worker::runAll();
