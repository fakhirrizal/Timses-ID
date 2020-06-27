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
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light ">
                <div class="portlet-body form">
                    <form role="form" enctype='multipart/form-data' class="form-horizontal" action="<?= base_url().'member_side/simpan_instruksi' ?>" method="post">
                        <div class="form-body">
                            <!-- <div class="form-group">
                                <label class="control-label col-md-3">Opsi Input
                                </label>
                                <div class="col-md-8">
                                    <div class="md-radio-inline">
                                        <div class="md-radio has-success">
                                            <input type="radio" id="radio1" name="radio1" value='semua' class="md-radiobtn">
                                            <label for="radio1">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Semua </label>
                                        </div>
                                        <div class="md-radio has-error">
                                            <input type="radio" id="radio2" name="radio1" value='caleg' class="md-radiobtn" checked="">
                                            <label for="radio2">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Admin Wilayah </label>
                                        </div>
                                        <div class="md-radio has-warning">
                                            <input type="radio" id="radio3" name="radio1" value='struktur' class="md-radiobtn" >
                                            <label for="radio3">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Relawan </label>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
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
                                        <!-- <div class="md-radio has-warning">
                                            <input type="radio" id="radio26" name="radio3" value='tingkat_struktur' class="md-radiobtn" >
                                            <label for="radio26">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Tingkat Relawan </label>
                                        </div> -->
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
                                        <!-- <div class="md-radio has-warning">
                                            <input type="radio" id="radio16" name="radio2" value='tingkat_pemilihan' class="md-radiobtn" >
                                            <label for="radio16">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Tingkat Pemilihan </label>
                                        </div>
                                        <div class="md-radio has-default">
                                            <input type="radio" id="radio17" name="radio2" value='dapil' class="md-radiobtn" >
                                            <label for="radio17">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Dapil </label>
                                        </div> -->
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
                                        $url1 = 'http://kertasfolio.id:99/api/userdatas/event/'.$get_info->id_event;
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
                                        $url2 = 'http://kertasfolio.id:99/api/relawandatas/byevent/'.$get_info->id_event;
                                        $data_r = $this->Main_model->getAPI($url2);
                                        foreach ($data_r as $key => $value) {
                                            $url3 = 'http://kertasfolio.id:99/api/relawanprofiles/getProfile/'.$value['idRelawan'];
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
                            <!-- <div class="form-group select2-bootstrap-prepend">
                                <label class="control-label col-md-3">Jenis Kegiatan<span class="required"> * </span></label>
                                <div class="col-md-4">
                                    <select name="jenis_kegiatan" class="form-control select2-allow-clear">
                                        <option value=""></option>
                                        <option value="PERSON">Person</option>
                                        <option value="FAMILY">Family</option>
                                        <option value='MASSA'>Massa</option>
                                        <option value='PROJECT'>Project</option>
                                    </select>
                                </div>
                            </div> -->
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
                                <!-- <div class="col-md-4">
                                    <input type="time" class="form-control" name="jam" />
                                </div> -->
                            </div>
                            <!-- <div class="form-group">
                                <label class="control-label col-md-3">Lokasi
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="detail_lokasi" />
                                </div>
                            </div> -->
                            <div class="form-group select2-bootstrap-prepend">
                                <label class="control-label col-md-3">Wilayah <span class="required"> * </span></label>
                            </div>
                            <!-- <div class="form-group select2-bootstrap-prepend">
                                <label class="control-label col-md-3">Kabupaten</label>
                                <div class="col-md-4">
                                    <select name="kabupaten" id="kabupaten" class="form-control select2-allow-clear">
                                        <option value=""></option>
                                        <?php
                                        foreach($data_provinsi as $key => $value){
                                            echo '<option value="'.$value['Id_Kabupaten'].'">'.$value['Nama_Kabupaten'].'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div> -->







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
											<select id="kabupaten" name="kabupaten" class="form-control select2-allow-clear" required>
												<option value="">-- Pilih --</option>
											';
											$url1 = 'http://kertasfolio.id:99/api/kab/prov/'.$get_info->wilayah;
											$data = $this->Main_model->getAPI($url1);
											foreach ($data as $key => $value) {
												echo'<option value="'.$value['idKabupaten'].'">'.$value['namaKabupaten'].'</option>';
											}
											echo'</select>
											';
										}elseif($get_info->keterangan=='PILKADA KAB/KOTA'){
											echo'
											<select id="kecamatan" name="kecamatan" class="form-control select2-allow-clear" required>
												<option value="">-- Pilih --</option>
											';
											$url1 = 'http://kertasfolio.id:99/api/kec/kab/'.$get_info->wilayah;
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
										<select id="kecamatan" name="kecamatan" class="form-control select2-allow-clear" required>
											<option value="">-- Pilih --</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group form-md-line-input has-danger">
								<label class="col-md-3 control-label" for="form_control_1">Kelurahan/ Desa </label>
								<div class="col-md-4">
									<div class="input-icon">
										<select id="desa" name="desa" class="form-control select2-allow-clear" required>
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
										<select id="desa" name="desa" class="form-control select2-allow-clear" required>
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













                            <!-- <div class="form-group select2-bootstrap-prepend">
                                <label class="control-label col-md-3">Kecamatan</label>
                                <div class="col-md-4">
                                    <select name="kecamatan" id="kecamatan" class="form-control select2-allow-clear">
                                        <option value=""></option>
                                        <?php
                                        foreach ($data_kabupaten as $key => $value) {
                                            echo '<option value="'.$value->id_kecamatan.'">'.$value->nm_kecamatan.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group select2-bootstrap-prepend">
                                <label class="control-label col-md-3">Kelurahan/ Desa</label>
                                <div class="col-md-4">
                                    <select name="desa" id="desa" class="form-control select2-allow-clear">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div> -->
                            <!-- <div class="form-group select2-bootstrap-prepend">
                                <label class="control-label col-md-3">Rukun Warga (RW)</label>
                                <div class="col-md-4">
                                    <select name="rw" id="rw" class="form-control select2-allow-clear">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group select2-bootstrap-prepend">
                                <label class="control-label col-md-3">Dapil <span class="required"> * </span></label>
                                <div class="col-md-4">
                                    <select id='tingkat_dapil' class="form-control select2-allow-clear">
                                        <option value=""></option>
                                        <option value="DPRRI">DPR-RI</option>
                                        <option value="DPRD">DPRD Provinsi</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group select2-bootstrap-prepend">
                                <label class="control-label col-md-3"></label>
                                <div class="col-md-4">
                                    <select name="dapil" id='dapil' class="form-control select2-allow-clear">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div> -->
                            <!-- <hr>
                            <div class="form-group">
                                <label class="control-label col-md-3">Segmentasi
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-8">
                                    <select id="select2-multiple" class="form-control select2-multiple" name='segmentasi[]' multiple>
                                        <option value="PKK">PKK</option>
                                        <option value="Majelis taklim">Majelis taklim</option>
                                        <option value='Posyandu'>Posyandu</option>
                                        <option value='Jumantik'>Jumantik</option>
                                        <option value='Dasawisma'>Dasawisma</option>
                                        <option value='Kyai, Habaib, DKM'>Kyai, Habaib, DKM</option>
                                        <option value='Ustadzah'>Ustadzah</option>
                                        <option value='Karang Taruna / Pemuda Lingkungan'>Karang Taruna / Pemuda Lingkungan</option>
                                        <option value='FBR'>FBR</option>
                                        <option value='FORKABI'>FORKABI</option>
                                        <option value='FPI'>FPI</option>
                                        <option value='Mantan pejabat/ pimpinan partai/ legislatif'>Mantan pejabat/ pimpinan partai/ legislatif</option>
                                        <option value='RT RW'>RT RW</option>
                                        <option value='FKMS/ Pokdan/ Mitra Koramil/ FKDM'>FKMS/ Pokdan/ Mitra Koramil/ FKDM</option>
                                        <option value='Paguyuban Kesukuan'>Paguyuban Kesukuan</option>
                                        <option value='Komunitas sepeda'>Komunitas sepeda</option>
                                        <option value='Komunitas buruh'>Komunitas buruh</option>
                                        <option value='Komunitas Jakmania'>Komunitas Jakmania</option>
                                        <option value='Pelajar/ Mahasiswa'>Pelajar/ Mahasiswa</option>
                                        <option value='Pendidikan (yayasan,  sekolah,  guru,  dosen)'>Pendidikan (yayasan,  sekolah,  guru,  dosen)</option>
                                        <option value='Komunitas Olahraga (bola,  futsal,  panahan,  dll)'>Komunitas Olahraga (bola,  futsal,  panahan,  dll)</option>
                                        <option value='Komunitas senam (lansia,  aerobik,  dll)'>Komunitas senam (lansia,  aerobik,  dll)</option>
                                        <option value='Kesehatan (RS,  Puskesmas,  dokter,  bidan,  perawat)'>Kesehatan (RS,  Puskesmas,  dokter,  bidan,  perawat)</option>
                                        <option value='Profesional (akuntan,  arsitek,  konsultan,  psikolog,  dll)'>Profesional (akuntan,  arsitek,  konsultan,  psikolog,  dll)</option>
                                        <option value='Hukum (pengacara,  notaris,  hakim,  jaksa,  pembuat akta tanah,  dll)'>Hukum (pengacara,  notaris,  hakim,  jaksa,  pembuat akta tanah,  dll)</option>
                                        <option value='Pengusaha (properti,  angkutan,  travel,  dll)'>Pengusaha (properti,  angkutan,  travel,  dll)</option>
                                        <option value='Pedagang Pasar'>Pedagang Pasar</option>
                                        <option value='Pedagang kaki lima / umkm'>Pedagang kaki lima / umkm</option>
                                        <option value='Ojek online'>Ojek online</option>
                                        <option value='Bank,  BPR,  Koperasi'>Bank,  BPR,  Koperasi</option>
                                        <option value='Pengangguran'>Pengangguran</option>
                                        <option value='Lainnya'>Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Isu Strategis
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-8">
                                    <select id="select2-multiple" class="form-control select2-multiple" name='isu[]' multiple>
                                        <option value='Sumber daya manusia-pendidikan dasar'>Sumber daya manusia-pendidikan dasar</option>
                                        <option value='Tenaga kerja, pengangguran'>Tenaga kerja, pengangguran</option>
                                        <option value='Lingkungan hidup,air, sungai, sampah'>Lingkungan hidup,air, sungai, sampah</option>
                                        <option value='Ukm, usaha rumahan'>Ukm, usaha rumahan</option>
                                        <option value='Pangan/perumahan'>Pangan/perumahan</option>
                                        <option value='Layanan kesehatan dasar'>Layanan kesehatan dasar</option>
                                        <option value='Pelayanan publik, pembangunan infrastruktur'>Pelayanan publik, pembangunan infrastruktur</option>
                                        <option value='Seni budaya dan olahraga'>Seni budaya dan olahraga</option>
                                        <option value='Keagamaan, masjid, pesantren'>Keagamaan, masjid, pesantren</option>
                                        <option value='Kepemudaan, pelajar, mahasiswa'>Kepemudaan, pelajar, mahasiswa</option>
                                        <option value='Tokoh wanita, keluarga'>Tokoh wanita, keluarga</option>
                                        <option value='Pertanian, peternakan, perikanan'>Pertanian, peternakan, perikanan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Tokoh yang akan dikunjungi
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="tokoh_dikunjungi" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Lembaga yang akan dikunjungi
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="lembaga_dikunjungi" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Lampiran
                                </label>
                                <div class="col-md-3">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="input-group input-large">
                                            <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                                <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                <span class="fileinput-filename"> </span>
                                            </div>
                                            <span class="input-group-addon btn default btn-file">
                                                <span class="fileinput-new"> Pilih file </span>
                                                <span class="fileinput-exists"> Ubah </span>
                                                <input type="file" name="foto[]"> </span>
                                            <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Hapus </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">
                                </label>
                                <div class="col-md-3">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="input-group input-large">
                                            <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                                <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                <span class="fileinput-filename"> </span>
                                            </div>
                                            <span class="input-group-addon btn default btn-file">
                                                <span class="fileinput-new"> Pilih file </span>
                                                <span class="fileinput-exists"> Ubah </span>
                                                <input type="file" name="foto[]"> </span>
                                            <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Hapus </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">
                                </label>
                                <div class="col-md-3">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="input-group input-large">
                                            <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                                <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                <span class="fileinput-filename"> </span>
                                            </div>
                                            <span class="input-group-addon btn default btn-file">
                                                <span class="fileinput-new"> Pilih file </span>
                                                <span class="fileinput-exists"> Ubah </span>
                                                <input type="file" name="foto[]"> </span>
                                            <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Hapus </a>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
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
            <!-- END SAMPLE FORM PORTLET-->
        </div>
    </div>
</div>