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
		<span>Data Relawan</span>
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
								<a href="<?= site_url('member_side/tambah_data_relawan/'); ?>" class="btn green uppercase">Tambah Data <i class="fa fa-plus"></i> </a>
							</div>
						</div>
					</div>
					<table class="table table-striped table-bordered table-hover order-column" style="overflow-x: auto;width: 100%;" id="tbl">
						<thead>
							<tr>
								
								<th style="text-align: center;" width="4%"> # </th>
								<th style="text-align: center;"> Nama </th>
								<th style="text-align: center;"> NIK </th>
								<th style="text-align: center;"> No. HP</th>
								<th style="text-align: center;"> Pekerjaan </th>
								<th style="text-align: center;"> Wilayah </th>
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
									url:"<?= site_url('member/Master/json_relawan_data'); ?>"
								},
								"aoColumns": [
											{ mData: 'number', sClass: "alignCenter" },
											{ mData: 'nama' } ,
											{ mData: 'nik', sClass: "alignCenter" },
											{ mData: 'no_hp', sClass: "alignCenter" },
											{ mData: 'pekerjaan', sClass: "alignCenter" },
											{ mData: 'wilayah', sClass: "alignCenter" },
											{ mData: 'aksi' }
										]
							});
						});
					</script>
				</div>
			</div>
		</div>
	</div>
</div>