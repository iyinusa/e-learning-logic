<html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <title></title>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width, minimum-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link rel="icon" href="<?php echo base_url(); ?>assets/img/favicon.png"  type="image/x-icon" id="favicon">

    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/simulator/lib/octicons/font/octicons.min.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/simulator/lib/ionicons/css/ionicons.min.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/simulator/lib/bootstrap/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/simulator/lib/prettify/src/prettify.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/simulator/assets/css/main.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/simulator/assets/css/depend.css" />

    <script>var base_url = '<?php echo base_url(); ?>';</script>
	
	<SCRIPT src="<?php echo base_url(); ?>assets/simulator/assets/javascript/dependencies.js"></SCRIPT>
    <SCRIPT src="<?php echo base_url(); ?>assets/simulator/lib/bootstrap/js/bootstrap.min.js"></SCRIPT>
    <script src="<?php echo base_url(); ?>assets/simulator/lib/prettify/src/prettify.js"></script>
    <SCRIPT src="<?php echo base_url(); ?>assets/simulator/assets/settings/backend.js"></SCRIPT>
    <SCRIPT src="<?php echo base_url(); ?>assets/simulator/assets/javascript/app.js"></SCRIPT>
    <script src="<?php echo base_url(); ?>assets/simulator/socket.io/socket.io.js"></script>

    <style>
        .x.axis line {
            shape-rendering: auto;
        }

        .line {
            fill: none;
            stroke: #000;
            stroke-width: 1px;
        }

    </style>
    <script type="text/javascript">
        var app = null;
        var socket = null;

        $(window).load(function () {
            $.getScript(conf.shapes.url+"index.js",function(){

                socket = io();
                app = new Application();
                $('.lazyload').lazyload({ trigger: "appear"});

                hardware.init(socket);
            });
        });
    </script>

</head>



