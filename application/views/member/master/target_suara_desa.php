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
		<span>Target</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Detail Data <?= $data_desa['namaDesa']; ?></span>
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
					<div class="table-toolbar">
						<div class="row">
							<div class="col-md-8">
								<h4>Data Relawan</h4>
							</div>
						</div>
					</div>
					<table class="table table-striped table-bordered table-hover order-column" style="overflow-x: auto;width: 120%;" id="tbl">
						<thead>
							<tr>
								<th style="text-align: center;" width="4%"> # </th>
								<th style="text-align: center;"> Nama </th>
								<th style="text-align: center;"> NIK </th>
								<th style="text-align: center;"> No. HP</th>
								<th style="text-align: center;"> Pekerjaan </th>
								<th style="text-align: center;"> Wilayah </th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							foreach ($data_relawan as $key => $value) {
								$url1 = 'http://pradi.is-very-good.org:7733/api/relawanprofiles/getProfile/'.$value['idRelawan'];
								$data_r = $this->Main_model->getAPI($url1);
								if($data_r['idDesa']==$id_desa){
									$url2 = 'http://pradi.is-very-good.org:7733/api/kec/id/'.$data_r['idKecamatan'];
									$data_kec = $this->Main_model->getAPI($url2);
									$url3 = 'http://pradi.is-very-good.org:7733/api/desa/id/'.$data_r['idDesa'];
									$data_desa = $this->Main_model->getAPI($url3);
							?>
									<tr class="odd gradeX">
										<td style="text-align: center;"><?= $no++.'.'; ?></td>
										<td style="text-align: center;"><?= $data_r['namaRelawan']; ?></td>
										<td style="text-align: center;"><?= $data_r['NIK']; ?></td>
										<td style="text-align: center;"><?= $value['telepon']; ?></td>
										<td style="text-align: center;"><?= $data_r['pekerjaan']; ?></td>
										<td style="text-align: center;"><?= $data_desa['namaDesa'].', '.$data_kec['namaKecamatan']; ?></td>
									</tr>
							<?php
								}else{
									echo'';
								}
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light ">
				<div class="portlet-body">
					<div class="table-toolbar">
						<div class="row">
							<div class="col-md-8">
								<h4>Data Rekrutmen</h4>
							</div>
						</div>
					</div>
					<table class="table table-striped table-bordered table-hover order-column" style="overflow-x: auto;width: 120%;" id="tbl">
						<thead>
							<tr>
								<th style="text-align: center;" width="4%"> # </th>
								<th style="text-align: center;"> Nama </th>
								<th style="text-align: center;"> No. HP </th>
								<th style="text-align: center;"> NIK </th>
								<th style="text-align: center;"> Pekerjaan </th>
								<th style="text-align: center;"> Alamat </th>
								<th style="text-align: center;"> Status </th>
								<th style="text-align: center;" > Recruiter </th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							foreach ($data_rekrutmen as $key => $value) {
								$url4 = 'http://pradi.is-very-good.org:7733/api/relawanprofiles/getProfile/'.$value['idRelawan'];
								$data_r = $this->Main_model->getAPI($url4);
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
									<td style="text-align: center;"><?= $data_r['namaRelawan']; ?></td>
								</tr>
							<?php
								
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>