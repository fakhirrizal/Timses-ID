<script src="<?=base_url('assets/global/plugins/jquery.min.js');?>" type="text/javascript"></script>
<script type="text/javascript">

	$(function(){

		$.ajaxSetup({
			type:"POST",
			url: "<?php echo site_url('/member/Master/ajax_function')?>",
			cache: false,
		});

		$("#id_provinsi").change(function(){
			var value=$(this).val();
			$.ajax({
				data:{id:value,modul:'get_kabupaten_by_id_provinsi'},
				success: function(respond){
					$("#id_kabupaten").html(respond);
				}
			})
		});

		$("#id_kabupaten").change(function(){
			var value=$(this).val();
			$.ajax({
				data:{id:value,modul:'get_kecamatan_by_id_kabupaten'},
				success: function(respond){
					$("#id_kecamatan").html(respond);
				}
			})
		});

		$("#id_kecamatan").change(function(){
			var value=$(this).val();
			$.ajax({
				data:{id:value,modul:'get_desa_by_id_kecamatan'},
				success: function(respond){
					$("#id_desa").html(respond);
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
		<span>Instruksi</span>
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
					<form role="form" class="form-horizontal" action="<?=base_url('member_side/simpan_data_kube');?>" method="post"  enctype='multipart/form-data'>
						<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
						<div class="form-body">
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Judul Instruksi <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<input type="text" class="form-control" name="judul" placeholder="Type something" required>
										<div class="form-control-focus"> </div>
										<span class="help-block">Some help goes here...</span>
										<i class="icon-pin"></i>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Wilayah <span class="required"> * </span></label>
								<div class="col-md-4">
									<div class="input-icon">
										<select name='wilayah' class="form-control select2-allow-clear" required>
											<option value=''>-- Pilih --</option>
											<option value='2017'>Kabupaten/ Kota</option>
											<option value='2018'>Kecamatan</option>
											<option value='2019'>Kelurahan/ Desa</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-2 control-label" for="form_control_1">Detail Instruksi <span class="required"> * </span></label>
								<div class="col-md-10">
									<div class="input-icon">
										<textarea class="form-control" name="detail" required></textarea>
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
	var rupiah = document.getElementById("rupiah");
	rupiah.addEventListener("keyup", function(e) {
		rupiah.value = formatRupiah(this.value, "Rp. ");
	});
	/* Fungsi formatRupiah */
	function formatRupiah(angka, prefix) {
		var number_string = angka.replace(/[^,\d]/g, "").toString(),
			split = number_string.split(","),
			sisa = split[0].length % 3,
			rupiah = split[0].substr(0, sisa),
			ribuan = split[0].substr(sisa).match(/\d{3}/gi);
		// tambahkan titik jika yang di input sudah menjadi angka ribuan
		if (ribuan) {
			separator = sisa ? "." : "";
			rupiah += separator + ribuan.join(".");
		}
		rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
		return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
	}
</script>
<style type="text/css">
	#map {
		height: 300px;
	}
</style>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&callback=initialize&key=AIzaSyCnjlDXASsyIUKAd1QANakIHIM8jjWWyNU"></script>

<script type="text/javascript">
    // Fungsi untuk mendapatkan nilai latitude longitude
	function updateMarkerPosition(latLng) {
		document.getElementById('latitude').value = [latLng.lat()]
		document.getElementById('longitude').value = [latLng.lng()]
	}
	var map = new google.maps.Map(document.getElementById('map'), {
	zoom: 12,
	center: new google.maps.LatLng(-6.909718326755971,109.734670017746),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});
	// posisi awal marker
	var latLng = new google.maps.LatLng(-6.909718326755971,109.734670017746);
	/* buat marker yang bisa di drag lalu
	panggil fungsi updateMarkerPosition(latLng)
	dan letakan posisi terakhir di id=latitude dan id=longitude
	*/
	var marker = new google.maps.Marker({
		position : latLng,
		title : 'lokasi',
		map : map,
		draggable : true
	});
	updateMarkerPosition(latLng);
	google.maps.event.addListener(marker, 'drag', function() {
	// ketika marker di drag, otomatis nilai latitude dan longitude
	// menyesuaikan dengan posisi marker
		updateMarkerPosition(marker.getPosition());
	});
</script>