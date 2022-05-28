<div class="bg-white pulldown" style="background: rgba(255, 255, 255, 0.85);">
    <div class="content content-boxed overflow-hidden">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                <div class="push-30-t push-50 animated fadeIn">
                    <div class="text-center"> <img alt="<?php echo app_name; ?>" src="<?php echo base_url('assets/img/favicons/apple-touch-icon-57x57.png'); ?>" />
                        <p class="text-muted push-15-t">
                            <?php if(!empty($err_msg)){echo $err_msg;} else {echo app_meta_desc;} ?>
                        </p>
                    </div>
                    <?php echo form_open_multipart('forgot', array('class'=>'js-validation-reminder form-horizontal push-30-t')); ?>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material form-material-primary floating">
                                    <input class="form-control" type="email" id="reminder-email" name="reminder-email">
                                    <label for="reminder-email">Enter Your Email</label>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="font-s13 text-right push-8-t"> <a href="<?php echo base_url('login'); ?>">Login</a> </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                                <button class="btn btn-sm btn-block btn-primary" type="submit"><i class="fa fa-key"></i> Reset Password</button>
                            </div>
                        </div>
                    <?php echo form_close(); ?> </div>
            </div>
        </div>
    </div>
</div>
