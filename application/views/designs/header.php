<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
	$log_user_role = $this->session->userdata('lps_user_role');
	$log_school_id = $this->session->userdata('lps_school_id');
	$log_school = $this->Crud->read_field('id', $log_school_id, 'lp_school', 'name');
	if($page_active) {
		if($page_active == 'dashboard'){$dash_act='active';}else{$dash_act='';}
		if($page_active == 'institution'){$institution_act='active';}else{$institution_act='';}
		if($page_active == 'session'){$session_act='active';}else{$session_act='';}
		if($page_active == 'programme'){$programme_act='active';}else{$programme_act='';}
		if($page_active == 'level'){$level_act='active';}else{$level_act='';}
		if($page_active == 'department'){$dept_act='active';}else{$dept_act='';}
		if($page_active == 'lecturer'){$lecturer_act='active';}else{$lecturer_act='';}
		if($page_active == 'upload'){$upload_act='active';}else{$upload_act='';}
		if($page_active == 'student'){$student_act='active';}else{$student_act='';}
		if($page_active == 'transaction'){$trans_act='active';}else{$trans_act='';}
		if($page_active == 'simulation'){$simulation_act='active';}else{$simulation_act='';}
	}
?>
<!DOCTYPE html>
<!--[if IE 9]>         <html class="ie9 no-focus" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-focus" lang="en">
<!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
<meta charset="utf-8">
<title><?php echo $title; ?></title>
<meta name="description" content="<?php echo app_meta_desc; ?>">
<meta name="author" content="I. Kennedy Yinusa (https://linkedin.com/in/iyinusa)">
<meta name="robots" content="noindex, nofollow">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">
<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon.png">
<!--<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600,700%7COpen+Sans:300,400,400italic,600,700">-->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/googlefonts.css">
<?php if($page_active != 'dashboard'){ ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/plugins/datatables/jquery.dataTables.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/plugins/select2/select2-bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/plugins/jquery-auto-complete/jquery.auto-complete.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/plugins/dropzonejs/dropzone.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/plugins/jquery-tags-input/jquery.tagsinput.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/js/plugins/ion-rangeslider/css/ion.rangeSlider.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/js/plugins/ion-rangeslider/css/ion.rangeSlider.skinHTML5.min.css">
<?php } ?>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/plugins/summernote/summernote.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min-1.4.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/plugins/slick/slick.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/plugins/slick/slick-theme.min.css">
<link rel="stylesheet" id="css-main" href="<?php echo base_url(); ?>assets/css/main.min-2.2.css">

