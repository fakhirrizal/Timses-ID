<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
	<meta name="author" content="Creative Tim">
	<title>Timses ID - Halaman Registrasi</title>
	<!-- Favicon -->
	<link href="<?=site_url('assets/icon.png');?>" rel="icon" type="image/png">
	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
	<!-- Icons -->
	<link href="<?= site_url(); ?>assets/login_page/nucleo.css" rel="stylesheet">
	<link href="<?= site_url(); ?>assets/login_page/all.min.css" rel="stylesheet">
	<!-- Argon CSS -->
	<link type="text/css" href="<?= site_url(); ?>assets/login_page/argon.css?v=1.0.0" rel="stylesheet">
	<script src="<?=base_url('assets/global/plugins/jquery.min.js');?>" type="text/javascript"></script>
	<script type="text/javascript">
		$(function(){
			$.ajaxSetup({
				type:"POST",
				url: "<?php echo site_url('/Auth/ajax_function')?>",
				cache: false,
			});
			$("#tingkat").change(function(){
				var value=$(this).val();
				$.ajax({
					data:{id:value,modul:'get_kabupaten_by_id_tingkatan'},
					success: function(respond){
						$("#tampil_kabkot").html(respond);
					}
				})
			});
			$("#provinsi").change(function(){
				var value=$(this).val();
				$.ajax({
					data:{id:value,modul:'get_kabupaten_by_id_provinsi'},
					success: function(respond){
						$("#kabkot").html(respond);
					}
				})
			});
		})
	</script>
</head>

