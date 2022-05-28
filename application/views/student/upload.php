<div style="background-image: url('<?php echo base_url('assets/img/skills-bg.jpg'); ?>'); background-size:cover; background-attachment:fixed">
<main id="main-container" style="background: rgba(255, 255, 255, 0.8);">
    <div class="content bg-gray-lighter">
        <div class="row items-push">
            <div class="col-sm-7">
                <h1 class="page-heading"> Matrics </h1>
            </div>
            <div class="col-sm-5 text-right hidden-xs">
                <ol class="breadcrumb push-10-t">
                    <li>Dashboard</li>
                    <li>Student</li>
                    <li><a class="link-effect" href="<?php echo base_url('students/upload'); ?>">Matrics</a></li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content content-narrow">
        <div class="block">
            <div class="block-header bg-gray-lighter">
                <ul class="block-options">
                    <li>
                        <button type="button" data-toggle="block-option" data-action="content_toggle"></button>
                    </li>
                </ul>
                <h3 class="block-title">Upload Matrics</h3>
            </div>
          	
            <div class="block-content">
            	<div class="row">
                    <div class="col-xs-12">
                        <?php if(!empty($err_msg)){echo $err_msg;} ?>
                        
                        <?php echo form_open_multipart('students/upload/manage', array('class'=>'form-horizontal')); ?>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material">
                                        <select id="sess_id" name="sess_id" class="js-select2 form-control select2-hidden-accessible" style="width: 100%;" data-placeholder="Choose one.." tabindex="-1" aria-hidden="true" required>
                                            <option value="">Select...</option>
                                            <?php $session = $this->Crud->read('lp_session'); foreach($session as $sess): ?>
                                            <option value="<?php echo $sess->id; ?>"> <?php echo $sess->name; ?> </option>
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
                                            <option value="<?php echo $prog->id; ?>"> <?php echo $prog->name; ?> </option>
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
                                            <option value="<?php echo $level->id; ?>"> <?php echo $level->name; ?> </option>
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
                                            <option value="<?php echo $dept->id; ?>"> <?php echo $dept->name; ?> </option>
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
                                        <input type="file" name="import" class="form-control" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="col-xs-12 text-center">
                                    <div class="form-material">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-list"></i> Import Matrics</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="block">
            <div class="block-header">
                <h3 class="block-title">
                	Matrics
                </h3>
            </div>
            <div class="block-content">
                <div class="">
                    <table id="dtable" class="table table-striped table-bordered responsive small">
                        <thead>
                            <tr>
                                <th>School</th>
                                <th>Lecturer</th>
                                <th>Section</th>
                                <th>Level</th>
                                <th>Matric</th>
                                <th width="120px"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
</div>