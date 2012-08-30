<?php

class Parameters {

	static private $parameters = null;

	static public function get()
	{
		if(!is_object(self::$parameters))
		{
			die("Pas de fichier de configuration chargé");
		}
		return self::$parameters;
	}

	static public function load($file)
	{
		if(is_file($file))
		{
			$parameters = null;
			$fp = fopen($file, "r");  
			$content = fread($fp, filesize($file));  
			$parameters = json_decode($content);
			if(!is_object($parameters))
			{
				die("error can't read parameters.json");
			}
			fclose ($fp);
		} else {
			die("error can't find parameters.json");
		}

		self::$parameters = $parameters;
		return true;
	}

	static public function set($key, $value)
	{
		self::$parameters->$key = $value;
	}

}
