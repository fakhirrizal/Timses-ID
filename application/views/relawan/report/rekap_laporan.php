<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<ul class="page-breadcrumb breadcrumb">
	<!-- <li>
		<a href="javascript:;">Usulan Task</a>
			<i class="fa fa-circle"></i>
	</li> -->
	<li>
		<span>Data Laporan</span>
	</li>
</ul>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
<div class="page-content-inner">
	<div class="m-heading-1 border-green m-bordered">
		<h3>Catatan</h3>
		<p> 1. Laporan "<b>Admin</b>" adalah laporan yg dibuat oleh Admin Wilayah dengan satu tingkat dibawah Anda.</p>
		<p> 2. Laporan "<b>Mandiri</b>" adalah laporan yg dibuat oleh Anda untuk Admin dengan tingkat diatas Anda.</p>
	</div>
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light ">
				<!-- <div class="portlet-title">
					<div class="caption font-dark">
						<i class="icon-settings font-dark"></i>
						<span class="caption-subject bold uppercase"> Managed Table</span>
					</div>
					<div class="actions">
						<div class="btn-group btn-group-devided" data-toggle="buttons">
							<label class="btn btn-transparent dark btn-outline btn-circle btn-sm active">
								<input type="radio" name="options" class="toggle" id="option1">Actions</label>
							<label class="btn btn-transparent dark btn-outline btn-circle btn-sm">
								<input type="radio" name="options" class="toggle" id="option2">Settings</label>
						</div>
					</div>
				</div> -->
				<div class="portlet-body">
					<div class="tabbable-line">
						<ul class="nav nav-tabs ">
							<li class="active">
								<a href="#tab_15_1" data-toggle="tab"> Laporan Admin </a>
							</li>
							<li>
								<a href="#tab_15_2" data-toggle="tab"> Laporan Mandiri </a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab_15_1">
								<form action="#" method="post" onsubmit="return deleteConfirm();"/>
								<div class="table-toolbar">
									<div class="row">
										<div class="col-md-6">
											<a href="#" class="btn red uppercase">Cetak Data <i class="fa fa-print"></i> </a>
										</div>
									
									</div>
								</div>
								
								<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
									<thead>
										<tr>
											<th width="3%">
												<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
													<input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
													<span></span>
												</label>
											</th>
											<th style="text-align: center;" width="4%"> # </th>
											<th style="text-align: center;"> Nama </th>
											<th style="text-align: center;"> Wilayah </th>
											<th style="text-align: center;"> Judul Laporan </th>
											<th style="text-align: center;"> Tanggal Laporan </th>
											<th style="text-align: center;" width='9%'> Aksi </th>
										</tr>
									</thead>
									<tbody>
										<?php
										$no = 1;
										?>
										<tr class="odd gradeX">
											<td>
												<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
													<input type="checkbox" class="checkboxes" name="selected_id[]" value="<?php // echo $value['Id_CalegUsulan']; ?>"/>
													<span></span>
												</label>
											</td>
											<td style="text-align: center;"><?= $no++.'.'; ?></td>
											<td><?= 'Mukhammad Fakhir Rizal'; ?></td>
											<td style="text-align: center;"><?= 'Kecamatan Batang'; ?></td>
											<td style="text-align: center;"><?= 'Laporan penyelenggaraan turnamen bola voli antar desa'; ?></td>
											<td style="text-align: center;"><?= '29 November 2019'; ?></td>
											<td style="text-align: center;">
												<a class="btn btn-xs green">Detail Data</a>
											</td>
										</tr>
										<tr class="odd gradeX">
											<td>
												<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
													<input type="checkbox" class="checkboxes" name="selected_id[]" value="<?php // echo $value['Id_CalegUsulan']; ?>"/>
													<span></span>
												</label>
											</td>
											<td style="text-align: center;"><?= $no++.'.'; ?></td>
											<td><?= 'Aji Saputra Raka Siwi'; ?></td>
											<td style="text-align: center;"><?= 'Kecamatan Subah'; ?></td>
											<td style="text-align: center;"><?= 'Laporan validasi relawan tingkat desa'; ?></td>
											<td style="text-align: center;"><?= '2 Desember 2019'; ?></td>
											<td style="text-align: center;">
												<a class="btn btn-xs green">Detail Data</a>
											</td>
										</tr>
										<?php
										?>
									</tbody>
								</table>
								</form>
							</div>
							<div class="tab-pane" id="tab_15_2">
								<form action="#" method="post" onsubmit="return deleteConfirm();"/>
								<div class="table-toolbar">
									<div class="row">
										<div class="col-md-6">
											<div class="btn-group">
												<a href="<?php echo site_url('relawan_side/tambah_laporan'); ?>" class="btn green uppercase">Tambah Data <i class="fa fa-plus"></i> </a>
											</div>
											<span class="separator">|</span>
											<a href="#" class="btn red uppercase">Cetak Data <i class="fa fa-print"></i> </a>
										</div>
									
									</div>
								</div>
								
								<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_2">
									<thead>
										<tr>
											<th width="3%">
												<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
													<input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
													<span></span>
												</label>
											</th>
											<th style="text-align: center;" width="4%"> # </th>
											<th style="text-align: center;"> Judul </th>
											<th style="text-align: center;"> Tanggal Laporan </th>
											<th style="text-align: center;"> Isi </th>
											<th style="text-align: center;" width="8%"> Aksi </th>
										</tr>
									</thead>
									<tbody>
										<?php
										$nomor = 1;
										?>
										<tr class="odd gradeX">
											<td>
												<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
													<input type="checkbox" class="checkboxes" name="selected_id[]" value="<?php // echo $value['Id_Usulan']; ?>"/>
													<span></span>
												</label>
											</td>
											<td style="text-align: center;"><?= $nomor++.'.'; ?></td>
											<td style="text-align: center;"><?= 'Rapat koordinasi dengan relawan'; ?></td>
											<td style="text-align: center;"><?= '1 Desember 2019'; ?></td>
											<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean vitae augue aliquet, scelerisque est aliquam, vehicula mi. Aliquam ut elementum nisi, quis semper est. Etiam et dui a mi commodo iaculis. Sed ultrices cursus sapien, fringilla sollicitudin purus dictum tempor.</td>
											<td>
												<div class="btn-group">
													<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Aksi
														<i class="fa fa-angle-down"></i>
													</button>
													<ul class="dropdown-menu" role="menu">
														<li>
															<a href="<?php echo site_url('relawan_side/ubah_laporan/'.md5(1)); ?>">
																<i class="icon-wrench"></i> Ubah Data </a>
														</li>
														<li>
															<a onclick="return confirm('Anda yakin?')" href="#">
																<i class="icon-trash"></i> Hapus Data </a>
														</li>
													</ul>
												</div>
											</td>
										</tr>
										<?php
										?>
									</tbody>
								</table>
								</form>
							</div>
						</div>
					</div>
					<script type="text/javascript">
					function deleteConfirm(){
						var result = confirm("Do you really want to delete records?");
						if(result){
							return true;
						}else{
							return false;
						}
					}
					</script>
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-full" >
    <div class="modal-content">

      <div class="modal-header" style="text-align: center;">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Detail Data</h4>
    

      </div>
      <div class="modal-body">
        <div class="box box-primary" id="data_detail"></div>
      </div>
      
    </div>
  </div>
