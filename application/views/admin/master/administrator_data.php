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
		<span>Data Pengguna</span>
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
                    <div class="form-group select2-bootstrap-prepend" >
						<form action="<?= base_url().'admin_side/pengguna'; ?>" method="post">
							<label class="control-label col-md-3">Opsi pencarian berdasarkan <b>Event</b></label>
							<div class="col-md-5">
								<select name='event' class="form-control select2-allow-clear">
									<option value="All" <?php if($event=='All'){echo'selected';}else{echo'';} ?>>All Event</option>
									<?php
									$url1 = 'http://kertasfolio.id:99/api/event/all/asc';
									$data_event = $this->Main_model->getAPI($url1);
									foreach ($data_event as $key => $value) {
										if($value['idEvent']==$event){
											echo'<option value="'.$value['idEvent'].'" selected>'.$value['namaEvent'].'</option>';
										}else{
											echo'<option value="'.$value['idEvent'].'">'.$value['namaEvent'].'</option>';
										}
									}
									?>
								</select>
							</div>
							<div class="col-md-4">
								<button type="submit" class="btn blue">Proses</button>
							</div>
						</form>
					</div>
					<br>
					<hr>
					<div class="table-toolbar">
						<div class="row">
							<div class="col-md-8">
								<a href="<?=base_url('admin_side/tambah_data_pengguna');?>" class="btn green uppercase">Tambah Data <i class="fa fa-plus"></i> </a>
							</div>
						</div>
					</div>
					<table class="table table-striped table-bordered table-hover order-column" style="overflow-x: auto;width: 120%;" id="tbl">
						<thead>
							<tr>
								<th style="text-align: center;" width="4%"> # </th>
								<th style="text-align: center;"> Nama </th>
								<th style="text-align: center;"> No. HP </th>
								<th style="text-align: center;"> Event </th>
								<th style="text-align: center;" width="1%"> Aksi </th>
							</tr>
						</thead>
					</table>
					<script type="text/javascript" language="javascript" >
						$(document).ready(function(){
							var event = '<?= $event ?>';
							$('#tbl').dataTable({
								"order": [[ 0, "asc" ]],
								"bProcessing": true,
								"ajax" : {
									type:"POST",
									url:"<?= site_url('admin/Master/json_administrator_data'); ?>",
									data: {event:event},
								},
								"aoColumns": [
									{ mData: 'number', sClass: "alignCenter" },
											{ mData: 'nama' } ,
											{ mData: 'hp', sClass: "alignCenter" } ,
											{ mData: 'event', sClass: "alignCenter" },
											{ mData: 'action', sClass: "td_action" }
										]
							});
						});
					</script>
				</div>
			</div>
		</div>
	</div>
</div>