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
		<style>
			.picture { margin:10px;display:inline;position: relative;float:left;text-align:center; 
			width:<?php echo ((int)$Param['sizeImage']['mini'][0]+10);?>px;height:<?php echo ((int)$Param['sizeImage']['mini'][1]+10);?>px }
		</style>

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
		</div>
		<div class="row-fluid">
			<?php
			$largeView = 12;
			if (isset($_aFolders)) {
				$largeView = 9;
				?>
				<div class="span2">
					<ul class="nav nav-tabs nav-stacked">
						<?php 
						foreach ($_aFolders as $folder){ ?>
							<li><a href="<?php echo $Param['ndd'].'index.php'.$allFolder.'/'.$folder;?>"><?php echo $folder;?></a></li>
						<?php } ?>
					</ul>
				</div>
				<?php
			}
			?>
			<div class="span<?php echo $largeView;?>">
				<?php if(isset($_aImages)) { 
					foreach ($_aImages as $images) { 
						?>
						<p class="picture" >
							<a href="<?php echo $images['path']['web'];?>" rel="carousel" class="carousel" title="<?php echo $images['name'];?> <a href='<?php echo $images['path']['normal'];?>' class='btn btn-inverse btn-mini' target='_blank' ><i class='icon-download-alt icon-white'></i>Télécharger</a>" >
							<img src="<?php echo $images['path']['mini'];?>" class="img-polaroid" />	
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
							slideshowSpeed:<?php echo (int)$Param['slideshowSpeed']*1000;?>,
							slideshow:true
						})
					});
					</script>
				<?php } ?>
				<!--Body content-->
			</div>
		  </div>
		</div>
		<?php if(isset($Param['analytics'])) { ?>
			<script type="text/javascript">

			  var _gaq = _gaq || [];
			  _gaq.push(['_setAccount', '<?php echo $Param['analytics'];?>');
			  _gaq.push(['_trackPageview']);

			  (function() {
			    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			  })();

			</script>
		<?php } ?>
	  </body>
	</html>
	<?php
}
