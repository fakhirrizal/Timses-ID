<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    /* Report */
    public function main(){
        $data['parent'] = 'command_center';
        $data['child'] = 'report';
        $data['grand_child'] = '';
        $this->load->view('member/template/header',$data);
        $this->load->view('member/report/main',$data);
        $this->load->view('member/template/footer');
    }
    public function detail_report()
    {
        $data['parent'] = 'command_center';
        $data['child'] = 'report';
        $data['grand_child'] = '';
        // $data['status_laporan'] = $this->Main_model->getSelectedData('status_laporan_kube a', 'a.*', array('md5(a.id_kube)'=>$this->uri->segment(3)))->row();
        // $data['data_detail_laporan'] = $this->Main_model->getSelectedData('laporan_kube a', 'a.*,b.fullname',array('md5(a.id_kube)'=>$this->uri->segment(3),'a.deleted'=>'0'),'','','','',array(
        //     'table' => 'user_profile b',
        //     'on' => 'a.user_id=b.user_id',
        //     'pos' => 'LEFT',
        // ))->result();
        // $data['data_utama'] = $this->Main_model->getSelectedData('kube a', 'a.*,f.nm_provinsi,b.nm_kabupaten,c.nm_kecamatan,d.nm_desa,e.jenis_usaha', array('md5(a.id_kube)'=>$this->uri->segment(3),'a.deleted'=>'0'),'','','','',array(
        //     array(
        //         'table' => 'provinsi f',
        //         'on' => 'a.id_provinsi=f.id_provinsi',
        //         'pos' => 'left',
        //     ),
        //     array(
        //         'table' => 'kabupaten b',
        //         'on' => 'a.id_kabupaten=b.id_kabupaten',
        //         'pos' => 'left',
        //     ),
        //     array(
        //         'table' => 'kecamatan c',
        //         'on' => 'a.id_kecamatan=c.id_kecamatan',
        //         'pos' => 'left',
        //     ),
        //     array(
        //         'table' => 'desa d',
        //         'on' => 'a.id_desa=d.id_desa',
        //         'pos' => 'left',
        //     ),
        //     array(
		// 		'table' => 'jenis_usaha e',
		// 		'on' => 'a.id_jenis_usaha=e.id_jenis_usaha',
		// 		'pos' => 'left'
		// 	)
        // ))->result();
        $this->load->view('member/template/header',$data);
        $this->load->view('member/report/detail_report',$data);
        $this->load->view('member/template/footer');
    }
    /* Analysis */
    public function analysis(){
        $data['parent'] = 'analysis';
        $data['child'] = '';
        $data['grand_child'] = '';
        $get_info = $this->Main_model->getSelectedData('user_to_role a', 'a.*', array('a.user_id'=>$this->session->userdata('id')))->row();
        $url1 = 'http://kertasfolio.id:99/api/kec/kab/'.$get_info->wilayah;
        $data['wilayah'] = $this->Main_model->getAPI($url1);
        $data['get_info'] = $get_info;
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
    public function rekap_isu(){
        $data['parent'] = 'command_center';
        $data['child'] = 'issue';
        $data['grand_child'] = '';
        $this->load->view('member/template/header',$data);
        $this->load->view('member/report/rekap_isu',$data);
        $this->load->view('member/template/footer');
    }
    public function json_issue_data(){
		$get_info = $this->Main_model->getSelectedData('user_to_role a', 'a.*', array('a.user_id'=>$this->session->userdata('id')))->row();
		$url1 = 'http://kertasfolio.id:99/api/relawanisu/all/'.$get_info->id_event;
		$data = $this->Main_model->getAPI($url1);
		$data_tampil = array();
		$no = 1;
		foreach ($data as $key => $value) {
            $isi['number'] = $no++.'.';
            $isi['judul'] = $value['judul'];
            $isi['desc'] = $value['deskripsi'];
            $url2 = 'http://kertasfolio.id:99/api/relawanprofiles/getProfile/'.$value['idRelawan'];
            $data_relawan = $this->Main_model->getAPI($url2);
            $isi['nama'] = $data_relawan['namaRelawan'];
            $isi['date'] = $this->Main_model->convert_tanggal(substr($value['createdDate'],0,10));
            $wilayah = '';
            if(strlen($value['idWilayah'])=='2'){
                $url2 = 'http://kertasfolio.id:99/api/prov/id/'.$value['idWilayah'];
                $data_prov = $this->Main_model->getAPI($url2);
                $wilayah = $data_prov['namaProvinsi'];
            }elseif(strlen($value['idWilayah'])=='4'){
                $url2 = 'http://kertasfolio.id:99/api/kab/id/'.$value['idWilayah'];
                $data_kab = $this->Main_model->getAPI($url2);
                $wilayah = $data_kab['namaKabupaten'];
            }elseif(strlen($value['idWilayah'])=='7'){
                $url2 = 'http://kertasfolio.id:99/api/kec/id/'.$value['idWilayah'];
                $data_kab = $this->Main_model->getAPI($url2);
                $wilayah = $data_kab['namaKecamatan'];
            }else{
                echo'';
            }
            $isi['wilayah'] = $wilayah;
            $return_on_click = "return confirm('Anda yakin?')";
            $isi['action'] =	'
                            <div class="dropdown">
                                <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Aksi
                                    <i class="fa fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu pull-right" role="menu">
                                    <li>
                                        <a onclick="'.$return_on_click.'" href="'.site_url('member_side/hapus_data_isu/'.$value['idIsu']).'">
                                            <i class="icon-trash"></i> Hapus Data </a>
                                    </li>
                                </ul>
                            </div>
                            ';
            
            $data_tampil[] = $isi;
		}
		$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data_tampil),
			"iTotalDisplayRecords" => count($data_tampil),
			"aaData"=>$data_tampil);
		echo json_encode($results);
    }
    public function hapus_data_isu(){
		$this->db->trans_start();
		$where = $this->uri->segment(3);
		$url1 = 'http://kertasfolio.id:99/api/relawanisu/delete/'.$where;
		$this->Main_model->deleteAPI($url1);
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."member_side/rekap_isu/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."member_side/rekap_isu/'</script>";
		}
	}
    /* Other Function */
    public function ajax_function(){
        if($this->input->post('modul')=='get_kabupaten_by_id_provinsi'){
            echo'<option value="">-- Pilih Kabupaten/ Kota --</option>';
            $url_k = 'http://kertasfolio.id:99/api/kab/prov/'.$this->input->post('id');
            $data_k = $this->Main_model->getAPI($url_k);
            foreach ($data_k as $key => $value) {
                echo'<option value="'.$value['idKabupaten'].'">'.$value['namaKabupaten'].'</option>';
            }
        }
    }
}