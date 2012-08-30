<?php
require __DIR__.'/albox/bootstrap.php';
//var_dump($_SERVER);

// D�claration du moteur de template
$template = new Template();

$currentFolder = null;
if(isset(Parameters::get()->currentFolder)){
	$currentFolder = '/'.implode('/', Parameters::get()->currentFolder);
}

$_element = Folder::listing(__DIR__.$currentFolder);

// R�cup�ration de la liste des r�pertoires
if (isset($_element['folder'])) {
	$template->assign('_aFolders', $_element['folder']);
}

// R�cup�ration de la liste des images
if (isset($_element['image'])) {

	$oImage = new Image();

	foreach ($_element['image'] as $images) {
		
		$pathImage = array();
		$pathImage['normal'] = Parameters::get()->ndd.implode('/', Parameters::get()->currentFolder).'/'.$images;

		// V�rification de l'existance des dossiers miniature
		foreach(Parameters::get()->sizeImage as $name => $size) {

			// v�rification si chaque dossier est bien cr��
			$currentFolderTest = null;
			foreach(Parameters::get()->currentFolder as $folder) {
				$currentFolderTest .= '/'.$folder;
				if(!is_dir($_SERVER['DOCUMENT_ROOT'].Parameters::get()->resizeFolder.'/'.$name.$currentFolderTest)) {
					mkdir($_SERVER['DOCUMENT_ROOT'].Parameters::get()->resizeFolder.'/'.$name.$currentFolderTest);
				}
			}
			$pathSizeImage = Parameters::get()->ndd.Parameters::get()->resizeFolder.'/'.$name.$currentFolder;
			// v�rification si chaque image existe bien
			if (!is_file($pathSizeImage.'/'.$images)) {

				$pathImagesTest = $_SERVER['DOCUMENT_ROOT'].Parameters::get()->resizeFolder.'/'.$name.$currentFolderTest.'/'.$images;
				if(!file_exists($pathImagesTest))
				{
					// Cr�ation de la miniature
					if (file_exists($_SERVER['DOCUMENT_ROOT'].implode('/', Parameters::get()->currentFolder).'/'.$images)) {
						$oImage->load($_SERVER['DOCUMENT_ROOT'].implode('/', Parameters::get()->currentFolder).'/'.$images);
						$_aSize = Parameters::get()->sizeImage->$name;
						$oImage->resize($_aSize[0], $_aSize[1]);
						$oImage->save($pathImagesTest);
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