<body>
<div id="layout">
        <ul class="nav nav-tabs" id="leftTabStrip">
            <li id="index_tab" class="active">
                <a href="#home" class="leftTab home"   data-toggle="tab">
                    <span class="ion-home"></span>
                </a>
            </li>

            <!--<li id="howto_tab">
                <a href="#howto" class="leftTab howto"  data-toggle="tab">
                    <span class="octicon octicon-info"></span>
                </a>
            </li>-->

            <!--<li id="files_tab" class="">
                <a href="#files" class="leftTab files"   data-toggle="tab">
                    <span class="ion-android-folder-open"></span>
                </a>
            </li>-->

            <li id="editor_tab">
                <a href="#editor" class="leftTab editor" data-toggle="tab">
                    <span class="octicon octicon-circuit-board"></span>
                </a>
            </li>

            <!--<li id="gitbook_tab">
                <a href="#gitbook" class="leftTab gitbook"  data-toggle="tab">
                    <span class="octicon octicon-book"></span>
                </a>
            </li>-->
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="home">
                <div class="row hidden-xs teaser">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="title">BrainBox Simulator</div>
                        <div class="slogan">
                        	Teach logic gates and digital circuits effectively.<br /><br >
                            Simulator built with simple drag and drop approach, all to do is drag GATE elements to PALLET and join their NODE's.<br />
                            <style>
								.start_simulate{display:block; text-decoration:none; padding:10px 0px; background-color:#0098E5; color:#fff; text-align:center;}
								.start_simulate:hover{text-decoration:none;}
							</style>
                            <a href="#editor" class="start_simulate" data-toggle="tab">Start Simulation</a>
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="title">DEMO <small>(click 1 in each)</small></div>
                        <div class="lazyload">
                            <script type="text/lazyload">
                                <div class="widget">
                                  <iframe src="<?php echo base_url(); ?>simulator/widget?circuit=<?php echo base_url(); ?>assets/simulator/assets/circuit/test.circuit" width="100%" height="200" frameBorder="0">
                                  </iframe>
                                  <div class="subtitle">Click on the switch to test the circuit  <span class="octicon octicon-clippy"></span></div>
                                </div>
                            </script>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="files">
                <div class="container">
                    <div class="row">
                        Login with Github to open/save files....

                        <span id="" class="editorLogin">
                            <div class="googleIcon">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 48 48" class="abcRioButtonSvg"><g><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path><path fill="none" d="M0 0h48v48H0z"></path></g></svg>
                            </div>
                            <div class="googleText">
                                Sign In
                            </div>
                        </span>

                    </div>
                </div>
            </div>

            <div class="tab-pane" id="editor">
                <div class="workspace">
                    <div class="palette ">
                        <span class="title">Design</span>
                        <input type="text" id="filter"  placeholder="Filter..." autofocus>
                        <div id="paletteElementsScroll">
                            <div id="paletteElements" class="row ">

                            </div>
                            <div id="paletteElementsOverlay"></div>
                        </div>
                    </div>
                    <div class="toolbar">
                        <!--<span class="group" id="editorgroup_login">
                            <span class="editorLogin">
                                <div class="googleIcon">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 48 48" class="abcRioButtonSvg"><g><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path><path fill="none" d="M0 0h48v48H0z"></path></g></svg>
                                </div>
                                <div class="googleText">
                                    Sign In
                                </div>
                            </span>
                        </span>-->

                        <span class="group" id="editorgroup_fileoperations">
                            <span id="editorFileOpen" class="ion-ios-download-outline icon" title="Open circuit"></span>
                            <span id="editorFileSave" class="ion-ios-upload-outline icon"   title="Save circuit"></span>
                        </span>

                        <span class="group">
                            <span id="editDelete" class="ion-ios-close-empty icon disabled"></span>
                        </span>

                        <span class="group">
                            <span id="editUndo" class="ion-ios-arrow-left icon disabled"></span>
                            <span id="editRedo" class="ion-ios-arrow-right icon disabled"></span>
                        </span>



                        <span class="group simulationBase" style="display: none;">
                            <label>Simulation Speed</label>
                            <input id="simulationBaseTimer"
                                   type="text"
                                   value="100"
                                   data-slider-min="50"
                                   data-slider-max="500"
                                   data-slider-step="1"
                                   data-slider-value="100"
                                   data-slider-handle="round"
                                   data-slider-tooltip="hide"
                                   data-slider-id="simulationBaseTimerSlider"
                                   data-slider-orientation="horizontal">
                        </span>

                        <span class="group raspiConnection">
                            Connection to RaspberryPi lost..
                        </span>

                        <a href="javascript:;" class="morph_btn play" id="simulationStartStop">
                            <span>
                              <span class="s1"></span>
                              <span class="s2"></span>
                              <span class="s3"></span>
                            </span>
                        </a>

                    </div>
                    <div class="content" id="draw2dCanvasWrapper">
                        <div class="canvas" id="draw2dCanvas" oncontextmenu="return false;">
                        </div>
                        <div id="canvas_zoom" class="btn-group">
                            <button type="button" id="canvas_zoom_in"     class="btn highlight">&#8210;</button>
                            <button type="button" id="canvas_zoom_normal" class="btn highlight">100%</button>
                            <button type="button" id="canvas_zoom_out"    class="btn highlight">&#xFF0B</button>
                        </div>
                    </div>
                    <div id='probe_window'>
                        <div id="probe_window_stick" class="ion-ios-eye-outline" title="Stick Window"></div>
                        <div id="probe_hint"><span class="ion-ios-information-outline"></span>Simulation running...</div>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="gitbook">
                <iframe src="./assets/help/basics/index.html" style="width:100%; height:100%" marginwidth="0"  marginheight="0" frameBorder="0">
                </iframe>
            </div>

            <div class="tab-pane" id="howto">
                <iframe src="./assets/help/howto/index.html" style="width:100%; height:100%" marginwidth="0"  marginheight="0" frameBorder="0">
                </iframe>
            </div>

        </div><!-- /tab-content -->

</div><!-- /container -->

<script id="shapeTemplate" type="text/x-jsrender">
{{for shapes}}
    <div  data-name='{{:name}}' class="mix col-md-6 pallette_item">
    <div class="glow">
        <img data-shape="{{:name}}" class="draw2d_droppable" src="{{:~root.shapesUrl}}{{:name}}.png">
        <div>{{:basename}}</div>
        </div>
    </div>
{{/for}}
</script>


<!--
  # Save Dialog
  #
  #
-->
<div id="githubSaveFileDialog" class="modal fade githubFileDialog" tabindex="-1">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="media-heading">Save your circuit</h4>
            </div>
            <div class="modal-body">
                <div class="media">
                    <div class="media-left media-middle">
                        <a href="#">
                            <div class="media-object githubFilePreview ion-ios-upload-outline" ></div>
                        </a>
                    </div>
                    <div class="media-body">


                            <br>
                            <br>
                            <fieldset>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <input type="text"
                                               class="form-control floating-label githubFileName"
                                               value=""
                                                >
                                    </div>
                                </div>
                            </fieldset>
                            <div class="row"></div>


                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal">Abort</button>
                <button class="btn btn-primary okButton"><span>Save</span></button>
            </div>
        </div>
    </div>
</div>

<!--
  # Save Dialog
  #
  #
-->
<div id="githubNewFileDialog" class="modal fade githubFileDialog" tabindex="-1">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="media-heading">Enter File Name</h4>
            </div>
            <div class="modal-body">
                <div class="media">
                    <div class="media-left media-middle">
                        <a href="#">
                            <div class="media-object githubFilePreview ion-ios-plus-outline" ></div>
                        </a>
                    </div>
                    <div class="media-body">


                        <br>
                        <br>
                        <fieldset>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <input type="text"
                                           class="form-control floating-label githubFileName"
                                           value=""
                                    >
                                </div>
                            </div>
                        </fieldset>
                        <div class="row"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal">Abort</button>
                <button class="btn btn-primary okButton"><span>Create</span></button>
            </div>
        </div>
    </div>
</div>

<!--
  # GitHub File select/open dialog
  #
  -->
<div id="githubFileSelectDialog" class="modal fade githubFileDialog" tabindex="-1">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="media-heading">File Open...</h4>
            </div>
            <div class="modal-body">


                <div class="list-group githubNavigation">
                    <!-- FileList here -->
                </div>


            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal">Abort</button>
                <button class="btn btn-primary okButton"><span>Open</span></button>
            </div>
        </div>
    </div>
</div>


<!--
  # FileSaveAs Dialog
  #
  -->
<div id="githubFileSaveAsDialog" class="modal fade githubFileDialog" tabindex="-1">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="media-heading">Save on GitHub</h4>
            </div>
            <div class="modal-body">

                <div class="list-group githubNavigation">
                    <!-- FileList here -->
                </div>


                <div class="media">
                    <div class="media-left media-middle">
                        <a href="#">
                            <img class="media-object githubFilePreview" src="assets/images/octocat.svg">
                        </a>
                    </div>
                    <div class="media-body">

                        <form class="form-horizontal">
                            <br>
                            <br>
                            <fieldset>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <input type="text"
                                               class="form-control floating-label githubFileName"
                                               value=""
                                               placeholder="enter filename"
                                                >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <input type="text"
                                               class="form-control floating-label githubCommitMessage"
                                               value=""
                                               autofocus
                                               placeholder="commit message"
                                                >
                                    </div>
                                </div>
                            </fieldset>
                            <div class="row"></div>

                        </form>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn" data-dismiss="modal">Abort</button>
                <button class="btn btn-primary okButton"><span>Save</span></button>
            </div>
        </div>
    </div>
</div>


<!--
  Dialog with behaviour code preview of the shapes
 -->
<div id="codePreviewDialog" class="modal fade" tabindex="-1">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="media-heading">Shape Behaviour Code</h4>
            </div>
            <div class="modal-body">
                <pre class="prettyprint">

                </pre>
            </div>
            <div class="modal-footer">
                <button class="btn  btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!--
  Help file of a single shape element
 -->
<div id="markdownDialog" class="modal fade" tabindex="-1">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="media-heading">Shape Documentation</h4>
            </div>
            <div class="modal-body">
                <div class="html">

                </div>
            </div>
            <div class="modal-footer">
                <button class="btn  btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div id="figureConfigDialog">
    Please configure me
</div>

</body>
</html>
