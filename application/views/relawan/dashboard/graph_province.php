<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
<div class="page-content-inner">
	<div class="m-heading-1 border-green m-bordered">
		<h3>Catatan</h3>
		<p> Tampilan standar adalah rekap data Tahun <?= date('Y'); ?></p>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light ">
				<div class="portlet-body">
					<div class="table-toolbar">
						<div class="row">
                            <div class="col-md-12">
                                <form action="<?=base_url('relawan_side/dasbor_grafik_provinsi/'.$this->uri->segment(3).'/'.$this->uri->segment(4));?>" method="post">
                                    <div class="form-group form-md-line-input has-danger">
                                        <label class="col-md-4 control-label" for="form_control_1"></label>
                                        <label class="col-md-1 control-label" for="form_control_1">Tahun</label>
                                        <div class="col-md-2">
                                            <div class="input-icon">
                                                <select name='tahun' class="form-control select2-allow-clear">
                                                    <option value=''>-- Pilih --</option>
                                                    <option value='2016'>2016</option>
                                                    <option value='2017'>2017</option>
                                                    <option value='2018'>2018</option>
                                                    <option value='2019'>2019</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button type='submit' class="btn btn-info">Proses</button>
                                        </div>
                                    </div>
                                </form>
							</div>
                            <hr>
                            <hr>
                            <hr>
                            <div class="col-md-12">
                            <?php
                            if(isset($data_utama_1)){
                            ?>
                            <hr>
                            <div class="grafik" style="width:100%; height:400px;"></div>
                            <div class="tabbable-line">
                                <table class="table table-striped table-bordered" id="tbl1">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;" width="4%"> # </th>
                                            <th style="text-align: center;"> Kabupaten </th>
                                            <th style="text-align: center;"> Jumlah Kube </th>
                                            <th style="text-align: center;"> Jumlah Rutilahu </th>
                                            <th style="text-align: center;"> Jumlah Sarling </th>
                                            <th style="text-align: center;" width="7%"> Aksi </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($data_utama_1 as $key => $value) {
                                            $jumlah_kube = 0;
                                            $jumlah_rutilahu = 0;
                                            $jumlah_sarling = 0;
                                            $persentase_anggaran_kube = 0;
                                            if($value->jumlah_kube=='0'){
                                                echo'';
                                            }else{
                                                $jumlah_kube = $value->jumlah_kube;
                                            }
                                            if($value->jumlah_rutilahu=='0'){
                                                echo'';
                                            }else{
                                                $jumlah_rutilahu = $value->jumlah_rutilahu;
                                            }
                                            if($value->jumlah_sarling=='0'){
                                                echo'';
                                            }else{
                                                $jumlah_sarling = $value->jumlah_sarling;
                                            }
                                            echo'
                                            <tr>
                                                <td style="text-align: center;">'.$no++.'.</td>
                                                <td><a href="'.site_url().'relawan_side/dasbor_grafik_kabupaten/'.md5($value->id_kabupaten).'/'.$penanda.'">'.$value->nm_kabupaten.'</a></td>
                                                <td style="text-align: center;">'.number_format($jumlah_kube,0).' Kelompok</td>
                                                <td style="text-align: center;">'.number_format($jumlah_rutilahu,0).' Kelompok</td>
                                                <td style="text-align: center;">'.number_format($jumlah_sarling,0).' Tim</td>
                                                <td style="text-align: center;">
                                                    <a class="btn btn-xs green" href="'.site_url().'relawan_side/dasbor_grafik_kabupaten/'.md5($value->id_kabupaten).'/'.$penanda.'">
                                                    <i class="icon-eye"></i> Detail Data </a>
                                                </td>
                                            </tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <script type="text/javascript">
                                $('.grafik').highcharts({
                                    chart: {
                                        type: 'line',
                                        marginTop: 80
                                    },
                                    credits: {
                                        enabled: false
                                    }, 
                                    tooltip: {
                                        shared: true,
                                        crosshairs: true,
                                        headerFormat: '<b>{point.key}</b><br/>'
                                    },
                                    title: {
                                        text: 'Rekap Data Penanganan Fakir Miskin Perkotaan'
                                    },
                                    subtitle: {
                                        text: 'Jumlah Kube, RLTH, dan Sarling <?= $data_provinsi->nm_provinsi; ?> Tahun <?= $periode; ?>'
                                    },
                                    xAxis: {
                                        categories: [
                                                        <?php
                                                        foreach ($data_utama_1 as $key => $value) {
                                                            echo "'".$value->nm_kabupaten."',";
                                                        }
                                                        ?>
                                                    ],
                                        labels: {
                                            rotation: 0,
                                            align: 'right',
                                            style: {
                                                fontSize: '10px',
                                                fontFamily: 'Verdana, sans-serif'
                                            }
                                        }
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: 'Kelompok/ Tim'
                                        }
                                    },
                                    legend: {
                                        enabled: true
                                    },
                                    series:[
                                                {
                                                    name: 'Kube',
                                                    data: [
                                                        <?php
                                                            foreach ($data_utama_1 as $key => $fff) {
                                                                $persentase = 0;
                                                                if($fff->jumlah_kube=='0'){
                                                                    echo'';
                                                                }else{
                                                                    $persentase = $fff->jumlah_kube;
                                                                }
                                                                echo number_format($persentase,0).",";
                                                            }
                                                        ?>
                                                    ],

                                                },
                                                {
                                                    name: 'Rutilahu',
                                                    data: [
                                                        <?php
                                                            foreach ($data_utama_1 as $key => $fff) {
                                                                $persentase = 0;
                                                                if($fff->jumlah_rutilahu=='0'){
                                                                    echo'';
                                                                }else{
                                                                    $persentase = $fff->jumlah_rutilahu;
                                                                }
                                                                echo number_format($persentase,0).",";
                                                            }
                                                        ?>
                                                    ],

                                                },
                                                {
                                                    name: 'Sarling',
                                                    data: [
                                                        <?php
                                                            foreach ($data_utama_1 as $key => $fff) {
                                                                $persentase = 0;
                                                                if($fff->jumlah_sarling=='0'){
                                                                    echo'';
                                                                }else{
                                                                    $persentase = $fff->jumlah_sarling;
                                                                }
                                                                echo number_format($persentase,0).",";
                                                            }
                                                        ?>
                                                    ],
                                                }
                                            ]
                                });
                            </script>
                            <?php
                            }elseif(isset($data_utama_2)){
                            ?>
                            <hr>
                            <div class="grafik" style="width:100%; height:400px;"></div>
                            <div class="tabbable-line">
                                <table class="table table-striped table-bordered" id="tbl1">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;" width="4%"> # </th>
                                            <th style="text-align: center;"> Kabupaten </th>
                                            <th style="text-align: center;"> Realisasi Kube </th>
                                            <th style="text-align: center;"> Realisasi Rutilahu </th>
                                            <th style="text-align: center;"> Realisasi Sarling </th>
                                            <th style="text-align: center;" width="7%"> Aksi </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($data_utama_2 as $key => $value) {
                                            $persentase_kube = 0;
                                            $persentase_fisik_kube = 0;
                                            $anggaran_kube = 0;
                                            $persentase_anggaran_kube = 0;
                                            if($value->jumlah_kube=='0'){
                                                echo'';
                                            }else{
                                                $persentase_kube = ($value->persentase_realisasi_kube)/($value->jumlah_kube);
                                                $persentase_fisik_kube = ($value->persentase_fisik_kube)/($value->jumlah_kube);
                                                $anggaran_kube = ($value->anggaran_kube)/($value->jumlah_kube);
                                                $persentase_anggaran_kube = ($value->persentase_anggaran_kube)/($value->jumlah_kube);
                                            }
                                            $persentase_rutilahu = 0;
                                            $persentase_fisik_rutilahu = 0;
                                            $anggaran_rutilahu = 0;
                                            $persentase_anggaran_rutilahu = 0;
                                            if($value->jumlah_rutilahu=='0'){
                                                echo'';
                                            }else{
                                                $persentase_rutilahu = ($value->persentase_realisasi_rutilahu)/($value->jumlah_rutilahu);
                                                $persentase_fisik_rutilahu = ($value->persentase_fisik_rutilahu)/($value->jumlah_rutilahu);
                                                $anggaran_rutilahu = ($value->anggaran_rutilahu)/($value->jumlah_rutilahu);
                                                $persentase_anggaran_rutilahu = ($value->persentase_anggaran_rutilahu)/($value->jumlah_rutilahu);
                                            }
                                            $persentase_sarling = 0;
                                            $persentase_fisik_sarling = 0;
                                            $anggaran_sarling = 0;
                                            $persentase_anggaran_sarling = 0;
                                            if($value->jumlah_sarling=='0'){
                                                echo'';
                                            }else{
                                                $persentase_sarling = ($value->persentase_realisasi_sarling)/($value->jumlah_sarling);
                                                $persentase_fisik_sarling = ($value->persentase_fisik_sarling)/($value->jumlah_sarling);
                                                $anggaran_sarling = ($value->anggaran_sarling)/($value->jumlah_sarling);
                                                $persentase_anggaran_sarling = ($value->persentase_anggaran_sarling)/($value->jumlah_sarling);
                                            }
                                            echo'
                                            <tr>
                                                <td style="text-align: center;">'.$no++.'.</td>
                                                <td><a href="'.site_url().'relawan_side/dasbor_grafik_kabupaten/'.md5($value->id_kabupaten).'/'.$penanda.'">'.$value->nm_kabupaten.'</a></td>
                                                <td style="text-align: center;">'.number_format($persentase_kube,2).'%</td>
                                                <td style="text-align: center;">'.number_format($persentase_rutilahu,2).'%</td>
                                                <td style="text-align: center;">'.number_format($persentase_sarling,2).'%</td>
                                                <td style="text-align: center;">
                                                    <a class="btn btn-xs green" href="'.site_url().'relawan_side/dasbor_grafik_kabupaten/'.md5($value->id_kabupaten).'/'.$penanda.'">
                                                    <i class="icon-eye"></i> Detail Data </a>
                                                </td>
                                            </tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <script type="text/javascript">
                                $('.grafik').highcharts({
                                    chart: {
                                        type: 'line',
                                        marginTop: 80
                                    },
                                    credits: {
                                        enabled: false
                                    }, 
                                    tooltip: {
                                        shared: true,
                                        crosshairs: true,
                                        headerFormat: '<b>{point.key}</b><br/>'
                                    },
                                    title: {
                                        text: 'Rekap Data Penanganan Fakir Miskin Perkotaan'
                                    },
                                    subtitle: {
                                        text: 'Rekap Realisasi Program Kube, RLTH dan Sarling <?= $data_provinsi->nm_provinsi; ?> Tahun <?= $periode; ?>'
                                    },
                                    xAxis: {
                                        categories: [
                                                        <?php
                                                        foreach ($data_utama_2 as $key => $value) {
                                                            echo "'".$value->nm_kabupaten."',";
                                                        }
                                                        ?>
                                                    ],
                                        labels: {
                                            rotation: 0,
                                            align: 'right',
                                            style: {
                                                fontSize: '10px',
                                                fontFamily: 'Verdana, sans-serif'
                                            }
                                        }
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: 'Persentase Realisasi (%)'
                                        }
                                    },
                                    legend: {
                                        enabled: true
                                    },
                                    series:[
                                                {
                                                    name: 'Kube',
                                                    data: [
                                                        <?php
                                                            foreach ($data_utama_2 as $key => $fff) {
                                                                $persentase = 0;
                                                                if($fff->jumlah_kube=='0'){
                                                                    echo'';
                                                                }else{
                                                                    $persentase = ($fff->persentase_realisasi_kube)/($fff->jumlah_kube);
                                                                }
                                                                echo number_format($persentase,2).",";
                                                            }
                                                        ?>
                                                    ],

                                                },
                                                {
                                                    name: 'Rutilahu',
                                                    data: [
                                                        <?php
                                                            foreach ($data_utama_2 as $key => $fff) {
                                                                $persentase = 0;
                                                                if($fff->jumlah_rutilahu=='0'){
                                                                    echo'';
                                                                }else{
                                                                    $persentase = ($fff->persentase_realisasi_rutilahu)/($fff->jumlah_rutilahu);
                                                                }
                                                                echo number_format($persentase,2).",";
                                                            }
                                                        ?>
                                                    ],

                                                },
                                                {
                                                    name: 'Sarling',
                                                    data: [
                                                        <?php
                                                            foreach ($data_utama_2 as $key => $fff) {
                                                                $persentase = 0;
                                                                if($fff->jumlah_sarling=='0'){
                                                                    echo'';
                                                                }else{
                                                                    $persentase = ($fff->persentase_realisasi_sarling)/($fff->jumlah_sarling);
                                                                }
                                                                echo number_format($persentase,2).",";
                                                            }
                                                        ?>
                                                    ],
                                                }
                                            ]
                                });
                            </script>
                            <?php
                            }elseif(isset($data_utama_3)){
                            ?>
                            <hr>
                            <div class="grafik" style="width:100%; height:400px;"></div>
                            <div class="tabbable-line">
                                <table class="table table-striped table-bordered" id="tbl1">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;" width="4%"> # </th>
                                            <th style="text-align: center;"> Kabupaten </th>
                                            <th style="text-align: center;"> Serapan Anggaran Kube </th>
                                            <th style="text-align: center;"> Serapan Anggaran Rutilahu </th>
                                            <th style="text-align: center;"> Serapan Anggaran Sarling </th>
                                            <th style="text-align: center;" width="7%"> Aksi </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($data_utama_3 as $key => $value) {
                                            $anggaran_kube = 0;
                                            $persentase_anggaran_kube = 0;
                                            if($value->jumlah_kube=='0'){
                                                echo'';
                                            }else{
                                                $anggaran_kube = ($value->anggaran_kube)/($value->jumlah_kube);
                                                $persentase_anggaran_kube = ($value->persentase_anggaran_kube)/($value->jumlah_kube);
                                            }
                                            $anggaran_rutilahu = 0;
                                            $persentase_anggaran_rutilahu = 0;
                                            if($value->jumlah_rutilahu=='0'){
                                                echo'';
                                            }else{
                                                $anggaran_rutilahu = ($value->anggaran_rutilahu)/($value->jumlah_rutilahu);
                                                $persentase_anggaran_rutilahu = ($value->persentase_anggaran_rutilahu)/($value->jumlah_rutilahu);
                                            }
                                            $anggaran_sarling = 0;
                                            $persentase_anggaran_sarling = 0;
                                            if($value->jumlah_sarling=='0'){
                                                echo'';
                                            }else{
                                                $anggaran_sarling = ($value->anggaran_sarling)/($value->jumlah_sarling);
                                                $persentase_anggaran_sarling = ($value->persentase_anggaran_sarling)/($value->jumlah_sarling);
                                            }
                                            echo'
                                            <tr>
                                                <td style="text-align: center;">'.$no++.'.</td>
                                                <td><a href="'.site_url().'relawan_side/dasbor_grafik_kabupaten/'.md5($value->id_kabupaten).'/'.$penanda.'">'.$value->nm_kabupaten.'</a></td>
                                                <td style="text-align: center;">Rp '.number_format($anggaran_kube,2).' ('.number_format($persentase_anggaran_kube,2).'%)</td>
                                                <td style="text-align: center;">Rp '.number_format($anggaran_rutilahu,2).' ('.number_format($persentase_anggaran_rutilahu,2).'%)</td>
                                                <td style="text-align: center;">Rp '.number_format($anggaran_sarling,2).' ('.number_format($persentase_anggaran_sarling,2).'%)</td>
                                                <td style="text-align: center;">
                                                    <a class="btn btn-xs green" href="'.site_url().'relawan_side/dasbor_grafik_kabupaten/'.md5($value->id_kabupaten).'/'.$penanda.'">
                                                    <i class="icon-eye"></i> Detail Data </a>
                                                </td>
                                            </tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <script type="text/javascript">
                                $('.grafik').highcharts({
                                    chart: {
                                        type: 'line',
                                        marginTop: 80
                                    },
                                    credits: {
                                        enabled: false
                                    }, 
                                    tooltip: {
                                        shared: true,
                                        crosshairs: true,
                                        headerFormat: '<b>{point.key}</b><br/>'
                                    },
                                    title: {
                                        text: 'Rekap Data Penanganan Fakir Miskin Perkotaan'
                                    },
                                    subtitle: {
                                        text: 'Rekap Serapan Bantuan Keuangan untuk Program Kube, RLTH dan Sarling <?= $data_provinsi->nm_provinsi; ?> Tahun <?= $periode; ?>'
                                    },
                                    xAxis: {
                                        categories: [
                                                        <?php
                                                        foreach ($data_utama_3 as $key => $value) {
                                                            echo "'".$value->nm_kabupaten."',";
                                                        }
                                                        ?>
                                                    ],
                                        labels: {
                                            rotation: 0,
                                            align: 'right',
                                            style: {
                                                fontSize: '10px',
                                                fontFamily: 'Verdana, sans-serif'
                                            }
                                        }
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: 'Persentase Serapan (%)'
                                        }
                                    },
                                    legend: {
                                        enabled: true
                                    },
                                    series:[
                                                {
                                                    name: 'Kube',
                                                    data: [
                                                        <?php
                                                            foreach ($data_utama_3 as $key => $fff) {
                                                                $persentase = 0;
                                                                if($fff->jumlah_kube=='0'){
                                                                    echo'';
                                                                }else{
                                                                    $persentase = ($fff->persentase_anggaran_kube)/($fff->jumlah_kube);
                                                                }
                                                                echo number_format($persentase,2).",";
                                                            }
                                                        ?>
                                                    ],

                                                },
                                                {
                                                    name: 'Rutilahu',
                                                    data: [
                                                        <?php
                                                            foreach ($data_utama_3 as $key => $fff) {
                                                                $persentase = 0;
                                                                if($fff->jumlah_rutilahu=='0'){
                                                                    echo'';
                                                                }else{
                                                                    $persentase = ($fff->persentase_anggaran_rutilahu)/($fff->jumlah_rutilahu);
                                                                }
                                                                echo number_format($persentase,2).",";
                                                            }
                                                        ?>
                                                    ],

                                                },
                                                {
                                                    name: 'Sarling',
                                                    data: [
                                                        <?php
                                                            foreach ($data_utama_3 as $key => $fff) {
                                                                $persentase = 0;
                                                                if($fff->jumlah_sarling=='0'){
                                                                    echo'';
                                                                }else{
                                                                    $persentase = ($fff->persentase_anggaran_sarling)/($fff->jumlah_sarling);
                                                                }
                                                                echo number_format($persentase,2).",";
                                                            }
                                                        ?>
                                                    ],
                                                }
                                            ]
                                });
                            </script>
                            <?php
                            }elseif(isset($data_utama_4)){
                            ?>
                            <hr>
                            <div class="grafik" style="width:100%; height:400px;"></div>
                            <div class="tabbable-line">
                                <table class="table table-striped table-bordered" id="tbl1">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;" width="4%"> # </th>
                                            <th style="text-align: center;"> Kabupaten </th>
                                            <th style="text-align: center;"> Progres Fisik Kube </th>
                                            <th style="text-align: center;"> Progres Fisik Rutilahu </th>
                                            <th style="text-align: center;"> Progres Fisik Sarling </th>
                                            <th style="text-align: center;" width="7%"> Aksi </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($data_utama_4 as $key => $value) {
                                            $persentase_fisik_kube = 0;
                                            if($value->jumlah_kube=='0'){
                                                echo'';
                                            }else{
                                                $persentase_fisik_kube = ($value->persentase_fisik_kube)/($value->jumlah_kube);
                                            }
                                            $persentase_fisik_rutilahu = 0;
                                            if($value->jumlah_rutilahu=='0'){
                                                echo'';
                                            }else{
                                                $persentase_fisik_rutilahu = ($value->persentase_fisik_rutilahu)/($value->jumlah_rutilahu);
                                            }
                                            $persentase_fisik_sarling = 0;
                                            if($value->jumlah_sarling=='0'){
                                                echo'';
                                            }else{
                                                $persentase_fisik_sarling = ($value->persentase_fisik_sarling)/($value->jumlah_sarling);
                                            }
                                            echo'
                                            <tr>
                                                <td style="text-align: center;">'.$no++.'.</td>
                                                <td><a href="'.site_url().'relawan_side/dasbor_grafik_kabupaten/'.md5($value->id_kabupaten).'/'.$penanda.'">'.$value->nm_kabupaten.'</a></td>
                                                <td style="text-align: center;">'.number_format($persentase_fisik_kube,2).'%</td>
                                                <td style="text-align: center;">'.number_format($persentase_fisik_rutilahu,2).'%</td>
                                                <td style="text-align: center;">'.number_format($persentase_fisik_sarling,2).'%</td>
                                                <td style="text-align: center;">
                                                    <a class="btn btn-xs green" href="'.site_url().'relawan_side/dasbor_grafik_kabupaten/'.md5($value->id_kabupaten).'/'.$penanda.'">
                                                    <i class="icon-eye"></i> Detail Data </a>
                                                </td>
                                            </tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <script type="text/javascript">
                                $('.grafik').highcharts({
                                    chart: {
                                        type: 'line',
                                        marginTop: 80
                                    },
                                    credits: {
                                        enabled: false
                                    }, 
                                    tooltip: {
                                        shared: true,
                                        crosshairs: true,
                                        headerFormat: '<b>{point.key}</b><br/>'
                                    },
                                    title: {
                                        text: 'Rekap Data Penanganan Fakir Miskin Perkotaan'
                                    },
                                    subtitle: {
                                        text: 'Rekap Progress Fisik Program Kube, RLTH dan Sarling <?= $data_provinsi->nm_provinsi; ?> Tahun <?= $periode; ?>'
                                    },
                                    xAxis: {
                                        categories: [
                                                        <?php
                                                        foreach ($data_utama_4 as $key => $value) {
                                                            echo "'".$value->nm_kabupaten."',";
                                                        }
                                                        ?>
                                                    ],
                                        labels: {
                                            rotation: 0,
                                            align: 'right',
                                            style: {
                                                fontSize: '10px',
                                                fontFamily: 'Verdana, sans-serif'
                                            }
                                        }
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: 'Persentase Progress Fisik (%)'
                                        }
                                    },
                                    legend: {
                                        enabled: true
                                    },
                                    series:[
                                                {
                                                    name: 'Kube',
                                                    data: [
                                                        <?php
                                                            foreach ($data_utama_4 as $key => $fff) {
                                                                $persentase = 0;
                                                                if($fff->jumlah_kube=='0'){
                                                                    echo'';
                                                                }else{
                                                                    $persentase = ($fff->persentase_fisik_kube)/($fff->jumlah_kube);
                                                                }
                                                                echo number_format($persentase,2).",";
                                                            }
                                                        ?>
                                                    ],

                                                },
                                                {
                                                    name: 'Rutilahu',
                                                    data: [
                                                        <?php
                                                            foreach ($data_utama_4 as $key => $fff) {
                                                                $persentase = 0;
                                                                if($fff->jumlah_rutilahu=='0'){
                                                                    echo'';
                                                                }else{
                                                                    $persentase = ($fff->persentase_fisik_rutilahu)/($fff->jumlah_rutilahu);
                                                                }
                                                                echo number_format($persentase,2).",";
                                                            }
                                                        ?>
                                                    ],

                                                },
                                                {
                                                    name: 'Sarling',
                                                    data: [
                                                        <?php
                                                            foreach ($data_utama_4 as $key => $fff) {
                                                                $persentase = 0;
                                                                if($fff->jumlah_sarling=='0'){
                                                                    echo'';
                                                                }else{
                                                                    $persentase = ($fff->persentase_fisik_sarling)/($fff->jumlah_sarling);
                                                                }
                                                                echo number_format($persentase,2).",";
                                                            }
                                                        ?>
                                                    ],
                                                }
                                            ]
                                });
                            </script>
                            <?php
                            }
                            ?>
							<script>
							$(document).ready( function () {
								$('#tbl1').DataTable();
							} );
							</script>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>