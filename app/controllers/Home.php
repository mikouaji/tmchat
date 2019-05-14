<?php
/**
 * Created by PhpStorm.
 * User: mikouaji
 * Date: 2/1/19
 * Time: 3:02 PM
 */


use app\core\APP_Controller as Controller;;

class Home extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->view->setLayout('default');;
	}

	public function index()
	{

	}
}
