<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<style>
	#m_wrap{background-color:#eee; color:#666; padding:20px; font-family:"Palatino Linotype", "Book Antiqua", Palatino, serif}
	#m_box{width:85%; margin:auto; background-color:#fff; border-radius:15px; padding:20px;}
	#m_box .mlogo{padding:20px 0px; border-bottom:2px solid #ddd; text-align:center; margin-bottom:15px;}
	#m_box .mlogo a{text-decoration:none; outline:none; border:none;}
	#m_box .mhead{font-size:28px; border-bottom:2px solid #ddd; padding-bottom:20px; margin-bottom:15px;}
	#m_box .mcontent{font-size:18px;}
	#m_box .mcontent .mname{font-size:26px; font-weight:bold;}
	.mfooter{text-align:center; font-size:12px; margin-top:15px;}
	.mbtn{padding:10px 0px; margin:15px 0px;}
	.mbtn a{text-decoration:none; outline:none; color:#fff; font-weight:bold; background-color:#9CF; padding:15px 30px; border-radius:10px;}
</style>
</head>

<body>
	<div id="m_wrap"> 
        <div id="m_box">
            <div class="mlogo">
                <img alt="<?php echo app_name; ?>" src="<?php echo base_url(); ?>assets/img/tbd_logo.png" style="max-width:100%;" />
            </div>
            
            <div class="mhead">
                <?php echo $subhead; ?>
            </div>
            
            <div class="mcontent">
                <?php echo $message; ?>
            </div>
        </div>
        
        <div class="mfooter">
            <b><?php echo app_name; ?> Team</b><br />
            &copy;<?php echo date('Y'); ?> - All right reserved. Tehilah Base Digital
        </div>
    </div>
</body>
</html>