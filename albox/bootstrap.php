<?php
/**
 * Bootstrap - albox
 * @author : Julien EDOUARD
 * @date : 30 aout 2012
 * @PHP version : >  5.2.0
 */

// Chargement des classes
if(is_dir(dirname(__FILE__).'/class')) {
	
	// Ouverture du dossier
	$dir = opendir(dirname(__FILE__).'/class'); 
	while($element = readdir($dir)) {
		if(preg_match('#\.php$#i', $element)) {
			require dirname(__FILE__).'/class/'.$element;
		}
	}
	closedir($dir);

} else {
	die("error can't read class dir");
}

// Chargement de la configuration
Parameters::load(dirname(__FILE__).'/parameters.json');

// Vérification des droits d'écriture du dossier images
if (!is_writable(dirname(__FILE__).'/../'.Parameters::get()->resizeFolder)) {
	die("Dossier '".Parameters::get()->resizeFolder."' non accessible en écriture <a href=''>aide</a>.");
}

// Vérification de l'existance des répertoires
if(isset(Parameters::get()->sizeImage) && sizeof(Parameters::get()->sizeImage) > 0){
	$path = dirname(__FILE__).'/../'.Parameters::get()->resizeFolder;
	foreach(Parameters::get()->sizeImage as $name => $size) {
		if (!is_dir($path.'/'.$name)) {
			mkdir($path.'/'.$name);
		}
	}
} else {
	die("Pas de dossier de miniature");
}

// Récupération du chemin de navigation
preg_match('#(.*)index.php\/(.*)#i', $_SERVER['SCRIPT_URI'], $info);
if(isset($info[1])) {
	Parameters::set('ndd', $info[1]);
} else {
	Parameters::set('ndd', str_replace('index.php', '', $_SERVER['SCRIPT_URI']));
}
if(isset($info[2])) {
	if(stripos($info[2], '/')){
		Parameters::set('currentFolder', explode('/', $info[2]));
	} else {
		Parameters::set('currentFolder', array('0' => $info[2]));
	}
}
