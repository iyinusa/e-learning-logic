<?php echo form_open_multipart('students/upload/'.$param1.'/'.$param2.'/'.$param3, array('id'=>'bb_ajax_form', 'class'=>'form-horizontal')); ?>
<div class="row">
    <div id="bb_ajax_msg"></div>
    
    <?php if($param2 == 'delete') { // delete view ?>
        <div class="col-xs-12 text-center">
            <h3><b>Are you sure?</b></h3>
            <input type="hidden" name="d_matric_id" value="<?php if(!empty($d_id)){echo $d_id;} ?>" />
        </div>
        <div class="form-group text-center m-t-40">
            <div class="col-xs-12">
                <button class="btn btn-danger text-uppercase" type="submit">
                    <span class="btn-label"><i class="fa fa-trash-o"></i></span> Yes - Delete
                </button>
            </div>
        </div>
    <?php } else { // insert/edit view ?>
        <input type="hidden" name="matric_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />
        
        <div class="col-sm-4">
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="form-material">
                        <select id="sess_id" name="sess_id" class="js-select2 form-control select2-hidden-accessible" style="width: 100%;" data-placeholder="Choose one.." tabindex="-1" aria-hidden="true" required>
                            <option value="">Select...</option>
                            <?php $session = $this->Crud->read('lp_session'); foreach($session as $sess): ?>
                            <option value="<?php echo $sess->id; ?>" <?php if(!empty($e_sess_id)){if($e_sess_id == $sess->id){echo 'selected';}} ?>> <?php echo $sess->name; ?> </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="sess_id">Session</label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-sm-4">
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="form-material">
                        <select id="prog_id" name="prog_id" class="js-select2 form-control select2-hidden-accessible" style="width: 100%;" data-placeholder="Choose one.." tabindex="-1" aria-hidden="true" required>
                            <option value="">Select...</option>
                            <?php foreach($allprogramme as $prog): ?>
                            <option value="<?php echo $prog->id; ?>" <?php if(!empty($e_prog_id)){if($e_prog_id == $prog->id){echo 'selected';}} ?>> <?php echo $prog->name; ?> </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="prog_id">Programme</label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-sm-4">
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="form-material">
                        <select id="level_id" name="level_id" class="js-select2 form-control select2-hidden-accessible" style="width: 100%;" data-placeholder="Choose one.." tabindex="-1" aria-hidden="true" required>
                            <option value="">Select...</option>
                            <?php foreach($alllevel as $level): ?>
                            <option value="<?php echo $level->id; ?>" <?php if(!empty($e_level_id)){if($e_level_id == $level->id){echo 'selected';}} ?>> <?php echo $level->name; ?> </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="level_id">Level</label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-sm-6">
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="form-material">
                        <select id="dept_id" name="dept_id" class="js-select2 form-control select2-hidden-accessible" style="width: 100%;" data-placeholder="Choose one.." tabindex="-1" aria-hidden="true" required>
                            <option value="">Select...</option>
                            <?php foreach($alldept as $dept): ?>
                            <option value="<?php echo $dept->id; ?>" <?php if(!empty($e_dept_id)){if($e_dept_id == $dept->id){echo 'selected';}} ?>> <?php echo $dept->name; ?> </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="dept_id">Department</label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-sm-6">
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="form-material">
                        <input type="text" name="matric" class="form-control" value="<?php if(!empty($e_matric)){echo $e_matric;} ?>" required />
                    </div>
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