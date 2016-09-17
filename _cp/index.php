<?php 
	include("require/session.inc.php");
	include("require/connection.inc.php")
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="msapplication-TileColor" content="#5bc0de"/>
        <meta name="msapplication-TileImage" content="assets/img/metis-tile.png"/>
        <link rel="stylesheet" href="assets/lib/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="assets/css/main.css"/>
        <link rel="stylesheet" href="assets/lib/Font-Awesome/css/font-awesome.css"/>
        <link rel="stylesheet" href="assets/css/theme.css">
        <link rel="stylesheet" href="assets/lib/fullcalendar-1.6.2/fullcalendar/fullcalendar.css">
        <link rel="stylesheet" type="text/css" href="assets/css/custom.css"/>
     <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-1669764-16', 'onokumus.com');
  ga('send', 'pageview');
</script>
<script src="assets/lib/modernizr-build.min.js"></script>
<title>Admin C-Panel</title>
</head>

<body>
<div id="wrap">
    <div id="top">
        <!-- .navbar -->
    <nav class="navbar navbar-inverse navbar-static-top">
    <header class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
	<span class="sr-only">Toggle navigation</span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
      </button>
      <a href="../_cp/" class="navbar-brand"><img src="assets/img/logo.png" alt=""></a>
  </header>
    

    <div class="topnav">

        <div class="btn-toolbar">
           <div class="btn-group">
                <a href="../_login/Logout.php" data-toggle="tooltip" data-original-title="Logout" data-placement="bottom" class="btn btn-metis-1 btn-sm">
		  <i class="fa fa-power-off"></i>
                </a>
            </div>
        </div>

    </div>

</nav>
<!-- /.navbar -->

                <!-- header.head -->
                <header class="head">
                    <div class="search-bar">
                        <a data-original-title="Show/Hide Menu" data-placement="bottom" data-tooltip="tooltip" class="accordion-toggle btn btn-primary btn-sm visible-xs" data-toggle="collapse" href="#menu" id="menu-toggle">
                            <i class="fa fa-resize-full"></i>
                        </a>
                    </div>
                    <!-- ."main-bar -->
                    <div class="main-bar">
                        <h3><i class="fa fa-home"></i> Home</h3>
                    </div>
                    <!-- /.main-bar -->
                </header>
                <!-- end header.head -->


            </div>
            <!-- /#top -->

<!-- #menu -->
<?php
include_once("leftframe.inc.php");
?>
<!-- /#menu -->

            <!-- /#left -->

            <div id="content">
                <div class="outer">
                  <div class="inner" style="min-height: 550px;">
                    <div class="row">
                     <div class="col-lg-12">
                    <div class="box">
                      <div class="col-lg-4">
                      
                      <div class="box">
                          <header class="dark">
                            <div class="icons"><i class="fa fa-envelope fa-2x"></i></div>
                            <h5>Messages
                            	
                            </h5>
                          </header>
                          <div class="body row">
                             
                              <div class="form-group">
                                <label class="control-label col-lg-9">Total Messages sent for today</label><div class="col-lg-3">
                                0
                                 
                                </div>
                                
                                <label class="control-label col-lg-9">Total Failed Messages</label><div class="col-lg-3">
                                0
                                 
                                </div>
                                
                                <div class="form-group">
                                <div class="col-lg-4">
                                </div>
                                <div class="col-lg-4">
                                <a href="" class="btn btn-sm btn-default btn-block  btn-grad">Message List</a>
                                </div>
                                
                                <div class="col-lg-4">
                                <a href="" class="btn btn-sm btn-default btn-block btn-grad">Send New</a>
                                </div>
                                
                              </div>
                              
                            
                           
                          </div>
                        </div>
                      
                      </div>
                      
                    </div>
                    
                    
                    
                    
                    
                    <div class="col-lg-4">
                      
                      <div class="box">
                          <header class="dark">
                            <div class="icons"><i class="fa fa-envelope fa-2x"></i></div>
                            <h5>Contacts
                            	
                            </h5>
                          </header>
                          <div class="body row">
                             
                              <div class="form-group">
                                <label class="control-label col-lg-9">Total Mails received today</label><div class="col-lg-3">
                                0
                                 
                                </div>
                                <label class="control-label col-lg-9">Total Mails replied </label><div class="col-lg-3">
                                0
                                 
                                </div>
                                <div class="form-group">
                                <div class="col-lg-4">
                                </div>
                                <div class="col-lg-4">
                                <a href="" class="btn btn-sm btn-default btn-block  btn-grad">Message List</a>
                                </div>
                                
                                <div class="col-lg-4">
                                <a href="" class="btn btn-sm btn-default btn-block btn-grad">Send New</a>
                                </div>
                                
                              </div>
                              
                            
                           
                          </div>
                        </div>
                      
                      </div>
                      
                    </div>
                    
                    
                    
                    
                    
                    
                    <div class="col-lg-4">
                      
                      <div class="box">
                          <header class="dark">
                            <div class="icons"><i class="fa fa-user fa-2x"></i></div>
                            <h5>Members
                            	
                            </h5>
                          </header>
                          <div class="body row">
                             
                              <div class="form-group">
                                <label class="control-label col-lg-9">New Joinings<div class="col-lg-3">
                                0
                                 
                                </div>
                                <label class="control-label col-lg-9">Total Members<div class="col-lg-3">
                                0
                                 
                                </div>
                             </div>   
                                <div class="form-group">
                                <div class="col-lg-4">
                                </div>
                                <div class="col-lg-4">
                                <a href="" class="btn btn-sm btn-default btn-block  btn-grad">User List</a>
                                </div>
                                
                                <div class="col-lg-4">
                                <a href="" class="btn btn-sm btn-default btn-block btn-grad">Register</a>
                                </div>
                                
                              </div>
                              
                            
                           
                          </div>
                        </div>
                      
                      </div>
                      
                    </div>
                    
                    </div>
                      </div>
                    </div>
                  </div>
                  <!-- end .inner -->
                </div>
                <!-- end .outer -->
            </div>
            <!-- end #content -->

            

        </div>
        <!-- /#wrap -->


        <div id="footer">
            <p>&nbsp;</p>
        </div>


        <!-- #helpModal -->        
      ]

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="assets/lib/jquery.min.js"><\/script>')</script> 




        <script src="assets/lib/bootstrap/js/bootstrap.js"></script>





        
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        

        
        <script src="assets/lib/fullcalendar-1.6.2/fullcalendar/fullcalendar.min.js"></script>
		<script src="assets/lib/tablesorter/js/jquery.tablesorter.min.js"></script>
        <script src="assets/lib/sparkline/jquery.sparkline.min.js"></script>
        <script src="assets/lib/flot/jquery.flot.js"></script>
        <script src="assets/lib/flot/jquery.flot.selection.js"></script>
        <script src="assets/lib/flot/jquery.flot.resize.js"></script>
                

        <script src="assets/js/main.js"></script>

        
        <script>
            $(function() { dashboard(); });
        </script>
        


</body>
</html>