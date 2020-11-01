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
		<span>Ubah Data</span>
	</li>
</ul>
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
					<form role="form" class="form-horizontal" action="<?= base_url().'relawan_side/perbarui_data_relawan'; ?>" method="post"  enctype='multipart/form-data'>
					<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
						<input type="hidden" name="id_relawan" value="<?=$data_utama['idRelawan'];?>">
						<input type="hidden" name="id_event" value="<?=$data_utama['idEvent'];?>">
						<input type="hidden" name="password" value="<?=$data_utama['password'];?>">
						<!-- <input type="hidden" name="id_desa" value="<?=$data_utama['idDesa'];?>"> -->
						<input type="hidden" name="id_kecamatan" value="<?=$data_utama['idKecamatan'];?>">
						<input type="hidden" name="id_kabupaten" value="<?=$data_utama['idKabupaten'];?>">
						<input type="hidden" name="id_provinsi" value="<?=$data_utama['idProvinsi'];?>">
						<input type="hidden" name="desa" value="<?=$data_utama['desa'];?>">
						<input type="hidden" name="kecamatan" value="<?=$data_utama['kecamatan'];?>">
						<input type="hidden" name="kabupaten" value="<?=$data_utama['kabupaten'];?>">
						<input type="hidden" name="provinsi" value="<?=$data_utama['provinsi'];?>">
						<input type="hidden" name="is_active" value="<?=$data_utama['isActive'];?>">
						<input type="hidden" name="created_at" value="<?=$data_utama['createdDate'];?>">
						<div class="form-body">
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Nama <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="nama" placeholder="Type something" required value="<?=$data_utama['namaRelawan'];?>">
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
										<input type="text" class="form-control" name="nik" placeholder="Type something" required value="<?=$data_utama['NIK'];?>">
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="icon-credit-card"></i>
									</div>
								</div>
							</div>
							<!-- <div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Nomor Telpon</label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="no_hp" placeholder="Type something" value="<?=$data_utama['telepon'];?>">
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="fa fa-phone"></i>
									</div>
								</div>
							</div> -->
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Kelurahan/ Desa <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<select id="desa" name="id_desa" class="form-control select2-allow-clear" required>
											<option value="">-- Pilih --</option>
											<?php
											$url1 = 'http://pradi.is-very-good.org:7733/api/desa/kec/'.$data_utama['idKecamatan'];
											$data = $this->Main_model->getAPI($url1);
											foreach ($data as $key => $value) {
												if($value['idDesa']==$data_utama['idDesa']){
													echo'<option value="'.$value['idDesa'].'" selected>'.$value['namaDesa'].'</option>';
												}else{
													echo'<option value="'.$value['idDesa'].'">'.$value['namaDesa'].'</option>';
												}
											}
											?>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Pekerjaan <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<select name='pekerjaan' class="form-control select2-allow-clear" required>
											<option value=''>-- Pilih --</option>
											<option value='PNS' <?php if($data_utama['pekerjaan']=='PNS'){echo'selected';}else{echo'';} ?>>PNS</option>
											<option value='Buruh' <?php if($data_utama['pekerjaan']=='Buruh'){echo'selected';}else{echo'';} ?>>Buruh</option>
											<option value='Pensiunan' <?php if($data_utama['pekerjaan']=='Pensiunan'){echo'selected';}else{echo'';} ?>>Pensiunan</option>
											<option value='Ibu Rumah Tangga' <?php if($data_utama['pekerjaan']=='Ibu Rumah Tangga'){echo'selected';}else{echo'';} ?>>Ibu Rumah Tangga</option>
											<option value='Pedagang' <?php if($data_utama['pekerjaan']=='Pedagang'){echo'selected';}else{echo'';} ?>>Pedagang</option>
											<option value='Petani' <?php if($data_utama['pekerjaan']=='Petani'){echo'selected';}else{echo'';} ?>>Petani</option>
											<option value='Pelajar/ Mahasiswa' <?php if($data_utama['pekerjaan']=='Pelajar/ Mahasiswa'){echo'selected';}else{echo'';} ?>>Pelajar/ Mahasiswa</option>
											<option value='WIRASWASTA' <?php if($data_utama['pekerjaan']=='WIRASWASTA'){echo'selected';}else{echo'';} ?>>WIRASWASTA</option>
											<option value='PEGAWAI SWASTA' <?php if($data_utama['pekerjaan']=='PEGAWAI SWASTA'){echo'selected';}else{echo'';} ?>>PEGAWAI SWASTA</option>
											<option value='GURU/STAF PENGAJAR' <?php if($data_utama['pekerjaan']=='GURU/STAF PENGAJAR'){echo'selected';}else{echo'';} ?>>GURU/STAF PENGAJAR</option>
											<option value='LAIN-LAIN' <?php if($data_utama['pekerjaan']=='LAIN-LAIN'){echo'selected';}else{echo'';} ?>>LAIN-LAIN</option>
										</select>
									</div>
								</div>
							</div>
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