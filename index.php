<?php
require __DIR__.'/albox/config.php';

$dir = opendir(DIR_IMAGES_MINI) or die('Erreur de listage : le r�pertoire n\'existe pas'); // on ouvre le contenu du dossier courant
$fichier = array(); // on d�clare le tableau contenant le nom des fichiers
$dossier = array(); // on d�clare le tableau contenant le nom des dossiers
$sDir = null;

// Affichage des r�pertoires
if(isset($_GET['dir']))
{
	$sDir = filter_var($_GET['dir'], FILTER_SANITIZE_URL);
}
$_dossiers = crawlDir(DIR_IMAGES_MINI.'/web/'.$sDir);

// Si pas de r�pertoire � lister, on r�cup�re la liste pr�c�dante
if(sizeof($_dossiers) == 0)
{
	$_dossiers =  crawlDir(DIR_IMAGES_MINI.'/web/');
}

// R�cup�ration des images
$_images = listImage(DIR_IMAGES_MINI.'/web/'.$sDir);

include __DIR__.'/albox/template.php';


function listImage($dir_name)
{
	
	$_images = array();
	$dir = opendir($dir_name); // on ouvre le contenu du dossier courant
	if(!$dir)
	{
		return false;
	}

	$fichier = array(); // on d�clare le tableau contenant le nom des fichiers
	$dossier = array(); // on d�clare le tableau contenant le nom des dossiers

	while($element = readdir($dir)) 
	{
		if($element != '.' && $element != '..') 
		{
			if (!is_dir($dir_name.'/'.$element)) 
			{
				if(!file_exists( DIR_IMAGES_MINI.'/web/'.$dir_name.'/'.$element))
				{
					$_images[] = $element;
				}
			}
		}
	}

	closedir($dir);

	return $_images;

}

function crawlDir($dir_name){

	$_dossier = array();
	$dir = opendir($dir_name); // on ouvre le contenu du dossier courant
	if(!$dir)
	{
		return false;
	}

	while($element = readdir($dir)) 
	{
		if($element != '.' && $element != '..') 
		{
			if (is_dir($dir_name.'/'.$element)) 
			{
				$_dossier[] = array(
					'title' => $element,
					'chemin' => $element
				);
			}
		}
	}

	closedir($dir);

	return $_dossier;

}

