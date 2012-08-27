<html>
  <head>
    <title>Diaporama </title>
    <!-- Bootstrap -->
    <link href="albox/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!-- Le styles -->
    <link href="albox/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="albox/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
  </head>
  <body>
	<div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
    		<h1>Diaporama</h1>
			<ul class="breadcrumb">
				<li><a href="index.php">Accueil</a> <span class="divider">/</span></li>
				<?php 
				if(isset($sDir))
				{
					$bcrumbs = explode('/', $sDir);
					$tmpBcrumb = null;
					foreach($bcrumbs as $bcrumb)
					{
						$tmpBcrumb .= $bcrumb;  
						?>
							<li><a href="index.php?dir=<?php echo $tmpBcrumb;?>"><?php echo $bcrumb;?></a> <span class="divider">/</span></li>
						<?php	
					}
				}
				?>
			</ul>
		</div>
		<div class="span2">
			<ul class="nav nav-tabs nav-stacked">
				<?php foreach($_dossiers as $dossier){ ?>
					<li><a href="index.php?dir=<?php echo $dossier['chemin'];?>"><?php echo $dossier['title'];?></a></li>
 				<?php } ?>
			</ul>
		</div>
		<div class="span9">
			<?php if(isset($_images)){ ?>
				<div id="myCarousel" class="carousel slide">
				  <!-- Carousel items -->
				  <div class="carousel-inner">
				  	<?php 
					$cpt = 1;
					foreach($_images as $images)
					{ 
						if(file_exists($images) || 1 == 1)
						{
							?>
							<div class="item <?php if($cpt ==1){ echo "active"; } ?>">
								<img src="/albox/images/web/<?php echo $sDir.'/'.$images;?>" />	
							</div>
							<?php
						}
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
    <script src="albox/bootstrap/js/jquery-1.8.0.min.js"></script>
    <script src="albox/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
