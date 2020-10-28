<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<style media="all" type="text/css">
    .alignCenter { text-align: center; }
    .td_action { text-align: center;width: 1px; }
</style>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Master</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Data Target <?= $datakecamatan['namaKecamatan']; ?></span>
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
					<table class="table table-striped table-bordered table-hover order-column" style="overflow-x: auto;width: 120%;" id="tbl">
						<thead>
							<tr>
								<th style="text-align: center;" width="4%"> # </th>
								<th style="text-align: center;"> Nama Desa/ Kelurahan </th>
								<th style="text-align: center;"> Jumlah Relawan </th>
								<th style="text-align: center;"> Jumlah Rekrutmen </th>
								<th style="text-align: center;" width="1%"> Aksi </th>
							</tr>
						</thead>
					</table>
					<script type="text/javascript" language="javascript" >
						$(document).ready(function(){
							$('#tbl').dataTable({
								"order": [[ 0, "asc" ]],
								"bProcessing": true,
								"ajax" : {
                                    type:'POST',
                                    data: {id_kecamatan:"<?= $this->uri->segment(3); ?>",id_event:"<?= $this->uri->segment(4); ?>"},
									url:"<?= site_url('member/Master/json_target_suara_per_desa'); ?>"
								},
								"aoColumns": [
											{ mData: 'number', sClass: "alignCenter" },
											{ mData: 'nama', sClass: "alignCenter" } ,
											{ mData: 'relawan', sClass: "alignCenter" } ,
											{ mData: 'rekrutmen', sClass: "alignCenter" },
											{ mData: 'action' }
										],
								"drawCallback": function(data) {
										$('.detaildata').click(function(){
										var id = $(this).attr("id");
										var modul = 'modul_ubah_data_target';
										$.ajax({
											type:"POST",
											url: "<?php echo site_url(); ?>member/Master/ajax_page",
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
<div class="modal fade" id="detaildata" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Form Ubah Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="box box-primary" id='formdetaildata' >
                </div>
            </div>
        </div>
    </div>
</div>