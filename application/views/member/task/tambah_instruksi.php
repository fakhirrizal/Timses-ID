<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>
$(document).ready(function(){
    $("#radio1").click(function(){
            $('#pilihan_manual').hide('fast');
            $('#pilihan_manual_relawan').hide('fast');
            $('#pilihan_caleg_tingkat_pemilihan').hide('fast');
            $('#pilihan_caleg_pilihan_dapil').hide('fast');
            $('#pilihan_caleg_dapil').hide('fast');
            $('#pilihancaleg').hide('fast');
            $('#pilihanrelawan').hide('fast');
            $('#pilihan_relawan_tingkat_relawan').hide('fast');
    });
});
$(document).ready(function(){
    $("#radio2").click(function(){
            $('#pilihan_manual').show('fast');
            $('#pilihan_manual_relawan').hide('fast');
            $('#pilihan_caleg_tingkat_pemilihan').hide('fast');
            $('#pilihan_caleg_pilihan_dapil').hide('fast');
            $('#pilihan_caleg_dapil').hide('fast');
            $('#pilihancaleg').show('fast');
            $('#pilihanrelawan').hide('fast');
            $('#pilihan_relawan_tingkat_relawan').hide('fast');
    });
});
$(document).ready(function(){
    $("#radio3").click(function(){
            $('#pilihan_manual').hide('fast');
            $('#pilihan_manual_relawan').show('fast');
            $('#pilihan_caleg_tingkat_pemilihan').hide('fast');
            $('#pilihan_caleg_pilihan_dapil').hide('fast');
            $('#pilihan_caleg_dapil').hide('fast');
            $('#pilihancaleg').hide('fast');
            $('#pilihanrelawan').show('fast');
            $('#pilihan_relawan_tingkat_relawan').hide('fast');
    });
});
$(document).ready(function(){
    $("#radio14").click(function(){
            $('#pilihan_manual').hide('fast');
            $('#pilihan_caleg_tingkat_pemilihan').hide('fast');
            $('#pilihan_caleg_pilihan_dapil').hide('fast');
            $('#pilihan_caleg_dapil').hide('fast');
    });
});
$(document).ready(function(){
    $("#radio15").click(function(){
            $('#pilihan_manual').show('fast');
            $('#pilihan_caleg_tingkat_pemilihan').hide('fast');
            $('#pilihan_caleg_pilihan_dapil').hide('fast');
            $('#pilihan_caleg_dapil').hide('fast');
    });
});
$(document).ready(function(){
    $("#radio16").click(function(){
            $('#pilihan_manual').hide('fast');
            $('#pilihan_caleg_tingkat_pemilihan').show('fast');
            $('#pilihan_caleg_pilihan_dapil').hide('fast');
            $('#pilihan_caleg_dapil').hide('fast');
    });
});
$(document).ready(function(){
    $("#radio17").click(function(){
            $('#pilihan_manual').hide('fast');
            $('#pilihan_caleg_tingkat_pemilihan').hide('fast');
            $('#pilihan_caleg_pilihan_dapil').show('fast');
            $('#pilihan_caleg_dapil').show('fast');
    });
});
$(document).ready(function(){
    $("#radio24").click(function(){
            $('#pilihan_manual_relawan').hide('fast');
            $('#pilihan_relawan_tingkat_relawan').hide('fast');
    });
});
$(document).ready(function(){
    $("#radio25").click(function(){
            $('#pilihan_manual_relawan').show('fast');
            $('#pilihan_relawan_tingkat_relawan').hide('fast');
    });
});
$(document).ready(function(){
    $("#radio26").click(function(){
            $('#pilihan_manual_relawan').hide('fast');
            $('#pilihan_relawan_tingkat_relawan').show('fast');
    });
});
</script>
<script type="text/javascript">

$(function(){
		$.ajaxSetup({
			type:"POST",
			url: "<?php echo site_url('/member/Master/ajax_function')?>",
			cache: false,
		});
		$("#kabupaten").change(function(){
			var value=$(this).val();
			$.ajax({
				data:{id:value,modul:'get_kecamatan_by_id_kabupaten'},
				success: function(respond){
					$("#kecamatan").html(respond);
				}
			})
		});
		$("#kecamatan").change(function(){
			var value=$(this).val();
			$.ajax({
				data:{id:value,modul:'get_desa_by_id_kecamatan'},
				success: function(respond){
					$("#desa").html(respond);
				}
			})
		});
	})

</script>
<ul class="page-breadcrumb breadcrumb">
	<li>
		<span>Command Center</span>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<span>Tambah Instruksi</span>
	</li>
