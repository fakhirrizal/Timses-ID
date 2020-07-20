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
                                            url:"<?= site_url('relawan/Task/json_detail_task_data'); ?>",
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
                                                    url: "<?php echo site_url(); ?>relawan/Task/ajax_function",
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