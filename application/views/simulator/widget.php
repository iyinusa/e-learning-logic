<html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <SCRIPT src="<?php echo base_url(); ?>assets/simulator/assets/settings/backend.js"></SCRIPT>
        <SCRIPT src="<?php echo base_url(); ?>assets/simulator/assets/javascript/widget.js"></SCRIPT>

        <script>
        var widget=null;
        $(window).load(function () {
            $.getScript(conf.shapes.url+"index.js",function() {
                widget = new Widget();
            });
        });
        </script>

    </head>

    <body style="overflow:hidden;margin:0px; padding:0px;">
        <div class="content" id="draw2dCanvasWrapper" style="overflow:hidden;width:100%;height:100%">
            <div class="canvas" id="draw2dCanvas" oncontextmenu="return false;" style="width:100%;height:100%">
            </div>
        </div>
    </body>

</html>
