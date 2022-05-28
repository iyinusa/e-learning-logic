<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Transactions extends CI_Controller {

	function __construct() {
        parent::__construct();
    }
	
	public function index() {
		if($this->session->userdata('logged_in') == FALSE){
			redirect(base_url('login'), 'refresh');	
		} else {
			$lps_user_role = $this->session->userdata('lps_user_role');
			$user_id = $this->session->userdata('lps_id');
			$user_name = $this->session->userdata('lps_username');
			$school_id = $this->session->userdata('lps_school_id');
			$permit = array('Super Admin', 'Admin', 'Lecturer');
			if(!in_array($lps_user_role, $permit)){
				redirect(base_url('dashboard'), 'refresh');	
			}
		}
		
		if($lps_user_role == 'Lecturer') {
			$lecturer_id = $this->Crud->read_field('username', $user_name, 'lp_lecturer', 'id');
		} else {
			$lecturer_id = 0;
		}
		
		// for datatable
		$data['table_rec'] = 'transactions/lists'; // ajax table
		$data['order_sort'] = '0, "desc"'; // default ordering (0, 'asc')
		$data['no_sort'] = ''; // sort disable columns (1,3,5)
	
		$data['title'] = 'Transactions | '.app_name;
		$data['page_active'] = 'transaction';
		
		$this->load->view('designs/header', $data);
		$this->load->view('transaction', $data);
		$this->load->view('designs/footer', $data);
	}
	
	public function lists() {
		if($this->session->userdata('logged_in') == FALSE){
			redirect(base_url('login'), 'refresh');	
		} else {
			$lps_user_role = $this->session->userdata('lps_user_role');
			$user_id = $this->session->userdata('lps_id');
			$user_name = $this->session->userdata('lps_username');
			$school_id = $this->session->userdata('lps_school_id');
			$permit = array('Super Admin', 'Admin', 'Lecturer');
			if(!in_array($lps_user_role, $permit)){
				redirect(base_url('dashboard'), 'refresh');	
			}
		}
		
		if($lps_user_role == 'Lecturer') {
			$lecturer_id = $this->Crud->read_field('username', $user_name, 'lp_lecturer', 'id');
		} else {
			$lecturer_id = 0;
		}
		
		// DataTable parameters
		$table = 'lp_transaction';
		$column_order = array('id', 'item_type', 'pay_code', 'amount', 'medium', 'trnx_id', 'trnx_code', 'trnx_ref', 'trnx_status', 'trnx_msg', 'reg_date');
		$column_search = array('id', 'item_type', 'pay_code', 'amount', 'medium', 'trnx_id', 'trnx_code', 'trnx_ref', 'trnx_status', 'trnx_msg', 'reg_date');
		$order = array('id' => 'desc');
		
		if($lps_user_role != 'Super Admin' && $lps_user_role != 'Admin') {
			$where = array('lecturer_id'=>$lecturer_id);	
		} else {
			$where = '';	
		}
		
		// load data into table
		$list = $this->Crud->datatable_load($table, $column_order, $column_search, $order, $where);
		$data = array();
		// $no = $_POST['start'];
		$count = 1;
		foreach ($list as $item) {
			$id = $item->id;
			$lecturer_id = $item->lecturer_id;
			$item_id = $item->item_id;
			$item_type = $item->item_type;
			$pay_code = $item->pay_code;
			$recipient = $item->recipient;
			$amount = $item->amount;
			$medium = $item->medium;
			$trnx_id = $item->trnx_id;
			$trnx_code = $item->trnx_code;
			$trnx_ref = $item->trnx_ref;
			$trnx_msg = $item->trnx_msg;
			$reg_date = $item->reg_date;
			
			$from = '';
			
			if($item_type == 'activation') {
				$item_type = 'Activation';	
				
				// get student and lecturer name
				$student = $this->Crud->read_field('id', $item_id, 'lp_student', 'firstname').' '.$this->Crud->read_field('id', $item_id, 'lp_student', 'middlename').' '.$this->Crud->read_field('id', $item_id, 'lp_student', 'lastname'); 
				
				$lecturer = $this->Crud->read_field('id', $lecturer_id, 'lp_lecturer', 'firstname').' '.$this->Crud->read_field('id', $lecturer_id, 'lp_lecturer', 'lastname'); 
				$from = $student.'<br /><small>'.$lecturer.'</small>';
			}
			
			// medium and ip
			$medium = explode('|', $medium);
			if(empty($medium) || count($medium) <= 1) {
				$medium = '';
			} else {
				$medium = 'Medium: <b>'.ucwords($medium[0]).'</b><br/>'.$medium[1];	
			}
			
			if($trnx_code){$trnx_code = '<br /><b>Code: </b>'.$trnx_code.'</small>';} else {$trnx_code = '';}
			
			$row = array();
			$row[] = '<small class="text-muted">'.$id.'.</small> '.date('M d, Y h:s A', strtotime($reg_date));
			$row[] = $from.'<br/><small><b>'.$item_type.'</b></small>';
			$row[] = $recipient;
			$row[] = $pay_code;
			$row[] = $medium;
			$row[] = '&#8358;'.number_format((float)$amount);
			$row[] = '<small>'.$trnx_msg.'</small>';

			$data[] = $row;
			$count += 1;
		}

		$output = array(
			"draw" => intval($_POST['draw']),
			"recordsTotal" => $this->Crud->datatable_count($table, $where),
			"recordsFiltered" => $this->Crud->datatable_filtered($table, $column_order, $column_search, $order, $where),
			"data" => $data,
		);
		
		//output to json format
		echo json_encode($output);
		exit;	
	}
}
