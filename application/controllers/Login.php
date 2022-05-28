<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct() {
        parent::__construct();
    }
	
	public function index() {
		if($this->session->userdata('logged_in') == TRUE){
			redirect(base_url('dashboard'), 'refresh');	
		} 
		
		if($_POST) {
			$username = $_POST['username'];
			$password = $_POST['password'];
			$password = md5($password);
			if(isset($_POST['remember-me'])){$remind='true';}else{$remind='';}
			
			if($this->Crud->check3('username', $username, 'password', $password, 'activate', 1, 'lp_user') <= 0 && $this->Crud->check3('email', $username, 'password', $password, 'activate', 1, 'lp_user') <= 0){
				$data['err_msg'] = $this->Crud->msg('danger', 'Username/Code or password is wrong!');
			} else {
				$query = $this->Crud->read2('username', $username, 'password', $password, 'lp_user');
				if(empty($query)) {
					// then query by email
					$query = $this->Crud->read2('email', $username, 'password', $password, 'lp_user');
				}
				
				if(!empty($query)) {
					foreach($query as $row) {
						$ban = 0;
						// check if lecturer is banned
						if($row->role == 'Lecturer') {
							$ban = $this->Crud->read_field('username', $row->username, 'lp_lecturer', 'ban');
							if($ban == 1) {$ban_msg = 'Unauthorized - Please contact Support';}
						}
						
						// check if student is banned
						if($row->role == 'Student') {
							$ban = $this->Crud->read_field('username', $row->username, 'lp_student', 'ban');
							if($ban == 1) {$ban_msg = 'Unauthorized - Please contact Lecturer/Support';}
						}
						
						// check if student academic activation is expired
						if($row->role == 'Student') {
							$sess_id = $this->Crud->read_field('username', $row->username, 'lp_student', 'sess_id');
							$session = $this->Crud->read_field('id', $sess_id, 'lp_session', 'name');
							$sess = explode('/', $session);
							if($sess[1] < date('Y')) {
								$data['err_msg'] = $this->Crud->msg('danger', 'Academic Session expired');
								$ban = 1;
							}
							
							if($ban == 1) {$ban_msg = 'Academic Session expired. Please contact Lecturer/Support';}
						}
						
						if($ban == 1) {
							$data['err_msg'] = $this->Crud->msg('danger', $ban_msg);
						} else {
							//update status
							$first_log = $row->last_log; //to check first time user
							
							$now = date("Y-m-d H:i:s");
							$status_update = array('status'=>1, 'last_log'=>$now);
							$this->Crud->update('id', $row->id, 'lp_user', $status_update);
							
							//get logo
							$logo_path = 'assets/img/avatar.png';
							$getimg = $this->Crud->read_single('id', $row->pics, 'lp_img');
							if(!empty($getimg)){
								foreach($getimg as $img){
									$logo_path = $img->pics;	
								}
							}
							
							//add data to session
							$s_data = array (
								'lps_id' => $row->id,
								'lps_username' => $row->username,
								'lps_user_email' => $row->email,
								'lps_user_lastlog' => $row->last_log,
								'lps_user_status' => $row->status,
								'lps_user_othername' => $row->othername,
								'lps_user_lastname' => $row->lastname,
								'lps_user_dob' => $row->dob,
								'lps_user_sex' => $row->sex,
								'lps_user_phone' => $row->phone,
								'lps_user_address' => $row->address,
								'lps_user_state' => $row->state,
								'lps_user_country' => $row->country,
								'lps_user_pics' => $logo_path,
								'lps_school_id' => $row->school_id,
								'lps_user_role' => $row->role,
								'lps_user_activate' => $row->activate,
								'lps_user_reg_date' => $row->reg_date,
								'logged_in' => TRUE
							);
							
							$check = $this->session->set_userdata($s_data);
					
							//redirect
							redirect(base_url('dashboard/'), 'refresh');
						}
					}
				}
			}
		}
		
		$data['title'] = 'Login | '.app_name;
		$data['page_active'] = 'login';
		
		$this->load->view('designs/auth_header', $data);
		$this->load->view('login', $data);
		$this->load->view('designs/auth_footer', $data);
	}
}
