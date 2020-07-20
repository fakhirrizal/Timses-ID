<?php
if(($this->session->userdata('id'))==NULL OR ($this->session->userdata('role_id'))!='1'){
            echo "<script>alert('Harap login terlebih dahulu')</script>";
            echo "<script>window.location='".base_url('Auth/logout')."'</script>";
        }
else{
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Timses ID</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1" name="viewport" />
		<meta content="Timses ID" name="description" />
		<meta content="Timses ID" name="author" />
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/simple-line-icons/simple-line-icons.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/datatables/datatables.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/select2/css/select2.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/select2/css/select2-bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/cubeportfolio/css/cubeportfolio.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/ladda/ladda-themeless.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/global/css/components-md.min.css');?>" rel="stylesheet" id="style_components" type="text/css" />
		<link href="<?=base_url('assets/global/css/plugins-md.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/pages/css/blog.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/layouts/layout3/css/layout.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?=base_url('assets/layouts/layout3/css/themes/default.min.css');?>" rel="stylesheet" type="text/css" id="style_color" />
		<link href="<?=base_url('assets/layouts/layout3/css/custom.min.css');?>" rel="stylesheet" type="text/css" />
		<link href="<?= site_url(); ?>assets/favicon.ico" rel="icon" type="image/x-icon">
	</head>
		<body class="page-container-bg-solid page-md">
		<div class="page-header">
			<div class="page-header-top">
				<div class="container">
					<img src="<?= site_url(); ?>assets/timses_web_banner.png" width='14%'>
					<a href="javascript:;" class="menu-toggler"></a>
					<div class="top-menu">
						<ul class="nav navbar-nav pull-right">
							<li class="dropdown dropdown-user dropdown-dark">
								<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
									<img alt="" class="img-circle" src="https://www.shareicon.net/data/512x512/2016/07/03/790265_people_512x512.png">
									<span class="username username-hide-mobile">Admin Pilkada</span>
								</a>
								<ul class="dropdown-menu dropdown-menu-default">
									<li>
										<a href="#!">
											<i class="icon-user"></i> Profil </a>
									</li>
									<li>
										<a href="<?php echo site_url('member_side/bantuan'); ?>">
											<i class="icon-rocket"></i> Bantuan
										</a>
									</li>
									<li class="divider"> </li>
									<li>
										<a href="<?php echo site_url('Auth/logout'); ?>">
											<i class="icon-key"></i> Keluar </a>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="page-header-menu">
				<div class="container">
					<form class="search-form" action="javascript:;" method="GET">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Cari" name="query">
							<span class="input-group-btn">
								<a href="javascript:;" class="btn submit">
									<i class="icon-magnifier"></i>
								</a>
							</span>
						</div>
					</form>
					<div class="hor-menu  ">
						<ul class="nav navbar-nav">
							<li class="menu-dropdown classic-menu-dropdown <?php if($parent=='home'){echo 'active';}else{echo '';} ?>">
								<a href="<?php echo site_url('member_side/beranda'); ?>"><i class="icon-home"></i> Beranda
								</a>
							</li>
							<li class="menu-dropdown classic-menu-dropdown <?php if($parent=='master'){echo 'active';}else{echo '';} ?>">
								<a href="javascript:;"><i class="icon-drawer"></i> Master
									<span class="arrow <?php if($parent=='master'){echo 'open';}else{echo '';} ?>"></span>
								</a>
								<ul class="dropdown-menu pull-left">
									<li class=" <?php if($child=='relawan'){echo 'active';}else{echo '';} ?>">
										<a href="<?php echo site_url('member_side/relawan'); ?>" class="nav-link nav-toggle ">
											<i class="icon-users"></i> Data Relawan
										</a>
									</li>
									<li class=" <?php if($child=='admin'){echo 'active';}else{echo '';} ?>">
										<a href="<?php echo site_url('member_side/admin'); ?>" class="nav-link nav-toggle ">
											<i class="icon-users"></i> Data Admin Wilayah
										</a>
									</li>
									<li class=" <?php if($child=='target_suara'){echo 'active';}else{echo '';} ?>">
										<a href="<?php echo site_url('member_side/target_suara'); ?>" class="nav-link nav-toggle ">
											<i class="icon-layers"></i> Target
										</a>
									</li>
								</ul>
							</li>
							<li class="menu-dropdown classic-menu-dropdown <?php if($parent=='command_center'){echo 'active';}else{echo '';} ?>">
								<a href="javascript:;"><i class="fa fa-bullhorn"></i> Command Center
									<span class="arrow <?php if($parent=='command_center'){echo 'open';}else{echo '';} ?>"></span>
								</a>
								<ul class="dropdown-menu pull-left">
									<li class=" <?php if($child=='task'){echo 'active';}else{echo '';} ?>">
										<a href="<?php echo site_url('member_side/daftar_instruksi'); ?>" class="nav-link nav-toggle ">
											<i class="icon-note"></i> Penugasan
										</a>
									</li>
									<li class=" <?php if($child=='request_task'){echo 'active';}else{echo '';} ?>">
										<a href="<?php echo site_url('member_side/usulan_instruksi'); ?>" class="nav-link nav-toggle ">
											<i class="icon-login"></i> Usulan Kegiatan
										</a>
									</li>
									<li class=" <?php if($child=='issue'){echo 'active';}else{echo '';} ?>">
										<a href="<?php echo site_url('member_side/rekap_isu'); ?>" class="nav-link nav-toggle ">
											<i class="fa fa-bullhorn"></i> Rekap Isu
										</a>
									</li>
								</ul>
							</li>
							<li class="menu-dropdown classic-menu-dropdown <?php if($parent=='analysis'){echo 'active';}else{echo '';} ?>">
								<a href="<?php echo site_url('member_side/analisis'); ?>"><i class="icon-graph"></i> Analisis
								</a>
							</li>
							<li class="menu-dropdown classic-menu-dropdown <?php if($parent=='log_activity'){echo 'active';}else{echo '';} ?>">
								<a href="<?php echo site_url('member_side/log_activity'); ?>"><i class="fa fa-rss"></i> Log Aktifitas
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="page-container">
			<div class="page-content-wrapper">
				<div class="page-head">
					<div class="container">
						<div class="page-title">
							<h1>Dashboard
								<small>Sistem Informasi</small>
							</h1>
						</div>
						<div class="page-toolbar">
							<div class="btn-group btn-theme-panel">
								<script type="text/javascript">function startTime(){var today=new Date(),curr_hour=today.getHours(),curr_min=today.getMinutes(),curr_sec=today.getSeconds();curr_hour=checkTime(curr_hour);curr_min=checkTime(curr_min);curr_sec=checkTime(curr_sec);document.getElementById('clock').innerHTML=curr_hour+":"+curr_min+":"+curr_sec;}function checkTime(i){if(i<10){i="0"+i;}return i;}setInterval(startTime,500);</script>
								<span class="tanggalwaktu">
								<?= $this->Main_model->convert_hari(date('Y-m-d')).', '.$this->Main_model->convert_tanggal(date('Y-m-d')) ?>  -  Pukul  <span id="clock">13:53:45</span>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="page-content">
					<div class="container">
<?php } ?>