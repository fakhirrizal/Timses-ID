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
    <div class="portlet light ">
		<div class="portlet-body">
            <div class='row'>
                <?php
                // if(isset($data_utama)){
                //     foreach($data_utama as $value)
                //     {
                ?>
                        <div class="col-md-6">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td> Judul </td>
                                        <td> : </td>
                                        <td><?php echo $value['judulTask']; ?></td>
                                    </tr>
                                    <tr>
                                        <td> Deskripsi </td>
                                        <td> : </td>
                                        <td><?php echo $value['deskripsiTask']; ?></td>
                                    </tr>
                                    <tr>
                                        <td> Waktu </td>
                                        <td> : </td>
                                        <td><?php echo $this->Main_model->convert_tanggal(substr($value['waktuTask'],0,10)); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td> Relawan </td>
                                        <td> : </td>
                                        <td><?php
                                        $url2 = 'http://kertasfolio.id:99/api/relawanprofiles/getProfile/'.$value['idRelawan'];
                                        $data_relawan = $this->Main_model->getAPI($url2);
                                        echo $data_relawan['namaRelawan'];
                                        ?></td>
                                    </tr>
                                    <tr>
                                        <td> Wilayah </td>
                                        <td> : </td>
                                        <td><?php
                                        $wilayah = '';
                                        if(strlen($value['idWilayah'])=='2'){
                                            $url3 = 'http://kertasfolio.id:99/api/prov/id/'.$value['idWilayah'];
                                            $data_prov = $this->Main_model->getAPI($url3);
                                            $wilayah = $data_prov['namaProvinsi'];
                                        }elseif(strlen($value['idWilayah'])=='4'){
                                            $url3 = 'http://kertasfolio.id:99/api/kab/id/'.$value['idWilayah'];
                                            $data_kab = $this->Main_model->getAPI($url3);
                                            $wilayah = $data_kab['namaKabupaten'];
                                        }elseif(strlen($value['idWilayah'])=='7'){
                                            $url3 = 'http://kertasfolio.id:99/api/kec/id/'.$value['idWilayah'];
                                            $data_kab = $this->Main_model->getAPI($url3);
                                            $wilayah = $data_kab['namaKecamatan'];
                                        }elseif(strlen($value['idWilayah'])=='10'){
                                            $url3 = 'http://kertasfolio.id:99/api/desa/id/'.$value['idWilayah'];
                                            $data_kab = $this->Main_model->getAPI($url3);
                                            $wilayah = $data_kab['namaDesa'];
                                        }else{
                                            echo'';
                                        }
                                        echo $wilayah;
                                        ?></td>
                                    </tr>
                                    <tr>
                                        <td> Status </td>
                                        <td> : </td>
                                        <td><?php
                                        if($value['isDone']=='false'){
                                            echo 'Belum Selesai';
                                        }else{
                                            echo 'Selesai';
                                        }
                                        ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <?php
                        if($value['lampiran']==null){
                            echo'';
                        }else{
                        ?>
                        <div class="col-md-12">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td> Lampiran </td>
                                        <td><?php
                                        foreach ($value['lampiran'] as $key => $r) {
                                            echo '<iframe src="'.$r['urlFile'].'" width="100%" height="500px"/>';
                                        }
                                        ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <?php } ?>
                <?php // }} ?>
            </div>
        </div>
    </div>
</div>