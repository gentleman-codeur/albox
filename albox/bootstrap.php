<?php
/**
 * Bootstrap - albox
 * @author : Julien EDOUARD
 * @date : 30 aout 2012
 * @PHP version : >  5.2.0
 */

// Verification si la librairie gd est bien chargé :
if (!extension_loaded('gd')) {
	die("Librairie GD non installé, veuillez contacter votre hébergeur");
}

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
Parameters::load(dirname(__FILE__).'/parameters.ini');

// Récupération du chemin de navigation
$uriComplete = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
preg_match('#(.*)index.php\/(.*)#i', $uriComplete, $info);
if(isset($info[1])) {
	Parameters::set('ndd', $info[1]);
} else {
	Parameters::set('ndd', str_replace('index.php', '', $uriComplete);
}
if(isset($info[2])) {
	if(stripos($info[2], '/')){
		Parameters::set('currentFolder', explode('/', $info[2]));
	} else {
		Parameters::set('currentFolder', array('0' => $info[2]));
	}
}
if($_SERVER['SCRIPT_FILENAME']) {
	Parameters::set('pathRoot', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']));
} else {
	die('Problème de paramètre serveur');
}

// Vérification des droits d'écriture du dossier images
$Param = Parameters::get();
if (!is_writable($Param['pathRoot'].$Param['resizeFolder'])) {
	die("Dossier '".$Param['resizeFolder']."' non accessible en écriture <a href=''>aide</a>.");
}

// Vérification de l'existance des répertoires
if(isset($Param['sizeImage']) && sizeof($Param['sizeImage']) > 0){
	$path = $Param['pathRoot'].$Param['resizeFolder'];
	foreach($Param['sizeImage'] as $name => $size) {
		if (!is_dir($path.'/'.$name)) {
			mkdir($path.'/'.$name);
		}
	}
} else {
	die("Pas de dossier de miniature");
}
