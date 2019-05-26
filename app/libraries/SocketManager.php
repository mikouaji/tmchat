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
	const SERVER_RESPONSE_START = "Start success.";
	const SERVER_RESPONSE_START_SIZE = 7;
	const SERVER_RESPONSE_RUNNING = "already running";
	const SERVER_RESPONSE_RUNNING_SIZE = 1;
	const SERVER_RESPONSE_SIZE = 2;

    /**
     * @param array $value
     * @return bool
     */
	public static function message(array $value) : bool{
        $socketio = new SocketIO();
        $config = config_item('socket');
        return ($socketio->send("localhost", $config['port'], 'message', json_encode($value)));
    }

	/**
	 * @return bool
	 */
	public static function start() : bool {
	    $config = config_item('socket');
		exec('php '.$config['path'].' start -d', $output);
        if(sizeof($output) >= self::SERVER_RESPONSE_SIZE
            and (
                strpos($output[self::SERVER_RESPONSE_RUNNING_SIZE], self::SERVER_RESPONSE_RUNNING) !== FALSE
                or
                strpos($output[self::SERVER_RESPONSE_START_SIZE], self::SERVER_RESPONSE_START) !== FALSE
            ))
            return TRUE;
        return FALSE;
	}

    /**
     * @return array
     */
	public static function status() : array{
        $config = config_item('socket');
        exec('php '.$config['path'].' status', $output);
        return $output;
    }

    /**
     * @return array
     */
	public static function stop() : array{
        $config = config_item('socket');
        exec('php '.$config['path'].' stop', $output);
        return $output;
    }
}
