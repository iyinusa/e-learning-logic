<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Simulation extends CI_Controller {

	function __construct() {
        parent::__construct();
    }
	
	public function index() {
		if($this->session->userdata('logged_in') == FALSE){
			redirect(base_url('login'), 'refresh');	
		} else {
			$lps_user_role = $this->session->userdata('lps_user_role');
		}
		
		$data['title'] = 'Simulator | '.app_name;
		$data['page_active'] = 'simulation';
		
		$this->load->view('designs/header', $data);
		$this->load->view('simulator/simulation', $data);
		$this->load->view('designs/footer', $data);
	}
}
