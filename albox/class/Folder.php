<?php


class Folder {


	static public function listing($rootDir){

		$_element = array();
		// on ouvre le contenu du dossier courant
		$dir = opendir($rootDir); 
		if(!$dir)
		{
			return false;
		}
		while($element = readdir($dir)) 
		{
			if($element != '.' && $element != '..') 
			{
				if (preg_match('#(.*)\.'.implode('|', Parameters::get()->allowFormat).'#i', $element)) 
				{
					$_element['image'][] = $element;
				} 
				elseif (preg_match('#(.*)\.md#i', $element)) 
				{
					$_element['text'][] = $element;
				} 
				elseif(is_dir($rootDir.'/'.$element) && !in_array($element, Parameters::get()->excludeFolder))
				{
					$_element['folder'][] = $element;
				}
			}
		}
		closedir($dir);

		return $_element;
	}

}
