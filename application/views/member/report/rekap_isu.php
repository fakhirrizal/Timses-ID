<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<style media="all" type="text/css">
    .alignCenter { text-align: center; }
</style>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Laporan</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Rekap Data Isu</span>
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
					<!-- <div class="table-toolbar">
						<div class="row">
							<div class="col-md-6">
								<div class="btn-group">
									<button type='submit' id="sample_editable_1_new" class="btn sbold red"> Hapus
										<i class="fa fa-trash"></i>
									</button>
								</div>
								<span class="separator">|</span>
								<a href="<?=base_url('member_side/tambah_data_admin');?>" class="btn green uppercase">Tambah Data <i class="fa fa-plus"></i> </a>
							</div>
						</div>
					</div> -->
					<table class="table table-striped table-bordered table-hover " id="tbl">
						<thead>
							<tr>
								<th style="text-align: center;" width="4%"> # </th>
								<th style="text-align: center;"> Relawan </th>
								<th style="text-align: center;"> Wilayah </th>
								<th style="text-align: center;"> Judul </th>
								<th style="text-align: center;"> Deskripsi </th>
								<th style="text-align: center;"> Created Date </th>
								<th style="text-align: center;" width="7%"> Aksi </th>
							</tr>
						</thead>
					</table>
					<script type="text/javascript" language="javascript" >
						$(document).ready(function(){
							$('#tbl').dataTable({
								"order": [[ 0, "asc" ]],
								"bProcessing": true,
								"ajax" : {
									url:"<?= site_url('member/Report/json_issue_data'); ?>"
								},
								"aoColumns": [
											{ mData: 'number', sClass: "alignCenter" },
											{ mData: 'nama' } ,
											{ mData: 'wilayah', sClass: "alignCenter" } ,
											{ mData: 'judul', sClass: "alignCenter" },
											{ mData: 'desc', sClass: "alignCenter" },
											{ mData: 'date', sClass: "alignCenter" },
											{ mData: 'action' }
										]
							});
						});
					</script>
				</div>
			</div>
		</div>
	</div>
</div>