<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<style media="all" type="text/css">
    .alignCenter { text-align: center; }
</style>
<ul class="page-breadcrumb breadcrumb">
	<!-- <li>
		<a href="javascript:;">Usulan Task</a>
			<i class="fa fa-circle"></i>
	</li> -->
	<li>
		<span>Data Usulan Task</span>
	</li>
</ul>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light ">
				<div class="portlet-body">
					<div class="tabbable-line">
						<ul class="nav nav-tabs ">
							<li class="active">
								<a href="#tab_15_2" data-toggle="tab"> dari Relawan </a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane " id="tab_15_1">
								<form action="#" method="post" onsubmit="return deleteConfirm();"/>
								<div class="table-toolbar">
									<div class="row">
										<div class="col-md-6">
											<div class="btn-group">
												<button type='submit' id="sample_editable_1_new" class="btn sbold green"> Hapus
													<i class="fa fa-trash"></i>
												</button>
											</div>
											<span class="separator">|</span>
											<a target="_blank" href="<?=site_url('Usulan/cetak_rekap_usulan_caleg');?>" class="btn red uppercase">Cetak Data <i class="fa fa-print"></i> </a>
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
											<th style="text-align: center;"> Pengusul </th>
											<th style="text-align: center;"> Kegiatan </th>
											<th style="text-align: center;"> Waktu </th>
											<th style="text-align: center;"> Status </th>
											<th style="text-align: center;" width="8%"> Aksi </th>
										</tr>
									</thead>
									<tbody>
										<?php
										$no = 1;
										foreach ($usulan_caleg as $key => $value) {
											if($value['Status']=='string'){
											echo '';
											}
											else{
										?>
										<tr class="odd gradeX">
											<td>
												<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
													<input type="checkbox" class="checkboxes" name="selected_id[]" value="<?php echo $value['Id_CalegUsulan']; ?>"/>
													<span></span>
												</label>
											</td>
											<td style="text-align: center;"><?= $no++.'.'; ?></td>
											<td><?= $value['Nama_Caleg']; ?></td>
											<td><?= $value['Nama_Kegiatan']; ?></td>
											<td><?php
														$tanggal = explode('T', $value['Waktu']);
														$waktu = explode('-', $tanggal[0]);
														if ($waktu[1]=="01") {
															echo $waktu[2]." Januari ".$waktu[0];
														}elseif ($waktu[1]=="02") {
															echo $waktu[2]." Februari ".$waktu[0];
														}elseif ($waktu[1]=="03") {
															echo $waktu[2]." Maret ".$waktu[0];
														}elseif ($waktu[1]=="04") {
															echo $waktu[2]." April ".$waktu[0];
														}elseif ($waktu[1]=="05") {
															echo $waktu[2]." Mei ".$waktu[0];
														}elseif ($waktu[1]=="06") {
															echo $waktu[2]." Juni ".$waktu[0];
														}elseif ($waktu[1]=="07") {
															echo $waktu[2]." Juli ".$waktu[0];
														}elseif ($waktu[1]=="08") {
															echo $waktu[2]." Agustus ".$waktu[0];
														}elseif ($waktu[1]=="09") {
															echo $waktu[2]." September ".$waktu[0];
														}elseif ($waktu[1]=="10") {
															echo $waktu[2]." Oktober ".$waktu[0];
														}elseif ($waktu[1]=="11") {
															echo $waktu[2]." November ".$waktu[0];
														}elseif ($waktu[1]=="12") {
															echo $waktu[2]." Desember ".$waktu[0];
														}?></td>
											<td style="text-align: center;">
												<?php
													if($value['Status']=='PENDING'){
														echo '<span class="label label-default"> Pending </span>';
													}
													elseif($value['Status']=='APPROVE'){
														echo '<span class="label label-warning"> Approved </span>';
													}
													elseif($value['Status']=='REJECTED'){
														echo '<span class="label label-danger"> Rejected </span>';
													}
													else{
														echo '<span class="label label-success"> Done </span>';
													}
												?>
											</td>
											<td>
												<div class="btn-group">
													<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Aksi
														<i class="fa fa-angle-down"></i>
													</button>
													<ul class="dropdown-menu" role="menu">
														<li>
															<a data-toggle="modal" class='view_data' data-target="#myModal" id="<?= $value['Id_CalegUsulan']; ?>">
																<i class="icon-eye"></i> Detail Data </a>
														</li>
														<li>
															<a onclick="return confirm('Anda yakin?')" href="<?php echo site_url('Usulan/hapus_usulan/1/'.$value['Id_CalegUsulan'])?>">
																<i class="icon-trash"></i> Hapus Data </a>
														</li>
														<?php
														if($this->session->userdata('role')=='dpd' or $this->session->userdata('role')=='super admin' or $this->session->userdata('role')=='dapil'){
															if($value['Status']=='PENDING'){
														?>
														<li class="divider"> </li>
														<li>
															<a href="<?php echo site_url('Usulan/approval/'.$value['Id_CalegUsulan'].'/1/1')?>">
																<i class="fa fa-check"></i> Setujui
															</a>
														</li>
														<li>
															<a href="<?php echo site_url('Usulan/approval/'.$value['Id_CalegUsulan'].'/1/0')?>">
																<i class="fa fa-close"></i> Tolak
															</a>
														</li>
														<?php
															}
															else{
																echo '';
															}
														}else{echo'';}
														?>
													</ul>
												</div>
											</td>
										</tr>
										<?php
										}}
										?>
									</tbody>
								</table>
								</form>
							</div>
							<div class="tab-pane active" id="tab_15_2">
								<form action="#" method="post" onsubmit="return deleteConfirm();"/>
								<div class="table-toolbar">
									<div class="row">
										<div class="col-md-6">
											<div class="btn-group">
												<button type='submit' id="sample_editable_1_new" class="btn sbold green"> Hapus
													<i class="fa fa-trash"></i>
												</button>
											</div>
											<span class="separator">|</span>
											<a target="_blank" href="<?=site_url('member_side/cetak_rekap_usulan_relawan');?>" class="btn red uppercase">Cetak Data <i class="fa fa-print"></i> </a>
										</div>
									
									</div>
								</div>
								
								<table class="table table-striped table-bordered table-hover table-checkable order-column" id="tbl">
									<thead>
										<tr>
											<th style="text-align: center;" width="4%"> # </th>
											<th style="text-align: center;"> Judul Instruksi </th>
											<th style="text-align: center;"> Deskripsi </th>
											<th style="text-align: center;"> Waktu </th>
											<th style="text-align: center;"> Wilayah </th>
											<th style="text-align: center;"> Pengusul </th>
											<th style="text-align: center;"> Status </th>
											<th style="text-align: center;" width="8%"> Aksi </th>
										</tr>
									</thead>
								</table>
								<script type="text/javascript" language="javascript" >
									$(document).ready(function(){
										$('#tbl').dataTable({
											"order": [[ 0, "asc" ]],
											"bProcessing": true,
											"ajax" : {
												url:"<?= site_url('member/Task/json_usulan_instruksi'); ?>"
											},
											"aoColumns": [
														{ mData: 'number', sClass: "alignCenter" },
														{ mData: 'judul', sClass: "alignCenter" } ,
														{ mData: 'deskripsi', sClass: "alignCenter" },
														{ mData: 'waktu', sClass: "alignCenter" },
														{ mData: 'wilayah', sClass: "alignCenter" },
														{ mData: 'relawan', sClass: "alignCenter" },
														{ mData: 'status', sClass: "alignCenter" },
														{ mData: 'action' }
													]
										});
									});
								</script>
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
  $(document).ready(function(){
    $('.view_data').click(function(){
      var id = $(this).attr("id");
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
  $(document).ready(function(){
    $('.view_data2').click(function(){
      var id = $(this).attr("id");
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