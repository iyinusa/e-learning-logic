<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Backup extends CI_Controller {

	function __construct() {
        parent::__construct();
        $this->load->dbutil();

        $params['key'] = '72t3ugcgaxrm56h';
		$params['secret'] = 'ngnmsnvs3gymvlx';
		
		$this->load->library('dropbox', $params);
    }
	
	public function index() {
		$prefs = array(     
        	'format'      => 'zip',             
          	'filename'    => 'db_backup.sql'
        );


        $backup =& $this->dbutil->backup($prefs); 

        $db_name = 'backup-on-'. date("Y-m-d-H-i-s") .'.zip';
        $save = 'assets/backups/'.$db_name;

        $this->load->helper('file');

        if(write_file($save, $backup)) {
        	$status = 'BackUp Successful!';
        } else {
        	$status = 'BackUp Failed!';
        }

        // now send file to Dropbox Backup Folder
        $dbpath = 'Apps/BaseSOFT Backup';
        if($this->dropbox->add($dbpath, $save)) {
        	$file_drop = 'Dropbox Sync Successfully!';
        } else {
        	$file_drop = 'Dropbox Sync Failed!';
        }

        // try and push email notification
        $this->email->clear(); //clear initial email variables
		$this->email->to('coo@tehilahbase.com');
		$this->email->from(app_email,app_name);
		$this->email->subject(app_name.' - Database BackUp');
		$this->email->attach($save); // attach zip file to email
						
		//compose html body of mail
		$mail_subhead = 'Backup Notification';
		$body_msg = '
			'.app_name.' Database Backup ('.$db_name.') Status:<br /><br />
			<b>Local Storage: </b>'.$status.'<br />
			<b>Cloud Storage: </b>'.$file_drop.'<br /><br />Thanks
		';
						
		$mail_data = array('message'=>$body_msg, 'subhead'=>$mail_subhead);
		$this->email->set_mailtype("html"); //use HTML format
		$mail_design = $this->load->view('designs/email_template', $mail_data, TRUE);
				
		$this->email->message($mail_design);
		if($this->email->send()) {}

        // force download backup
        //$this->load->helper('download');
        //force_download($db_name, $backup);
	}

	/////////////////// DROPBOX API ////////////////////////////////////////////////
	// Call this method first by visiting http://SITE_URL/example/request_dropbox
    public function request_dropbox()
	{
		$params['key'] = '72t3ugcgaxrm56h';
		$params['secret'] = 'ngnmsnvs3gymvlx';
		
		$this->load->library('dropbox', $params);
		$data = $this->dropbox->get_request_token(base_url("backup/access_dropbox"));
		$this->session->set_userdata('token_secret', $data['token_secret']);
		redirect($data['redirect']);
	}
	//This method should not be called directly, it will be called after 
    //the user approves your application and dropbox redirects to it
	public function access_dropbox()
	{
		$params['key'] = '72t3ugcgaxrm56h';
		$params['secret'] = 'ngnmsnvs3gymvlx';
		
		$this->load->library('dropbox', $params);
		
		$oauth = $this->dropbox->get_access_token($this->session->userdata('token_secret'));
		
		$this->session->set_userdata('oauth_token', $oauth['oauth_token']);
		$this->session->set_userdata('oauth_token_secret', $oauth['oauth_token_secret']);
        redirect('backup/test_dropbox');
	}
	//Once your application is approved you can proceed to load the library
    //with the access token data stored in the session. If you see your account
    //information printed out then you have successfully authenticated with
    //dropbox and can use the library to interact with your account.
	public function test_dropbox()
	{
		$params['key'] = '72t3ugcgaxrm56h';
		$params['secret'] = 'ngnmsnvs3gymvlx';
		$params['access'] = array('oauth_token'=>urlencode($this->session->userdata('oauth_token')),
								  'oauth_token_secret'=>urlencode($this->session->userdata('oauth_token_secret')));
		
		$this->load->library('dropbox', $params);
		
        $dbobj = $this->dropbox->account();
		
        print_r($dbobj);
	}

	/////////////////// END DROPBOX API ///////////////////////////////////////////
}
