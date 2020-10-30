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
		<span><a href='<?= site_url('/member_side/relawan'); ?>'>Data Relawan</a></span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Detil Data</span>
	</li>
</ul>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
<?php
$id_relawan = '';
$url_event = 'http://pradi.is-very-good.org:7733/api/event/id/'.$data_relawan['idEvent'];
$data_event = $this->Main_model->getAPI($url_event);
?>
<div class="page-content-inner">
	<div class="m-heading-1 border-green m-bordered">
		<h3>Catatan</h3>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light ">
				<div class="portlet-body">
					<div class='row'>
						<div class="col-md-12">
							<table class="table">
								<tbody>
									<tr>
										<td> Nama </td>
										<td> : </td>
										<td><?php echo $data_relawan['namaRelawan']; ?></td>
									</tr>
									<tr>
										<td> Event </td>
										<td> : </td>
										<td><?php echo $data_event['namaEvent']; ?></td>
									</tr>
									<tr>
										<td> No. Hp </td>
										<td> : </td>
										<td><?php echo $data_relawan['telepon']; ?></td>
									</tr>
									<tr>
										<td> NIK </td>
										<td> : </td>
										<td><?php echo $data_relawan['NIK']; ?></td>
									</tr>
									<tr>
										<td> Pekerjaan </td>
										<td> : </td>
										<td><?php echo $data_relawan['pekerjaan']; ?></td>
									</tr>
									<tr>
										<td> Desa/ Kelurahan </td>
										<td> : </td>
										<td><?php echo $data_relawan['desa']; ?></td>
									</tr>
									<tr>
										<td> Kecamatan </td>
										<td> : </td>
										<td><?php echo $data_relawan['kecamatan']; ?></td>
									</tr>
									<tr>
										<td> Kabupaten/ Kota </td>
										<td> : </td>
										<td><?php echo $data_relawan['kabupaten']; ?></td>
									</tr>
									<tr>
										<td> Provinsi </td>
										<td> : </td>
										<td><?php echo $data_relawan['provinsi']; ?></td>
									</tr>
									<tr>
										<td> </td>
										<td> </td>
										<td> </td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="col-md-12" >
							<div class="tabbable-line">
								<ul class="nav nav-tabs ">
									<li class="active">
										<a href="#tab_15_1" data-toggle="tab"> Daftar Rekrutmen </a>
									</li>
									<!-- <li>
										<a href="#tab_15_2" data-toggle="tab"> Daftar Realisasi Intruksi </a>
									</li> -->
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="tab_15_1">
										<!-- <div class="table-toolbar">
											<div class="row">
												<div class="col-md-6">
													<a data-toggle="modal" data-target="#tambahdataanggota" class="btn green uppercase">Tambah Data <i class="fa fa-plus"></i> </a>
												</div>
											</div>
										</div> -->
										<table class="table table-striped table-bordered" id="tbl1">
											<thead>
												<!-- <tr>
													<th style="text-align: center;" width="4%"> # </th>
													<th style="text-align: center;"> Nama </th>
													<th style="text-align: center;"> NIK </th>
													<th style="text-align: center;" width="10%"> Foto </th>
												</tr> -->
												<tr>
													<th style="text-align: center;" width="4%"> # </th>
													<th style="text-align: center;"> Nama </th>
													<th style="text-align: center;"> No. HP </th>
													<th style="text-align: center;"> NIK </th>
													<th style="text-align: center;"> Pekerjaan </th>
													<th style="text-align: center;"> Alamat </th>
													<th style="text-align: center;"> Status </th>
												</tr>
                                            </thead>
                                            <tbody>
                                                <!-- <tr>
                                                    <td style="text-align: center;">1.</td>
                                                    <td style="text-align: center;">Mukhammad Fakhir Rizal</td>
                                                    <td style="text-align: center;">3325111611940004</td>
                                                    <td style="text-align: center;"><a class="btn green-sharp btn-outline btn-block sbold detaildata" data-toggle="modal" data-target="#detaildata" id="<?= md5(1); ?>">Lihat Foto</a></td>
                                                    <div class="modal fade" id="detaildata" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="box box-primary" id='formdetaildata' style="text-align: center;">
                                                                        <img src='https://s0.bukalapak.com/img/5654525602/w-1000/Pas_Photo_scaled.jpg' width='50%'>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
												</tr> -->
												<?php
												$no = 1;
												foreach ($data_rekrutmen as $key => $value) {
													$url5 = 'http://pradi.is-very-good.org:7733/api/kec/id/'.$value['idKecamatan'];
													$data_kec = $this->Main_model->getAPI($url5);
													$url6 = 'http://pradi.is-very-good.org:7733/api/desa/id/'.$value['idDesa'];
													$data_desa = $this->Main_model->getAPI($url6);
													$status = '';
													if($value['isVerified']==true){
														$status = 'Terverifikasi';
													}else{
														$status = 'Belum Terverifikasi';
													}
												?>
													<tr class="odd gradeX">
														<td style="text-align: center;"><?= $no++.'.'; ?></td>
														<td style="text-align: center;"><?= $value['namaRekrutmen']; ?></td>
														<td style="text-align: center;"><?= $value['telepon']; ?></td>
														<td style="text-align: center;"><?= $value['NIK']; ?></td>
														<td style="text-align: center;"><?= $value['pekerjaan']; ?></td>
														<td style="text-align: center;"><?= $data_desa['namaDesa'].', '.$data_kec['namaKecamatan']; ?></td>
														<td style="text-align: center;"><?= $status; ?></td>
													</tr>
												<?php
												}
												?>
                                            </tbody>
										</table>
									</div>
									<!-- <div class="tab-pane" id="tab_15_2">
										<table class="table table-striped table-bordered" id="tbl2">
											<thead>
												<tr>
													<th style="text-align: center;" width="4%"> # </th>
													<th style="text-align: center;"> Judul Instruksi </th>
													<th style="text-align: center;"> Tanggal Realisasi </th>
													<th style="text-align: center;" width="10%"> Foto </th>
												</tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="text-align: center;">1.</td>
                                                    <td style="text-align: center;">Koordinasi jalan sehat se-Kecamatan</td>
                                                    <td style="text-align: center;">12 Desember 2019</td>
                                                    <td style="text-align: center;"><a class="btn green-sharp btn-outline btn-block sbold detaildata" data-toggle="modal" data-target="#detaildata1" id="<?= md5(1); ?>">Lihat Foto</a></td>
                                                    <div class="modal fade" id="detaildata1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="box box-primary" id='formdetaildata' style="text-align: center;">
                                                                        <img src='https://rakyatjelata.com/wp-content/uploads/2019/08/03754841-59C7-445C-94E8-D40B7AE9AE4B.jpeg' width='80%'>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </tr>
                                            </tbody>
										</table>
									</div> -->
								</div>
							</div>
						</div>
						<div class="col-md-12" >
						<hr><a href="<?php echo base_url()."relawan_side/daftar_relawan"; ?>" class="btn btn-info" role="button"><i class="fa fa-angle-double-left"></i> Kembali</a></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="tambahdataanggota" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Form Tambah Data Anggota</h4>
				</div>
				<div class="modal-body">
					<div class="box box-primary">
						<form role="form" class="form-horizontal" action="<?=base_url('member_side/simpan_data_anggota_relawan');?>" method="post">
							<input type="hidden" name="id_relawan" value="<?= $id_relawan; ?>">
							<div class="form-body">
								<div class="form-group form-md-line-input has-danger">
									<label class="col-md-3 control-label" for="form_control_1">Nama Lengkap <span class="required"> * </span></label>
									<div class="col-md-9">
										<div class="input-icon">
											<input type="text" class="form-control" name="nama" placeholder="Type something" required>
											<div class="form-control-focus"> </div>
											<span class="help-block">Some help goes here...</span>
											<i class="fa fa-user"></i>
										</div>
									</div>
								</div>
								<div class="form-group form-md-line-input has-danger">
									<label class="col-md-3 control-label" for="form_control_1">NIK (Nomor Induk Kependudukan) <span class="required"> * </span></label>
									<div class="col-md-9">
										<div class="input-icon">
											<input type="text" class="form-control" name="nik" placeholder="Type something" required>
											<div class="form-control-focus"> </div>
											<span class="help-block">Some help goes here...</span>
											<i class="fa fa-credit-card"></i>
										</div>
									</div>
								</div>
								<div class="form-group form-md-line-input has-danger">
									<label class="col-md-3 control-label" for="form_control_1">BDT <span class="required"> * </span></label>
									<div class="col-md-9">
										<div class="input-icon">
											<input type="text" class="form-control" name="bdt" placeholder="Type something" required>
											<div class="form-control-focus"> </div>
											<span class="help-block">Some help goes here...</span>
											<i class="fa fa-credit-card"></i>
										</div>
									</div>
								</div>
								<div class="form-group form-md-line-input has-danger">
									<label class="col-md-3 control-label" for="form_control_1">Jabatan Kelompok <span class="required"> * </span></label>
									<div class="col-md-9">
										<div class="input-icon">
											<input type="text" class="form-control" name="jabatan_kelompok" placeholder="Type something" required>
											<div class="form-control-focus"> </div>
											<span class="help-block">Some help goes here...</span>
											<i class="icon-badge"></i>
										</div>
									</div>
								</div>
								<div class="form-group form-md-line-input has-danger">
									<label class="col-md-3 control-label" for="form_control_1">Nomor KK <span class="required"> * </span></label>
									<div class="col-md-9">
										<div class="input-icon">
											<input type="text" class="form-control" name="no_kk" placeholder="Type something" required>
											<div class="form-control-focus"> </div>
											<span class="help-block">Some help goes here...</span>
											<i class="fa fa-credit-card"></i>
										</div>
									</div>
								</div>
							</div>
							<br>
							<div class="form-actions margin-top-9">
								<div class="row">
									<div class="col-md-offset-3 col-md-9">
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
	<div class="modal fade" id="ubahdata" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Form Ubah Data</h4>
				</div>
				<div class="modal-body">
					<div class="box box-primary" id='formubahdata' >
					</div>
				</div>
			</div>
		</div>
	</div>