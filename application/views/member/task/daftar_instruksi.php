<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<style media="all" type="text/css">
    .alignCenter { text-align: center; }
</style>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Data Instruksi</span>
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
					<form action="#" method="post" onsubmit="return deleteConfirm();"/>
					<div class="table-toolbar">
						<div class="row">
							<div class="col-md-8">
								<a href="<?= site_url('member_side/tambah_instruksi/'); ?>" class="btn green uppercase">Tambah Data <i class="fa fa-plus"></i> </a>
							</div>
						</div>
					</div>
					<table class="table table-striped table-bordered table-hover order-column" style="overflow-x: auto;width: 100%;" id="tbl">
						<thead>
							<tr>
								
								<th style="text-align: center;" width="4%"> # </th>
								<th style="text-align: center;"> Judul Instruksi </th>
								<th style="text-align: center;"> Deskripsi </th>
								<th style="text-align: center;"> Waktu </th>
								<th style="text-align: center;"> Wilayah </th>
								<th style="text-align: center;"> Relawan </th>
								<th style="text-align: center;"> Status </th>
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
								<td style="text-align: center;">Mengadakan pengajian</td>
								<td style="text-align: center;">1 Desember - 20 Desember 2019</td>
								<td style="text-align: center;">Kecamatan Batang</td>
								<td style="text-align: center;">Ibu-ibu PKK</td>
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
								<td style="text-align: center;">Inisiasi gotong royong tingkat kampung</td>
								<td style="text-align: center;">1 Desember - 31 Desember 2019</td>
								<td style="text-align: center;">Kecamatan Tulis</td>
								<td style="text-align: center;">Bapak rumah tangga</td>
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
					<script type="text/javascript" language="javascript" >
						// $(document).ready(function(){
						// 	$('#tbl').dataTable({
						// 	});
						// });
						$(document).ready(function(){
							$('#tbl').dataTable({
								"order": [[ 0, "asc" ]],
								"bProcessing": true,
								"ajax" : {
									url:"<?= site_url('member/Task/json_task_data'); ?>"
								},
								"aoColumns": [
											{ mData: 'number', sClass: "alignCenter" },
											{ mData: 'judul', sClass: "alignCenter" } ,
											{ mData: 'deskripsi', sClass: "alignCenter" },
											{ mData: 'waktu', sClass: "alignCenter" },
											{ mData: 'wilayah', sClass: "alignCenter" },
											{ mData: 'relawan', sClass: "alignCenter" },
											{ mData: 'status', sClass: "alignCenter" },
											{ mData: 'action' }
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