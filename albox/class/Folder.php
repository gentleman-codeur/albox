<?php


class Folder {


	static public function listing($rootDir){

		$_element = array();
		// on ouvre le contenu du dossier courant
		$dir = opendir(str_replace('%20', ' ', $rootDir)); 
		if(!$dir)
		{
			return false;
		}
		$Param = Parameters::get();
		while($element = readdir($dir)) 
		{
			if($element != '.' && $element != '..') 
			{
				if (preg_match('#(.*)\.'.implode('|', $Param['allowFormat']).'#i', $element)) 
				{
					$_element['image'][] = $element;
				} 
				elseif (preg_match('#(.*)\.md#i', $element)) 
				{
					$_element['text'][] = $element;
				} 
				elseif(is_dir($rootDir.'/'.$element) && !in_array($element, $Param['excludeFolder']))
				{
					$_element['folder'][] = $element;
				}
			}
		}
		closedir($dir);

		return $_element;
	}

}
