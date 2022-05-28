    <div class="push-10-t text-center animated fadeInUp">
        <small class="text-muted font-w600">Copyright &copy; <?php echo date('Y').' - '.app_name; ?></small>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/main.min-2.2.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/jquery-validation/jquery.validate.min.js"></script> 

<?php if($page_active == 'login'){ ?>
<script src="<?php echo base_url(); ?>assets/js/pages/base_pages_login.js"></script>
<?php } ?>

<?php if($page_active == 'forgot'){ ?>
<script src="<?php echo base_url(); ?>assets/js/pages/base_pages_reminder.js"></script>
<?php } ?>
</body>
</html>