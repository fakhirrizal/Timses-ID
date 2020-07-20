<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Master</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Data Siswa</span>
	</li>
</ul>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
<div class="page-content-inner">
	<div class="m-heading-1 border-green m-bordered">
		<h3>Catatan</h3>
		<p> Ketika mengklik <b>Atur Ulang Sandi</b>, maka kata sandi otomatis menjadi "<b>1234</b>"</p>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light ">
				<div class="portlet-body">
					<form action="#" method="post" onsubmit="return deleteConfirm();"/>
					<div class="table-toolbar">
						<div class="row">
							<div class="col-md-6">
								<div class="btn-group">
									<button type='submit' id="sample_editable_1_new" class="btn sbold red"> Hapus
										<i class="fa fa-trash"></i>
									</button>
								</div>
								<span class="separator">|</span>
								<a href="<?=base_url('member_side/tambah_data_admin');?>" class="btn green uppercase">Tambah Data <i class="fa fa-plus"></i> </a>
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
								<th style="text-align: center;"> Nama </th>
								<th style="text-align: center;"> Username </th>
								<th style="text-align: center;"> Email </th>
								<th style="text-align: center;" width="7%"> Aksi </th>
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
								<td style="text-align: center;">Imam Fajrul Falah</td>
								<td style="text-align: center;">imam_fajrul</td>
								<td style="text-align: center;">imam@gmail.com</td>
								<td>
									<div class="btn-group" style="text-align: center;">
										<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Aksi
											<i class="fa fa-angle-down"></i>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a href="<?=site_url('member_side/detail_data_admin/');?>">
													<i class="icon-eye"></i> Detail Data </a>
											</li>
											<li>
												<a href="<?=site_url('member_side/ubah_data_admin/');?>">
													<i class="icon-wrench"></i> Ubah Data </a>
											</li>
											<li>
												<a onclick="return confirm('Anda yakin?')" href="<?=site_url('member_side/hapus_data_admin/');?>">
													<i class="icon-trash"></i> Hapus Data </a>
											</li>
											<li class="divider"> </li>
											<li>
												<a href="<?=site_url('member_side/atur_ulang_kata_sandi_admin/');?>">
													<i class="fa fa-refresh"></i> Atur Ulang Sandi
												</a>
											</li>
										</ul>
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