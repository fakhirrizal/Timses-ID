<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    public function index()
    {
        $this->load->view('home_page');
    }
    public function upload_rekrutmen()
    {
        $this->load->view('upload_rekrutmen');
	}
	// 130iElX
	// 218x5Af
	// 219VrTy
    public function impor()
    {
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
		$namafile = date('YmdHis').'.xlsx';
		$config['upload_path'] = 'data_upload/';
		$config['allowed_types'] = 'xlsx';
		$config['max_size']	= '7048';
		$config['overwrite'] = true;
		$config['file_name'] = $namafile;

		$this->upload->initialize($config);
		if($this->upload->do_upload('fmasuk')){
			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel = $excelreader->load('data_upload/'.$namafile);
			$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			$numrow = 1;
			foreach($sheet as $row){
				if($numrow > 1){
                    if($row['A']=='' OR $row['B']=='NAMA LENGKAP'){
                        echo'';
                    }else{
						// echo $row['A'].'<br>';
						// $url_ = 'http://pradi.is-very-good.org:7733/api/rekrutmen/ceknik/'.$row['C'].'/468efcbe-9818-4de5-9814-c099a2bce7cd';
						// $data_rekrutmen = $this->Main_model->getAPI($url_);
						// if($data_rekrutmen==NULL){
						// 	echo'';
						// }else{
							$url_insert = 'http://pradi.is-very-good.org:7733/api/rekrutmen/insert/';
							$data_insert = array(
								"idRekrutmen"=> '',
								"idRelawan"=> '219VrTy',
								"idEvent"=> '468efcbe-9818-4de5-9814-c099a2bce7cd',
								"namaRekrutmen"=> $row['B'],
								"telepon"=> $row['D'],
								"NIK"=> $row['C'],
								"pekerjaan"=> $row['E'],
								"idDesa"=> $row['I'],
								"idKecamatan"=> $row['H'],
								"idKabupaten"=> $row['G'],
								"idProvinsi"=> $row['F'],
								"fotoKTP"=> '',
								"isVerified"=> true,
								"createdDate"=> '2020-11-20T12:32:47.896Z'
							);
							// print_r($data_insert);
							$hasil_insert = $this->Main_model->insertAPI($url_insert,$data_insert);
						// }
                    }
				}
				$numrow++;
			}
		}else{
            echo'';
		}
        
	}
	public function impor_()
    {
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
		$namafile = date('YmdHis').'.xlsx';
		$config['upload_path'] = 'data_upload/';
		$config['allowed_types'] = 'xlsx';
		$config['max_size']	= '7048';
		$config['overwrite'] = true;
		$config['file_name'] = $namafile;

		$this->upload->initialize($config);
		if($this->upload->do_upload('fmasuk')){
			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel = $excelreader->load('data_upload/'.$namafile);
			$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			$numrow = 1;
			foreach($sheet as $row){
				if($numrow > 1){
                    if($row['A']==''){
                        echo'';
                    }else{
						// echo $row['A'].'<br>';
						$url_ = 'http://pradi.is-very-good.org:7733/api/rekrutmen/ceknik/'.$row['D'].'/468efcbe-9818-4de5-9814-c099a2bce7cd';
						$data_rekrutmen = $this->Main_model->getAPI($url_);
						if($data_rekrutmen['telepon']==''){
							$data_insert = array(
								"idRekrutmen"=> $data_rekrutmen['idRekrutmen'],
								"idRelawan"=> $data_rekrutmen['idRelawan'],
								"idEvent"=> $data_rekrutmen['idEvent'],
								"namaRekrutmen"=> $data_rekrutmen['namaRekrutmen'],
								"telepon"=> $row['C'],
								"NIK"=> $data_rekrutmen['NIK'],
								"pekerjaan"=> $data_rekrutmen['pekerjaan'],
								"idDesa"=> $data_rekrutmen['idDesa'],
								"idKecamatan"=> $data_rekrutmen['idKecamatan'],
								"idKabupaten"=> $data_rekrutmen['idKabupaten'],
								"idProvinsi"=> $data_rekrutmen['idProvinsi'],
								"fotoKTP"=> $data_rekrutmen['fotoKTP'],
								"isVerified"=> $data_rekrutmen['isVerified'],
								"createdDate"=> $data_rekrutmen['createdDate']
							);
							// print_r($data_insert);
							$url_insert = 'http://pradi.is-very-good.org:7733/api/rekrutmen/update/';
							$hasil_insert = $this->Main_model->updateAPI($url_insert,$data_insert);
						}else{
							echo'';
						}
                    }
				}
				$numrow++;
			}
		}else{
            echo'';
		}
        
    }
}