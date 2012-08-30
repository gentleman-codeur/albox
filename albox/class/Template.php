<?php

class Template {

	private $param = array();

	public function assign($key, $value)
	{
		$this->param[$key] = $value;
		return true;
	}

	public function render($template)
	{
		require (dirname(__FILE__).'/../template/'.$template);
	}
}