</ul>
<?= $this->session->flashdata('sukses') ?>
<?= $this->session->flashdata('gagal') ?>
<div class="page-content-inner">
    <div class="m-heading-1 border-green m-bordered">
        <h3>Catatan</h3>
        <p> 1. Untuk tempat pelaksanaan tugas sesuaikan dengan wilayahnya jika mencakup satu provinsi maka silahkan hanya <i>select dropdown</i> Kecamatan, begitu seterusnya.</p>
        <p> 2. Ketentuan file yang diupload:</p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Format berupa file <b>.pdf</b></p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Ukuran maksimum file <b>5 MB</b></p>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light ">
                <div class="portlet-body form">
                    <form role="form" enctype='multipart/form-data' class="form-horizontal" action="<?= base_url().'member_side/simpan_instruksi' ?>" method="post">
                        <div class="form-body">
                            <div class="form-group" id='pilihanrelawan' >
                            <hr>
                                <label class="control-label col-md-3">
                                </label>
                                <div class="col-md-8">
                                    <div class="md-radio-inline">
                                        <div class="md-radio has-success">
                                            <input type="radio" id="radio24" name="pilihan_sasaran" value='semua' class="md-radiobtn">
                                            <label for="radio24">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Semua Relawan </label>
                                        </div>
                                        <div class="md-radio has-error">
                                            <input type="radio" id="radio25" name="pilihan_sasaran" value='' class="md-radiobtn" checked="">
                                            <label for="radio25">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Pilih Manual </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id='pilihancaleg' style='display: none'>
                            <hr>
                                <label class="control-label col-md-3">
                                </label>
                                <div class="col-md-8">
                                    <div class="md-radio-inline">
                                        <div class="md-radio has-success">
                                            <input type="radio" id="radio14" name="radio2" value='semua' class="md-radiobtn">
                                            <label for="radio14">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Semua Admin Wilayah </label>
                                        </div>
                                        <div class="md-radio has-error">
                                            <input type="radio" id="radio15" name="radio2" value='' class="md-radiobtn" checked="">
                                            <label for="radio15">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Pilih Manual </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group select2-bootstrap-prepend" id='pilihan_caleg_dapil' style='display: none'>
                                <label class="control-label col-md-3">Dapil<span class="required"> * </span></label>
                                <div class="col-md-4">
                                    <select id='tingkat_dapil2' name='tingkatan_dapil' class="form-control select2-allow-clear">
                                        <option value=""></option>
                                        <option value="DPRRI">DPR-RI</option>
                                        <option value="DPRD">DPRD Provinsi</option>
                                    </select>
                                </div>
                            <br>
                            <br>
                            </div>
                            
                            <div class="form-group select2-bootstrap-prepend" id='pilihan_caleg_pilihan_dapil' style='display: none'>
                                <label class="control-label col-md-3"></label>
                                <div class="col-md-4">
                                    <select name="dapil" id='pilihandapil' class="form-control select2-allow-clear">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group select2-bootstrap-prepend" id='pilihan_caleg_tingkat_pemilihan' style='display: none'>
                                <label class="control-label col-md-3">Tingkat Pemilihan<span class="required"> * </span></label>
                                <div class="col-md-4">
                                    <select name="tingkat_pemilihan" class="form-control select2-allow-clear">
                                        <option value=""></option>
                                        <option value="DPR">DPR-RI</option>
                                        <option value="DPRD">DPRD Provinsi</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group select2-bootstrap-prepend" id='pilihan_relawan_tingkat_relawan' style='display: none'>
                                <label class="control-label col-md-3">Tingkat Relawan<span class="required"> * </span></label>
                                <div class="col-md-4">
                                    <select name="tingkat_relawan" class="form-control select2-allow-clear">
                                        <option value=""></option>
                                        <option value="DPC">DPC</option>
                                        <option value="DPRA">DPRA</option>
                                        <option value="UPPA">UPPA</option>
                                        <option value="TIMSES">TIMSES</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id='pilihan_manual' style='display: none'>
                                <label class="control-label col-md-3">Admin Wilayah
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-8 has-warning">
                                    <select id="select2-multiple" class="form-control select2-multiple" name='caleg[]' multiple>
                                        <option value=""></option>
                                        <?php
                                        $url1 = 'http://pradi.is-very-good.org:7733/api/userdatas/event/'.$get_info->id_event;
                                        $data = $this->Main_model->getAPI($url1);
                                        foreach ($data as $key => $value) {
                                            if($value['keterangan']==$this->session->userdata('id')){
                                                echo'';
                                            }else{
                                                echo'<option value="'.$value['idUserDatas'].'">'.$value['namaUser'].'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <p class="help-block">Silahkan pilih Admin Wilayah yang akan ditugasi</p>
                                </div>
                            </div>
                            <div class="form-group" id='pilihan_manual_relawan' >
                                <label class="control-label col-md-3">Relawan
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-8 has-warning">
                                    <select id="select2-multiple" class="form-control select2-multiple" name='struktur[]' multiple>
                                        <option value=""></option>
                                        <?php
                                        $url2 = 'http://pradi.is-very-good.org:7733/api/relawandatas/byevent/'.$get_info->id_event;
                                        $data_r = $this->Main_model->getAPI($url2);
                                        foreach ($data_r as $key => $value) {
                                            $url3 = 'http://pradi.is-very-good.org:7733/api/relawanprofiles/getProfile/'.$value['idRelawan'];
                                            $data_r = $this->Main_model->getAPI($url3);
                                            echo'<option value="'.$value['idRelawan'].'">'.$data_r['namaRelawan'].'</option>';
                                        }
                                        ?>
                                    </select>
                                    <p class="help-block">Silahkan pilih Relawan yang akan ditugasi</p>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="control-label col-md-3">Nama Kegiatan
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="nama_kegiatan" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Deskripsi Kegiatan
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <textarea class="form-control" name="deskripsi_kegiatan"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Waktu
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="date" class="form-control" name="waktu" />
                                </div>
                            </div>
                            <div class="form-group select2-bootstrap-prepend">
                                <label class="control-label col-md-3">Wilayah <span class="required"> * </span></label>
                                
                            </div>
                            <div class="form-group select2-bootstrap-prepend">
                                <label class="control-label col-md-3"></label>
                                <div class="col-md-4">
                                    <div class="md-checkbox has-success">
                                        <input type="checkbox" id="checkbox9" class="md-check" name='all_wilayah' value='1'>
                                        <label for="checkbox9">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span> All Wilayah </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-md-line-input has-danger">
								<?php
								if($get_info->keterangan=='PILKADA PROVINSI'){
									echo'<label class="col-md-3 control-label" for="form_control_1">Kabupaten/ Kota </label>';
								}elseif($get_info->keterangan=='PILKADA KAB/KOTA'){
									echo'<label class="col-md-3 control-label" for="form_control_1">Kecamatan </label>';
								}else{
									echo'<label class="col-md-3 control-label" for="form_control_1">Wilayah </label>';
								}
								?>
								<div class="col-md-4">
									<div class="input-icon">
										<?php
										if($get_info->keterangan=='PILKADA PROVINSI'){
											echo'
											<select id="kabupaten" name="kabupaten" class="form-control select2-allow-clear" >
												<option value="">-- Pilih --</option>
											';
											$url1 = 'http://pradi.is-very-good.org:7733/api/kab/prov/'.$get_info->wilayah;
											$data = $this->Main_model->getAPI($url1);
											foreach ($data as $key => $value) {
												echo'<option value="'.$value['idKabupaten'].'">'.$value['namaKabupaten'].'</option>';
											}
											echo'</select>
											';
										}elseif($get_info->keterangan=='PILKADA KAB/KOTA'){
											echo'
											<select id="kecamatan" name="kecamatan" class="form-control select2-allow-clear" >
												<option value="">-- Pilih --</option>
											';
											$url1 = 'http://pradi.is-very-good.org:7733/api/kec/kab/'.$get_info->wilayah;
											$data = $this->Main_model->getAPI($url1);
											foreach ($data as $key => $value) {
												echo'<option value="'.$value['idKecamatan'].'">'.$value['namaKecamatan'].'</option>';
											}
											echo'</select>';
										}else{
											echo'
											<select id="wilayah" name="wilayah" class="form-control select2-allow-clear" required>
												<option value="">-- Pilih --</option>
											</select>
											';
										}
										?>
									</div>
								</div>
							</div>
							<?php
							if($get_info->keterangan=='PILKADA PROVINSI'){
							?>
							<input type="hidden" name="provinsi" value="<?= $get_info->wilayah; ?>">
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-3 control-label" for="form_control_1">Kecamatan </label>
								<div class="col-md-4">
									<div class="input-icon">
										<select id="kecamatan" name="kecamatan" class="form-control select2-allow-clear" >
											<option value="">-- Pilih --</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-3 control-label" for="form_control_1">Kelurahan/ Desa </label>
								<div class="col-md-4">
									<div class="input-icon">
										<select id="desa" name="desa" class="form-control select2-allow-clear" >
											<option value="">-- Pilih --</option>
										</select>
									</div>
								</div>
							</div>
							<?php
							}elseif($get_info->keterangan=='PILKADA KAB/KOTA'){
							?>
							<input type="hidden" name="provinsi" value="<?= substr($get_info->wilayah,0,2); ?>">
							<input type="hidden" name="kabupaten" value="<?= $get_info->wilayah; ?>">
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-3 control-label" for="form_control_1">Kelurahan/ Desa </label>
								<div class="col-md-4">
									<div class="input-icon">
										<select id="desa" name="desa" class="form-control select2-allow-clear" >
											<option value="">-- Pilih --</option>
										</select>
									</div>
								</div>
							</div>
							<?php
							}else{
								echo'';
							}
							?>
                            <hr>
                            <div class="form-group">
                                <label class="control-label col-md-3">File lampiran
                                </label>
                                <div class="col-md-4">
                                    <input type="file" class="form-control" name="file" />
                                </div>
                            </div>
                        </div>
                        <div class="form-actions margin-top-10">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-10">
                                    <button type="button" class="btn default">Batal</button>
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