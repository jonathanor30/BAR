<?php require(RUTA_APP . '/Views/inc/header1.php'); ?>



<html lang="en">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title></title>
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="author" content="">

<body class="host_version">

	<!-- Modal -->

	<!-- Start header -->
	<header class="top-navbar">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<div class="container-fluid">
				<a class="navbar-brand" href="index.php">
					<img src="public/otros/images/logo.png" alt="" width="120" height="55" />
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbars-host" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbars-host">
					<ul class="navbar-nav ml-auto">

						<li class="nav-item"><a class="nav-link" href="domain.html"></a></li>
						<li class="nav-item"><a class="nav-link" href="pricing.html"></a></li>
						<li class="nav-item"><a class="nav-link" href="contact.html"></a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a class="hover-btn-new log" href="<?php echo RUTA_URL ?>/Login/home" data-toggle="modal" data-target="#login"><span>Inicio Sesión</span></a></li>
					</ul>
				</div>
			</div>
		</nav>
		<!-- End header -->

		<div id="carouselExampleControls" class="carousel slide bs-slider box-slider" data-ride="carousel" data-pause="hover" data-interval="false">
			<!-- Indicators -->

			<div class="carousel-inner" role="listbox">
				<div class="carousel-item active">
					<?php if ($datos['home']->ImagenMision != NULL || $datos['home']->ImagenMision != '') : ?>

						<div id="" class="first-section" style="background-image:url('<?php echo RUTA_URL ?>/Login/files?img=<?php echo $datos['home']->ImagenMision; ?>');">
						<?php else : ?>
							<h5>El producto no tiene una imagen cargada</h5>

						<?php endif; ?>

						<div class="dtab">

							<div class="container">
								<div class="row">
									<div class="col-md-12 col-sm-12 text-right">
										<div class="big-tagline">
											<h2><strong>LICORERA Y BAR LA 70</strong></h2>
										</div>
									</div>
								</div><!-- end row -->
							</div><!-- end container -->
						</div>
						</div><!-- end section -->
				</div>


			</div>

		</div>
		<!-- end col -->
		</div><!-- end row -->
		</div><!-- end container -->
		</div><!-- end section -->

		<div id="overviews" class="section lb">
			<div class="container">
				<div class="section-title row text-center">
					<div class="col-md-8 offset-md-2">
						<h3>¿Quiénes somos?</h3>
						<div class="col-md-8 offset-md-2">
							<p>
								<?php echo $datos['home']->Quienes_Somos ?>
							</p>
							<br>
						</div>
					</div><!-- end title -->
					<div class="row align-items-center">
						<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
							<div class="message-box">
								<h2>Misión</h2>
								<p>
									<?php echo $datos['home']->Mision ?>
								</p>
							</div><!-- end messagebox -->
						</div><!-- end col -->

						<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
							<div class="post-media wow fadeIn">
								<?php if ($datos['home']->ImagenMision != NULL || $datos['home']->ImagenMision != '') : ?>
									<img style="width: -50%; " class="img-fluid img-producto" src="<?php echo RUTA_URL ?>/Login/files?img=<?php echo $datos['home']->ImagenMision; ?>" alt="HOME">
								<?php else : ?>
									<h5>El producto no tiene una imagen cargada</h5>
								<?php endif; ?> </div><!-- end media -->
						</div><!-- end col -->
					</div>
					<div class="row align-items-center">
						<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
							<div class="post-media wow fadeIn">

								<?php if ($datos['home']->ImagenVision != NULL || $datos['home']->ImagenVision != '') : ?>
									<img style="width: -50%;" class="img-fluid img-producto" src="<?php echo RUTA_URL ?>/Login/files?img=<?php echo $datos['home']->ImagenVision; ?>" alt="HOME">
								<?php else : ?>
									<h5>El producto no tiene una imagen cargada</h5>
								<?php endif; ?>
							</div><!-- end media -->
						</div><!-- end col -->

						<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
							<form>
								<div class="message-box">
									<h2>Visión</h2>
									<p>
										<?php echo $datos['home']->Vision ?>
									</p>
							</form>
						</div><!-- end messagebox -->
					</div><!-- end col -->

				</div><!-- end row -->
			</div><!-- end container -->
		</div><!-- end section -->

		<footer class="footer">
			<div class="container">
				<div class="row">
					<div class="col-lg-4 col-md-4 col-xs-12">
						<div class="widget clearfix">
							<div class="widget-title">
								<h3></h3>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6 wow fadeInUp"><br><br>
								<a href="#"><img src="public/otros/images/lOGOempre.png" alt="" width="100" height="150" class="img-repsonsive"></a>
							</div>
						</div><!-- end clearfix -->
					</div><!-- end col -->

					<div class="col-lg-4 col-md-4 col-xs-12">
						<div class="widget clearfix">
							<div class="widget-title">
								<h3>Informacion Link</h3>
							</div>
							<ul class="footer-links">
								<li><a href="#"></a></li>
								<li><a href="#">¿Quienes somos?</a></li>
								<li><a href="#"></a></li>
								<li><a href="#"></a></li>
								<li><a href="#"></a></li>
								<li><a href="#"></a></li>
							</ul><!-- end links -->
						</div><!-- end clearfix -->
					</div><!-- end col -->

					<div class="col-lg-4 col-md-4 col-xs-12">
						<div class="widget clearfix">
							<div class="widget-title">
								<h3> Contacto </h3>
							</div>

							<ul class="footer-links">
								<li><a href="mailto:#">info@yoursite.com</a></li>
								<li><a href="#">Ubicados en medellin</a></li>
								<li>En castilla - Barrio Alfonzo lopez</li>
								<li>Direccion - Calle 92 bb #70-03</li>
								<li>contacto - 302145755</li>
								<p class="footer-company-name">All Rights Reserved. &copy; 2018 <a href="#">QuickCloud</a> Design By : <a href=>html design</a></p>
							</ul><!-- end links -->
						</div><!-- end clearfix -->
					</div><!-- end col -->

				</div><!-- end row -->
			</div><!-- end container -->
		</footer><!-- end footer -->
		<?php require(RUTA_APP . '/Views/inc/footer1.php'); ?>