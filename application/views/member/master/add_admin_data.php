<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<!-- <script src="<?=base_url('assets/pages/scripts/components-editors.min.js');?>" type="text/javascript"></script> -->
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Master</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Data Admin Wilayah</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Tambah Data</span>
	</li>
</ul>
<script type="text/javascript">
	$(function(){
		$.ajaxSetup({
			type:"POST",
			url: "<?php echo site_url('/member/Master/ajax_function')?>",
			cache: false,
		});
		$("#wilayah").change(function(){
			var value=$(this).val();
			$.ajax({
				data:{id:value,modul:'get_wilayah_by_role_event'},
				success: function(respond){
					$("#muncul_1").html(respond);
					$("#provinsi").change(function(){
						var value=$(this).val();
						$.ajax({
							data:{id:value,modul:'get_kabupaten_by_id_provinsi'},
							success: function(respond){
								$("#kabupaten").change(function(){
									var value=$(this).val();
									$.ajax({
										data:{id:value,modul:'get_kecamatan_by_id_kabupaten'},
										success: function(respond){
											$("#kecamatan").html(respond);
										}
									})
								});
							}
						})
					});
				}
			})
		});
	})
</script>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
<div class="page-content-inner">
	<div class="m-heading-1 border-green m-bordered">
		<h3>Catatan</h3>
		<p> Kolom isian dengan tanda bintang (<font color='red'>*</font>) adalah wajib untuk di isi.</p>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light ">
				<div class="portlet-body">
					<form role="form" class="form-horizontal" action="<?=base_url('member_side/simpan_data_admin');?>" method="post"  enctype='multipart/form-data'>
					<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
					<input type="hidden" name="id_event" value="<?=$get_info->id_event;?>">
					<input type="hidden" name="role" value="<?=$get_info->keterangan;?>">
						<div class="form-body">
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Nama <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="nama" placeholder="Type something" required>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="fa fa-user"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Nomor Telpon</label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="no_hp" placeholder="Type something">
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="fa fa-phone"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Wilayah <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<select id='wilayah' name='role_name' class="form-control select2-allow-clear" required>
											<option value=''>-- Pilih --</option>
											<?php
											if($get_info->keterangan=='PILKADA KAB/KOTA'){
												echo"
												<option value='2c'>Admin Kabupaten/ Kota</option>
												<option value='3c'>Admin Kecamatan</option>
												";
											}elseif($get_info->keterangan=='SELURUH PILKADA'){
												echo"
												<option value='1a'>Admin Provinsi</option>
												<option value='2a'>Admin Kabupaten/ Kota</option>
												<option value='3a'>Admin Kecamatan</option>
												";
											}elseif($get_info->keterangan=='PILKADA PROVINSI'){
												echo"
												<option value='1b'>Admin Provinsi</option>
												<option value='2b'>Admin Kabupaten/ Kota</option>
												<option value='3b'>Admin Kecamatan</option>
												";
											}else{
												echo'';
											}
											?>
										</select>
									</div>
								</div>
							</div>
							<div id='muncul_1'>
							</div>
							<hr>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Username<span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="username" placeholder="Type something" required>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="fa fa-user"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Kata Sandi <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="password" class="form-control" name="pass" placeholder="Type something" required max='999'>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="fa fa-lock"></i>
									</div>
								</div>
							</div>
							<hr>
						</div>
						<br>
						<div class="form-actions margin-top-10">
							<div class="row">
								<div class="col-md-offset-2 col-md-10">
									<button type="reset" class="btn default">Batal</button>
									<button type="submit" class="btn blue">Simpan</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>