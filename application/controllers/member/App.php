<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {

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
    function __construct() {
        parent::__construct();
	}
	public function launcher()
	{
		// $this->load->view('member/template/header',$data);
		$this->load->view('member/app/launcher');
		// $this->load->view('member/template/footer');
	}
    public function home()
	{
		$data['parent'] = 'home';
		$data['child'] = '';
		$data['grand_child'] = '';
		$get_info = $this->Main_model->getSelectedData('user_to_role a', 'a.*,(SELECT SUM(b.relawan) FROM data_target b WHERE b.id_event=a.id_event) AS target_relawan,(SELECT SUM(b.rekrutmen) FROM data_target b WHERE b.id_event=a.id_event) AS target_rekrutmen', array('a.user_id'=>$this->session->userdata('id')))->row();
		$data['get_info'] = $get_info;
		$url1 = 'http://pradi.is-very-good.org:7733/api/rekrutmen/all/'.$get_info->id_event;
		$data['data_rekrutmen'] = $this->Main_model->getAPI($url1);
		$url2 = 'http://pradi.is-very-good.org:7733/api/relawandatas/byevent/'.$get_info->id_event;
		$data['data_relawan'] = $this->Main_model->getAPI($url2);
		$this->load->view('member/template/header',$data);
		$this->load->view('member/app/home',$data);
		$this->load->view('member/template/footer');
	}
	public function log_activity()
	{
		$data['parent'] = 'log_activity';
		$data['child'] = '';
		$data['grand_child'] = '';
		$data['data_tabel'] = $this->Main_model->getSelectedData('activity_logs a', 'a.*,b.fullname', '', "a.activity_time DESC",'','','',array(
			'table' => 'user_profile b',
			'on' => 'a.user_id=b.user_id',
			'pos' => 'left',
		))->result();
		$this->load->view('member/template/header',$data);
		$this->load->view('member/app/log_activity',$data);
		$this->load->view('member/template/footer');
	}
	public function hapus_aktifitas(){
		$this->db->trans_start();
		$where = $this->uri->segment(3);
		$this->Main_model->deleteData('activity_logs',array('md5(activity_id)'=>$where));
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."member_side/log_activity/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."member_side/log_activity/'</script>";
		}
	}
	public function cleaning_log(){
		$this->db->trans_start();
		$this->Main_model->deleteData('activity_logs',array('md5(user_id)'=>md5($this->session->userdata('id'))));
		$this->db->trans_complete();
		if($this->db->trans_status() === false){
			$this->session->set_flashdata('gagal','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Oops! </strong>data gagal dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."member_side/log_activity/'</script>";
		}
		else{
			$this->session->set_flashdata('sukses','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong></i>Yeah! </strong>data telah berhasil dihapus.<br /></div>' );
			echo "<script>window.location='".base_url()."member_side/log_activity/'</script>";
		}
	}
	public function about()
	{
		$data['parent'] = 'about';
		$data['child'] = '';
		$data['grand_child'] = '';
		$this->load->view('member/template/header',$data);
		$this->load->view('member/app/about',$data);
		$this->load->view('member/template/footer');
	}
	public function helper()
	{
		$data['parent'] = 'helper';
		$data['child'] = '';
		$data['grand_child'] = '';
		$this->load->view('member/template/header',$data);
		$this->load->view('member/app/helper',$data);
		$this->load->view('member/template/footer');
	}
	/* Menu setting and user's permission */
	public function ajax_function(){
		if($this->input->post('modul')=='modul_detail_log_aktifitas'){
			$data['data_utama'] = $this->Main_model->getSelectedData('activity_logs a', 'a.*,b.fullname', array('md5(a.activity_id)'=>$this->input->post('id')), "",'','','',array(
				'table' => 'user_profile b',
				'on' => 'a.user_id=b.user_id',
				'pos' => 'left',
			))->result();
			$this->load->view('member/app/ajax_detail_log_aktifitas',$data);
		}
	}
}