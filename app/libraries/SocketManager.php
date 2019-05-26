<?php
/**
 * Created by PhpStorm.
 * User: mikouaji
 * Date: 3/14/19
 * Time: 11:14 AM
 */

namespace app\libraries;

class SocketManager
{
	const ADDR = "http://localhost";
	const PORT_BASE = 54300;
	const SERVER_DIR = FCPATH."/server/";
	const SERVER_SAMPLE_FILE = 'server_sample.php';
	const SERVER_SAMPLE_PID_STR = "###PID###";
	const SERVER_SAMPLE_PORT_STR = "###PORT###";
	const SERVER_RESPONSE_START = "Start success.";
	const SERVER_RESPONSE_START_SIZE = 7;
	const SERVER_RESPONSE_STOP = "stop success";
	const SERVER_RESPONSE_STOP_SIZE = 2;


	/*
	 * todo:
	 * lepiej obudowac klase socketio albo forka zrobic/przerobic ja;
	 * to dodac po tym jak sie zapisze w bazie to co zostanie wyslane
	 */
	public function testMessage($msg){
		$socketio = new SocketIO();
		if ($socketio->send('localhost', 54333, 'message', $msg)){
			echo 'we sent the message and disconnected';
		} else {
			echo 'Sorry, we have a mistake :\'(';
		}
	}

	/**
	 * @param string $server
	 * @param bool $daemon
	 * @return bool
	 */
	public function start(string $server, bool $daemon = TRUE) : bool {
		$serverFile = $this->getServerPath($server);
		$d = $daemon ? " -d" : "";
		exec('php '.$serverFile.' start'.$d, $output);
		return (sizeof($output)>self::SERVER_RESPONSE_START_SIZE
			and strpos($output[self::SERVER_RESPONSE_START_SIZE], self::SERVER_RESPONSE_START) !== FALSE) ?
			TRUE : FALSE;
	}

	/**
	 * @param string $server
	 * @return bool
	 */
	public function stop(string $server) : bool {
		$serverFile = $this->getServerPath($server);
		exec('php '.$serverFile.' stop', $output);
		return (sizeof($output)>self::SERVER_RESPONSE_STOP_SIZE
			and strpos($output[self::SERVER_RESPONSE_STOP_SIZE], self::SERVER_RESPONSE_STOP) !== FALSE) ?
			TRUE : FALSE;
	}

	/**
	 * @param string $filename
	 * @param int $port
	 * @return bool
	 */
	public function create(string $filename, int $port) : bool {
		$server = file_get_contents($this->getSampleServerPath());
		$serverFile = $this->getServerPath($filename);
		$server = str_replace(self::SERVER_SAMPLE_PID_STR, $filename, $server);
		$server = str_replace(self::SERVER_SAMPLE_PORT_STR, self::PORT_BASE + $port, $server);
		$result = file_put_contents($serverFile, $server);
		return $result>0 ? TRUE : FALSE;
	}

	/**
	 * @param string $filename
	 */
	public function delete(string $filename) : void {
		exec("rm ".$this->getServerPath($filename));
	}

	/**
	 * @return string
	 */
	private function getSampleServerPath() : string {
		return self::SERVER_DIR.self::SERVER_SAMPLE_FILE;
	}

	/**
	 * @param string $filename
	 * @return string
	 */
	private function getServerPath(string $filename) : string {
		return self::SERVER_DIR.$filename.".php";
	}
}
