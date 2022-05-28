<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Students extends CI_Controller {

	function __construct() {
        parent::__construct();
    }
	
	public function index() {
		$this->upload();
	}
	
	// UPLOAD
	public function upload($param1='',$param2='',$param3='') {
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
		
		$table = 'lp_matric';
		
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
						$del_id = $this->input->post('d_matric_id');
						if($this->Crud->delete('id', $del_id, $table) > 0) {
							echo $this->Crud->msg('success', 'Record Deleted');
							echo '<script>location.reload(false);</script>';
							exit;
						} else {
							echo $this->Crud->msg('danger', 'Please try later');
							exit;
						}
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
								$data['e_sess_id'] = $e->sess_id;
								$data['e_prog_id'] = $e->prog_id;
								$data['e_level_id'] = $e->level_id;
								$data['e_dept_id'] = $e->dept_id;
								$data['e_matric'] = $e->matric;
							}
						}
					}
				}
				
				if($_POST){
					$matric_id = $this->input->post('matric_id');
					$sess_id = $this->input->post('sess_id');
					$prog_id = $this->input->post('prog_id');
					$level_id = $this->input->post('level_id');
					$dept_id = $this->input->post('dept_id');
					$matric = $this->input->post('matric');
					
					// do create or update
					if($matric_id) {
						$upd_data['sess_id'] = $sess_id;
						$upd_data['prog_id'] = $prog_id;
						$upd_data['level_id'] = $level_id;
						$upd_data['dept_id'] = $dept_id;
						$upd_data['matric'] = $matric;
						$upd_rec = $this->Crud->update('id', $matric_id, $table, $upd_data);
						if($upd_rec > 0) {
							echo $this->Crud->msg('success', 'Record Updated');
							echo '<script>location.reload(false);</script>';
							exit;
						} else {
							echo $this->Crud->msg('info', 'No Changes');
							exit;	
						}
					} else {
						// bulk matric upload
						if(isset($_FILES['import']['name'])) {
							$ext = pathinfo($_FILES['import']['name'], PATHINFO_EXTENSION);
							if($ext != 'csv') {
								$data['err_msg'] = $this->Crud->msg('danger', 'Please select CSV File');
							} else {
								$path = realpath($_FILES['import']['tmp_name']);
								$csv = array_map('str_getcsv', file($path));
								$data['err_msg'] = $this->bulk_upload($school_id, $lecturer_id, $sess_id, $prog_id, $level_id, $dept_id, $csv);
							}
						}
					}
				}
			}
		}
		
		// record listing
		if($param1 == 'list') {
			// DataTable parameters
			$table = 'lp_matric';
			$column_order = array('school_id', 'lecturer_id', 'sess_id', 'dept_id', 'matric');
			$column_search = array('school_id', 'lecturer_id', 'sess_id', 'dept_id', 'matric');
			$order = array('id' => 'desc');
			
			if($lps_user_role != 'Super Admin' && $lps_user_role != 'Admin') {
				$where = array('school_id'=>$school_id);	
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
				$school_id = $item->school_id;
				$lecturer_id = $item->lecturer_id;
				$sess_id = $item->sess_id;
				$prog_id = $item->prog_id;
				$level_id = $item->level_id;
				$dept_id = $item->dept_id;
				$matric = $item->matric;
				
				$school = $this->Crud->read_field('id', $school_id, 'lp_school', 'name');
				$lecturer = $this->Crud->read_field('id', $lecturer_id, 'lp_lecturer', 'firstname').' '.$this->Crud->read_field('id', $lecturer_id, 'lp_lecturer', 'lastname');
				$session = $this->Crud->read_field('id', $sess_id, 'lp_session', 'name');
				$programme = $this->Crud->read_field('id', $prog_id, 'lp_programme', 'name');
				$level = $this->Crud->read_field('id', $level_id, 'lp_level', 'name');
				$department = $this->Crud->read_field('id', $dept_id, 'lp_department', 'name');
				
				// add scripts to last record
				if($count == count($list)){
					$script = '<script src="'.base_url('assets/js/jsform.js').'"></script>';
				} else {$script = '';}
				
				// add manage buttons
				$all_btn = '
					<div class="text-center">
						<a class="btn btn-danger btn-xs pop" href="javascript:;" pageTitle="Delete '.$matric.'" pageName="'.base_url('students/upload/manage/delete/'.$id).'">
							<i class="fa fa-trash-o"></i>
						</a>
						<a class="btn btn-primary btn-xs pop" href="javascript:;" pageTitle="Manage '.$matric.'" pageName="'.base_url('students/upload/manage/edit/'.$id).'">
							<i class="fa fa-edit"></i>
						</a>
					</div>
					'.$script.'
				';
				
				// check if matric used by student, then don't allow record manage
				if($this->Crud->check('matric', $matric, 'lp_student') > 0) {
					$all_btn = '';
				}
				
				$row = array();
				$row[] = $school;
				$row[] = $lecturer;
				$row[] = $session.' <span class="text-muted">'.$programme.'</span>';
				$row[] = $level.' <span class="text-muted">'.$department.'</span>';
				$row[] = $matric;
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
		
		$data['allprogramme'] = $this->Crud->read_single('school_id', $school_id, 'lp_programme');
		$data['alllevel'] = $this->Crud->read_single('school_id', $school_id, 'lp_level');
		$data['alldept'] = $this->Crud->read_single('school_id', $school_id, 'lp_department');
		
		if($param1 == 'manage' && $param2 != '') { // view for form data posting
			$this->load->view('student/upload_form', $data);
		} else { // view for main page
			// for datatable
			$data['table_rec'] = 'students/upload/list'; // ajax table
			$data['order_sort'] = '4, "asc"'; // default ordering (0, 'asc')
			$data['no_sort'] = '5'; // sort disable columns (1,3,5)
			
			$data['title'] = 'Upload Matrics | '.app_name;
			$data['page_active'] = 'upload';
			
			$this->load->view('designs/header', $data);
			$this->load->view('student/upload', $data);
			$this->load->view('designs/footer', $data);
		}
	}
	
	private function bulk_upload($sch_id, $lecturer_id, $sess_id, $prog_id, $level_id, $dept_id, $csv) {
		$table = 'lp_matric';
		$bulk_msg = '';
		if($csv) {
			$ct = 0;
			foreach($csv as $cell) {
				// remove first roll
				if($ct == 0) {
					$ct += 1;
					continue;	
				}
				
				// start from second row
				$matric = $cell[0]; // the Matric
				
				// ignore if Matric already exist
				if($this->Crud->check2('sess_id', $sess_id, 'matric', $matric, $table) <= 0) {
					$ins_data['school_id'] = $sch_id;
					$ins_data['lecturer_id'] = $lecturer_id;
					$ins_data['sess_id'] = $sess_id;
					$ins_data['prog_id'] = $prog_id;
					$ins_data['level_id'] = $level_id;
					$ins_data['dept_id'] = $dept_id;
					$ins_data['matric'] = $matric;
					$ins_data['reg_date'] = date(fdate);
					if($this->Crud->create($table, $ins_data) > 0) {
						$ct += 1;	
					}
				}
			}
			
			if($ct > 1) {
				$bulk_msg = $this->Crud->msg('success', ($ct-1).' Matric Imported');
			} else {
				$bulk_msg = $this->Crud->msg('danger', 'Matric not Imported - either already exist or CSV is empty');	
			}
		}
		
		return $bulk_msg;
	}
	
	// LISTS
	public function lists($param1='',$param2='',$param3='') {
		if($this->session->userdata('logged_in') == FALSE){
			redirect(base_url('login'), 'refresh');	
		} else {
			$lps_user_role = $this->session->userdata('lps_user_role');
			$user_id = $this->session->userdata('lps_id');
			$school_id = $this->session->userdata('lps_school_id');
			$permit = array('Super Admin', 'Admin', 'Lecturer');
			if(!in_array($lps_user_role, $permit)){
				redirect(base_url('dashboard'), 'refresh');	
			}
		}
		
		$table = 'lp_student';
		
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
						$del_id = $this->input->post('d_student_id');
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
								$data['e_sess_id'] = $e->sess_id;
								$data['e_prog_id'] = $e->prog_id;
								$data['e_level_id'] = $e->level_id;
								$data['e_dept_id'] = $e->dept_id;
								$data['e_username'] = $e->username;
								$data['e_matric'] = $e->matric;
								$data['e_firstname'] = $e->firstname;
								$data['e_middlename'] = $e->middlename;
								$data['e_lastname'] = $e->lastname;
								$data['e_sex'] = $e->sex;
								$data['e_email'] = $e->email;
								$data['e_phone'] = $e->phone;
								$data['e_ban'] = $e->ban;
							}
						}
					}
				}
				
				if($_POST){
					$student_id = $this->input->post('student_id');
					$sess_id = $this->input->post('sess_id');
					$prog_id = $this->input->post('prog_id');
					$level_id = $this->input->post('level_id');
					$dept_id = $this->input->post('dept_id');
					$username = $this->input->post('username');
					$password = $this->input->post('password');
					$matric = $this->input->post('matric');
					$firstname = $this->input->post('firstname');
					$middlename = $this->input->post('middlename');
					$lastname = $this->input->post('lastname');
					$sex = $this->input->post('sex');
					$email = $this->input->post('email');
					$phone = $this->input->post('phone');
					if($this->input->post('ban')){$ban = 1;} else {$ban = 0;}
					
					// do create or update
					if($student_id) {
						$upd_data['sess_id'] = $sess_id;
						$upd_data['prog_id'] = $prog_id;
						$upd_data['level_id'] = $level_id;
						$upd_data['dept_id'] = $dept_id;
						//$upd_data['username'] = $username;
						$upd_data['firstname'] = $firstname;
						$upd_data['middlename'] = $middlename;
						$upd_data['lastname'] = $lastname;
						//$upd_data['email'] = $email;
						$upd_data['phone'] = $phone;
						$upd_data['ban'] = $ban;
						
						// if password not empty
						if($password) {
							if($this->Crud->update('username', $username, 'lp_user', array('password'=>md5($password))) > 0) {
								echo $this->Crud->msg('success', 'Password Updated');
							}
						}
						
						$upd_rec = $this->Crud->update('id', $student_id, $table, $upd_data);
						if($upd_rec > 0) {
							echo $this->Crud->msg('success', 'Record Updated');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('info', 'No Changes');
						}
					} else {
						
					}
					
					exit;
				}
			}
		}
		
		// record listing
		if($param1 == 'list') {
			// DataTable parameters
			$table = 'lp_student';
			$column_order = array('reg_date', 'school_id', 'sess_id', 'dept_id', 'username', 'matric', 'firstname', 'middlename', 'lastname', 'sex', 'email', 'phone', 'ban');
			$column_search = array('reg_date', 'school_id', 'sess_id', 'dept_id', 'username', 'matric', 'firstname', 'middlename', 'lastname', 'sex', 'email', 'phone', 'ban');
			$order = array('id' => 'desc');
			
			if($lps_user_role != 'Super Admin' && $lps_user_role != 'Admin') {
				$where = array('school_id'=>$school_id);	
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
				$school_id = $item->school_id;
				$lecturer_id = $item->lecturer_id;
				$sess_id = $item->sess_id;
				$prog_id = $item->prog_id;
				$level_id = $item->level_id;
				$dept_id = $item->dept_id;
				$username = $item->username;
				$matric = $item->matric;
				$firstname = $item->firstname;
				$middlename = $item->middlename;
				$lastname = $item->lastname;
				$sex = $item->sex;
				$email = $item->email;
				$phone = $item->phone;
				$ban = $item->ban;
				$reg_date = $item->reg_date;
				
				$school = $this->Crud->read_field('id', $school_id, 'lp_school', 'name');
				$session = $this->Crud->read_field('id', $sess_id, 'lp_session', 'name');
				$programme = $this->Crud->read_field('id', $prog_id, 'lp_programme', 'name');
				$level = $this->Crud->read_field('id', $level_id, 'lp_level', 'name');
				$department = $this->Crud->read_field('id', $dept_id, 'lp_department', 'name');
				
				if($ban==0){$ban = '<span class="text-primary">Active</span>';} else {$ban = '<span class="text-danger">Banned</span>';}
				
				// check if student paid activation fee
				if($this->Crud->read_field('matric', $matric, 'lp_student', 'paid') == 1) {
					$paid = '<span class="label label-success">PAID</span>';
				} else {
					$paid = '<span class="label label-danger">UNPAID</span>';	
				}
				
				// add scripts to last record
				if($count == count($list)){
					$script = '<script src="'.base_url('assets/js/jsform.js').'"></script>';
				} else {$script = '';}
				
				// add manage buttons
				$all_btn = '
					<div class="text-center">
						<a class="btn btn-danger btn-xs pop" href="javascript:;" pageTitle="Delete '.$firstname.' '.$middlename.' '.$lastname.'" pageName="'.base_url('students/lists/manage/delete/'.$id).'">
							<i class="fa fa-trash-o"></i>
						</a>
						<a class="btn btn-primary btn-xs pop" href="javascript:;" pageTitle="Manage '.$firstname.' '.$middlename.' '.$lastname.'" pageName="'.base_url('students/lists/manage/edit/'.$id).'">
							<i class="fa fa-edit"></i>
						</a>
					</div>
					'.$script.'
				';
				
				$row = array();
				$row[] = date('M d, Y', strtotime($reg_date));
				$row[] = $level.' - '.$department.'<br /><span class="text-muted small">'.$school.', '.$session.' '.$programme.'</span>';
				$row[] = $firstname.' '.$middlename.' '.$lastname.'<br /><span class="text-muted small">'.$sex.' | '.$matric.' | '.$username.'</span>';
				$row[] = $phone.'<br />'.$email;
				$row[] = $ban.'<br />'.$paid;
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
		
		$data['allprogramme'] = $this->Crud->read_single('school_id', $school_id, 'lp_programme');
		$data['alllevel'] = $this->Crud->read_single('school_id', $school_id, 'lp_level');
		$data['alldept'] = $this->Crud->read_single('school_id', $school_id, 'lp_department');
		
		if($param1 == 'manage') { // view for form data posting
			$this->load->view('student/lists_form', $data);
		} else { // view for main page
			// for datatable
			$data['table_rec'] = 'students/lists/list'; // ajax table
			$data['order_sort'] = '2, "asc"'; // default ordering (0, 'asc')
			$data['no_sort'] = '5'; // sort disable columns (1,3,5)
		
			$data['title'] = 'Students | '.app_name;
			$data['page_active'] = 'student';
			
			$this->load->view('designs/header', $data);
			$this->load->view('student/lists', $data);
			$this->load->view('designs/footer', $data);
		}
	}
}
