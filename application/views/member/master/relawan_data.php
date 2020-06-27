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
		<span>Data Relawan</span>
	</li>
</ul>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
<div class="page-content-inner">
	<div class="m-heading-1 border-green m-bordered">
		<h3>Catatan</h3>
		<!-- <p> Tipe file yang diizinkan adalah <b>.xlsx</b></p> -->
	</div>
	<div class="row">
		<div class="col-md-12">
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
						<div class="row">
							<div class="col-md-8">
								<a href="<?= site_url('member_side/tambah_data_relawan/'); ?>" class="btn green uppercase">Tambah Data <i class="fa fa-plus"></i> </a>
							</div>
							<!-- <div class="col-md-4" style='text-align: right;'>
								<a href="#" class="btn btn-info" data-toggle="modal" data-target="#fi">Impor Data <i class="fa fa-cloud-upload"></i></a>
								<a href="<?=base_url()?>import_data_template/template_wo.xlsx" class="btn btn-warning">Unduh Template</a>
							</div> -->
						</div>
					</div>
					<table class="table table-striped table-bordered table-hover order-column" style="overflow-x: auto;width: 100%;" id="tbl">
						<thead>
							<tr>
								
								<th style="text-align: center;" width="4%"> # </th>
								<th style="text-align: center;"> Nama </th>
								<th style="text-align: center;"> NIK </th>
								<th style="text-align: center;"> No. HP</th>
								<th style="text-align: center;"> Pekerjaan </th>
								<th style="text-align: center;"> Wilayah </th>
								<th style="text-align: center;" width="7%"> Aksi </th>
							</tr>
						</thead>
						<!-- <tbody> -->
							<?php
							$no = 1;
							// foreach ($data_tabel as $key => $value) {
							?>
							<!-- <tr class="odd gradeX">
								<td style="text-align: center;"><?= $no++.'.'; ?></td>
								<td style="text-align: center;">Alan Surapraja</td>
								<td style="text-align: center;">12341116119412345</td>
								<td style="text-align: center;">+62 8976 5265 01</td>
								<td style="text-align: center;">Karyawan Swasta</td>
								<td style="text-align: center;">Proyonanggan Utara</td>
								<td>
									<div class="dropdown">
										<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Aksi
											<i class="fa fa-angle-down"></i>
										</button>
										<ul class="dropdown-menu pull-right" role="menu">
											<li>
												<a href="#">
													<i class="icon-eye"></i> Detail Data </a>
											</li>
											<li>
												<a href="#">
													<i class="icon-wrench"></i> Ubah Data </a>
											</li>
											<li>
												<a onclick="return confirm('Anda yakin?')" href="#">
													<i class="icon-trash"></i> Hapus Data </a>
											</li>
										</ul>
									</div>
								</td>
							</tr>
							<tr class="odd gradeX">
								<td style="text-align: center;"><?= $no++.'.'; ?></td>
								<td style="text-align: center;">Supriyadi</td>
								<td style="text-align: center;">33251116119400004</td>
								<td style="text-align: center;">+62 8569 6303 627</td>
								<td style="text-align: center;">Guru</td>
								<td style="text-align: center;">Proyonanggan Tengah</td>
								<td>
									<div class="dropdown">
										<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Aksi
											<i class="fa fa-angle-down"></i>
										</button>
										<ul class="dropdown-menu pull-right" role="menu">
											<li>
												<a href="#">
													<i class="icon-eye"></i> Detail Data </a>
											</li>
											<li>
												<a href="#">
													<i class="icon-wrench"></i> Ubah Data </a>
											</li>
											<li>
												<a onclick="return confirm('Anda yakin?')" href="#">
													<i class="icon-trash"></i> Hapus Data </a>
											</li>
										</ul>
									</div>
								</td>
							</tr> -->
							<?php
							// }
							?>
						<!-- </tbody> -->
					</table>
					</form>
					<!-- <script type="text/javascript" language="javascript" >
						$(document).ready(function(){
							$('#tbl').dataTable({
							});
						});
					</script> -->
					<script type="text/javascript" language="javascript" >
						$(document).ready(function(){
							$('#tbl').dataTable({
								"order": [[ 0, "asc" ]],
								"bProcessing": true,
								"ajax" : {
									url:"<?= site_url('member/Master/json_relawan_data'); ?>"
								},
								"aoColumns": [
											{ mData: 'number', sClass: "alignCenter" },
											{ mData: 'nama' } ,
											{ mData: 'nik', sClass: "alignCenter" },
											{ mData: 'no_hp', sClass: "alignCenter" },
											{ mData: 'pekerjaan', sClass: "alignCenter" },
											{ mData: 'wilayah', sClass: "alignCenter" },
											{ mData: 'aksi' }
										]
							});
						});
					</script>
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