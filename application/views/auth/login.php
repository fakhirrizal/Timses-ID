<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Timses ID">
	<meta name="author" content="Timses ID">
	<title>Timses ID - Halaman Login</title>
	<!-- Favicon -->
	<link href="<?= site_url(); ?>assets/favicon.ico" rel="icon" type="image/png">
	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
	<!-- Icons -->
	<link href="<?= site_url(); ?>assets/login_page/nucleo.css" rel="stylesheet">
	<link href="<?= site_url(); ?>assets/login_page/all.min.css" rel="stylesheet">
	<!-- Argon CSS -->
	<link type="text/css" href="<?= site_url(); ?>assets/login_page/argon.css?v=1.0.0" rel="stylesheet">
</head>

<body class="bg-default" onload="getLocation()">
	<div class="main-content">
		<!-- Header -->
		<div class="header bg-gradient-primary py-7 py-lg-8">
		<div class="separator separator-bottom separator-skew zindex-100">
			<svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
			<polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
			</svg>
		</div>
		</div>
		<!-- Page content -->
		<div class="container mt--8 pb-5">
		<div class="row justify-content-center">
			<div class="col-lg-5 col-md-7">
			<div class="card bg-secondary shadow border-0">
				<!-- <div class="card-header bg-transparent pb-5">
					<div class="text-muted text-center mt-2 mb-3">
						<small>Sign in with</small>
					</div>
					<div class="btn-wrapper text-center">
					</div>
				</div> -->
				<div class="card-body px-lg-5 py-lg-5" style='text-align: center'>
				<!-- <div class="text-center text-muted mb-4">
					<small>Or sign in with credentials</small>
				</div> -->
				<img src="<?= site_url(); ?>assets/timses_web_banner.png" width='70%'>
				<hr>
				<?= $this->session->flashdata('error') ?>
				<form role="form" action="<?= site_url('login_process'); ?>" method='post'>
					<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
					<div class="form-group mb-3">
					<div class="input-group input-group-alternative">
						<div class="input-group-prepend">
						<span class="input-group-text"><i class="ni ni-single-02"></i></span>
						</div>
						<input class="form-control" placeholder="Email" type="text" name='username'>
					</div>
					</div>
					<div class="form-group">
					<div class="input-group input-group-alternative">
						<div class="input-group-prepend">
						<span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
						</div>
						<input class="form-control" placeholder="Kata Sandi" type="password" name='password'>
					</div>
					</div>
					<p id="getLocation"></p>
					<div class="custom-control custom-control-alternative custom-checkbox">
					<input class="custom-control-input" id=" customCheckLogin" type="checkbox">
					<label class="custom-control-label" for=" customCheckLogin">
						<span class="text-muted">Ingat saya</span>
					</label>
					</div>
					<div class="text-center">
					<button type="submit" class="btn btn-primary my-4">Masuk</button>
					</div>
				</form>
				</div>
			</div>
			<div class="row mt-3">
				<div class="col-6">
				<a href="#" class="text-light" data-toggle="modal" data-target="#exampleModal"><small>Lupa Kata Sandi?</small></a>
				</div>
				<div class="col-6 text-right">
				<a href="<?= site_url('registrasi'); ?>" class="text-light"><small>Registrasi</small></a>
				</div>
			</div>
			</div>
		</div>
		</div>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Form Lupa Kata Sandi</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<form role="form" action="#" method='post'>
		<div class="modal-body">
				<div class="form-group mb-3">
				<div class="input-group input-group-alternative">
					<div class="input-group-prepend">
					<span class="input-group-text"><i class="ni ni-email-83"></i></span>
					</div>
					<input class="form-control" placeholder="Email" type="email" name='email' required>
				</div>
				</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			<button type="submit" class="btn btn-primary">Kirim</button>
		</div>
		</form>
		</div>
	</div>
	</div>
	<script>
		var view = document.getElementById("getLocation");
		function getLocation() {
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(showPosition);
			} else {
				view.innerHTML = "";
			}
		}
		function showPosition(position) {
			view.innerHTML = "<input type='hidden' name='location' value='" + position.coords.latitude + "," + position.coords.longitude +"' />";
		}
	</script>
	<!-- Footer -->
	<footer class="py-5">
		<div class="container">
		<div class="row align-items-center justify-content-xl-between">
			<div class="col-xl-6">
			<div class="copyright text-center text-xl-left text-muted">
				&copy; 2019 <a href="#" class="font-weight-bold ml-1">Timses ID</a>
			</div>
			</div>
			<div class="col-xl-6">
			<ul class="nav nav-footer justify-content-center justify-content-xl-end">
				<li class="nav-item">
				<a href="#" class="nav-link" target="_blank">Creative Tim</a>
				</li>
				<li class="nav-item">
				<a href="#" class="nav-link" target="_blank">About Us</a>
				</li>
				<li class="nav-item">
				<a href="#" class="nav-link" target="_blank">Blog</a>
				</li>
				<li class="nav-item">
				<a href="#" class="nav-link" target="_blank">MIT License</a>
				</li>
			</ul>
			</div>
		</div>
		</div>
	</footer>
	<!-- Argon Scripts -->
	<!-- Core -->
	<script src="<?= site_url(); ?>assets/login_page/jquery.min.js"></script>
	<script src="<?= site_url(); ?>assets/login_page/bootstrap.bundle.min.js"></script>
	<!-- Argon JS -->
	<script src="<?= site_url(); ?>assets/login_page/argon.js?v=1.0.0"></script>
</body>
</html>