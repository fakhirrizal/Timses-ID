<script src="<?=base_url('assets/global/plugins/jquery.min.js');?>" type="text/javascript"></script>
<script type="text/javascript">

	$(function(){

		$.ajaxSetup({
			type:"POST",
			url: "<?php echo site_url('/admin/Master/ajax_function')?>",
			cache: false,
		});

		$("#role").change(function(){
			var value=$(this).val();
			$.ajax({
				data:{id:value,modul:'get_wilayah_by_role_event'},
				success: function(respond){
					$("#proses").html(respond);
					$("#id_provinsi").change(function(){
						var value=$(this).val();
						$.ajax({
							data:{id:value,modul:'get_tampil_kabupaten_by_id_provinsi'},
							success: function(respond){
								$("#tampil_kabupaten").html(respond);
							}
						})
					});
				}
			})
		});
	})

</script>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Master</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span><a href='<?= site_url('admin_side/event'); ?>'>Data Event</a></span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Tambah Data</span>
	</li>
</ul>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
<div class="page-content-inner">
	<div class="m-heading-1 border-green m-bordered">
		<h3>Catatan</h3>
		<p> 1. Kolom isian dengan tanda bintang (<font color='red'>*</font>) adalah wajib untuk di isi.</p>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light ">
				<div class="portlet-body">
					<form role="form" class="form-horizontal" action="<?=base_url('admin_side/simpan_data_event');?>" method="post"  enctype='multipart/form-data'>
						<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
						<div class="form-body">
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Nama Event <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="namaEvent" placeholder="Type something" required>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="icon-direction"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Role Event <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<select name='roleEvent' id='role' class="form-control" required>
											<option value=''>-- Pilih --</option>
											<!-- <option value='SELURUH PILKADA'>SELURUH PILKADA</option> -->
											<option value='5469458f-8760-45b1-b05a-a4ca3aab2461'>PILKADA PROVINSI</option>
											<option value='dbabb74d-df5b-4b79-820b-057abdf99b1a'>PILKADA KAB/KOTA</option>
										</select>
									</div>
								</div>
							</div>
							<div id='proses'>
							</div>
						</div>
						<br>
						<div class="form-actions margin-top-10">
							<div class="row">
								<div class="col-md-offset-2 col-md-10">
									<button type="reset" class="btn default">Batal</button>
									<button type="submit" class="btn blue">Simpan</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>