<?php if($page_active=='data'){ ?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/webcam.js"></script>
<?php } ?>
</head>
<body>
<div id="page-container" class="sidebar-l sidebar-o <?php if($page_active=='simulation'){echo 'sidebar-mini';} ?> side-scroll header-navbar-fixed">
    <nav id="sidebar">
        <div id="sidebar-scroll">
            <div class="sidebar-content">
                <div class="side-header side-content bg-white">
                    <button class="btn btn-link text-gray pull-right hidden-md hidden-lg" type="button" data-toggle="layout" data-action="sidebar_close"> <i class="si si-arrow-left"></i> </button>
                    <a class="h5 text-white" href="<?php echo base_url('dashboard'); ?>"> 
                    	<img alt="<?php echo app_name; ?>" src="<?php echo base_url('assets/img/logo.png'); ?>" height="45px" />
                        
                    </a> 
              	</div>
                
                <div class="side-content">
                    <ul class="nav-main">
                        <li> 
                        	<a href="<?php echo base_url('dashboard'); ?>" class="<?php echo $dash_act; ?>"><i class="si si-speedometer"></i><span class="sidebar-mini-hide">Dashboard</span></a> 
                     	</li>
                        
                        <?php $setup_mod = array('Super Admin', 'Admin', 'Lecturer'); if(in_array($log_user_role, $setup_mod)){ ?>
                        	<li class="<?php if($page_active=='institution' || $page_active=='session' || $page_active=='programme' || $page_active=='level' || $page_active=='department' || $page_active=='lecturer'){echo 'open';} ?>"> 
                                <a class="nav-submenu" data-toggle="nav-submenu" href="javascript:;"><i class="si si-wrench"></i><span class="sidebar-mini-hide">Setup</span></a>
                                <ul>
                                    <?php if($log_user_role != 'Lecturer'){ ?>
                                    <li> <a href="<?php echo base_url('setup/institution'); ?>" class="<?php echo $institution_act; ?>">Institution</a> </li>
                                    <li> <a href="<?php echo base_url('setup/session'); ?>" class="<?php echo $session_act; ?>">Session</a> </li>
                                    <?php } ?>
                                    <li> <a href="<?php echo base_url('setup/programme'); ?>" class="<?php echo $programme_act; ?>">Programme</a> </li>
                                    <li> <a href="<?php echo base_url('setup/level'); ?>" class="<?php echo $level_act; ?>">Level</a> </li>
                                    <li> <a href="<?php echo base_url('setup/department'); ?>" class="<?php echo $dept_act; ?>">Department</a> </li>
                                    <?php if($log_user_role != 'Lecturer'){ ?>
                                    <li> <a href="<?php echo base_url('setup/lecturer'); ?>" class="<?php echo $lecturer_act; ?>">Lecturer</a> </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                        
                        <?php $student_mod = array('Super Admin', 'Admin', 'Lecturer'); if(in_array($log_user_role, $student_mod)){ ?>
                        	<li class="<?php if($page_active=='upload' || $page_active=='student'){echo 'open';} ?>"> 
                                <a class="nav-submenu" data-toggle="nav-submenu" href="javascript:;"><i class="si si-users"></i><span class="sidebar-mini-hide">Students</span></a>
                                <ul>
                                    <li> <a href="<?php echo base_url('students/upload'); ?>" class="<?php echo $upload_act; ?>">Upload Matrics</a> </li>
                                    <li> <a href="<?php echo base_url('students/lists'); ?>" class="<?php echo $student_act; ?>">Lists</a> </li>
                                </ul>
                            </li>
                            
                            <li> 
                                <a href="<?php echo base_url('transactions'); ?>" class="<?php echo $trans_act; ?>"><i class="si si-wallet"></i><span class="sidebar-mini-hide">Transaction</span></a> 
                            </li>
                        <?php } ?>
                        
                        <li> 
                        	<a href="<?php echo base_url('simulation'); ?>" class="<?php echo $simulation_act; ?>"><i class="si si-compass"></i><span class="sidebar-mini-hide">Logic Simulation</span></a> 
                     	</li>
                        
                        <!--<li> 
                        	<a href="<?php echo base_url('data'); ?>" class=""><i class="si si-notebook"></i><span class="sidebar-mini-hide">Assignments</span></a> 
                     	</li>-->
                        
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    
    <header id="header-navbar" class="content-mini content-mini-full">
        <ul class="nav-header pull-right">
            <li>
                <div class="btn-group">
                    <button class="btn btn-default btn-image dropdown-toggle" data-toggle="dropdown" type="button"> <img src="<?php echo base_url($this->session->userdata('lps_user_pics')); ?>" alt=""> <span class="caret"></span> </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="dropdown-header">Actions</li>
                        <li> <a tabindex="-1" href="<?php echo base_url('logout'); ?>"> <i class="si si-logout pull-right"></i>Log out </a> </li>
                    </ul>
                </div>
            </li>
        </ul>
        <ul class="nav-header pull-left">
            <li class="hidden-md hidden-lg">
                <button class="btn btn-default" data-toggle="layout" data-action="sidebar_toggle" type="button"> <i class="fa fa-navicon"></i> </button>
            </li>
            <li class="hidden-xs hidden-sm">
                <button class="btn btn-default" data-toggle="layout" data-action="sidebar_mini_toggle" type="button"> <i class="fa fa-ellipsis-v"></i> </button>
            </li>
            <li class="text-muted small">
            	<b class="text-warning"><?php if($log_school){echo $log_school;} else {echo app_name;} ?></b><br />
                <span class="hidden-xs">
					<?php echo $this->session->userdata('lps_user_othername').' <b>- '.$this->session->userdata('lps_user_role').'</b>'; ?>
                </span>
                <span class="xs-only hidden-lg hidden-md hidden-sm">
					<?php echo substr($this->session->userdata('lps_user_othername'),0,10).'... <b>- '.$this->session->userdata('lps_user_role').'</b>'; ?>
                </span>
            </li>
        </ul>
    </header>