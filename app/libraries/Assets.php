<?php
/**
 * Created by PhpStorm.
 * User: mikouaji
 * Date: 2/4/19
 * Time: 12:00 AM
 */

namespace app\libraries;

use MatthiasMullie\Minify;

class Assets
{
	protected $_minifyCSS;
	protected $_minifyJS;
	protected $_requireJS;
	protected $_version = 0;

	protected $_styles = [];
	protected $_scripts =[];

	public function __construct()
	{
		$config = config_item('assets');
		$this->_minifyCSS = $config['minifyCSS'];
		$this->_minifyJS = $config['minifyJS'];
		$this->_requireJS = $config['requireJS'];
		$this->_scripts = $config['scripts'];
		$this->_styles  = $config['styles'];
		$this->_version = (ENVIRONMENT == "production") ? $config['version'] : rand(0,10000);
	}

	/**
	 * @param string $name
	 * @return array
	 * @throws \Exception
	 */
	public function getStyles(string $name = 'default') : array
	{
		$styles = [
			'local'=>[],
			'remote'=>$this->_styles[$name]['remote'],
		];
		$dir = $this->_styles[$name]['dir'];
		foreach($this->_styles[$name]['local'] as $style)
		{
			if(!file_exists(FCPATH."/".$dir."/".$style['url']))
				Throw new \Exception("Style file ".$style['url']." not found");
			$style['url'] = $dir."/".$style['url']."?v=".$this->_version;
			$styles['local'][] = $style;
		}
		if($this->_minifyCSS && !empty($styles['local']))
			$styles['local'] = $this->_minify($styles['local'], $dir, $name, "css");
		return $styles;
	}

	/**
	 * @param string $name
	 * @return array
	 * @throws \Exception
	 */
	public function getScripts(string $name = 'default') : array
	{
		$scripts = [
			'local'=>[],
			'remote'=>$this->_scripts[$name]['remote'],
		];
		$dir = $this->_scripts[$name]['dir'];
		foreach($this->_scripts[$name]['local'] as $script)
		{
			if(!file_exists(FCPATH."/".$dir."/".$script['url']))
				Throw new \Exception("Script file ".$script['url']." not found");
			$script['url'] = $dir."/".$script['url']."?v=".$this->_version;
			$scripts['local'][] = $script;
		}
		if($this->_minifyJS)
			$scripts['local'] = $this->_minify($scripts['local'], $dir, $name, "js");

		$scripts['requireJS'] = $this->_requireJS;
		return $scripts;
	}

	/**
	 * @param array $localScripts
	 * @param string $dir
	 * @param string $name
	 * @param string $type
	 * @return array
	 */
	private function _minify(array $localScripts, string $dir, string $name, string $type="css") : array
	{
		$minPath = (ENVIRONMENT == "production") ? $dir."/".$name."-".$this->_version.".min.".$type : $dir."/".$name.".min.".$type;

		$newFile = [
			[
				"url"=>$minPath,
				'integrity'=>NULL,
				'crossorigin'=>NULL,
			]
		];
		if($type=="js") {
			$minifier = new Minify\JS();
			$newFile[0]['async'] = 'async';
		}else {
			$minifier = new Minify\CSS();
		}
		if(ENVIRONMENT == "production" and file_exists(FCPATH.$minPath))
			return $newFile;
		touch(FCPATH.$minPath);
		foreach($localScripts as $file)
		{
			$minifier->add(explode("?",$file['url'])[0]);
		}
		$minifier->minify(FCPATH.$minPath);
		return $newFile;
	}
}
