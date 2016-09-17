<?php
ob_start();
session_start();
include("../require/session.inc.php");
include("../require/connection.inc.php");
include("../require/functions.inc.php");
include("../require/timezone.inc.php");
include("../require/common.inc.php");
include("../require/validate-user.inc.php");


	if(isset($_POST['BTN_Upl_Event']))
	{
		$event = uploadEvent();
		header("location:ListEvents.php");
	}
	if(isset($_POST['BTN_NextCont']))
	{
		$event = uploadEvent();
		header("location:UploadEventDescription.php?event_id=".$event);
	}

	function uploadEvent()
	{
		$content=htmlentities($_POST['MTXT_EventData'], ENT_QUOTES, "utf-8");
		$heading=htmlentities($_POST['TXT_Event'], ENT_QUOTES, "utf-8");
		$news_dt = $_POST['TXT_EventDt'];
		
		
		$row_NewsCode = mysql_fetch_assoc(mysql_query("SELECT `LE_Slno` FROM `latest_news` ORDER BY `LE_Slno` DESC LIMIT 0,1"));
		$varNewsCode=$row_NewsCode['LE_Slno']+1;
				
		if($_FILES['FF_NewsPhoto']['name']!="")
		{
			$Event_photo=$varNewsCode."_EventPhoto".".jpg";
			upload_image($_FILES['FF_NewsPhoto'], "../../Upl_Images/EventImage/Thumbnail/",$Event_photo, 236, 157, "no");
			upload_image($_FILES['FF_NewsPhoto'], "../../Upl_Images/EventImage/Main/",$Event_photo, 600, 400, "yes");
		}
		else
		{
			$News_photo="Event_img.jpg";
		}

		mysql_query("INSERT INTO `latest_news` (`LE_Heading`, `LE_Date`, `LE_UpdatedDate`,`LE_UpdatedBy`, `LE_Photo`) VALUES ('$heading','$news_dt', 'Never Updated', 'Never Updated', '".$Event_photo."')") or die(mysql_error());
		$event_id=mysql_insert_id();
		if(!empty($content))
		{
			$content_Position = 1;
		mysql_query("INSERT INTO `latest_news_content` (`LE_C_EventId`, `LE_C_Content`, `LE_C_Type`, `LE_C_Status`, `LE_C_Position`) VALUES ('$event_id', '".$content."', 'Text', 1,'$content_Position')");
		}
		return $event_id;
		
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin C-Panel by Atreyawebs</title>
        
        <link rel="stylesheet" href="../assets/lib/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="../assets/css/main.css"/>
        <link rel="stylesheet" href="../assets/lib/Font-Awesome/css/font-awesome.css"/>
        <link rel="stylesheet" href="../assets/css/theme.css">
        <link rel="stylesheet" href="../assets/lib/fullcalendar-1.6.2/fullcalendar/fullcalendar.css">
        <link rel="stylesheet" href="../assets/lib/wysihtml5/dist/bootstrap-wysihtml5-0.0.2.css">
    	<link rel="stylesheet" href="../assets/css/jquery.cleditor-hack.css">

        <link rel="stylesheet" href="../assets/css/bootstrap-fileupload.min.css">

      <link rel="stylesheet" href="../assets/lib/daterangepicker/daterangepicker-bs3.css">
	  <link rel="stylesheet" href="../assets/lib/datepicker/css/datepicker.css">
        <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-1669764-16', 'onokumus.com');
  ga('send', 'pageview');

</script>
        <script src="../assets/lib/modernizr-build.min.js"></script>
<link rel="stylesheet" type="text/css" href="../assets/lib/calender-picker/epoch_styles.css"/>
<script type="text/javascript" src="../assets/lib/calender-picker/epoch_classes.js"></script>
<script type="text/javascript">
var dp_cal;      
window.onload = function () {
dp_cal = new Epoch('epoch_popup','popup',document.getElementById('TXT_EventDt'));
};
</script>

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
                        <h3><i class="fa fa-calendar"></i>Create a News Letter</h3>
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
                     <div class="col-lg-12">
                       <div class="box">
                         <header class="dark">
                        <div class="icons"><i class="fa fa-file-text-o fa-2x"></i></div>
                        <h5>Add New Event</h5>
                      </header>
                         <div class="body">
                        <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                        <div class="row">
                        <div class="col-lg-6">
                        	<div class="form-group">
                                <div class="col-lg-6">
                                  <input type="text" class="validate[required] form-control" name="TXT_EventDt" id="TXT_EventDt" placeholder="Event Date"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-11">
                                 <input type="text" class="validate[required] form-control" name="TXT_Event" id="TXT_Event" placeholder="Event Heading"/>
                                </div>
                            </div>
                            <div class="form-group">
                            	<textarea name="MTXT_EventData" id="MTXT_EventData"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                        <div class="form-group">
                                <div class="col-lg-12">
                                
                                  <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail"><img src="http://www.placehold.it/390x280/EFEFEF/AAAAAA&amp;text=upload+photo" alt="" /></div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div> <span class="btn btn-file btn-success"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                                      <input type="file" id="FF_NewsPhoto" name="FF_NewsPhoto" />
                                    </span> <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a> </div>
                                  </div>
                                </div>
                              </div>
                        </div>
					</div>	                                  
                                
                    	<div class="row">          
                        	<div class="col-lg-6">
                             <input type="submit" name="BTN_Upl_Event" id="BTN_Upl_Event" value="Save & Return" class="btn btn-primary btn-block" />
                             </div>    
                            <div class="col-lg-6">
                            <input type="submit" name="BTN_NextCont" id="BTN_NextCont" value="Add more Content" class="btn btn-warning btn-block" />
                            </div>
                            
                       	</div>
                            
                          </form>
                        
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
            <p>2013 &copy; Atreyawebs</p>
        </div>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="assets/lib/jquery.min.js"><\/script>')</script> 
  
  
<script src="../assets/lib/plupload/js/jquery.plupload.queue/jquery.plupload.queue.min.js"></script>
<script src="../assets/lib/plupload/js/plupload.full.min.js"></script>
<script src="../assets/lib/jasny/js/bootstrap-fileupload.js"></script>
  
  <script src="../assets/lib/bootstrap/js/bootstrap.js"></script>
 <script src="../assets/lib/daterangepicker/daterangepicker.js"></script>
<script src="../assets/lib/daterangepicker/moment.min.js"></script>
<script src="../assets/lib/datepicker/js/bootstrap-datepicker.js"></script> 
        <script src="../assets/lib/jquery-1.9.1.min.js"></script>
		<script src="../assets/lib/ckeditor/ckeditor.js"></script>
		<script src="../assets/lib/ckeditor/adapters/jquery.js"></script>
          <script src="../assets/js/main.js"></script>

        <script>
        $(function() {
            // Bootstrap
            $( 'textarea#MTXT_EventData' ).ckeditor({width:'98%', height: '150px', toolbar: [
				/*{ name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] },*/	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
				[ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],			// Defines toolbar group without name.
				{ name: 'basicstyles', items: [ 'Bold', 'Italic' ] }
			]});
           /*$( 'textarea#MTXT_EventData' ).ckeditor();*/
        });

        // Tiny MCE
       

        </script>  
  
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
</body>
</html>