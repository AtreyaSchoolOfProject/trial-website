<?php
ob_start();
session_start();
include("../require/session.inc.php");
include("../require/connection.inc.php");
include("../require/functions.inc.php");
include("../require/timezone.inc.php");
include("../require/common.inc.php");
include("../require/validate-user.inc.php");
// All Query Strings Fetched Here. 

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin C-Panel</title>
        
        <link rel="stylesheet" href="../assets/lib/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="../assets/css/main.css"/>
        <link rel="stylesheet" href="../assets/lib/Font-Awesome/css/font-awesome.css"/>

        <link rel="stylesheet" href="../assets/css/theme.css">

        
        <link rel="stylesheet" href="../assets/lib/fullcalendar-1.6.2/fullcalendar/fullcalendar.css">
        
        
        <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-1669764-16', 'onokumus.com');
  ga('send', 'pageview');

</script>

<script src="../assets/lib/modernizr-build.min.js"></script>
        
</head>

<body>




        <div id="wrap">


            <div id="top">
                <!-- .navbar -->
<nav class="navbar navbar-inverse navbar-static-top">
    <!-- Brand and toggle get grouped for better mobile display -->
	<?php
		include("../require/notifications.inc.php");
	?>






    <!-- /.topnav -->
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
                        <h3><i class="fa fa-envelope"></i> Sent Message(s) </h3>
                  </div>
                    <!-- /.main-bar -->
            </header>
                <!-- end header.head -->


            </div>
            <!-- /#top -->
            <?php
				include("../require/leftframe.inc.php");
			?>
            <!-- /#left -->
          <div id="content">
                <div class="outer">
                  <div class="inner">
                    <div class="row">
                      <form id="form1" name="form1" method="post" action="">
                        <div class="col-lg-12">
                          <div class="box">
                            <header class="dark">
                              <div class="icons"><i class="fa  fa fa-file-text-o fa-2x"></i></div>
                              <h5>Message List</h5>
                            </header>
                            <div style="height: auto;" id="stripedTable" class="body in">
                              <hr />
                              <table border="0" cellpadding="5" cellspacing="0" class="table table-striped responsive-table col-lg-12">
                                <tr>
                                  <th width="16%">Message Id</th>
                                  <th width="64%">Message</th>
                                  <th width="10%">Sent On</th>
                                  <th width="10%">&nbsp;</th>
                                </tr>
                                
                                <?php
						$lower = (isset($_GET['lower'])) ? $_GET['lower'] : 0;
						$upper = (isset($_GET['upper'])) ? $_GET['upper'] : 10;
				
						$res_MessageList = mysql_query("SELECT `message_id`, `api_responseCode`, `message`, date(`sent_on`) FROM `sent_messages` WHERE 1 ORDER BY `sent_on` DESC LIMIT $lower, $upper");
	$i = 0;
	while($row_MessageList=mysql_fetch_array($res_MessageList))
	{

						?>
                                <tr>
                                  <td><strong><?php echo $row_MessageList['message_id']; ?></strong></td>
                                  <td style="font-size:11px"><?php echo urldecode($row_MessageList['message']); ?></td>
                                  <td>
                                  <?php
								  	echo date('d M, Y', strtotime($row_MessageList['date(`sent_on`)']));
								  ?>
                                  </td>
                                  <td>
                                  <a href="javascript:void(0)" class="btn btn-grad btn-sm btn-info" style="text-align:left">Detail</a>
                                  
                            
                                  </td>
                                </tr>
                                <?php
	}
						?>
                        <tr>
                        <td align="center"><?php if(mysql_num_rows($res_MessageList)==0){ echo "No message sent yet..!!";} ?></td>
                        </tr>
                              </table>
                              <div class="pull-right">
                                <div class="dataTables_paginate paging_bootstrap">
                                  <ul class="pagination">
                                    <?php
						  //echo mysql_num_rows($res_tot_videos);
						  	for($i = 0; $i <= (mysql_num_rows($res_MessageList)/10); $i++)
							{
								if(isset($_GET['type']))
								$query = "type=".$_GET['type']."&lower=".($i*10)."&upper=".(10);
								else $query = "lower=".($i*10)."&upper=".(10);
								?>
                                    <li <?php if($lower == ($i*10)) echo ' class="active"'; ?>><a href="<?php echo 
					  $_SERVER['PHP_SELF']."?".$query; ?>"><?php echo $i+1; ?></a></li>
                                    <?php
							}
							?>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
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
            <p>2013 &copy; Atreyawebs</p>
        </div>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="assets/lib/jquery.min.js"><\/script>')</script> 
  
  
  
  
  <script src="../assets/lib/bootstrap/js/bootstrap.js"></script>
          <script src="../assets/js/main.js"></script>


  
  
  
  
  
  
  
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        


</body>
</html>