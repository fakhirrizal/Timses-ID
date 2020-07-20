<script src="<?=base_url('assets/global/plugins/jquery.min.js');?>" type="text/javascript"></script>
<script type="text/javascript">
	$(function(){
		$.ajaxSetup({
			type:"POST",
			url: "<?php echo site_url('/member/Master/ajax_function')?>",
			cache: false,
		});
		$("#id_kube").change(function(){
			var value=$(this).val();
			$.ajax({
				data:{id:value,modul:'get_anggota_kube_by_id_kube'},
				success: function(respond){
					$("#id_anggota_kube").html(respond);
				}
			})
		});
		$("#id_kube").change(function(){
			var value=$(this).val();
			$.ajax({
				data:{id:value,modul:'get_isian_indikator_by_id_kube'},
				success: function(respond){
					$("#list_indikator").html(respond);
				}
			})
		});
	})
</script>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Laporan</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span><a href='<?= site_url('/member_side/analisis'); ?>'>Analisis</a></span>
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
					<form role="form" class="form-horizontal" action="<?=base_url('member_side/simpan_laporan_kube');?>" method="post" enctype='multipart/form-data'>
						<div class="form-body">
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Judul Analisis <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="judul" placeholder="Type something">
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="icon-pin"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Tanggal <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="date" class="form-control" name="tanggal" placeholder="Type something" required>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="icon-calendar"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Analisis <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<textarea class="form-control" name="analisis" required></textarea>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="icon-list"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Rekomendasi <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<textarea class="form-control" name="rekomendasi" required></textarea>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="icon-list"></i>
									</div>
								</div>
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
<script>
	var jum_arr = <?= count($indikator); ?>;
	for (let i = 0; i < jum_arr; i++) {
		var get_id = 'rupiah'+i;
		var rupiah = document.getElementById(get_id);
		rupiah.addEventListener("keyup", function(e) {
			rupiah.value = formatRupiah(this.value, "Rp. ");
		});
		function formatRupiah(angka, prefix) {
			var number_string = angka.replace(/[^,\d]/g, "").toString(),
				split = number_string.split(","),
				sisa = split[0].length % 3,
				rupiah = split[0].substr(0, sisa),
				ribuan = split[0].substr(sisa).match(/\d{3}/gi);
			if (ribuan) {
				separator = sisa ? "." : "";
				rupiah += separator + ribuan.join(".");
			}
			rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
			return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
		}
	}
</script>