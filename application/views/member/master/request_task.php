<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<style media="all" type="text/css">
    .alignCenter { text-align: center; }
</style>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Data Usulan</span>
		<!-- <i class="fa fa-circle"></i> -->
	</li>
	<!-- <li>
		<span>Data Kube (Kelompok Usaha Bersama)</span>
	</li> -->
</ul>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
<div class="page-content-inner">
	<div class="m-heading-1 border-green m-bordered">
		<h3>Catatan</h3>
		<!-- <p> Untuk menambahkan data anggota Kube silahkan klik detil data kube-nya.</p> -->
	</div>
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light ">
				<div class="portlet-body">
					<!-- <div class="form-group select2-bootstrap-prepend" >
						<label class="control-label col-md-2">Opsi pencarian berdasarkan <b>Status</b></label>
						<div class="col-md-5">
							<select id='pilihan' class="form-control select2-allow-clear">
								<option value=""></option>
								<option value="2">Aktif</option>
								<option value="2">Pending</option>
								<option value="19">Tidak Aktif</option>
							</select>
						</div>
					</div>
					<br>
					<hr> -->
					<form action="#" method="post" onsubmit="return deleteConfirm();"/>
					<div class="table-toolbar">
						<!-- <div class="row">
							<div class="col-md-6">
								<div class="btn-group">
									<button type='submit' id="sample_editable_1_new" class="btn sbold red"> Hapus
										<i class="fa fa-trash"></i>
									</button>
								</div>
									<span class="separator">|</span>
									<a href="<?=base_url('member_side/tambah_data_kube');?>" class="btn green uppercase">Tambah Data <i class="fa fa-plus"></i> </a>
									<button id="sample_editable_1_new" onclick="window.location.href='<?=base_url('Master/admin');?>'" class="btn sbold green"> Tambah Data Baru
										<i class="fa fa-plus"></i>
									</button>
							</div>
						</div> -->
						<div class="row">
							<div class="col-md-8">
								<div class="btn-group">
									<button type='submit' id="sample_editable_1_new" class="btn sbold red"> Hapus
										<i class="fa fa-trash"></i>
									</button>
								</div>
									<!-- <span class="separator">|</span>
									<a href="<?=base_url('member_side/tambah_data_kube');?>" class="btn green uppercase">Tambah Data <i class="fa fa-plus"></i> </a> -->
							</div>
							<!-- <div class="col-md-4" style='text-align: right;'>
								<a href="#" class="btn btn-info" data-toggle="modal" data-target="#fi">Impor Data <i class="fa fa-cloud-upload"></i></a>
								<a href="<?=base_url()?>import_data_template/template_kube.xlsx" class="btn btn-warning">Unduh Template</a>
							</div> -->
						</div>
					</div>
					<table class="table table-striped table-bordered table-hover table-checkable order-column" style="overflow-x: auto;width: 120%;" id="tbl">
						<thead>
							<tr>
								<th width="3%">
									<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
										<input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
										<span></span>
									</label>
								</th>
								<th style="text-align: center;" width="4%"> # </th>
								<th style="text-align: center;"> Judul Usulan </th>
								<th style="text-align: center;"> Kelurahan </th>
								<th style="text-align: center;"> Tanggal </th>
								<th style="text-align: center;"> Jam </th>
								<th style="text-align: center;"> Status </th>
								<th style="text-align: center;" width="7%"> Aksi </th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							// foreach ($data_tabel as $key => $value) {
							?>
							<tr class="odd gradeX">
								<td style="text-align: center;">
									<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
										<input type="checkbox" class="checkboxes" name="selected_id[]" value="#"/>
										<span></span>
									</label>
								</td>
								<td style="text-align: center;"><?= $no++.'.'; ?></td>
								<td style="text-align: center;">Mengadakan Lomba E-Sport</td>
								<td style="text-align: center;">Proyonanggan Tengah</td>
								<td style="text-align: center;">12 Oktober 2019</td>
								<td style="text-align: center;">08:00 - Selesai</td>
								<td style="text-align: center;"><span class="label label-sm label-warning">Tertunda</span></td>
								<td>
									<div class="btn-group" style="text-align: center;">
										<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Aksi
											<i class="fa fa-angle-down"></i>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a href="#">
													<i class="fa fa-check"></i> Setujui </a>
											</li>
											<li>
												<a onclick="return confirm('Anda yakin?')" href="#">
													<i class="fa fa-close"></i> Tolak </a>
											</li>
										</ul>
									</div>
								</td>
							</tr>
							<?php
							// }
							?>
						</tbody>
					</table>
					</form>
					<script type="text/javascript">
					function deleteConfirm(){
						var result = confirm("Yakin akan menghapus data ini?");
						if(result){
							return true;
						}else{
							return false;
						}
					}
					</script>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		$.ajaxSetup({
			type:"POST",
			url: "<?php echo site_url('/member/Master/ajax_function')?>",
			cache: false,
		});
		$("#id_provinsi").change(function(){
			var value=$(this).val();
			$.ajax({
				data:{id:value,modul:'get_kabupaten_by_id_provinsi'},
				success: function(respond){
					$("#id_kabupaten").html(respond);
				}
			})
		});
	})
