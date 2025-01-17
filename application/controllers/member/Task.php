<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    /* Task */
    public function daftar_instruksi(){
        $data['parent'] = 'command_center';
        $data['child'] = 'task';
        $data['grand_child'] = '';
        $this->load->view('member/template/header',$data);
        $this->load->view('member/task/daftar_instruksi',$data);
        $this->load->view('member/template/footer');
    }
    public function json_task_data(){
        $data_info = $this->Main_model->getSelectedData('user_to_role a', 'a.*', array('a.user_id'=>$this->session->userdata('id')))->row();
		$url1 = 'http://pradi.is-very-good.org:7733/api/relawantask/count/'.$data_info->id_event;
		$data = $this->Main_model->getAPI($url1);
		$data_tampil = array();
		$no = 1;
		foreach ($data as $key => $value) {
            if($value['idTaskParent']==NULL){
                echo'';
            }else{
                $url2 = 'http://pradi.is-very-good.org:7733/api/relawantask/all/'.$value['idEvent'];
                $data2 = $this->Main_model->getAPI($url2);
                $id_wilayah = '';
                foreach ($data2 as $key => $row) {
                    if($row['idTaskParent']==$value['idTaskParent'] AND $row['idTask']!=null){
                        $id_wilayah = $row['idWilayah'];
                        break;
                    }else{
                        echo'';
                    }
                }
                $jumlah_report_task = 0;
                foreach ($data2 as $key => $row) {
                    if($row['idTaskParent']!=$value['idTaskParent']){
                        echo'';
                    }else{
                        $url3 = 'http://pradi.is-very-good.org:7733/api/relawanreport/task/'.$row['idTask'].'/'.$value['idEvent'];
                        $data_laporan = $this->Main_model->getAPI($url3);
                        if($data_laporan==NULL){
                            echo'';
                        }else{
                            $jumlah_report_task++;
                            break;
                        }
                    }
                }
                $isi['number'] = $no++.'.';
                $isi['judul'] = $value['judulTask'];
                $pecah_data = explode(',',$value['idRelawan']);
                // $isi['relawan'] = $pecah_data[0].' / '.$pecah_data[2];
                $isi['relawan'] = number_format($jumlah_report_task,0).' / '.number_format($pecah_data[2],0);
                $isi['waktu'] = $this->Main_model->convert_tanggal(substr($value['waktuTask'],0,10));
                $wilayah = '';
                if(strlen($id_wilayah)=='2'){
                    $url3 = 'http://pradi.is-very-good.org:7733/api/prov/id/'.$id_wilayah;
                    $data_prov = $this->Main_model->getAPI($url3);
                    $wilayah = $data_prov['namaProvinsi'];
                }elseif(strlen($id_wilayah)=='4'){
                    $url3 = 'http://pradi.is-very-good.org:7733/api/kab/id/'.$id_wilayah;
                    $data_kab = $this->Main_model->getAPI($url3);
                    $wilayah = $data_kab['namaKabupaten'];
                }elseif(strlen($id_wilayah)=='7'){
                    $url3 = 'http://pradi.is-very-good.org:7733/api/kec/id/'.$id_wilayah;
                    $data_kab = $this->Main_model->getAPI($url3);
                    $wilayah = $data_kab['namaKecamatan'];
                }elseif(strlen($id_wilayah)=='10'){
                    $url3 = 'http://pradi.is-very-good.org:7733/api/desa/id/'.$id_wilayah;
                    $data_kab = $this->Main_model->getAPI($url3);
                    $wilayah = $data_kab['namaDesa'];
                }else{
                    echo'';
                }
                $isi['wilayah'] = $wilayah;
                $isi['action'] =	'
                                    <div class="btn-group">
                                        <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Aksi
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-right" role="menu">
                                            <li>
                                                <a href="'.site_url('member_side/detail_instruksi/'.$value['idTaskParent']).'">
                                                    <i class="icon-eye"></i> Detail Data </a>
                                            </li>
                                            
                                        </ul>
                                    </div>
                                    ';
                $data_tampil[] = $isi;
            }
		}
		$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data_tampil),
			"iTotalDisplayRecords" => count($data_tampil),
			"aaData"=>$data_tampil);
		echo json_encode($results);
    }
    public function json_detail_task_data(){
		$url1 = 'http://pradi.is-very-good.org:7733/api/relawantask/all/'.$this->input->post('id_event');
		$data = $this->Main_model->getAPI($url1);
		$data_tampil = array();
		$no = 1;
		foreach ($data as $key => $value) {
            if($value['idTaskParent']!=$this->input->post('id_task_parent')){
                echo'';
            }else{
                $isi['number'] = $no++.'.';
                $url2 = 'http://pradi.is-very-good.org:7733/api/relawanprofiles/getProfile/'.$value['idRelawan'];
                $data_relawan = $this->Main_model->getAPI($url2);
                $isi['nama'] = $data_relawan['namaRelawan'];
                $url3 = 'http://pradi.is-very-good.org:7733/api/relawanreport/task/'.$value['idTask'].'/'.$this->input->post('id_event');
                $data_laporan = $this->Main_model->getAPI($url3);
                $isi['waktu'] = $this->Main_model->convert_tanggal(substr($data_laporan['createdDate'],0,10));
                $isi['detail'] = $data_laporan['deskripsi'];
                if($data_laporan['fotoReport']==''){
                    $isi['action'] =	'
                        <a class="btn btn-xs green" type="button" disabled> Lihat
                        </a>
                                    ';
                }else{
                    $isi['action'] =	'
                        <a class="btn btn-xs green detaildata" type="button" id="'.$data_laporan['idReport'].'"> Lihat
                        </a>
                                    ';
                }
                $data_tampil[] = $isi;
            }
		}
		$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data_tampil),
			"iTotalDisplayRecords" => count($data_tampil),
			"aaData"=>$data_tampil);
		echo json_encode($results);
	}
    public function usulan_instruksi(){
        $data['parent'] = 'command_center';
        $data['child'] = 'request_task';
        $data['grand_child'] = '';
        $this->load->view('member/template/header',$data);
        $this->load->view('member/task/usulan_instruksi',$data);
        $this->load->view('member/template/footer');
    }
    public function json_usulan_instruksi(){
        $data_info = $this->Main_model->getSelectedData('user_to_role a', 'a.*', array('a.user_id'=>$this->session->userdata('id')))->row();
		$url1 = 'http://pradi.is-very-good.org:7733/api/relawanusulan/all/'.$data_info->id_event;
		$data = $this->Main_model->getAPI($url1);
		$data_tampil = array();
		$no = 1;
		foreach ($data as $key => $value) {
			$isi['number'] = $no++.'.';
			$isi['judul'] = $value['judul'];
            $isi['deskripsi'] = $value['deskripsi'];
            $url2 = 'http://pradi.is-very-good.org:7733/api/relawanprofiles/getProfile/'.$value['idRelawan'];
            $data_relawan = $this->Main_model->getAPI($url2);
            $isi['relawan'] = $data_relawan['namaRelawan'];
			$isi['waktu'] = $this->Main_model->convert_tanggal(substr($value['waktu'],0,10));
			$wilayah = '';
			if(strlen($value['idWilayah'])=='2'){
				$url3 = 'http://pradi.is-very-good.org:7733/api/prov/id/'.$value['idWilayah'];
				$data_prov = $this->Main_model->getAPI($url3);
				$wilayah = $data_prov['namaProvinsi'];
			}elseif(strlen($value['idWilayah'])=='4'){
				$url3 = 'http://pradi.is-very-good.org:7733/api/kab/id/'.$value['idWilayah'];
				$data_kab = $this->Main_model->getAPI($url3);
				$wilayah = $data_kab['namaKabupaten'];
			}elseif(strlen($value['idWilayah'])=='7'){
				$url3 = 'http://pradi.is-very-good.org:7733/api/kec/id/'.$value['idWilayah'];
				$data_kab = $this->Main_model->getAPI($url3);
				$wilayah = $data_kab['namaKecamatan'];
			}elseif(strlen($value['idWilayah'])=='10'){
				$url3 = 'http://pradi.is-very-good.org:7733/api/desa/id/'.$value['idWilayah'];
				$data_kab = $this->Main_model->getAPI($url3);
				$wilayah = $data_kab['namaDesa'];
			}else{
				echo'';
			}
			$isi['wilayah'] = $wilayah;
            if($value['isApprove']==false){
                $isi['status'] = 'Pending';
            }else{
                $isi['status'] = 'Disetujui';
            }
            $return_on_click = "return confirm('Anda yakin?')";
            if($value['isApprove']==false){
                $isi['action'] =	'
								<div class="btn-group">
									<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Aksi
										<i class="fa fa-angle-down"></i>
									</button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li>
											<a href="'.site_url('member_side/setujui_usulan/'.$value['idUsulan']).'">
												<i class="icon-check"></i> Setujui Usulan </a>
                                        </li>
                                        <li class="divider"> </li>
										<li>
											<a href="'.site_url('member_side/detail_instruksi/'.$value['idUsulan']).'">
												<i class="icon-eye"></i> Detail Data </a>
										</li>
										<li>
											<a onclick="'.$return_on_click.'" href="'.site_url('member_side/hapus_usulan_instruksi/'.$value['idUsulan']).'">
												<i class="icon-trash"></i> Hapus Data </a>
										</li>
									</ul>
								</div>
								';
            }else{
                $isi['action'] =	'
								<div class="btn-group">
									<button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Aksi
										<i class="fa fa-angle-down"></i>
									</button>
									<ul class="dropdown-menu pull-right" role="menu">
										<li>
											<a href="'.site_url('member_side/detail_instruksi/'.$value['idUsulan']).'">
												<i class="icon-eye"></i> Detail Data </a>
										</li>
										<li>
											<a onclick="'.$return_on_click.'" href="'.site_url('member_side/hapus_usulan_instruksi/'.$value['idUsulan']).'">
												<i class="icon-trash"></i> Hapus Data </a>
										</li>
									</ul>
								</div>
								';
            }
			
			$data_tampil[] = $isi;
		}
		$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data_tampil),
			"iTotalDisplayRecords" => count($data_tampil),
			"aaData"=>$data_tampil);
		echo json_encode($results);
    }
    public function setujui_usulan(){
        $where = $this->uri->segment(3);
		$url1 = 'http://pradi.is-very-good.org:7733/api/relawanusulan/usulan/'.$where;
        $getdata = $this->Main_model->getAPI($url1);
        $url_insert = 'http://pradi.is-very-good.org:7733/api/relawanusulan/update';
        $data_insert = array(
                "idUsulan"=> $getdata['idUsulan'],
                "idEvent"=> $getdata['idEvent'],
                "idRelawan"=> $getdata['idRelawan'],
                "idWilayah"=> $getdata['idWilayah'],
                "judul"=> $getdata['judul'],
                "deskripsi"=> $getdata['deskripsi'],
                "waktu"=> $getdata['waktu'],
                "isApprove"=> true,
                "isDone"=> $getdata['isDone'],
                "createdDate"=> $getdata['createdDate'],
        );
        $hasil_insert = $this->Main_model->updateAPI($url_insert,$data_insert);
		if($hasil_insert>0){
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil diperbarui.<br /></div>' );
			echo "<script>window.location='".base_url()."member_side/usulan_instruksi/'</script>";
		}
		else{
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal diperbarui.<br /></div>' );
			echo "<script>window.location='".base_url()."member_side/usulan_instruksi/'</script>";
		}
    }
    public function cetak_rekap_usulan_relawan(){
        $data_info = $this->Main_model->getSelectedData('user_to_role a', 'a.*', array('a.user_id'=>$this->session->userdata('id')))->row();
		$url1 = 'http://pradi.is-very-good.org:7733/api/relawanusulan/all/'.$data_info->id_event;
		$data['data_utama'] = $this->Main_model->getAPI($url1);
		$this->load->view('member/task/cetak_rekap_usulan_relawan',$data);
    }
    public function tambah_instruksi(){
        $data['parent'] = 'command_center';
        $data['child'] = 'task';
        $data['grand_child'] = '';
        $data['get_info'] = $this->Main_model->getSelectedData('user_to_role a', 'a.*', array('a.user_id'=>$this->session->userdata('id')))->row();
        $this->load->view('member/template/header',$data);
        $this->load->view('member/task/tambah_instruksi',$data);
        $this->load->view('member/template/footer');
    }
    public function simpan_instruksi(){
        $array_lampiran = array();
        $nmfile = ''; // nama file saya beri nama langsung dan diikuti fungsi time
        $url_file = '';
		$config['upload_path'] = dirname($_SERVER["SCRIPT_FILENAME"]).'/data_upload/lampiran_instruksi/'; // path folder
		$config['allowed_types'] = 'pdf'; // type yang dapat diakses bisa anda sesuaikan
		$config['max_size'] = '5072'; // maksimum besar file 3M
		$config['file_name'] = "file_".time(); // nama yang terupload nantinya

		$this->upload->initialize($config);

		if(isset($_FILES['file']['name']))
		{
			if(!$this->upload->do_upload('file'))
			{
				echo'';
			}
			else
			{
                $fileup = $this->upload->data();
                $nmfile = $fileup['file_name'];
                $url_file = base_url().'data_upload/lampiran_instruksi/'.$fileup['file_name'];
			}
        }else{echo'';}
        $isi = array(
            'namaFile' => $nmfile,
            'urlFile' => $url_file
        );
        $array_lampiran[] = $isi;
        $data = $this->Main_model->getSelectedData('user_to_role a', 'a.*', array('a.user_id'=>$this->session->userdata('id')))->row();
        $wilayah = '';
        if($this->input->post('all_wilayah')=='1'){
            $wilayah = $data->wilayah;
        }else{
            if($this->input->post('desa')!=NULL){
                $wilayah = $this->input->post('desa');
            }elseif($this->input->post('kecamatan')!=NULL){
                $wilayah = $this->input->post('kecamatan');
            }elseif($this->input->post('kabupaten')!=NULL){
                $wilayah = $this->input->post('kabupaten');
            }elseif($this->input->post('provinsi')!=NULL){
                $wilayah = $this->input->post('provinsi');
            }else{
                echo'';
            }
        }
        if($this->input->post('pilihan_sasaran')=='semua'){
            $data_tampung = array();
            $url1 = 'http://pradi.is-very-good.org:7733/api/relawandatas/byevent/'.$data->id_event;
            $data_r = $this->Main_model->getAPI($url1);
            foreach ($data_r as $key => $value) {
                $url_insert = 'http://pradi.is-very-good.org:7733/api/relawantask/insert';
                $data_insert = array(
                    "idEvent"=> $data->id_event,
                    "idRelawan"=> $value['idRelawan'],
                    "idWilayah"=> $wilayah,
                    "judulTask"=> $this->input->post('nama_kegiatan'),
                    "deskripsiTask"=> $this->input->post('deskripsi_kegiatan'),
                    'waktuTask'=> $this->input->post('waktu').'T05:39:56.757Z',
                    "isDone"=> false,
                    'createdDate'=> date("Y-m-d").'T05:39:56.757Z',
                    'lampiran' => $array_lampiran
                );
                // print_r($data_insert);
                $data_tampung[] = $data_insert;
            }
            $hasil_insert = $this->Main_model->insertAPI($url_insert,$data_tampung);
            $this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil ditambahkan.<br /></div>' );
            echo "<script>window.location='".base_url()."member_side/daftar_instruksi/'</script>";
        }else{
            for ($i=0; $i < count($this->input->post('struktur')); $i++) { 
                $url_insert = 'http://pradi.is-very-good.org:7733/api/relawantask/insert';
                $data_insert = array(
                    "idEvent"=> $data->id_event,
                    "idRelawan"=> $this->input->post('struktur')[$i],
                    "idWilayah"=> $wilayah,
                    "judulTask"=> $this->input->post('nama_kegiatan'),
                    "deskripsiTask"=> $this->input->post('deskripsi_kegiatan'),
                    'waktuTask'=> $this->input->post('waktu').'T05:39:56.757Z',
                    "isDone"=> false,
                    'createdDate'=> date("Y-m-d").'T05:39:56.757Z',
                    'lampiran' => $array_lampiran
                );
                // print_r($data_insert);
                $hasil_insert = $this->Main_model->insertAPI($url_insert,$data_insert);
            }
            $this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil ditambahkan.<br /></div>' );
            echo "<script>window.location='".base_url()."member_side/daftar_instruksi/'</script>";
        }
    }
    public function detail_instruksi($id)
    {
        $data['parent'] = 'command_center';
        $data['child'] = 'task';
        $data['grand_child'] = '';
        $data_info = $this->Main_model->getSelectedData('user_to_role a', 'a.*', array('a.user_id'=>$this->session->userdata('id')))->row();
        $url1 = 'http://pradi.is-very-good.org:7733/api/relawantask/count/'.$data_info->id_event;
		$data['data_utama'] = $this->Main_model->getAPI($url1);
        $data['id_task_parent'] = $id;
        $data['id_event'] = $data_info->id_event;
        $this->load->view('member/template/header',$data);
        $this->load->view('member/task/detail_instruksi',$data);
        $this->load->view('member/template/footer');
    }
    public function detail_report()
    {
        $data['parent'] = 'command_center';
        $data['child'] = 'report';
        $data['grand_child'] = '';
        $this->load->view('member/template/header',$data);
        $this->load->view('member/report/detail_report',$data);
        $this->load->view('member/template/footer');
    }
    public function hapus_instruksi(){
		$this->db->trans_start();
		$where = $this->uri->segment(3);
		$url1 = 'http://pradi.is-very-good.org:7733/api/relawantask/delete?idIsu='.$where;
		$this->Main_model->deleteAPI($url1);
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."member_side/daftar_instruksi/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."member_side/daftar_instruksi/'</script>";
		}
    }
    public function hapus_usulan_instruksi(){
		$this->db->trans_start();
		$where = $this->uri->segment(3);
		$url1 = 'http://pradi.is-very-good.org:7733/api/relawanusulan/delete/'.$where;
		$this->Main_model->deleteAPI($url1);
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."member_side/usulan_instruksi/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."member_side/usulan_instruksi/'</script>";
		}
	}
    /* Analysis */
    public function analysis(){
        $data['parent'] = 'analysis';
        $data['child'] = '';
        $data['grand_child'] = '';
        $this->load->view('member/template/header',$data);
        $this->load->view('member/report/analysis',$data);
        $this->load->view('member/template/footer');
    }
    public function add_analysis(){
        $data['parent'] = 'analysis';
        $data['child'] = '';
        $data['grand_child'] = '';
        $this->load->view('member/template/header',$data);
        $this->load->view('member/report/add_analysis',$data);
        $this->load->view('member/template/footer');
    }
    public function detail_analysis(){
        $data['parent'] = 'analysis';
        $data['child'] = '';
        $data['grand_child'] = '';
        $this->load->view('member/template/header',$data);
        $this->load->view('member/report/detail_analysis',$data);
        $this->load->view('member/template/footer');
    }
    /* Other Function */
    public function ajax_function(){
        if($this->input->post('modul')=='get_kabupaten_by_id_provinsi'){
            echo'<option value="">-- Pilih Kabupaten/ Kota --</option>';
            $url_k = 'http://pradi.is-very-good.org:7733/api/kab/prov/'.$this->input->post('id');
            $data_k = $this->Main_model->getAPI($url_k);
            foreach ($data_k as $key => $value) {
                echo'<option value="'.$value['idKabupaten'].'">'.$value['namaKabupaten'].'</option>';
            }
        }elseif($this->input->post('modul')=='modul_detail_laporan_task'){
            $url1 = 'http://pradi.is-very-good.org:7733/api/relawanreport/task/'.$this->input->post('id');
            $data_laporan = $this->Main_model->getAPI($url1);
            echo '<img src="data:image/png;base64,' . $data_laporan['fotoReport'] . '" alt="" width="100%"/>';
        }
    }
}