<body class="bg-default" onload="getLocation()">
	<div class="main-content">
		<!-- Header -->
		<div class="header bg-gradient-primary py-7 py-lg-8" style='text-align: center'>
			<h1 class="text-white">Selamat Datang di Timses ID!</h1>
			<div class="separator separator-bottom separator-skew zindex-100">
				<svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
				<polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
				</svg>
			</div>
		</div>
		<!-- Page content -->
		<div class="container mt--8 pb-5">
			<!-- Table -->
			<div class="row justify-content-center">
				<div class="col-lg-6 col-md-8">
					<div class="card bg-secondary shadow border-0">
						<div class="card-header bg-transparent pb-5">
						<!-- <div class="text-muted text-center mt-2 mb-4"><small>Cara lain? dengan berikut</small></div>
						<div class="text-center">
							<a href="#" class="btn btn-neutral btn-icon mr-4">
							<span class="btn-inner--icon"><img src="https://image.flaticon.com/icons/png/512/124/124010.png"></span>
							<span class="btn-inner--text">Facebook</span>
							</a>
							<a href="#" class="btn btn-neutral btn-icon">
							<span class="btn-inner--icon"><img src="http://pngimg.com/uploads/google/google_PNG19635.png"></span>
							<span class="btn-inner--text">Google</span>
							</a>
						</div>
						</div> -->
						<div class="card-body px-lg-5 py-lg-5" style='text-align: center'>
							<?= $this->session->flashdata('error') ?>
							<img src="<?= site_url(); ?>assets/timses_web_banner.png" width='60%'><hr>
							<form role="form" action="<?= site_url('register_process'); ?>" method='post'>
								<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
								<div class="form-group">
									<div class="input-group input-group-alternative mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="ni ni-email-83"></i></span>
										</div>
										<input class="form-control" placeholder="Email" type="email" name='email' maxlength='100'>
									</div>
								</div>
								<div class="form-group">
									<div class="input-group input-group-alternative mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="ni ni-mobile-button"></i></span>
										</div>
										<input class="form-control" placeholder="Nomor HP" type="text" name='number_phone' maxlength='14'>
									</div>
								</div>
								<hr>
								<div class="form-group">
									<div class="input-group input-group-alternative mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
										</div>
										<input class="form-control" placeholder="Kata Sandi" type="text" name='pass' required>
									</div>
								</div>
								<div class="form-group">
									<div class="input-group input-group-alternative mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="ni ni-archive-2"></i></span>
										</div>
										<select class="form-control" name='paket' required>
											<option value=''>-- Pilih Tipe Paket --</option>
											<option value='1'>Paket A</option>
											<option value='2'>Paket B</option>
											<option value='3'>Paket C</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<div class="input-group input-group-alternative mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="ni ni-box-2"></i></span>
										</div>
										<select class="form-control" name='tingkat' id='tingkat' required>
											<option value=''>-- Pilih Tingkat Wilayah Pilkada --</option>
											<option value='1'>Tingkat Provinsi</option>
											<option value='2'>Tingkat Kabupaten/ Kota</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<div class="input-group input-group-alternative mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="ni ni-square-pin"></i></span>
										</div>
										<select class="form-control" name='provinsi' id='provinsi' required>
											<option value=''>-- Pilih Provinsi --</option>
											<?php
											foreach ($prov as $key => $value) {
												echo'<option value="'.$value->id_provinsi.'">'.$value->nm_provinsi.'</option>';
											}
											?>
										</select>
									</div>
								</div>
								<div id='tampil_kabkot'>
								
								</div>
								<div class="row my-4">
									<div class="col-12">
										<div class="custom-control custom-control-alternative custom-checkbox">
											<input class="custom-control-input" id="customCheckRegister" type="checkbox">
											<label class="custom-control-label" for="customCheckRegister">
												<span class="text-muted">Saya menerima <a data-toggle="modal" data-target="#exampleModal">syarat & ketentuan</a> yang berlaku</span>
											</label>
										</div>
									</div>
								</div>
								<div class="text-center">
								<button type="submit" class="btn btn-primary mt-4">Daftar Sekarang</button>
								</div>
								<p id="getLocation"></p>
							</form>
							<!-- Modal -->
							<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="privacypolicy" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="privacypolicy">Syarat dan Ketentuan</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											...
										</div>
										<!-- <div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											<button type="button" class="btn btn-primary">Save changes</button>
										</div> -->
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
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Footer -->
	<footer class="py-5">
		<div class="container">
			<div class="row align-items-center justify-content-xl-between">
				<div class="col-xl-6">
					<div class="copyright text-center text-xl-left text-muted">
						&copy; 2019 <a href="https://www.creative-tim.com" class="font-weight-bold ml-1">Timses ID</a>
					</div>
				</div>
				<div class="col-xl-6">
					<ul class="nav nav-footer justify-content-center justify-content-xl-end">
						<li class="nav-item">
						<a href="https://www.creative-tim.com" class="nav-link" target="_blank">Creative Tim</a>
						</li>
						<li class="nav-item">
						<a href="https://www.creative-tim.com/presentation" class="nav-link" target="_blank">About Us</a>
						</li>
						<li class="nav-item">
						<a href="http://blog.creative-tim.com" class="nav-link" target="_blank">Blog</a>
						</li>
						<li class="nav-item">
						<a href="https://github.com/creativetimofficial/argon-dashboard/blob/master/LICENSE.md" class="nav-link" target="_blank">MIT License</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</footer>
	<script>
			// fungsi untuk mengecek kekuatan password
			function passwordStrength(p){
				var status = document.getElementById('status');

				var regex = new Array();
				regex.push("[A-Z]");
				regex.push("[a-z]");
				regex.push("[0-9]");
				regex.push("[!@#$%^&*]");

				var passed = 0;
				for(var x = 0; x < regex.length;x++){
					if(new RegExp(regex[x]).test(p)){
						console.log(passed++);
					}
				}

				var strength = null;
				var color = null;

				switch(passed){
					case 0:
					case 1:
					case 2:
					strength = "Tidak Aman";
					color = "#8898AA";
					break;
					case 3:
					strength = "Cukup Aman";
					color = "#E1D441";
					break;
					case 4:
					strength = "Sangat Aman";
					color = "#27D644";
				}

				status.innerHTML = strength;
				status.style.color = color;
			}
	</script>
	<!-- Argon Scripts -->
	<!-- Core -->
	<script src="<?= site_url(); ?>assets/login_page/jquery.min.js"></script>
	<script src="<?= site_url(); ?>assets/login_page/bootstrap.bundle.min.js"></script>
	<!-- Argon JS -->
	<script src="<?= site_url(); ?>assets/login_page/argon.js?v=1.0.0"></script>
</body>

</html>