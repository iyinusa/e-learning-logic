<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct() {
        parent::__construct();
    }
	
	public function index() {
		$this->data();
	}
	
	public function data($param1='',$param2='',$param3='') {
		if($this->session->userdata('logged_in') == FALSE){
			redirect(base_url('login'), 'refresh');	
		} else {
			$ebs_user_role = $this->session->userdata('ebs_user_role');
			$permit = array('Admin');
			if(!in_array($ebs_user_role, $permit)){
				redirect(base_url('dashboard'), 'refresh');	
			}
		}
		
		$table = 'eb_user';
		
		// pass parameters to view
		$data['param1'] = $param1;
		$data['param2'] = $param2;
		$data['param3'] = $param3;
		
		// manage record
		if($param1 == 'manage') {
			// prepare for delete
			if($param2 == 'delete') {
				if($param3) {
					$edit = $this->Crud->read_single('id', $param3, $table);
					if(!empty($edit)) {
						foreach($edit as $e) {
							$data['d_id'] = $e->id;
						}
					}
					
					if($_POST){
						$del_id = $this->input->post('d_user_id');
						if($this->Crud->delete('id', $del_id, $table) > 0) {
							echo $this->Crud->msg('success', 'Record Deleted');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('danger', 'Please try later');
						}
						exit;	
					}
				}
			} else {
				// prepare for edit
				if($param2 == 'edit') {
					if($param3) {
						$edit = $this->Crud->read_single('id', $param3, $table);
						if(!empty($edit)) {
							foreach($edit as $e) {
								$data['e_id'] = $e->id;
								$data['e_othername'] = $e->othername;
								$data['e_lastname'] = $e->lastname;
								$data['e_username'] = $e->username;
								$data['e_phone'] = $e->phone;
								$data['e_role'] = $e->role;
							}
						}
					}
				}
				
				if($_POST){
					$user_id = $this->input->post('user_id');
					$ins_data['othername'] = $this->input->post('othername');
					$ins_data['lastname'] = $this->input->post('lastname');
					$ins_data['username'] = $this->input->post('username');
					$ins_data['phone'] = $this->input->post('phone');
					$ins_data['role'] = $this->input->post('role');
					
					if(!empty($this->input->post('password'))) {
						$ins_data['password'] = md5($this->input->post('password'));
					}
					
					// do create or update
					if($user_id) {
						$upd_rec = $this->Crud->update('id', $user_id, $table, $ins_data);
						if($upd_rec > 0) {
							echo $this->Crud->msg('success', 'Record Updated');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('info', 'No Changes');	
						}
					} else {
						if($this->Crud->check('username', $this->input->post('username'), $table) > 0) {
							echo $this->Crud->msg('warning', 'Record Already Exist');
						} else {
							$ins_data['reg_date'] = date(fdate);
							
							$ins_rec = $this->Crud->create($table, $ins_data);
							if($ins_rec > 0) {
								echo $this->Crud->msg('success', 'Record Created');
								echo '<script>location.reload(false);</script>';
							} else {
								echo $this->Crud->msg('danger', 'Please try later');	
							}	
						}
					}
					exit;	
				}
			}
		}
		
		// record listing
		if($param1 == 'list') {
			// DataTable parameters
			$table = 'eb_user';
			$column_order = array('username', 'othername', 'lastname', 'phone', 'role');
			$column_search = array('username', 'othername', 'lastname', 'phone', 'role');
			$order = array('id' => 'desc');
			$where = '';
			
			// load data into table
			$list = $this->Crud->datatable_load($table, $column_order, $column_search, $order, $where);
			$data = array();
			// $no = $_POST['start'];
			$count = 1;
			foreach ($list as $item) {
				$id = $item->id;
				$othername = $item->othername;
				$lastname = $item->lastname;
				$username = $item->username;
				$phone = $item->phone;
				$role = $item->role;
				
				// add scripts to last record
				if($count == count($list)){
					$script = '<script src="'.base_url('assets/js/jsform.js').'"></script>';
				} else {$script = '';}
				
				if($role != 'Admin') {
					$del_btn = '
						<a class="btn btn-danger btn-xs pop" href="javascript:;" pageTitle="Delete '.$othername.' '.$lastname.'" pageName="'.base_url('user/data/manage/delete/'.$id).'">
							<i class="fa fa-trash-o"></i>
						</a>
					';
				} else {
					$del_btn = '';
				}
				
				// add manage buttons
				$all_btn = '
					<div class="text-center">
						'.$del_btn.'
						<a class="btn btn-primary btn-xs pop" href="javascript:;" pageTitle="Manage '.$othername.' '.$lastname.'" pageName="'.base_url('user/data/manage/edit/'.$id).'">
							<i class="fa fa-edit"></i>
						</a>
					</div>
					'.$script.'
				';
				
				$row = array();
				$row[] = $id;
				$row[] = $othername.' '.$lastname;
				$row[] = $username;
				$row[] = $phone;
				$row[] = $role;
				$row[] = $all_btn;
	
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
		
		if($param1 == 'manage') { // view for form data posting
			$this->load->view('user/form', $data);
		} else { // view for main page
			// for datatable
			$data['table_rec'] = 'user/data/list'; // ajax table
			$data['order_sort'] = '1, "asc"'; // default ordering (0, 'asc')
			$data['no_sort'] = '3'; // sort disable columns (1,3,5)
		
			$data['title'] = 'User Accounts | '.app_name;
			$data['page_active'] = 'user';
			
			$this->load->view('designs/header', $data);
			$this->load->view('user/user', $data);
			$this->load->view('designs/footer', $data);
		}
		
	}
}
