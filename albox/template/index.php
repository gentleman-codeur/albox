<?php
if($this)
{
	// récupération des variables passé au template
	foreach($this->param as $key => $val) {
		$$key = $val;
	}
	// Assignation de l'url
	$Param = Parameters::get();
	?>
	<html>
	  <head>
	  	<meta charset="utf-8">
		<title>Diaporama </title>
		<!-- Bootstrap -->
		<link href="<?php echo $Param['ndd'];?>albox/public/css/bootstrap.min.css" rel="stylesheet">
		<!-- Le styles -->
		<link href="<?php echo $Param['ndd'];?>albox/public/css/bootstrap.css" rel="stylesheet">
		<link href="<?php echo $Param['ndd'];?>albox/public/css/bootstrap-responsive.css" rel="stylesheet">
		<link href="<?php echo $Param['ndd'];?>albox/public/css/colorbox.css" rel="stylesheet">

		<script src="<?php echo $Param['ndd'];?>albox/public/js/jquery-1.8.0.min.js"></script>
		<script src="<?php echo $Param['ndd'];?>albox/public/js/bootstrap.min.js"></script>
		<script src="<?php echo $Param['ndd'];?>albox/public/js/jquery.colorbox.js"></script>

	  </head>
	  <body>
		<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">
				<h1><?php echo $Param['title'];?></h1>
				<ul class="breadcrumb">
					<li><a href="<?php echo $Param['ndd'].'index.php';?>">Accueil</a> <span class="divider">/</span></li>
					<?php 
					$currentFolder = null;
					$allFolder = null;
					if (isset($Param['currentFolder'])) {
						foreach ($Param['currentFolder'] as $currentFolder) {
							$allFolder .= '/'.$currentFolder;  
							?>
								<li><a href="<?php echo $Param['ndd'].'index.php'.$allFolder;?>"><?php echo $currentFolder;?></a> <span class="divider">/</span></li>
							<?php	
						}
					}
					?>
				</ul>
			</div>
			<div class="span2">
			<?php
			if (isset($_aFolders)) {
				?>
				<ul class="nav nav-tabs nav-stacked">
					<?php 
					foreach ($_aFolders as $folder){ ?>
						<li><a href="<?php echo $Param['ndd'].'index.php'.$allFolder.'/'.$folder;?>"><?php echo $folder;?></a></li>
					<?php } ?>
				</ul>
				<?php
			}
			?>
			</div>
			<div class="span9">
				<?php if(isset($_aImages)) { 
					foreach ($_aImages as $images) { 
						?>
						<p style="float:left;margin:10px">
							<a href="<?php echo $images['path']['web'];?>" rel="carousel" class="carousel" title="<?php echo $images['name'];?> <a href='<?php echo $images['path']['normal'];?>' class='btn btn-inverse btn-mini' target='_blank' ><i class='icon-download-alt icon-white'></i>Télécharger</a>" >
							<img src="<?php echo $images['path']['mini'];?>" width="<?php echo $Param['sizeImage']['mini'][0];?>" height="<?php echo $Param['sizeImage']['mini'][1];?>" class="img-polaroid" />	
							</a>
						</p>
						<?php
					} 
					?>
					<script  >
					$(document).ready(function(){
						$('.carousel').colorbox({
							rel:'carousel',
							transition:"none",
							width:"80%",
							height:"90%",
							slideshowSpeed:<?php echo $Param['slideshowSpeed']*1000;?>,
							slideshow:true
						})
					});
					</script>
				<?php } ?>
				<!--Body content-->
			</div>
		  </div>
		</div>
	  </body>
	</html>
	<?php
}
