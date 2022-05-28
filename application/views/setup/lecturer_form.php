<?php echo form_open_multipart('setup/lecturer/'.$param1.'/'.$param2.'/'.$param3, array('id'=>'bb_ajax_form', 'class'=>'form-horizontal')); ?>
<div class="row">
    <div id="bb_ajax_msg"></div>
    
    <?php if($param2 == 'delete') { // delete view ?>
        <div class="col-xs-12 text-center">
            <h3><b>Are you sure?</b></h3>
            <input type="hidden" name="d_lecturer_id" value="<?php if(!empty($d_id)){echo $d_id;} ?>" />
        </div>
        <div class="form-group text-center m-t-40">
            <div class="col-xs-12">
                <button class="btn btn-danger text-uppercase" type="submit">
                    <span class="btn-label"><i class="fa fa-trash-o"></i></span> Yes - Delete
                </button>
            </div>
        </div>
    <?php } else { // insert/edit view ?>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="form-material">
                        <select name="school_id" class="js-select2 form-control select2-hidden-accessible" style="width: 100%;" data-placeholder="Choose one.." tabindex="-1" aria-hidden="true" required>
                            <option value="">Select...</option>
                            <?php $schools = $this->Crud->read('lp_school'); foreach($schools as $sch): ?>
                            <option value="<?php echo $sch->id; ?>" <?php if(!empty($e_school_id)){if($e_school_id == $sch->id){echo 'selected';}} ?>> <?php echo $sch->name; ?> </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="school_id">Institution</label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-sm-4">
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="form-material">
                        <input type="hidden" name="lecturer_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />
                        <input class="form-control" type="text" id="firstname" name="firstname" value="<?php if(!empty($e_firstname)){echo $e_firstname;} ?>" required>
                        <label for="firstname">Firstname</label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-sm-4">
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="form-material">
                        <input class="form-control" type="text" id="lastname" name="lastname" value="<?php if(!empty($e_lastname)){echo $e_lastname;} ?>" required>
                        <label for="lastname">Lastname</label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-sm-6">
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="form-material">
                        <input class="form-control" type="text" id="email" name="email" value="<?php if(!empty($e_email)){echo $e_email;} ?>" <?php if(!empty($e_email)){echo 'readonly';} ?> required>
                        <label for="email">Email</label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-sm-6">
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="form-material">
                        <input class="form-control" type="text" id="phone" name="phone" value="<?php if(!empty($e_phone)){echo $e_phone;} ?>">
                        <label for="phone">Phone</label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-sm-5">
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="form-material">
                        <input class="form-control" type="text" id="username" name="username" value="<?php if(!empty($e_username)){echo $e_username;} else {echo substr(md5(rand()),0,6);} ?>" <?php if(!empty($e_username)){echo 'readonly';} ?> required>
                        <label for="username">Username</label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-sm-5">
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="form-material">
                        <input class="form-control" type="text" id="password" name="password" value="<?php if(empty($e_username)){echo substr(md5(rand()),0,6);} ?>" <?php if(empty($e_username)){echo 'required';} ?>>
                        <label for="password">Password</label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-sm-2">
            <div class="form-group">
                <div class="col-xs-12">
                    <label class="css-input switch switch-sm switch-primary">
                        <input name="ban" type="checkbox" <?php if(!empty($e_ban)){if($e_ban!=0){echo 'checked';}} ?>><span></span> Ban
                    </label>
                </div>
            </div>
        </div>
        
        <div class="form-group text-center m-t-40">
            <div class="col-xs-12">
                <button class="btn btn-success btn-rounded text-uppercase" type="submit">
                    <span class="btn-label"><i class="fa fa-save"></i></span> Save
                </button>
            </div>
        </div>
    <?php } ?>
</div>
<?php echo form_close(); ?>

<script src="<?php echo base_url(); ?>assets/js/jsform.js"></script>
<script>jQuery(function(){App.initHelpers(['datepicker', 'datetimepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs']);});</script>