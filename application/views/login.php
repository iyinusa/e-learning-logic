<div class="content overflow-hidden">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
            <div class="block block-themed animated fadeIn">
                <div class="block-header bg-primary">
                    <ul class="block-options">
                        <li> <a href="<?php echo base_url('forgot'); ?>">Forgot Password?</a> </li>
                        <li> <a href="<?php echo base_url('register'); ?>" data-toggle="tooltip" data-placement="left" title="New Account"><i class="si si-plus"></i></a> </li>
                    </ul>
                    <h3 class="block-title">Login</h3>
                </div>
                
                <?php echo form_open_multipart('login', array('class'=>'js-validation-login form-horizontal push-30-t push-50')); ?>
                <div class="block-content block-content-full block-content-narrow">
                    <div class="font-w600 text-center"><img alt="" src="<?php echo base_url('assets/img/logo.png'); ?>" style="max-width:80%;" /></div>
                    <p class="text-center">Welcome, please login.</p>
                    
                    <?php if(!empty($err_msg)){echo $err_msg;} ?>
                    
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material form-material-primary floating">
                                <input class="form-control" type="text" id="username" name="username" value="<?php echo set_value('username'); ?>">
                                <label for="username">Username/Code</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material form-material-primary floating">
                                <input class="form-control" type="password" id="password" name="password">
                                <label for="password">Password</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <label class="css-input switch switch-sm switch-primary">
                                <input type="checkbox" id="remember-me" name="remember-me">
                                <span></span> Remember Me? </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <button class="btn btn-block btn-primary" type="submit"><i class="si si-login pull-right"></i> Log in</button>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
