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
		<title>Diaporama </title>
		<!-- Bootstrap -->
		<link href="<?php echo $Param['ndd'];?>albox/public/css/bootstrap.min.css" rel="stylesheet">
		<!-- Le styles -->
		<link href="<?php echo $Param['ndd'];?>albox/public/css/bootstrap.css" rel="stylesheet">
		<link href="<?php echo $Param['ndd'];?>albox/public/css/bootstrap-responsive.css" rel="stylesheet">
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
				<?php if(isset($_aImages)) { ?>
					<div id="myCarousel" class="carousel slide">
					  <!-- Carousel items -->
					  <div class="carousel-inner">
						<?php 
						$cpt = 1;
						foreach ($_aImages as $images) { 
							?>
							<div class="item <?php if($cpt == 1){ echo "active"; } ?>">
								<img src="<?php echo $images['path']['web'];?>" />	
							</div>
							<?php
							$cpt++;
						} 
						?>
					  </div>
					  <!-- Carousel nav -->
					  <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
					  <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
					</div>
					<script type="script/javascript" >
					$('.carousel').carousel({
						interval: 2000	
					})
					</script>
				<?php } ?>
				<!--Body content-->
			</div>
		  </div>
		</div>
		<script src="<?php echo $Param['ndd'];?>albox/public/js/jquery-1.8.0.min.js"></script>
		<script src="<?php echo $Param['ndd'];?>albox/public/js/bootstrap.min.js"></script>
	  </body>
	</html>
	<?php
}
