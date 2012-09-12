<?php
require 'albox/bootstrap.php';

// Déclaration du moteur de template
$template = new Template();

$currentFolder = null;
if(isset($Param['currentFolder'])){
	$currentFolder = implode('/', $Param['currentFolder']);
}

$_element = Folder::listing($Param['pathRoot'].$currentFolder);

// Récupération de la liste des répertoires
if (isset($_element['folder'])) {
	$template->assign('_aFolders', $_element['folder']);
}

// Récupération de la liste des images
if (isset($_element['image'])) {

	$oImage = new Image();

	foreach ($_element['image'] as $images) {
		
		$pathImage = array();
		$pathImage['normal'] = $Param['ndd'].implode('/', $Param['currentFolder']).'/'.$images;

		// Vérification de l'existance des dossiers miniature
		foreach($Param['sizeImage'] as $name => $size) {

			// vérification si chaque dossier est bien créé
			$currentFolderTest = null;
			foreach($Param['currentFolder'] as $folder) {
				$currentFolderTest .= '/'.$folder;
				if(!is_dir($Param['pathRoot'].$Param['resizeFolder'].'/'.$name.$currentFolderTest)) {
					mkdir($Param['pathRoot'].$Param['resizeFolder'].'/'.$name.$currentFolderTest);
				}
			}
			$pathSizeImage = $Param['ndd'].$Param['resizeFolder'].'/'.$name.'/'.$currentFolder;
			// vérification si chaque image existe bien
			if (!is_file($pathSizeImage.'/'.$images)) {

				$pathImagesTest = $Param['pathRoot'].$Param['resizeFolder'].'/'.$name.$currentFolderTest.'/'.$images;
				if(!file_exists($pathImagesTest))
				{
					// Création de la miniature
					if (file_exists($Param['pathRoot'].implode('/', $Param['currentFolder']).'/'.$images)) {
						$_aSize = $Param['sizeImage'][$name];
						// *** 1) Initialize / load image  
						$resizeObj = new Resize($Param['pathRoot'].implode('/', $Param['currentFolder']).'/'.$images);  
						// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)  
						$resizeObj->resizeImage($_aSize[0], $_aSize[1], 'auto');  
						// *** 3) Save image  
						$resizeObj->saveImage($pathImagesTest);
					}
				}
			}
			$pathImage[$name] = $pathSizeImage.'/'.$images;
		}

		$_aImages[] = array(
			'name' => $images,
			'path' => $pathImage
		);

	}
	$template->assign('_aImages', $_aImages);
}

$template->render('index.php');
