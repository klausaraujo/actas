<!doctype html>
<html lang="en">
   <head>
		<!-- Loader Header -->
		<?php	require_once('inc/header.php');	?>
		<title>Login</title>
		<style>
			body{ background: #1f373a; }
		</style>
	</head>
   <body>
      <!-- loader Start -->
      <!--<div id="loading">
         <div id="loading-center">
         </div>
      </div>-->
      <!-- loader END -->
        <!-- Sign in Start -->
        <section class="sign-in-page">
            <div class="container sign-in-page-bg p-0">
                <div class="row no-gutters">
                    <div class="col-md-6 text-center">
                        <div class="sign-in-detail text-white">
                            <a class="sign-in-logo mb-5" href="#"><img src="<?=base_url()?>/public/images/logo-white.png" class="img-fluid" alt="logo"></a>
                            <div class="owl-carousel" data-autoplay="true" data-loop="true" data-nav="false" data-dots="true" data-items="1" data-items-laptop="1" data-items-tab="1" data-items-mobile="1" data-items-mobile-sm="1" data-margin="0">
                                <div class="item">
                                    <img src="<?=base_url()?>/public/images/1.png" class="img-fluid mb-4" alt="logo">
                                    <h4 class="mb-1 text-white">Anuncio 01</h4>
                                    <p>Descripcion del Anuncio 01</p>
                                </div>
                                <div class="item">
                                    <img src="<?=base_url()?>/public/images/2.png" class="img-fluid mb-4" alt="logo">
                                    <h4 class="mb-1 text-white">Anuncio 02</h4>
                                    <p>Descripcion del Anuncio 02</p>
                                </div>
                                <div class="item">
                                    <img src="<?=base_url()?>/public/images/3.png" class="img-fluid mb-4" alt="logo">
                                    <h4 class="mb-1 text-white">Anuncio 03</h4>
                                    <p>Descripcion del Anuncio 03</p>
                                </div>
                                <div class="item">
                                    <img src="<?=base_url()?>/public/images/4.png" class="img-fluid mb-4" alt="logo">
                                    <h4 class="mb-1 text-white">Anuncio 04</h4>
                                    <p>Descripcion del Anuncio 04</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 position-relative">
                        <div class="sign-in-from">
                            <h1 class="mb-0">Iniciar Sesi&oacute;n</h1>
                            <p>Ingrese su Usuario y Clave para ingresar al Tablero de Control</p>
                            <form class="mt-4" action="dologin" method="post" id="login-form">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Usuario</label>
									<input type="text" class="form-control mb-0" id="usuario" name="usuario" placeholder="Ingrese su usuario" 
									value="<?=$this->session->flashdata('usuarioError');?>" autocomplete="off" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Contrase&ntilde;a</label>
									<input type="password" class="form-control mb-0" name="pass" id="pass" placeholder="Ingrese su contraseña" autocomplete="new-password" >
                                </div>
                                <div class="d-inline-block w-100">
                                    <button type="submit" class="btn btn-sabogal float-right">Iniciar Sesi&oacute;n</button>
                                </div>
                                <div class="sign-info">
                                    Acceso directo a nuestras Redes Sociales
									<ul class="iq-social-media">
                                        <li><a href="#"><i class="ri-facebook-box-line"></i></a></li>
                                        <li><a href="#"><i class="ri-twitter-line"></i></a></li>
                                        <li><a href="#"><i class="ri-instagram-line"></i></a></li>
                                    </ul>
                                </div>
                            </form>
							<?php 
								$message = $this->session->flashdata('loginError');
								if($message){ ?>
								<p style="color:#dc8b89;margin:auto;text-align:center;"><?=$message;?></p>
							<?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Sign in END -->
		<!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="<?=base_url()?>/public/js/jquery.min.js"></script>
      <script src="<?=base_url()?>/public/js/popper.min.js"></script>
      <script src="<?=base_url()?>/public/js/bootstrap.min.js"></script>
      <!-- Appear JavaScript -->
      <script src="<?=base_url()?>/public/js/jquery.appear.js"></script>
      <!-- Countdown JavaScript -->
      <script src="<?=base_url()?>/public/js/countdown.min.js"></script>
      <!-- Counterup JavaScript -->
      <script src="<?=base_url()?>/public/js/waypoints.min.js"></script>
      <script src="<?=base_url()?>/public/js/jquery.counterup.min.js"></script>
      <!-- Wow JavaScript -->
      <script src="<?=base_url()?>/public/js/wow.min.js"></script>
      <!-- Apexcharts JavaScript -->
      <script src="<?=base_url()?>/public/js/apexcharts.js"></script>
      <!-- Slick JavaScript -->
      <script src="<?=base_url()?>/public/js/slick.min.js"></script>
      <!-- Select2 JavaScript -->
      <script src="<?=base_url()?>/public/js/select2.min.js"></script>
      <!-- Owl Carousel JavaScript -->
      <script src="<?=base_url()?>/public/js/owl.carousel.min.js"></script>
      <!-- Magnific Popup JavaScript -->
      <script src="<?=base_url()?>/public/js/jquery.magnific-popup.min.js"></script>
      <!-- Smooth Scrollbar JavaScript -->
      <script src="<?=base_url()?>/public/js/smooth-scrollbar.js"></script>
      <!-- Chart Custom JavaScript -->
      <script src="<?=base_url()?>/public/js/chart-custom.js"></script>
      <!-- Custom JavaScript -->
      <script src="<?=base_url()?>/public/js/custom.js"></script>
   </body>
</html>