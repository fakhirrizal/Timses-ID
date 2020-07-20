<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Master</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Target Suara</span>
	</li>
</ul>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
<div class="page-content-inner">
	<div class="m-heading-1 border-green m-bordered">
		<h3>Catatan</h3>
		<p> 1. Kolom isian dengan tanda bintang (<font color='red'>*</font>) adalah wajib untuk di isi.</p>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light ">
				<div class="portlet-body">
					<form role="form" class="form-horizontal" action="<?=base_url('member_side/perbarui_target_suara');?>" method="post"  enctype='multipart/form-data'>
						<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
						<div class="form-body">
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Target Suara <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="number" class="form-control" name="target_suara" placeholder="Type something" value='98.201' required>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="icon-pin"></i>
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
					<hr>
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
						</tbody>
					</table>
					<script type="text/javascript" language="javascript" >
						$(document).ready(function(){
							$('#tbl').dataTable({
							});
						});
					</script>
				</div>
			</div>
		</div>
	</div>
</div>