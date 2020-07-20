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
                    <!-- <div class="col-md-6">
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
                    </div> -->
                    <?php
                    if($value['lampiran']==null){
                        echo'';
                    }else{
                    ?>
                    <!-- <div class="col-md-12">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td> Lampiran </td>
                                    <td>  </td>
                                    <td><?php
                                    foreach ($value['lampiran'] as $key => $r) {
                                        echo '<iframe src="'.$r['urlFile'].'" width="100%" height="500px"></iframe>';
                                    }
                                    ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div> -->
                    <?php }
                    $url4 = 'http://kertasfolio.id:99/api/relawanreport/task/'.$value['idTask'].'/'.$value['idEvent'];
                    $data_laporan = $this->Main_model->getAPI($url4);
                    if($data_laporan==NULL){
                        echo'';
                    }else{
                    ?>
                    <!-- <div class="col-md-6">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td> Foto Laporan </td>
                                    <td>  </td>
                                    <td><?php
                                    echo '<img src="data:image/png;base64,' . $data_laporan['fotoReport'] . '" alt="" width="100%"/>';
                                    ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td> Waktu Laporan </td>
                                    <td> : </td>
                                    <td><?php echo $this->Main_model->convert_tanggal(substr($data_laporan['createdDate'],0,10)); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div> -->
                    <?php
                    }
                    ?>
                <?php // }} ?>
                <div class="col-md-12">
                    <div class="portlet light ">
                        <div class="portlet-body">
                            <table class="table table-striped table-bordered table-hover order-column" style="overflow-x: auto;width: 100%;" id="tbl">
                                <thead>
                                    <tr>
                                        
                                        <th style="text-align: center;" width="4%"> # </th>
                                        <th style="text-align: center;"> Nama Relawan </th>
                                        <th style="text-align: center;"> Waktu Laporan </th>
                                        <th style="text-align: center;"> Detail Laporan </th>
                                        <th style="text-align: center;" width="1%"> Foto Laporan </th>
                                    </tr>
                                </thead>
                            </table>
                            <script type="text/javascript" language="javascript" >
                                $(document).ready(function(){
                                    $('#tbl').dataTable({
                                        "order": [[ 0, "asc" ]],
                                        "bProcessing": true,
                                        "ajax" : {
                                            type:"POST",
                                            url:"<?= site_url('member/Task/json_detail_task_data'); ?>",
                                            data:{id_task_parent:'<?= $this->uri->segment(3); ?>'}
                                        },
                                        "aoColumns": [
                                                    { mData: 'number', sClass: "alignCenter" },
                                                    { mData: 'nama', sClass: "alignCenter" } ,
                                                    { mData: 'waktu', sClass: "alignCenter" },
                                                    { mData: 'detail', sClass: "alignCenter" },
                                                    { mData: 'action', sClass:"alignCenter" }
                                                ],
                                        "drawCallback": function(data) {
                                                $('.detaildata').click(function(){
                                                var id = $(this).attr("id");
                                                var modul = 'modul_detail_laporan_task';
                                                $.ajax({
                                                    type:"POST",
                                                    url: "<?php echo site_url(); ?>member/Task/ajax_function",
                                                    cache: false,
                                                    data: {id:id,modul:modul},
                                                    success:function(data){
                                                    $('#formdetaildata').html(data);
                                                    $('#detaildata').modal("show");
                                                    }
                                                });
                                                });
                                            }
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="detaildata" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Detail Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="box box-primary" id='formdetaildata' >
                </div>
            </div>
        </div>
    </div>
</div>