<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Setup extends CI_Controller {

	function __construct() {
        parent::__construct();
    }
	
	public function index() {
		$this->programme();
	}
	
	// INSTITUTION
	public function institution($param1='',$param2='',$param3='') {
		if($this->session->userdata('logged_in') == FALSE){
			redirect(base_url('login'), 'refresh');	
		} else {
			$lps_user_role = $this->session->userdata('lps_user_role');
			$user_id = $this->session->userdata('lps_id');
			$permit = array('Super Admin', 'Admin');
			if(!in_array($lps_user_role, $permit)){
				redirect(base_url('dashboard'), 'refresh');	
			}
		}
		
		$table = 'lp_school';
		
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
						$del_id = $this->input->post('d_institution_id');
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
								$data['e_name'] = $e->name;
							}
						}
					}
				}
				
				if($_POST){
					$institution_id = $this->input->post('institution_id');
					$name = $this->input->post('name');
					
					// do create or update
					if($institution_id) {
						$upd_data = array(
							'name' => $name
						);
						$upd_rec = $this->Crud->update('id', $institution_id, $table, $upd_data);
						if($upd_rec > 0) {
							echo $this->Crud->msg('success', 'Record Updated');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('info', 'No Changes');	
						}
					} else {
						if($this->Crud->check('name', $name, $table) > 0) {
							echo $this->Crud->msg('warning', 'Record Already Exist');
						} else {
							$ins_data = array(
								'name' => $name
							);
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
			$table = 'lp_school';
			$column_order = array('name');
			$column_search = array('name');
			$order = array('id' => 'desc');
			
			$where = '';
			
			// load data into table
			$list = $this->Crud->datatable_load($table, $column_order, $column_search, $order, $where);
			$data = array();
			// $no = $_POST['start'];
			$count = 1;
			foreach ($list as $item) {
				$id = $item->id;
				$name = $item->name;
				
				// add scripts to last record
				if($count == count($list)){
					$script = '<script src="'.base_url('assets/js/jsform.js').'"></script>';
				} else {$script = '';}
				
				// add manage buttons
				$all_btn = '
					<div class="text-center">
						<a class="btn btn-danger btn-xs pop" href="javascript:;" pageTitle="Delete '.$name.'" pageName="'.base_url('setup/institution/manage/delete/'.$id).'">
							<i class="fa fa-trash-o"></i>
						</a>
						<a class="btn btn-primary btn-xs pop" href="javascript:;" pageTitle="Manage '.$name.'" pageName="'.base_url('setup/institution/manage/edit/'.$id).'">
							<i class="fa fa-edit"></i>
						</a>
					</div>
					'.$script.'
				';
				
				$row = array();
				$row[] = $name;
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
			$this->load->view('setup/institution_form', $data);
		} else { // view for main page
			// for datatable
			$data['table_rec'] = 'setup/institution/list'; // ajax table
			$data['order_sort'] = '0, "asc"'; // default ordering (0, 'asc')
			$data['no_sort'] = '1'; // sort disable columns (1,3,5)
		
			$data['title'] = 'institution | '.app_name;
			$data['page_active'] = 'institution';
			
			$this->load->view('designs/header', $data);
			$this->load->view('setup/institution', $data);
			$this->load->view('designs/footer', $data);
		}
	}
	
	// SESSION
	public function session($param1='',$param2='',$param3='') {
		if($this->session->userdata('logged_in') == FALSE){
			redirect(base_url('login'), 'refresh');	
		} else {
			$lps_user_role = $this->session->userdata('lps_user_role');
			$user_id = $this->session->userdata('lps_id');
			$permit = array('Super Admin', 'Admin');
			if(!in_array($lps_user_role, $permit)){
				redirect(base_url('dashboard'), 'refresh');	
			}
		}
		
		$table = 'lp_session';
		
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
						$del_id = $this->input->post('d_session_id');
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
								$data['e_name'] = $e->name;
							}
						}
					}
				}
				
				if($_POST){
					$session_id = $this->input->post('session_id');
					$name = $this->input->post('name');
					
					// do create or update
					if($session_id) {
						$upd_data = array(
							'name' => $name
						);
						$upd_rec = $this->Crud->update('id', $session_id, $table, $upd_data);
						if($upd_rec > 0) {
							echo $this->Crud->msg('success', 'Record Updated');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('info', 'No Changes');	
						}
					} else {
						if($this->Crud->check('name', $name, $table) > 0) {
							echo $this->Crud->msg('warning', 'Record Already Exist');
						} else {
							$ins_data = array(
								'user_id' => $user_id,
								'name' => $name
							);
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
			$table = 'lp_session';
			$column_order = array('name');
			$column_search = array('name');
			$order = array('id' => 'desc');
			
			$where = '';
			
			// load data into table
			$list = $this->Crud->datatable_load($table, $column_order, $column_search, $order, $where);
			$data = array();
			// $no = $_POST['start'];
			$count = 1;
			foreach ($list as $item) {
				$id = $item->id;
				$name = $item->name;
				
				// add scripts to last record
				if($count == count($list)){
					$script = '<script src="'.base_url('assets/js/jsform.js').'"></script>';
				} else {$script = '';}
				
				// add manage buttons
				$all_btn = '
					<div class="text-center">
						<a class="btn btn-danger btn-xs pop" href="javascript:;" pageTitle="Delete '.$name.'" pageName="'.base_url('setup/session/manage/delete/'.$id).'">
							<i class="fa fa-trash-o"></i>
						</a>
						<a class="btn btn-primary btn-xs pop" href="javascript:;" pageTitle="Manage '.$name.'" pageName="'.base_url('setup/session/manage/edit/'.$id).'">
							<i class="fa fa-edit"></i>
						</a>
					</div>
					'.$script.'
				';
				
				$row = array();
				$row[] = $name;
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
			$this->load->view('setup/session_form', $data);
		} else { // view for main page
			// for datatable
			$data['table_rec'] = 'setup/session/list'; // ajax table
			$data['order_sort'] = '0, "asc"'; // default ordering (0, 'asc')
			$data['no_sort'] = '1'; // sort disable columns (1,3,5)
		
			$data['title'] = 'Session | '.app_name;
			$data['page_active'] = 'session';
			
			$this->load->view('designs/header', $data);
			$this->load->view('setup/session', $data);
			$this->load->view('designs/footer', $data);
		}
	}
	
	// PROGRAMME
	public function programme($param1='',$param2='',$param3='') {
		if($this->session->userdata('logged_in') == FALSE){
			redirect(base_url('login'), 'refresh');	
		} else {
			$lps_user_role = $this->session->userdata('lps_user_role');
			$user_id = $this->session->userdata('lps_id');
			$lps_school_id = $this->session->userdata('lps_school_id');
			$permit = array('Super Admin', 'Admin', 'Lecturer');
			if(!in_array($lps_user_role, $permit)){
				redirect(base_url('dashboard'), 'refresh');	
			}
		}
		
		$table = 'lp_programme';
		
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
						$del_id = $this->input->post('d_programme_id');
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
								$data['e_name'] = $e->name;
							}
						}
					}
				}
				
				if($_POST){
					$programme_id = $this->input->post('programme_id');
					$name = $this->input->post('name');
					
					// do create or update
					if($programme_id) {
						$upd_data = array(
							'name' => $name
						);
						$upd_rec = $this->Crud->update('id', $programme_id, $table, $upd_data);
						if($upd_rec > 0) {
							echo $this->Crud->msg('success', 'Record Updated');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('info', 'No Changes');	
						}
					} else {
						if($this->Crud->check('name', $name, $table) > 0) {
							echo $this->Crud->msg('warning', 'Record Already Exist');
						} else {
							$ins_data = array(
								'school_id' => $lps_school_id,
								'user_id' => $user_id,
								'name' => $name
							);
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
			$table = 'lp_programme';
			$column_order = array('name');
			$column_search = array('name');
			$order = array('id' => 'desc');
			
			if($lps_user_role != 'Super Admin' && $lps_user_role != 'Admin') {
				$where = array('school_id'=>$lps_school_id);	
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
				$name = $item->name;
				
				// add scripts to last record
				if($count == count($list)){
					$script = '<script src="'.base_url('assets/js/jsform.js').'"></script>';
				} else {$script = '';}
				
				// add manage buttons
				$all_btn = '
					<div class="text-center">
						<a class="btn btn-danger btn-xs pop" href="javascript:;" pageTitle="Delete '.$name.'" pageName="'.base_url('setup/programme/manage/delete/'.$id).'">
							<i class="fa fa-trash-o"></i>
						</a>
						<a class="btn btn-primary btn-xs pop" href="javascript:;" pageTitle="Manage '.$name.'" pageName="'.base_url('setup/programme/manage/edit/'.$id).'">
							<i class="fa fa-edit"></i>
						</a>
					</div>
					'.$script.'
				';
				
				$row = array();
				$row[] = $name;
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
			$this->load->view('setup/programme_form', $data);
		} else { // view for main page
			// for datatable
			$data['table_rec'] = 'setup/programme/list'; // ajax table
			$data['order_sort'] = '0, "asc"'; // default ordering (0, 'asc')
			$data['no_sort'] = '1'; // sort disable columns (1,3,5)
		
			$data['title'] = 'Programme | '.app_name;
			$data['page_active'] = 'programme';
			
			$this->load->view('designs/header', $data);
			$this->load->view('setup/programme', $data);
			$this->load->view('designs/footer', $data);
		}
	}
	
	// LEVEL
	public function level($param1='',$param2='',$param3='') {
		if($this->session->userdata('logged_in') == FALSE){
			redirect(base_url('login'), 'refresh');	
		} else {
			$lps_user_role = $this->session->userdata('lps_user_role');
			$user_id = $this->session->userdata('lps_id');
			$lps_school_id = $this->session->userdata('lps_school_id');
			$permit = array('Super Admin', 'Admin', 'Lecturer');
			if(!in_array($lps_user_role, $permit)){
				redirect(base_url('dashboard'), 'refresh');	
			}
		}
		
		$table = 'lp_level';
		
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
						$del_id = $this->input->post('d_level_id');
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
								$data['e_name'] = $e->name;
							}
						}
					}
				}
				
				if($_POST){
					$level_id = $this->input->post('level_id');
					$name = $this->input->post('name');
					
					// do create or update
					if($level_id) {
						$upd_data = array(
							'name' => $name
						);
						$upd_rec = $this->Crud->update('id', $level_id, $table, $upd_data);
						if($upd_rec > 0) {
							echo $this->Crud->msg('success', 'Record Updated');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('info', 'No Changes');	
						}
					} else {
						if($this->Crud->check('name', $name, $table) > 0) {
							echo $this->Crud->msg('warning', 'Record Already Exist');
						} else {
							$ins_data = array(
								'school_id' => $lps_school_id,
								'user_id' => $user_id,
								'name' => $name
							);
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
			$table = 'lp_level';
			$column_order = array('name');
			$column_search = array('name');
			$order = array('id' => 'desc');
			
			if($lps_user_role != 'Super Admin' && $lps_user_role != 'Admin') {
				$where = array('school_id'=>$lps_school_id);	
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
				$name = $item->name;
				
				// add scripts to last record
				if($count == count($list)){
					$script = '<script src="'.base_url('assets/js/jsform.js').'"></script>';
				} else {$script = '';}
				
				// add manage buttons
				$all_btn = '
					<div class="text-center">
						<a class="btn btn-danger btn-xs pop" href="javascript:;" pageTitle="Delete '.$name.'" pageName="'.base_url('setup/level/manage/delete/'.$id).'">
							<i class="fa fa-trash-o"></i>
						</a>
						<a class="btn btn-primary btn-xs pop" href="javascript:;" pageTitle="Manage '.$name.'" pageName="'.base_url('setup/level/manage/edit/'.$id).'">
							<i class="fa fa-edit"></i>
						</a>
					</div>
					'.$script.'
				';
				
				$row = array();
				$row[] = $name;
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
			$this->load->view('setup/level_form', $data);
		} else { // view for main page
			// for datatable
			$data['table_rec'] = 'setup/level/list'; // ajax table
			$data['order_sort'] = '0, "asc"'; // default ordering (0, 'asc')
			$data['no_sort'] = '1'; // sort disable columns (1,3,5)
		
			$data['title'] = 'Level | '.app_name;
			$data['page_active'] = 'level';
			
			$this->load->view('designs/header', $data);
			$this->load->view('setup/level', $data);
			$this->load->view('designs/footer', $data);
		}
	}
	
	// DEPARTMENT
	public function department($param1='',$param2='',$param3='') {
		if($this->session->userdata('logged_in') == FALSE){
			redirect(base_url('login'), 'refresh');	
		} else {
			$lps_user_role = $this->session->userdata('lps_user_role');
			$user_id = $this->session->userdata('lps_id');
			$lps_school_id = $this->session->userdata('lps_school_id');
			$permit = array('Super Admin', 'Admin', 'Lecturer');
			if(!in_array($lps_user_role, $permit)){
				redirect(base_url('dashboard'), 'refresh');	
			}
		}
		
		$table = 'lp_department';
		
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
						$del_id = $this->input->post('d_department_id');
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
								$data['e_name'] = $e->name;
							}
						}
					}
				}
				
				if($_POST){
					$department_id = $this->input->post('department_id');
					$name = $this->input->post('name');
					
					// do create or update
					if($department_id) {
						$upd_data = array(
							'name' => $name
						);
						$upd_rec = $this->Crud->update('id', $department_id, $table, $upd_data);
						if($upd_rec > 0) {
							echo $this->Crud->msg('success', 'Record Updated');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('info', 'No Changes');	
						}
					} else {
						if($this->Crud->check2('name', $name, 'school_id', $lps_school_id, $table) > 0) {
							echo $this->Crud->msg('warning', 'Record Already Exist');
						} else {
							$ins_data = array(
								'school_id' => $lps_school_id,
								'user_id' => $user_id,
								'name' => $name
							);
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
			$table = 'lp_department';
			$column_order = array('school_id', 'name');
			$column_search = array('school_id', 'name');
			$order = array('id' => 'desc');
			
			if($lps_user_role != 'Super Admin' && $lps_user_role != 'Admin') {
				$where = array('school_id'=>$lps_school_id);	
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
				$name = $item->name;
				$school_id = $item->school_id;
				$school = $this->Crud->read_field('id', $school_id, 'lp_school', 'name');
				
				// add scripts to last record
				if($count == count($list)){
					$script = '<script src="'.base_url('assets/js/jsform.js').'"></script>';
				} else {$script = '';}
				
				// add manage buttons
				$all_btn = '
					<div class="text-center">
						<a class="btn btn-danger btn-xs pop" href="javascript:;" pageTitle="Delete '.$name.'" pageName="'.base_url('setup/department/manage/delete/'.$id).'">
							<i class="fa fa-trash-o"></i>
						</a>
						<a class="btn btn-primary btn-xs pop" href="javascript:;" pageTitle="Manage '.$name.'" pageName="'.base_url('setup/department/manage/edit/'.$id).'">
							<i class="fa fa-edit"></i>
						</a>
					</div>
					'.$script.'
				';
				
				$row = array();
				$row[] = $school;
				$row[] = $name;
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
			$this->load->view('setup/department_form', $data);
		} else { // view for main page
			// for datatable
			$data['table_rec'] = 'setup/department/list'; // ajax table
			$data['order_sort'] = '1, "asc"'; // default ordering (0, 'asc')
			$data['no_sort'] = '2'; // sort disable columns (1,3,5)
		
			$data['title'] = 'Department | '.app_name;
			$data['page_active'] = 'department';
			
			$this->load->view('designs/header', $data);
			$this->load->view('setup/department', $data);
			$this->load->view('designs/footer', $data);
		}
	}
	
	// LECTURER
	public function lecturer($param1='',$param2='',$param3='') {
		if($this->session->userdata('logged_in') == FALSE){
			redirect(base_url('login'), 'refresh');	
		} else {
			$lps_user_role = $this->session->userdata('lps_user_role');
			$user_id = $this->session->userdata('lps_id');
			$lps_school_id = $this->session->userdata('lps_school_id');
			$permit = array('Super Admin', 'Admin');
			if(!in_array($lps_user_role, $permit)){
				redirect(base_url('dashboard'), 'refresh');	
			}
		}
		
		$table = 'lp_lecturer';
		
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
						$del_id = $this->input->post('d_lecturer_id');
						if($this->Crud->delete('id', $del_id, $table) > 0) {
							echo $this->Crud->msg('success', 'Record Deleted');
							
							// delete user account also
							$user_name = $this->Crud->read_field('id', $del_id, $table, 'username');
							$this->Crud->delete('username', $user_name, 'lp_user');
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
								$data['e_school_id'] = $e->school_id;
								$data['e_firstname'] = $e->firstname;
								$data['e_lastname'] = $e->lastname;
								$data['e_username'] = $e->username;
								$data['e_email'] = $e->email;
								$data['e_phone'] = $e->phone;
								$data['e_ban'] = $e->ban;
							}
						}
					}
				}
				
				if($_POST){
					$lecturer_id = $this->input->post('lecturer_id');
					$school_id = $this->input->post('school_id');
					$firstname = $this->input->post('firstname');
					$lastname = $this->input->post('lastname');
					$username = $this->input->post('username');
					$password = $this->input->post('password');
					$email = $this->input->post('email');
					$phone = $this->input->post('phone');
					if($this->input->post('ban')){$ban = 1;} else {$ban = 0;}
					
					// do create or update
					if($lecturer_id) {
						$upd_data = array(
							'school_id' => $school_id,
							'firstname' => $firstname,
							'lastname' => $lastname,
							'email' => $email,
							'phone' => $phone,
							'ban' => $ban
						);
						
						// if password not empty
						if($password) {
							if($this->Crud->update('username', $username, 'lp_user', array('password'=>md5($password))) > 0) {
								echo $this->Crud->msg('success', 'Password Updated');
							}
						}
						
						$upd_rec = $this->Crud->update('id', $lecturer_id, $table, $upd_data);
						if($upd_rec > 0) {
							echo $this->Crud->msg('success', 'Record Updated');
							echo '<script>location.reload(false);</script>';
						} else {
							echo $this->Crud->msg('info', 'No Changes');	
						}
					} else {
						if($this->Crud->check('username', $username, $table) > 0 || $this->Crud->check('email', $email, $table) > 0) {
							echo $this->Crud->msg('warning', 'Record Already Exist');
						} else {
							$ins_data = array(
								'school_id' => $school_id,
								'user_id' => $user_id,
								'firstname' => $firstname,
								'lastname' => $lastname,
								'username' => $username,
								'email' => $email,
								'phone' => $phone,
								'ban' => $ban,
								'reg_date' => date(fdate)
							);
							$this->db->trans_start(); // start transaction
							$ins_rec = $this->Crud->create($table, $ins_data);
							if($ins_rec > 0) {
								// register user
								if($this->Crud->check('username', $username, 'lp_user') > 0 || $this->Crud->check('email', $email, 'lp_user') > 0) {
									echo $this->Crud->msg('danger', 'Username/Email already attached to another account');
									exit;
								} else {
									$user_data['school_id'] = $school_id;
									$user_data['username'] = $username;
									$user_data['password'] = md5($password);
									$user_data['othername'] = $firstname;
									$user_data['lastname'] = $lastname;
									$user_data['email'] = $email;
									$user_data['phone'] = $phone;
									$user_data['activate'] = 1;
									$user_data['role'] = 'Lecturer';
									$user_data['reg_date'] = date(fdate);
									
									$user_rec = $this->Crud->create('lp_user', $user_data);
									$this->db->trans_complete(); // complete transactions
									
									if($user_rec > 0) {
										echo $this->Crud->msg('success', 'Record Created');
										// send email
										if($email) {
											$from = app_email;
											$subject = 'Account Creation';
											$name = app_name;
											$sub_head = 'Your Account Is Ready';
														
											$body = '
												Dear '.$firstname.' '.$lastname.',<br /><br />Your account has been created and now have access to '.app_name.'. Please kindly find your login details below:<br /><br /><b>Username:</b> '.$username.'<br /><b>Password:</b> '.$password.'<br /><br />Thank you.
											';
											
											$this->Crud->send_email($email, $from, $subject, $body, $name, $sub_head);
										}
									}
								}
								
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
			$table = 'lp_lecturer';
			$column_order = array('school_id', 'firstname', 'lastname', 'username', 'email', 'phone', 'ban', 'reg_date');
			$column_search = array('school_id', 'firstname', 'lastname', 'username', 'email', 'phone', 'ban', 'reg_date');
			$order = array('id' => 'desc');
			
			if($lps_user_role != 'Super Admin' && $lps_user_role != 'Admin') {
				$where = array('school_id'=>$lps_school_id);	
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
				$firstname = $item->firstname;
				$lastname = $item->lastname;
				$username = $item->username;				
				$email = $item->email;
				$phone = $item->phone;
				$ban = $item->ban;
				$reg_date = $item->reg_date;
				
				$school = $this->Crud->read_field('id', $school_id, 'lp_school', 'name');
				if($ban==0){$ban = '<span class="text-success">Active</span>';} else {$ban = '<span class="text-danger">Banned</span>';}
				
				// add scripts to last record
				if($count == count($list)){
					$script = '<script src="'.base_url('assets/js/jsform.js').'"></script>';
				} else {$script = '';}
				
				// add manage buttons
				$all_btn = '
					<div class="text-center">
						<a class="btn btn-danger btn-xs pop" href="javascript:;" pageTitle="Delete '.$firstname.' '.$lastname.'" pageName="'.base_url('setup/lecturer/manage/delete/'.$id).'">
							<i class="fa fa-trash-o"></i>
						</a>
						<a class="btn btn-primary btn-xs pop" href="javascript:;" pageTitle="Manage '.$firstname.' '.$lastname.'" pageName="'.base_url('setup/lecturer/manage/edit/'.$id).'">
							<i class="fa fa-edit"></i>
						</a>
					</div>
					'.$script.'
				';
				
				$row = array();
				$row[] = date('M d, Y', strtotime($reg_date));
				$row[] = $firstname.' '.$lastname.' ('.$username.')<br /><span class="text-muted">'.$school.'</span>';
				$row[] = $phone.'<br />'.$email;
				$row[] = $ban;
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
			$this->load->view('setup/lecturer_form', $data);
		} else { // view for main page
			// for datatable
			$data['table_rec'] = 'setup/lecturer/list'; // ajax table
			$data['order_sort'] = '1, "asc"'; // default ordering (0, 'asc')
			$data['no_sort'] = '4'; // sort disable columns (1,3,5)
		
			$data['title'] = 'Lecturer | '.app_name;
			$data['page_active'] = 'lecturer';
			
			$this->load->view('designs/header', $data);
			$this->load->view('setup/lecturer', $data);
			$this->load->view('designs/footer', $data);
		}
	}
}
