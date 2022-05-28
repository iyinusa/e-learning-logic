<div style="background-image: url('<?php echo base_url('assets/img/skills-bg.jpg'); ?>'); background-size:cover; background-attachment:fixed">
<main id="main-container" style="background: rgba(255, 255, 255, 0.8);">
    <div class="content bg-gray-lighter">
        <div class="row items-push">
            <div class="col-sm-7">
                <h1 class="page-heading"> Institution </h1>
            </div>
            <div class="col-sm-5 text-right hidden-xs">
                <ol class="breadcrumb push-10-t">
                    <li>Dashboard</li>
                    <li>Setup</li>
                    <li><a class="link-effect" href="<?php echo base_url('setup/institution'); ?>">Institution</a></li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content content-narrow">
        <div class="block">
            <div class="block-header">
                <h3 class="block-title">
                	Institution
                    <span class="pull-right"> 
                        <a href="javascript:;" class="btn btn-default btn-sm pop" pageTitle="Add Institution" pageName="<?php echo base_url('setup/institution/manage'); ?>">
                            <i class="fa fa-plus-circle"></i> Add
                        </a>
                    </span>
                </h3>
            </div>
            <div class="block-content">
                <div class="">
                    <table id="dtable" class="table table-striped table-bordered responsive small">
                        <thead>
                            <tr>
                                <th>Institution</th>
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