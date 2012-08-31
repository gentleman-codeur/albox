<?php

class Parameters {

	static private $parameters = null;

	static public function get()
	{
		if(!is_array(self::$parameters))
		{
			die("Pas de fichier de configuration chargé");
		}
		return self::$parameters;
	}

	static public function load($file)
	{
		// Avec un fichier ini
		if(is_file($file)) {
			$parameters = parse_ini_file($file, true);
		}
		self::$parameters = $parameters;
		return true;
	}

	static public function set($key, $value)
	{
		self::$parameters[$key] = $value;
	}

}
