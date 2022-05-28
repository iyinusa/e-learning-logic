<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	function __construct() {
        parent::__construct();
    }
	
	public function index() {
		if($this->session->userdata('logged_in') == TRUE){
			redirect(base_url('dashboard'), 'refresh');	
		} 
		
		$data['link'] = 'register';
		
		if($_POST) {
			$matric = $this->input->post('matric');
			
			// check matric number
			if($this->Crud->check('matric', $matric, 'lp_matric') <= 0) {
				$data['err_msg'] = $this->Crud->msg('danger', 'Matric Number not recognized');
			} else {
				// check if matric already registered
				if($this->Crud->check('matric', $matric, 'lp_student') > 0) {
					// check if paid
					if($this->Crud->read_field('matric', $matric, 'lp_student', 'paid') == 1) {
						$data['err_msg'] = $this->Crud->msg('danger', 'Student with Matric Number already registered');
					} else {
						// redirect to payment
						redirect(base_url('register/p/'.$matric), 'refresh');
					}
				} else {
					$matrics = $this->Crud->read_single('matric', $matric, 'lp_matric');
					if(!empty($matrics)) {
						foreach($matrics as $ma) {
							// check if academic session expired
							$session = $this->Crud->read_field('id', $ma->sess_id, 'lp_session', 'name');
							$sess = explode('/', $session);
							if($sess[1] < date('Y')) {
								$data['err_msg'] = $this->Crud->msg('danger', 'Academic Session expired');
							} else {
								redirect(base_url('register/r/'.$ma->matric), 'refresh');
							}
						}
					}
				}
			}
		}
		
		$data['title'] = 'Register | '.app_name;
		$data['page_active'] = 'register';
		
		$this->load->view('designs/auth_header', $data);
		$this->load->view('register', $data);
		$this->load->view('designs/auth_footer', $data);
	}
	
	public function r($matric='') {
		if($this->session->userdata('logged_in') == TRUE){
			redirect(base_url('dashboard'), 'refresh');	
		} 
		
		if(!$matric){redirect(base_url('register'), 'refresh');	}
		
		$data['link'] = 'register/r/'.$matric;
		$data['matric'] = $matric;
		
		$matrics = $this->Crud->read_single('matric', $matric, 'lp_matric');
		if(!empty($matrics)) {
			foreach($matrics as $ma) {
				$school_id = $ma->school_id;
				$sess_id = $ma->sess_id;
				$prog_id = $ma->prog_id;
				$level_id = $ma->level_id;
				$dept_id = $ma->dept_id;
				$lecturer_id = $ma->lecturer_id;
				
				// check if academic session expired
				$session = $this->Crud->read_field('id', $ma->sess_id, 'lp_session', 'name');
				$sess = explode('/', $session);
				if($sess[1] < date('Y')) {
					$data['err_msg'] = $this->Crud->msg('danger', 'Academic Session expired');
					$data['matric'] = ''; // clear matric
				} else {
					$data['school'] = $this->Crud->read_field('id', $ma->school_id, 'lp_school', 'name');
					$data['session'] = $this->Crud->read_field('id', $ma->sess_id, 'lp_session', 'name');
					$data['programme'] = $this->Crud->read_field('id', $ma->prog_id, 'lp_programme', 'name');
					$data['level'] = $this->Crud->read_field('id', $ma->level_id, 'lp_level', 'name');
					$data['department'] = $this->Crud->read_field('id', $ma->dept_id, 'lp_department', 'name');
					$data['lecturer'] = $this->Crud->read_field('id', $ma->lecturer_id, 'lp_lecturer', 'firstname').' '.$this->Crud->read_field('id', $ma->lecturer_id, 'lp_lecturer', 'lastname');
				
				}
			}
		}
		
		if($_POST) {
			$firstname = $this->input->post('firstname');
			$middlename = $this->input->post('middlename');
			$lastname = $this->input->post('lastname');
			$sex = $this->input->post('sex');
			$phone = $this->input->post('phone');
			$email = $this->input->post('email');
			$password = $this->input->post('password');	
			
			// check if email already exist
			if($this->Crud->check('email', $email, 'lp_user') > 0) {
				$data['err_msg'] = $this->Crud->msg('danger', 'Email Address already used by another');
			} else {
				$ins_data['school_id'] = $school_id;
				$ins_data['sess_id'] = $sess_id;
				$ins_data['prog_id'] = $prog_id;
				$ins_data['level_id'] = $level_id;
				$ins_data['dept_id'] = $dept_id;
				$ins_data['lecturer_id'] = $lecturer_id;
				$ins_data['username'] = strtoupper(substr(md5(rand()),0,6));
				$ins_data['password'] = $password;
				$ins_data['matric'] = $matric;
				$ins_data['firstname'] = $firstname;
				$ins_data['middlename'] = $middlename;
				$ins_data['lastname'] = $lastname;
				$ins_data['sex'] = $sex;
				$ins_data['phone'] = $phone;
				$ins_data['email'] = $email;
				$ins_data['reg_date'] = date(fdate);
				if($this->Crud->create('lp_student', $ins_data) > 0) {
					redirect(base_url('register/p/'.$matric), 'refresh');
				}
			}
		}
		
		$data['title'] = 'Register | '.app_name;
		$data['page_active'] = 'register';
		
		$this->load->view('designs/auth_header', $data);
		$this->load->view('register', $data);
		$this->load->view('designs/auth_footer', $data);
	}
	
	public function p($param1='', $param2='', $param3='') {
		if($this->session->userdata('logged_in') == TRUE){
			redirect(base_url('dashboard'), 'refresh');	
		} 
		
		if(!$param1){redirect(base_url('register'), 'refresh');	}
		
		if($param2){$link_add = '/'.$param2.'/'.$param3;} else {$link_add = '';}
		
		$data['link'] = 'register/p/'.$param1.$link_add;
		$data['payment'] = TRUE;
		
		$students = $this->Crud->read_single('matric', $param1, 'lp_student');
		if(!empty($students)) {
			foreach($students as $ma) {
				$id = $ma->id;
				$school_id = $ma->school_id;
				$lecturer_id = $ma->lecturer_id;
				$firstname = $ma->firstname;
				$lastname = $ma->lastname;
				$email = $ma->email;
				$phone = $ma->phone;
			}
		} else {
			redirect(base_url('register'), 'refresh');	
		}
		
		$price = $this->Crud->read_field('description', 'Activation', 'lp_fee', 'amount');
		$data['price'] = $price;
		
		// Payment Notification
		$pay_msg = '';
		if($param2 == 'status') {
			$trans_code = 'LP-'.time();
			$status_ref = $this->input->get('flw_ref');
			$status_msg = $this->input->get('flw_msg');
			
			// fail and success message
			if($param3 == 'fail') {
				if($this->Crud->check('trnx_ref', $status_ref, 'lp_transaction') > 0) {
					$trans_code = $this->Crud->read_field('trnx_ref', $status_ref, 'lp_transaction', 'pay_code');
				}
				
				$pay_msg = '
					<div class="block-content block-content-full text-center">
						<div class="push-30">
							<span class="item item-2x item-circle bg-danger-light">
								<i class="fa fa-times text-danger"></i>
							</span>
							<h4><br />'.$status_msg.'</h4>
							Transaction Code: <b>'.$trans_code.'</b>
						</div>
					</div>
				';
			} else {
				$status_msg = 'Payment Successful';
				$pay_msg = '
					<div class="block-content block-content-full text-center">
						<div class="push-30">
							<span class="item item-2x item-circle bg-success-light">
								<i class="fa fa-check text-success"></i>
							</span>
							<h4><br />'.$status_msg.'</h4>
						</div>
					</div>
				';
				
				// verify transaction on RavePay
				$ver_data = array(
					'SECKEY' => $this->Crud->rave_key('test', 'secret'),
					'flw_ref' => $status_ref,
					'normalize' => '1'
				);
				$ver = $this->Crud->rave_verify($ver_data);
				$ver = json_decode($ver);
				$res_data = $ver->data;
				if($res_data->flwMeta->chargeResponse != '00' || $res_data->flwMeta->chargeResponse != '0') {
					$pay_msg .= 'Unable To Complete Transaction';
				} else {
					$trnx_id = $res_data->id;
					$trnx_ip = $res_data->ip;
					$trnx_amount = $res_data->amount;
					$trnx_fee = $res_data->appfee;
					$trnx_meta = $res_data->meta;
					
					// get user's subscription duration
					$trnx_duration = 0; $trnx_productID = 0; $trnx_mdn = 0;
					if(!empty($trnx_meta)) {
						foreach($trnx_meta as $tm) {
							if($tm->metaname == 'matric') {
								$trnx_matric = $tm->metavalue;
								
								// student details
								$students = $this->Crud->read_single('matric', $trnx_matric, 'lp_student');
								if(!empty($students)) {
									foreach($students as $ma) {
										$id = $ma->id;
										$school_id = $ma->school_id;
										$lecturer_id = $ma->lecturer_id;
										$sess_id = $ma->sess_id;
										$prog_id = $ma->prog_id;
										$level_id = $ma->level_id;
										$dept_id = $ma->dept_id;
										$username = $ma->username;
										$password = $ma->password;
										$firstname = $ma->firstname;
										$middlename = $ma->middlename;
										$lastname = $ma->lastname;
										$sex = $ma->sex;
										$email = $ma->email;
										$phone = $ma->phone;
										
										$school = $this->Crud->read_field('id', $school_id, 'lp_school', 'name');
										$session = $this->Crud->read_field('id', $sess_id, 'lp_session', 'name');
										$programme = $this->Crud->read_field('id', $prog_id, 'lp_programme', 'name');
										$level = $this->Crud->read_field('id', $level_id, 'lp_level', 'name');
										$department = $this->Crud->read_field('id', $dept_id, 'lp_department', 'name');
									}
								} 
							}
						}
					}
					
					// check if transaction already logged
					if($this->Crud->read_single('trnx_ref', $status_ref, 'lp_transaction') <= 0) {
						$activated = 1;
						
						// register student in user
						if($this->Crud->check('username', $username, 'lp_user') <= 0) {
							$user_data['school_id'] = $school_id;
							$user_data['username'] = $username;
							$user_data['password'] = md5($password);
							$user_data['othername'] = $firstname.' '.$middlename;
							$user_data['lastname'] = $lastname;
							$user_data['email'] = $email;
							$user_data['phone'] = $phone;
							$user_data['sex'] = $phone;
							$user_data['activate'] = 1;
							$user_data['role'] = 'Student';
							$user_data['reg_date'] = date(fdate);
							
							$user_rec = $this->Crud->create('lp_user', $user_data);
							
							if($user_rec > 0) {
								// update student table
								$this->Crud->update('matric', $trnx_matric, 'lp_student', array('paid'=>1));
								
								// send email to lecturer
								$lec_fname = $this->Crud->read_field('id', $lecturer_id, 'lp_lecturer', 'firstname');
								$lec_email = $this->Crud->read_field('id', $lecturer_id, 'lp_lecturer', 'email');
								if($lec_email) {
									$from = app_email;
									$subject = 'Activation';
									$name = app_name;
									$sub_head = 'Student Account Activation';
												
									$body = '
										Dear '.$lec_fname.',<br /><br />You have a new Student account activation on '.app_name.'. Please kindly see details below:<br /><br /><b>Student:</b> '.$firstname.' '.$middlename.', '.$lastname.'<br /><b>School:</b> '.$school.'<br /><b>Session:</b> '.$session.' '.$programme.'<br /><b>Department:</b> '.$level.' '.$department.'<br /><br />Thank you.
									';
									
									$this->Crud->send_email($lec_email, $from, $subject, $body, $name, $sub_head);
								}
							}
						}
						
						$pay_msg .= '
							<h3 class="text-primary">Congratulation!!!</h3>
							<h4>Your Username/Code is <b>'.$username.'</b>. Use this with your password to login to your account <a href="'.base_url('login').'">HERE</a><br /><br /></h4>
						';
					}
				}
			}
			
			// log transaction here
			if($this->Crud->read_single('trnx_ref', $status_ref, 'lp_transaction') <= 0) {
					if(!empty($trnx_amount)){$amount = $trnx_amount;} else {$amount = 0;}
					if(!empty($trnx_ip)){$medium = 'web|'.$trnx_ip;} else {$medium = 'web';}
					if(!empty($trnx_id)){$trnx_id = $trnx_id; $status = 'completed';} else {$trnx_id = 0; $status = 'failed';}
					if(!empty($activated)){$activated = $activated;} else {$activated = 0;}
					
					$trnx_data['school_id'] = $school_id;
					$trnx_data['lecturer_id'] = $lecturer_id;
					$trnx_data['item_id'] = $id;
					$trnx_data['item_type'] = 'activation';
					$trnx_data['pay_code'] = $trans_code;
					$trnx_data['type'] = 'credit-account';
					$trnx_data['recipient'] = app_name;
					$trnx_data['amount'] = $amount;
					$trnx_data['medium'] = $medium;
					$trnx_data['trnx_id'] = $trnx_id;
					$trnx_data['trnx_ref'] = $status_ref;
					$trnx_data['trnx_status'] = $status;
					$trnx_data['trnx_msg'] = $status_msg;
					$trnx_data['re_query'] = 'register/p/status/?flw_ref='.$status_ref.'&flw_msg='.$status_msg;
					$trnx_data['paid'] = $activated;
					$trnx_data['reg_date'] = date(fdate);
					$ins_trnx = $this->Crud->create('lp_transaction', $trnx_data);
					
					// push email
					if(!empty($activated)){
						$email_body = 'Dear '.$firstname.'<br /><br />Your account is now activated</b><br /><br/>Thank you.';
						$this->push_email($email, $email_body);
					} else {
						$email_body = 'Dear '.$firstname.'<br /><br />Your account activation failed due to <b>'.$status_msg.'</b><br /><br/>Contact your Lecturer/Support. Thank you.';
						$this->push_email($email, $email_body);
					}
				}
		}
		
		// for RavePay
		$data['pay_msg'] = $pay_msg;
		$data['rave_server'] = 'test';
		$meta = json_encode(array('metaname' => 'matric', 'metavalue' => $param1)); // pass this meta to RavePAY to use later
		$data['rave_pay'] = $this->rave_script($param1, $firstname, $lastname, $phone, $email, $price, app_name, 'Activation', 'both', $meta);
		
		$data['title'] = 'Activate Account | '.app_name;
		$data['page_active'] = 'register';
		
		$this->load->view('designs/auth_header', $data);
		$this->load->view('activate', $data);
		$this->load->view('designs/auth_footer', $data);
	}
	
	private function rave_script($matric, $firstname, $lastname, $phone, $email, $price, $name, $desc, $method, $meta) {
		$pubkey = $this->Crud->rave_key('test', 'public');
		$secret = $this->Crud->rave_key('test', 'secret');
		$trxref = (float)rand()/(float)getrandmax();;
		$pay_title = $name;
		$pay_desc = ucwords($desc);
		$pay_logo = base_url('assets/img/icon.png');
		$pay_country = 'NG';
		$pay_currency = 'NGN';
		
		// compute hash, must follow ravepay ASCII order
		$pay_hash = $pubkey.$price.$pay_country.$pay_currency.$pay_desc.$pay_logo.$pay_title.$email.$firstname.$lastname.$phone.$method.$trxref;
		$pay_hash .= $secret;
		$pay_hash = hash('sha256', $pay_hash);
		
		$script = "
			getpaidSetup({ 
				PBFPubKey: '".$pubkey."',
				customer_email: '".$email."',
				customer_firstname: '".$firstname."',
				customer_lastname: '".$lastname."',
				customer_phone: '".$phone."',
				custom_logo: '".$pay_logo."',
				custom_title: '".$pay_title."',
				custom_description: '".$pay_desc."',
				amount: '".$price."',
				country: '".$pay_country."',
				currency: '".$pay_currency."',
				payment_method: '".$method."',
				txref: '".$trxref."',
				integrity_hash: '".$pay_hash."',
				meta: [".$meta."],
				onclose: function() {},
				callback: function(response) {
					flw_ref = response.tx.flwRef, chargeResponse = response.tx.chargeResponseCode, flw_msg = response.tx.chargeResponseMessage;
					if (chargeResponse == '00' || chargeResponse == '0') {
						window.location = '".base_url('register/p/'.$matric.'/status/pass/')."?flw_ref='+flw_ref+'&flw_msg='+flw_msg;
					} else {
						window.location = '".base_url('register/p/'.$matric.'/status/fail/')."?flw_ref='+flw_ref+'&flw_msg='+flw_msg;
					}
				}
			});
		";	
		
		return $script;
	}
	
	// push email
	private function push_email($email, $body) {
		// check for email alert
		if($email && $body) {
			$from = app_email;
			$subject = '['.app_name.'] Payment';
			$name = app_name;
			$sub_head = 'Payment Notification';
			
			$this->Crud->send_email($email, $from, $subject, $body, $name, $sub_head);
			
			// notify admin
			$admin_email = 'iyinusa@yahoo.co.uk';
			$this->Crud->send_email($admin_email, $from, $subject, $body, $name, $sub_head);
		}
	}
}