</script>
<div class="modal fade" id="fi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Form Import</h4>
			</div>
			<form role="form" action="<?php echo base_url()."admin/Master/import_kube_data"; ?>" method='post' enctype="multipart/form-data">
				<div class="modal-body">
					<div class="form-body">
						<div class="form-group form-md-line-input has-danger">
							<label class="col-md-3 control-label" for="form_control_1">Provinsi <span class="required"> * </span></label>
							<div class="col-md-9">
								<div class="input-icon">
									<select name='id_provinsi' id='id_provinsi' class="form-control select2-allow-clear" required>
										<option value=''></option>
										<?php
										foreach ($provinsi as $key => $value) {
											echo '<option value="'.$value->id_provinsi.'">'.$value->nm_provinsi.'</option>';
										}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="form-group form-md-line-input has-danger">
							<label class="col-md-3 control-label" for="form_control_1">Kabupaten/ Kota <span class="required"> * </span></label>
							<div class="col-md-9">
								<div class="input-icon">
									<select name='id_kabupaten' id='id_kabupaten' class="form-control select2-allow-clear" required>
										<option value=''></option>
									</select>
								</div>
							</div>
						</div>
						<div class="form-group form-md-line-input has-danger">
							<label class="col-md-3 control-label" for="form_control_1">Tahun Program <span class="required"> * </span></label>
							<div class="col-md-3">
								<div class="input-icon">
									<select name='tahun' class="form-control select2-allow-clear" required>
										<option value=''>-- Pilih --</option>
										<option value='2015'>2015</option>
										<option value='2016'>2016</option>
										<option value='2017'>2017</option>
										<option value='2018'>2018</option>
										<option value='2019'>2019</option>
									</select>
								</div>
							</div>
							<label class="col-md-2 control-label" for="form_control_1">Tahap <span class="required"> * </span></label>
							<div class="col-md-4">
								<div class="input-icon">
									<select name='tahap' class="form-control select2-allow-clear" required>
										<option value=''>-- Pilih --</option>
										<option value='1'>Tahap 1</option>
										<option value='2'>Tahap 2</option>
										<option value='3'>Tahap 3</option>
									</select>
								</div>
							</div>
						</div>
						<div class="form-group form-md-line-input has-danger">
							<label class="col-md-3 control-label" for="form_control_1">File Import <span class="required"> * </span></label>
							<div class="col-md-9">
								<div class="input-icon">
									<input class="form-control" type="file" name='fmasuk' required>
									<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-primary">Unggah</button>
				</div>
			</form>
		</div>
	</div>
</div>