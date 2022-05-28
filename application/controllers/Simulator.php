<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Simulator extends CI_Controller {

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
		$data['page_active'] = 'simuator';
		
		$this->load->view('simulator/simulator', $data);
	}
	
	public function widget() {
		
		
		$data['title'] = 'Widget | '.app_name;
		$data['page_active'] = 'widget';
		
		$this->load->view('simulator/widget', $data);
	}
}
