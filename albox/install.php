<?php
require __DIR__.'/config.php';
require __DIR__.'/SimpleImage.php';

// Vérification si on peut ecrire dans le répertoire.
if(!is_writable(DIR_IMAGES_MINI))
{
	echo 'vous devez avoir votre répertoire \'/albox/images/\' accessible en écriture';
	die();
}

// Création du répertoire pour les mini images
if(!is_dir(DIR_IMAGES_MINI.'/mini/'))
{
	mkdir(DIR_IMAGES_MINI.'/mini');
}

// Création du répertoire pour les images taille web
if(!is_dir(DIR_IMAGES_MINI.'/web/'))
{
	mkdir(DIR_IMAGES_MINI.'/web');
}

// Création des mini images
crawlDir();

function crawlDir($dir_name = null){

	$dir = opendir(DIR_ALBUM.$dir_name); // on ouvre le contenu du dossier courant
	if(!$dir)
	{
		return false;
	}

	$fichier = array(); // on déclare le tableau contenant le nom des fichiers
	$dossier = array(); // on déclare le tableau contenant le nom des dossiers

	while($element = readdir($dir)) 
	{
		if($element != '.' && $element != '..') 
		{
			if (!is_dir(DIR_ALBUM.$dir_name.'/'.$element.'/')) 
			{
				

				echo '<br />-'.DIR_ALBUM.$dir_name.'/'.$element;
				$image = new SimpleImage();
				$image->load(DIR_ALBUM.$dir_name.'/'.$element);
				
				if(!file_exists(DIR_IMAGES_MINI.'/mini/'.$dir_name.'/'.$element))
				{
					$image->resize(153, 116);
					$image->save(DIR_IMAGES_MINI.'/mini/'.$dir_name.'/'.$element);
				}
				if(!file_exists( DIR_IMAGES_MINI.'/web/'.$dir_name.'/'.$element))
				{
					$image->resize(1024,768);
					$image->save(DIR_IMAGES_MINI.'/web/'.$dir_name.'/'.$element);
				}
			} 
			else 
			{
				// présence d'un dossier
				// Création des dossiers correspondants
				if(!is_dir(DIR_IMAGES_MINI.'/mini/'.$element)){
					mkdir(DIR_IMAGES_MINI.'/mini/'.$element);
				}
				if(!is_dir(DIR_IMAGES_MINI.'/web/'.$element)){
					mkdir(DIR_IMAGES_MINI.'/web/'.$element);
				}
				// execution du script à nouveau
				crawlDir($dir_name.'/'.$element);
			}
		}
	}

	closedir($dir);

	return true;

}

function resize($image, $target_file, $size) {
  // $image is the uploaded image
  list($width, $height) = getimagesize($image);

  //setup the new size of the image
  $ratio = $width/$height;
  $new_height = $size;
  $new_width = $new_height * $ratio;

  //move the file in the new location
  move_uploaded_file($image, $target_file);
  
  // resample the image        
  $new_image = imagecreatetruecolor($new_width, $new_height);
  $old_image = @imagecreatefromjpeg($image);
  imagecopyresampled($new_image, $old_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);        

  //output
  imagejpeg($new_image, $target_file, 100);
}
