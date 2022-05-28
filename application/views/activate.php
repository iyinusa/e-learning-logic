<div class="content overflow-hidden">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 ">
            <div class="block block-themed animated fadeIn">
                <div class="block-header bg-primary">
                    <ul class="block-options">
                        <li> <a href="<?php echo base_url('login'); ?>" data-toggle="tooltip" data-placement="left" title="Log In"><i class="si si-login"></i></a> </li>
                    </ul>
                    <h3 class="block-title">Activate Account</h3>
                </div>
                
                <?php echo form_open_multipart($link, array('class'=>'js-validation-login form-horizontal')); ?>
                <div class="block-content block-content-full block-content-narrow">
                    <div class="font-w600 text-center"><img alt="" src="<?php echo base_url('assets/img/logo.png'); ?>" style="height:70px; max-width:80%;" /></div>
                    <p class="text-center">Please fill the following details to create a new account.<hr /></p>
                    
                    <?php if(!empty($payment)){ ?>
                    	<?php if(!empty($pay_msg)){ ?>
                            <div class="text-center">
								<?php echo $pay_msg; ?><br /><br />
                            </div>
                    	<?php } else {  ?>
                        	<div>
                                <fieldset>
                                    <legend>Finally!</legend>
                                    <div class="text-center">
                                        <h3>You need to Activate your Account for full access.</h3><br />
                                        <h1>&#8358; <?php echo number_format((float)$price); ?></h1>
                                        <img alt="" src="<?php echo base_url('assets/img/pay.png'); ?>" style="max-width:45%;" /><br />
                                         <a href="javascript:;" onClick="pay();" class="btn btn-lg btn-success"><i class="fa fa-shopping-cart"></i> Pay Now</a>
                                     </div>
                                </fieldset>
                            </div>
                        <?php }  ?>
                    <?php }  ?>
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


<?php if($rave_server == 'live'){ ?>
<script type="text/javascript" src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
<?php } else { ?>
<script type="text/javascript" src="http://flw-pms-dev.eu-west-1.elasticbeanstalk.com/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
<?php } ?> 
<script>
	function pay() {
		var flw_ref = "", chargeResponse = "";
		<?php echo $rave_pay; ?>
	}
</script>