</div>
<script>
  // ini menyiapkan dokumen agar siap grak :)
  $(document).ready(function(){
    // yang bawah ini bekerja jika tombol lihat data (class="view_data") di klik
    $('.view_data').click(function(){
      // membuat variabel id, nilainya dari attribut id pada button
      // id="'.$row['id'].'" -> data id dari database ya sob, jadi dinamis nanti id nya
      var id = $(this).attr("id");
      
      // memulai ajax
      $.ajax({
        url: '<?php echo site_url(); ?>/Usulan/ajax_usulan_caleg', // set url -> ini file yang menyimpan query tampil detail data gambar
        method: 'post',   // method -> metodenya pakai post. Tahu kan post? gak tahu? browsing aja :)
        data: {id:id},    // nah ini datanya -> {id:id} = berarti menyimpan data post id yang nilainya dari = var id = $(this).attr("id");
        success:function(data){   // kode dibawah ini jalan kalau sukses
          $('#data_detail').html(data); // mengisi konten dari -> <div class="modal-body" id="data_gambar">
          $('#myModal').modal("show");  // menampilkan dialog modal nya
        }
      });
    });
  });
</script>
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-full" >
    <div class="modal-content">

      <div class="modal-header" style="text-align: center;">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Detail Data</h4>
    

      </div>
      <div class="modal-body">
        <div class="box box-primary" id="data_detail2"></div>
      </div>
      
    </div>
  </div>
</div>
<script>
  // ini menyiapkan dokumen agar siap grak :)
  $(document).ready(function(){
    // yang bawah ini bekerja jika tombol lihat data (class="view_data") di klik
    $('.view_data2').click(function(){
      // membuat variabel id, nilainya dari attribut id pada button
      // id="'.$row['id'].'" -> data id dari database ya sob, jadi dinamis nanti id nya
      var id = $(this).attr("id");
      
      // memulai ajax
      $.ajax({
        url: '<?php echo site_url(); ?>/Usulan/ajax_usulan_relawan', // set url -> ini file yang menyimpan query tampil detail data gambar
        method: 'post',   // method -> metodenya pakai post. Tahu kan post? gak tahu? browsing aja :)
        data: {id:id},    // nah ini datanya -> {id:id} = berarti menyimpan data post id yang nilainya dari = var id = $(this).attr("id");
        success:function(data){   // kode dibawah ini jalan kalau sukses
          $('#data_detail2').html(data); // mengisi konten dari -> <div class="modal-body" id="data_gambar">
          $('#myModal2').modal("show");  // menampilkan dialog modal nya
        }
      });
    });
  });
</script>