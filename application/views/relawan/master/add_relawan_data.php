<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Master</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Data Relawan</span>
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
			url: "<?php echo site_url('/relawan/Master/ajax_function')?>",
			cache: false,
		});
		$("#kabupaten").change(function(){
			var value=$(this).val();
			$.ajax({
				data:{id:value,modul:'get_kecamatan_by_id_kabupaten'},
				success: function(respond){
					$("#kecamatan").html(respond);
				}
			})
		});
		$("#kecamatan").change(function(){
			var value=$(this).val();
			$.ajax({
				data:{id:value,modul:'get_desa_by_id_kecamatan'},
				success: function(respond){
					$("#desa").html(respond);
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
		<p> 1. Kolom isian dengan tanda bintang (<font color='red'>*</font>) adalah wajib untuk di isi.</p>
		<p> 2. Kolom <b>Nomor Telpon</b> akan dijadikan <b>username</b>, <b>NIK</b> akan dijadikan <b>kata sandi</b> untuk masuk Aplikasi (Mobile & WEB).</p>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light ">
				<div class="portlet-body">
					<form role="form" class="form-horizontal" action="<?= base_url().'relawan_side/simpan_data_relawan'; ?>" method="post"  enctype='multipart/form-data'>
					<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
					<input type="hidden" name="id_event" value="<?=$get_info['idEvent'];?>">
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
								<label class="col-md-2 control-label" for="form_control_1">NIK <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="nik" placeholder="Type something" required>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="icon-credit-card"></i>
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
								<label class="col-md-2 control-label" for="form_control_1">Pekerjaan <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<select name='pekerjaan' class="form-control select2-allow-clear" required>
											<option value=''>-- Pilih --</option>
											<option value='PNS'>PNS</option>
											<option value='Buruh'>Buruh</option>
											<option value='Pensiunan'>Pensiunan</option>
											<option value='Ibu Rumah Tangga'>Ibu Rumah Tangga</option>
											<option value='Pedagang'>Pedagang</option>
											<option value='Petani'>Petani</option>
											<option value='Pelajar/ Mahasiswa'>Pelajar/ Mahasiswa</option>
											<option value='WIRASWASTA'>WIRASWASTA</option>
											<option value='PEGAWAI SWASTA'>PEGAWAI SWASTA</option>
											<option value='GURU/STAF PENGAJAR'>GURU/STAF PENGAJAR</option>
											<option value='LAIN-LAIN'>LAIN-LAIN</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<?php
								if($get_info['roleEvent']=='5469458f-8760-45b1-b05a-a4ca3aab2461'){
									echo'<label class="col-md-2 control-label" for="form_control_1">Kabupaten/ Kota <span class="required"> * </span></label>';
								}elseif($get_info['roleEvent']=='dbabb74d-df5b-4b79-820b-057abdf99b1a'){
									echo'<label class="col-md-2 control-label" for="form_control_1">Kecamatan <span class="required"> * </span></label>';
								}else{
									echo'<label class="col-md-2 control-label" for="form_control_1">Wilayah <span class="required"> * </span></label>';
								}
								?>
								<div class="col-md-10">
									<div class="input-icon">
										<?php
										if($get_info['roleEvent']=='5469458f-8760-45b1-b05a-a4ca3aab2461'){
											echo'
											<select id="kabupaten" name="kabupaten" class="form-control select2-allow-clear" required>
												<option value="">-- Pilih --</option>
											';
											$url1 = 'http://pradi.is-very-good.org:7733/api/kab/prov/'.$get_info['idWilayahEvent'];
											$data = $this->Main_model->getAPI($url1);
											foreach ($data as $key => $value) {
												echo'<option value="'.$value['idKabupaten'].'">'.$value['namaKabupaten'].'</option>';
											}
											echo'</select>
											';
										}elseif($get_info['roleEvent']=='dbabb74d-df5b-4b79-820b-057abdf99b1a'){
											echo'
											<select id="kecamatan" name="kecamatan" class="form-control select2-allow-clear" required>
												<option value="">-- Pilih --</option>
											';
											$url1 = 'http://pradi.is-very-good.org:7733/api/kec/kab/'.$get_info['idWilayahEvent'];
											$data = $this->Main_model->getAPI($url1);
											foreach ($data as $key => $value) {
												echo'<option value="'.$value['idKecamatan'].'">'.$value['namaKecamatan'].'</option>';
											}
											echo'</select>';
										}else{
											echo'
											<select id="wilayah" name="wilayah" class="form-control select2-allow-clear" required>
												<option value="">-- Pilih --</option>
											</select>
											';
										}
										?>
									</div>
								</div>
							</div>
							<?php
							if($get_info['roleEvent']=='5469458f-8760-45b1-b05a-a4ca3aab2461'){
							?>
							<input type="hidden" name="provinsi" value="<?= $get_info['idWilayahEvent']; ?>">
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Kecamatan <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<select id="kecamatan" name="kecamatan" class="form-control select2-allow-clear" required>
											<option value="">-- Pilih --</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Kelurahan/ Desa <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<select id="desa" name="desa" class="form-control select2-allow-clear" required>
											<option value="">-- Pilih --</option>
										</select>
									</div>
								</div>
							</div>
							<?php
							}elseif($get_info['roleEvent']=='dbabb74d-df5b-4b79-820b-057abdf99b1a'){
							?>
							<input type="hidden" name="provinsi" value="<?= substr($get_info['idWilayahEvent'],0,2); ?>">
							<input type="hidden" name="kabupaten" value="<?= $get_info['idWilayahEvent']; ?>">
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Kelurahan/ Desa <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<select id="desa" name="desa" class="form-control select2-allow-clear" required>
											<option value="">-- Pilih --</option>
										</select>
									</div>
								</div>
							</div>
							<?php
							}else{
								echo'';
							}
							?>
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