<div class="content overflow-hidden">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 ">
            <div class="block block-themed animated fadeIn">
                <div class="block-header bg-primary">
                    <ul class="block-options">
                        <li> <a href="javascript:;" data-toggle="modal" data-target="#modal-terms">Terms</a> </li>
                        <li> <a href="<?php echo base_url('login'); ?>" data-toggle="tooltip" data-placement="left" title="Log In"><i class="si si-login"></i></a> </li>
                    </ul>
                    <h3 class="block-title">Register</h3>
                </div>
                
                <?php echo form_open_multipart($link, array('class'=>'js-validation-login form-horizontal')); ?>
                <div class="block-content block-content-full block-content-narrow">
                    <div class="font-w600 text-center"><img alt="" src="<?php echo base_url('assets/img/logo.png'); ?>" style="height:70px; max-width:80%;" /></div>
                    <p class="text-center">Please fill the following details to create a new account.<hr /></p>
                    
                    <div class="row"><div class="col-xs-12"><?php if(!empty($err_msg)){echo $err_msg;} ?></div></div>
                    
                    <?php if(empty($matric)){ ?>
                    
                    <div class="text-center">
                        <div class="form-group">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <div class="form-material">
                                    <input class="form-control input-lg text-center" type="text" id="matric" name="matric" placeholder="Matric Number" value="<?php echo set_value('matric'); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-xs-12">
                                <button class="btn btn-lg btn-primary">Proceed <i class="si si-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                    
                    <?php } else { ?>
                    
                    <div>
                    	<fieldset>
                        	<legend>Almost there!</legend>
                            <div class="col-sm-6">
                            	<b class="text-muted small">SCHOOL:</b><br />
                                <b><?php echo $school; ?></b>
                            </div>
                            
                            <div class="col-sm-6">
                            	<b class="text-muted small">SESSION:</b><br />
                                <b><?php echo $session; ?> <?php echo $programme; ?></b>
                            </div>
                            
                            <div class="col-sm-6">
                            	<b class="text-muted small"><br />DEPARTMENT:</b><br />
                                <b><?php echo $level; ?> <?php echo $department; ?></b>
                            </div>
                            
                            <div class="col-sm-6">
                            	<b class="text-muted small"><br />LECTURER:</b><br />
                                <b><?php echo $lecturer; ?></b>
                            </div>
                            
                            <div class="col-sm-12"><hr /></div>
                            
                            <div class="col-sm-6">
                            	<div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material">
                                            <input class="form-control" type="text" name="firstname" placeholder="First Name" value="<?php echo set_value('firstname'); ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-6">
                            	<div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material">
                                            <input class="form-control" type="text" name="middlename" placeholder="Middle Name" value="<?php echo set_value('middlename'); ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-8">
                            	<div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material">
                                            <input class="form-control" type="text" name="lastname" placeholder="Surname" value="<?php echo set_value('lastname'); ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-4">
                            	<div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material">
                                            <select name="sex" class="js-select2 form-control select2-hidden-accessible" style="width: 100%;" data-placeholder="Choose one.." tabindex="-1" aria-hidden="true" required>
                                                <option value="">Gender...</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-4">
                            	<div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material">
                                            <input class="form-control" type="text" name="phone" placeholder="Phone" value="<?php echo set_value('phone'); ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-4">
                            	<div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material">
                                            <input class="form-control" type="email" name="email" placeholder="Email" value="<?php echo set_value('email'); ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-4">
                            	<div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material">
                                            <input class="form-control" type="password" name="password" placeholder="Password">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xs-12 text-center">
                            	<div class="form-group">
                                    <div class="col-xs-12">
                                        <button class="btn btn-lg btn-primary"><i class="si si-user-follow"></i> Register</button>
                                    </div>
                                </div>
                            </div>
                       	</fieldset>
                    </div>
                	
                    <?php } ?>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-terms" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout">
        <div class="modal-content">
            <div class="block block-themed block-transparent remove-margin-b">
                <div class="block-header bg-primary-dark">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Terms &amp; Conditions</h3>
                </div>
                <div class="block-content">
                    Coming soon...
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-sm btn-primary" type="button" data-dismiss="modal"><i class="fa fa-check"></i> I agree</button>
            </div>
        </div>
    </div>
</div>