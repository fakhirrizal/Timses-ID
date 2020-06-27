<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<style media="all" type="text/css">
    .alignCenter { text-align: center; }
</style>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Master</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Data Pengguna</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Ubah Data</span>
	</li>
</ul>
<script type="text/javascript">
	$(function(){
		$.ajaxSetup({
			type:"POST",
			url: "<?php echo site_url('/admin/Master/ajax_function')?>",
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
		$("#event").change(function(){
			var value=$(this).val();
			$.ajax({
				data:{id:value,modul:'get_role_event_by_id_event'},
				success: function(respond){
					$("#muncul_role_event").html(respond);
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
					<form role="form" class="form-horizontal" action="<?=base_url('admin_side/perbarui_data_pengguna');?>" method="post"  enctype='multipart/form-data'>
						<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                        <input type="hidden" name="iduser" value='<?= $data_user['idUserDatas']; ?>'>
                        <input type="hidden" name="idevent" value='<?= $data_user['idEvent']; ?>'>
                        <input type="hidden" name="id_wilayah" value='<?= $data_user['idWilayah']; ?>'>
                        <input type="hidden" name="uname" value='<?= $data_user['username']; ?>'>
                        <input type="hidden" name="pass_lama" value='<?= $data_user['password']; ?>'>
                        <input type="hidden" name="role_event" value='<?= $data_user['roleEvent']; ?>'>
                        <input type="hidden" name="roleUser" value='<?= $data_user['roleUser']; ?>'>
                        <input type="hidden" name="createdat" value='<?= $data_user['createdDate']; ?>'>
                        <input type="hidden" name="isactive" value='<?= $data_user['isActive']; ?>'>
                        <input type="hidden" name="userid_keterangan" value='<?= $data_user['keterangan']; ?>'>
						<div class="form-body">
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Nama <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="nama" placeholder="Type something" value='<?= $data_user['namaUser']; ?>' required>
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
										<input type="text" class="form-control" name="no_hp" placeholder="Type something" value='<?= $data_user['telepon']; ?>'>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="fa fa-phone"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Event <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<select id='event' class="form-control select2-allow-clear" required disabled>
											<option value=''>-- Pilih --</option>
											<?php
											$url1 = 'http://kertasfolio.id:99/api/event/all/asc';
											$data = $this->Main_model->getAPI($url1);
											foreach ($data as $key => $value) {
                                                if($value['idEvent']==$data_user['idEvent']){
                                                    echo'<option value="'.$value['idEvent'].'" selected>'.$value['namaEvent'].'</option>';
                                                }else{
                                                    echo'<option value="'.$value['idEvent'].'">'.$value['namaEvent'].'</option>';
                                                }
											}
											?>
										</select>
									</div>
								</div>
							</div>
							<div id='muncul_role_event'>
							</div>
							<hr>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Username<span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" placeholder="Type something" value='<?= $data_user['username']; ?>' required disabled>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="fa fa-user"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Kata Sandi </label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="password" class="form-control" name="pass" placeholder="Type something" max='999'>
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