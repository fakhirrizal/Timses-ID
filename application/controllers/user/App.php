<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {
	var $userdata = NULL;

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
    public function __construct (){
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');

        $this->load->view('user/template/header');
    }
    public function home()
	{
		$this->load->view('user/home_page');
	}
	public function rekap_rp3kp_provinsi(){
        $data['load']       =  array("user/rekap_rp3kp_provinsi"); 

        $this->load->view('user/template/footer', $data);
	}
	public function rekap_rp3kp_kabkota(){
		$data['load']       =  array("user/rekap_rp3kp_kabkota"); 
		$data['data_provinsi'] = $this->Main_model->getSelectedData('provinsi a', 'a.*')->result();
        $this->load->view('user/template/footer', $data);
	}
	public function rekap_pokja_pkp_provinsi()
	{
        $data['load']       =  array("user/rekap_pokja_pkp_provinsi"); 

        $this->load->view('user/template/footer', $data);
	}
	public function rekap_pokja_pkp_kabkota()
	{
        $data['load']       =  array("user/rekap_pokja_pkp_kabkota"); 

        $data['data_hitung1'] = $this->Main_model->getSelectedData('provinsi a', 'a.*,(SELECT COUNT(c.id_kabupaten) FROM rekap_pokja_pkp_kabkota c LEFT JOIN kabupaten b ON c.id_kabupaten=b.id_kabupaten WHERE (c.status="Sudah" OR c.sk="V") AND b.id_provinsi=a.id_provinsi) AS jml')->result();
        $data['data_hitung2'] = $this->Main_model->getSelectedData('provinsi a', 'a.*,(SELECT COUNT(c.id_kabupaten) FROM rekap_pokja_pkp_kabkota c LEFT JOIN kabupaten b ON c.id_kabupaten=b.id_kabupaten WHERE c.penggabungan="Sudah" AND b.id_provinsi=a.id_provinsi) AS jml')->result();
        $data['data_hitung3'] = $this->Main_model->getSelectedData('provinsi a', 'a.*,(SELECT COUNT(c.id_kabupaten) FROM rekap_pokja_pkp_kabkota c LEFT JOIN kabupaten b ON c.id_kabupaten=b.id_kabupaten WHERE c.forum="Ya" AND b.id_provinsi=a.id_provinsi) AS jml')->result();
        $data['data_hitung4'] = $this->Main_model->getSelectedData('provinsi a', 'a.*,(SELECT COUNT(c.id_kabupaten) FROM rekap_pokja_pkp_kabkota c LEFT JOIN kabupaten b ON c.id_kabupaten=b.id_kabupaten WHERE c.apbd="Ya" AND b.id_provinsi=a.id_provinsi) AS jml')->result();
        $this->load->view('user/template/footer', $data);
    }
	public function simpan_aspirasi(){
        $this->db->trans_start();
        $data_1 = array(
            'nama' => $this->input->post('nama'),
            'email' => $this->input->post('email'),
            'nohp' => $this->input->post('nohp'),
			'pesan' => $this->input->post('pesan'),
			'waktu' => date('Y-m-d H:i:s')
        );
        // print_r($data_1);
        $this->Main_model->insertData('aspirasi',$data_1);
		
        // $this->Main_model->log_activity($this->session->userdata('id'),'Insert data',"Menyimpan data kritik/ saran dari masyarakat (".$this->input->post('nama').")",$this->session->userdata('location'));
        $this->db->trans_complete();
        if($this->db->trans_status() === false){
            echo "<script>window.location='http://blog-sibilup.aplikasiku.online/hubungi-kami/'</script>";
        }
        else{
            echo "<script>window.location='http://blog-sibilup.aplikasiku.online/hubungi-kami/'</script>";
        }
    }
}