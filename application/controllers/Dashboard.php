<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct() {
        parent::__construct();
    }
	
	public function index() {
		if($this->session->userdata('logged_in') == FALSE){
			redirect(base_url('login'), 'refresh');	
		} else {
			$lps_user_role = $this->session->userdata('lps_user_role');
		}
		
		
		$data['title'] = 'Dashboard | '.app_name;
		$data['page_active'] = 'dashboard';
		
		$this->load->view('designs/header', $data);
		$this->load->view('dashboard', $data);
		$this->load->view('designs/footer', $data);
	}
}
