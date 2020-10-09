<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript">

	$(function(){

		$.ajaxSetup({
			type:"POST",
			url: "<?php echo site_url('/member/Report/ajax_function')?>",
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
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Command Center</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Rekap Laporan</span>
	</li>
</ul>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
<div class="page-content-inner">
	<div class="m-heading-1 border-green m-bordered">
		<h3>Catatan</h3>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light ">
				<div class="portlet-body">
					<div class="col-md-12">
						<form method='post' action='<?=site_url('member_side/rekap_laporan');?>'>
							<div class="form-group select2-bootstrap-prepend" >
								<label class="control-label col-md-3">Opsi pencarian</label>
								<div class="col-md-3">
									<select id='id_provinsi' name='id_provinsi' class="form-control" required>
										<option value="">-- Pilih Provinsi --</option>
										<?php
										$url_p = 'http://pradi.is-very-good.org:7733/api/prov/all/asc/';
										$data_p = $this->Main_model->getAPI($url_p);
										foreach ($data_p as $key => $value) {
											echo'<option value="'.$value['idProvinsi'].'">'.$value['namaProvinsi'].'</option>';
										}
										?>
									</select>
								</div>
								<div class="col-md-4">
									<select id='id_kabupaten' name='id_kabupaten' class="form-control">
										<option value="">-- Pilih Kabupaten/ Kota --</option>
									</select>
								</div>
								<div class="col-md-2">
								</div>
							</div>
							<br><br>
							<div class="form-group select2-bootstrap-prepend" >
								<label class="control-label col-md-3"></label>
								<div class="col-md-3">
									<select name='pekerjaan' class="form-control" required>
										<option value=''>-- Pilih Pekerjaan --</option>
										<option value='PNS'>PNS</option>
										<option value='Buruh'>Buruh</option>
										<option value='Pensiunan'>Pensiunan</option>
										<option value='Ibu Rumah Tangga'>Ibu Rumah Tangga</option>
										<option value='Pedagang'>Pedagang</option>
										<option value='Petani'>Petani</option>
										<option value='Pelajar/ Mahasiswa'>Pelajar/ Mahasiswa</option>
									</select>
								</div>
								<div class="col-md-6">
								</div>
							</div>
							<br>
							<br>
							<div class="form-group select2-bootstrap-prepend" >
								<label class="control-label col-md-3"></label>
								<div class="col-md-3">
									<button type="submit" class="btn btn-info">Proses</button>
								</div>
								<div class="col-md-6">
								</div>
							</div>
						</form>
					</div>
					<hr>
					<form action="#" method="post" onsubmit="return deleteConfirm();"/>
					<div class="table-toolbar">
					<br>
					<br>
					<br>
					<br>
					<br>
					<hr>
						<div class="row">
							<div class="col-md-6">
								<div class="btn-group">
									<button type='submit' id="sample_editable_1_new" class="btn sbold red"> Hapus
										<i class="fa fa-trash"></i>
									</button>
								</div>
								<span class="separator">|</span>
								<a href="<?=base_url('member_side/tambah_data_relawan');?>" class="btn green uppercase">Tambah Data <i class="fa fa-plus"></i> </a>
							</div>
						</div>
					</div>
					<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
						<thead>
							<tr>
								<th width="3%">
									<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
										<input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
										<span></span>
									</label>
								</th>
								<th style="text-align: center;" width="4%"> # </th>
								<th style="text-align: center;"> Judul Instruksi </th>
								<th style="text-align: center;"> Sasaran </th>
								<th style="text-align: center;"> Lokasi </th>
								<th style="text-align: center;"> Realisasi </th>
								<th style="text-align: center;" width="10%"> Aksi </th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							?>
							<tr class="odd gradeX">
								<td style="text-align: center;">
									<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
										<input type="checkbox" class="checkboxes" name="selected_id[]" value="#"/>
										<span></span>
									</label>
								</td>
								<td style="text-align: center;"><?= $no++.'.'; ?></td>
								<td style="text-align: center;">Mengadakan pengajian tiap malam jumat</td>
								<td style="text-align: center;">Guru</td>
								<td style="text-align: center;">Proyonanggan Tengah, Batang, Batang</td>
								<td style="text-align: center;">12 Orang</td>
								<td>
									<div class="btn-group" style="text-align: center;">
										<button class="btn btn-xs green" type="button" onclick="window.location.href='<?=base_url('member_side/detil_rekap/'.md5(1));?>'"> Detail Data
										</button>
									</div>
								</td>
							</tr>
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