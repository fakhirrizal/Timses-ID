<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Laporan</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Analisis</span>
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
					<script src="https://code.highcharts.com/highcharts.js"></script>
					<script src="https://code.highcharts.com/modules/exporting.js"></script>
					<script src="https://code.highcharts.com/modules/export-data.js"></script>
					<script src="https://code.highcharts.com/modules/accessibility.js"></script>
					<figure class="highcharts-figure">
						<div id="grafik1"></div>
					</figure>
					<script>
						Highcharts.chart('grafik1', {
							chart: {
								type: 'column'
							},
							credits: {
								enabled: false
							},
							title: {
								text: 'Total Relawan Event'
							},
							subtitle: {
								text: 'Rekapan per daerah'
							},
							xAxis: {
								type: 'category',
								labels: {
									rotation: -45,
									style: {
										fontSize: '13px',
										fontFamily: 'Verdana, sans-serif'
									}
								}
							},
							yAxis: {
								min: 0,
								title: {
									text: ''
								}
							},
							legend: {
								enabled: false
							},
							tooltip: {
								pointFormat: 'Jumlah relawan: <b>{point.y:.0f} orang</b>'
							},
							series: [{
								name: 'Population',
								data: [
									<?php
									foreach ($wilayah as $key => $value) {
										$tot_relawan = 0;
										$url1 = 'http://kertasfolio.id:99/api/relawandatas/byevent/'.$get_info->id_event;
										$data_relawan = $this->Main_model->getAPI($url1);
										foreach ($data_relawan as $key => $row) {
											$url2 = 'http://kertasfolio.id:99/api/relawanprofiles/getProfile/'.$row['idRelawan'];
											$cek = $this->Main_model->getAPI($url2);
											if($cek['idKecamatan']==$value['idKecamatan']){
												$tot_relawan++;
											}else{
												echo'';
											}
										}
										echo'["'.$value['namaKecamatan'].'",'.number_format($tot_relawan,0).'],';
									}
									?>
								],
								dataLabels: {
									enabled: true,
									rotation: -90,
									color: '#FFFFFF',
									align: 'right',
									format: '{point.y:.0f}', // number of decimal
									y: 10, // 10 pixels down from the top
									style: {
										fontSize: '13px',
										fontFamily: 'Verdana, sans-serif'
									}
								}
							}]
						});
					</script>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light ">
				<div class="portlet-body">
					<figure class="highcharts-figure">
						<div id="grafik2"></div>
					</figure>
					<script>
						Highcharts.chart('grafik2', {
							chart: {
								type: 'column'
							},
							credits: {
								enabled: false
							},
							title: {
								text: 'Total Isu'
							},
							subtitle: {
								text: 'Rekapan per daerah'
							},
							xAxis: {
								type: 'category',
								labels: {
									rotation: -45,
									style: {
										fontSize: '13px',
										fontFamily: 'Verdana, sans-serif'
									}
								}
							},
							yAxis: {
								min: 0,
								title: {
									text: ''
								}
							},
							legend: {
								enabled: false
							},
							tooltip: {
								pointFormat: 'Jumlah isu: <b>{point.y:.0f}</b>'
							},
							series: [{
								name: 'Population',
								data: [
									<?php
									foreach ($wilayah as $key => $value) {
										$tot_isu = 0;
										$url1 = 'http://kertasfolio.id:99/api/relawanisu/all/'.$get_info->id_event;
										$data_isu = $this->Main_model->getAPI($url1);
										foreach ($data_isu as $key => $row) {
											if(preg_match("/".$value['idKecamatan']."/i", $row['idWilayah'])){
												$tot_isu++;
											}else{
												echo'';
											}
										}
										echo'["'.$value['namaKecamatan'].'",'.number_format($tot_isu,0).'],';
									}
									?>
								],
								dataLabels: {
									enabled: true,
									rotation: -90,
									color: 'ff0000',
									align: 'right',
									format: '{point.y:.0f}', // number of decimal
									y: 10, // 10 pixels down from the top
									style: {
										fontSize: '13px',
										fontFamily: 'Verdana, sans-serif'
									}
								}
							}]
						});
					</script>
				</div>
			</div>
		</div>
	</div>
</div>