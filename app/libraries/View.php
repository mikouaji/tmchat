<?php
/**
 * Created by PhpStorm.
 * User: mikouaji
 * Date: 2/1/19
 * Time: 4:19 PM
 */

namespace app\libraries;

class View
{
	protected $_enabled = TRUE;
	protected $_profiler = FALSE;

	protected $_layoutDir = NULL;
	protected $_layout = NULL;

	protected $_viewDir = NULL;
	protected $_view = NULL;

	protected $_helperDir = NULL;
	protected $_helpers = [];

	protected $_json_response = NULL;
	protected $output;

	public function __construct(\CI_Output $output)
	{
		$this->output = $output;
		$this->_layoutDir = config_item('view_layout_dir');
		$this->_viewDir = config_item('view_page_dir');
		$this->_helperDir = config_item('view_helper_dir');
		$this->_helpers['default'] = $this->_helperDir."/".config_item('view_helper_default');
		if(ENVIRONMENT === "development") {
			$this->_profiler = config_item('view_profiler_enabled');
//			$this->output->enable_profiler(config_item('view_profiler_enabled'));
		}
	}

	/**
	 * @return bool
	 */
	public function hasJsonResponse() : bool
	{
		return !is_null($this->_json_response);
	}

	/**
	 * @return array
	 */
	public function getJsonResponse() : array
	{
		return $this->_json_response;
	}

	/**
	 * @param mixed $data
	 * @param int $code
	 */
	public function setJsonResponse($data, int $code=200)
	{
		$this->_json_response = ['data'=>$data, 'code'=>$code];
	}

	public function getProfiler()
	{
		return $this->output->get_output();
	}

	public function profilerEnabled()
	{
		return $this->_profiler;
	}

	public function getData()
	{
		return (array) $this;
	}

	public function addHelper(string $filename)
	{
		$this->_helpers[$filename] = $this->_helperDir."/".$filename.".twig";
	}

	public function getHelpers()
	{
		return $this->_helpers;
	}

	public function setLayout($layout)
	{
		$layoutFullPath = VIEWPATH.$this->_layoutDir."/".$layout.".twig";
		if(!file_exists($layoutFullPath))
			Throw new \Exception("Layout file not found at ".$layoutFullPath);
		$this->_layout = $this->_layoutDir."/".$layout;
	}

	public function setView($view)
	{
		$viewFullPath = VIEWPATH.$this->_viewDir."/".$view.".twig";
		if(!file_exists($viewFullPath))
			Throw new \Exception("View file not found at ".$viewFullPath);
		$this->_view=$this->_viewDir."/".$view;
	}

	public function disable($enableProfiler = TRUE)
	{
		$this->output->enable_profiler($enableProfiler);
		$this->_enabled = FALSE;
	}

	public function getLayout()
	{
		return $this->_layout;
	}

	public function getView()
	{
		return $this->_view.".twig";
	}

	public function enabled()
	{
		return $this->_enabled;
	}
}
