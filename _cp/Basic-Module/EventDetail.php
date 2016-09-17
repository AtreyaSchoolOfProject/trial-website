<?php
ob_start();
session_start();
include("../require/session.inc.php");
include("../require/connection.inc.php");
include("../require/functions.inc.php");
include("../require/timezone.inc.php");
include("../require/common.inc.php");
include("../require/validate-user.inc.php");

$get_event = $_GET['event_id'];
$event_result = mysql_query("SELECT * FROM `latest_news` WHERE `LE_Slno`='$get_event'");
$event_row = mysql_fetch_array($event_result);

##### This Commend for updating Event #####	
	if(isset($_POST['BTN_Upd_Event']))
	{
		if($_FILES['FF_NewsPhoto']['name']!="")
		{
			$Event_photo=$event_row['LE_Slno']."_EventPhoto".".jpg";
			upload_image($_FILES['FF_NewsPhoto'], "../../Upl_Images/EventImage/Thumbnail/",$Event_photo, 154, 116, "no");
			upload_image($_FILES['FF_NewsPhoto'], "../../Upl_Images/EventImage/Main/",$Event_photo, 600, 400, "yes");
		}
		else
		{
			$Event_photo=($event_row['LE_Photo']!='')? $event_row['LE_Photo']:"Event_img.jpg";
		}
		$upd_date = date('Y-m-d');	
		$event_heading = htmlentities($_POST['TXT_Event'], ENT_QUOTES,"utf-8");
		$event_date = htmlentities($_POST['TXT_EventDt'], ENT_QUOTES,"utf-8");
		mysql_query("UPDATE  latest_news SET `LE_Heading` = '$event_heading', `LE_Photo`='$Event_photo', `LE_Date` = '$event_date', LE_UpdatedDate = '$upd_date', LE_UpdatedBy = '".$_SESSION['username']."' WHERE `LE_SlNo` = '".$_GET['event_id']."'") or die(mysql_error());
		
		echo header("location:ListEvents.php");
	}
##################################################
	
### This command for delete content of a Event ###
if(isset($_GET['delcontid']))
{
	$contDetail = mysql_fetch_array(mysql_query("SELECT * FROM `latest_news_content` WHERE `LE_C_Slno` = '".$_GET['delcontid']."'"));
	if($contDetail['LE_C_Type'] == "Image")
	{
		unlink("../../Upl_Images/EventImage/Main/".$contDetail['LE_C_Content']);
		unlink("../../Upl_Images/EventImage/Thumbnail/".$contDetail['LE_C_Content']);
	}
	mysql_query("DELETE FROM `latest_news_content` WHERE `LE_C_Slno` = '".$_GET['delcontid']."'");
	mysql_query("OPTIMIZE TABLE `latest_news_content`");
	header("location:".$_SERVER['PHP_SELF']."?event_id=".$_GET['delcontid']);
}
##################################################

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

        <link rel="stylesheet" href="../assets/css/bootstrap-fileupload.min.css">
        <link rel="stylesheet" href="../assets/lib/fullcalendar-1.6.2/fullcalendar/fullcalendar.css">
        
          <link rel="stylesheet" href="../assets/lib/wysihtml5/dist/bootstrap-wysihtml5-0.0.2.css">
<link rel="stylesheet" href="../assets/css/Markdown.Editor.hack.css">
<link rel="stylesheet" href="../assets/lib/CLEditor1_4_3/jquery.cleditor.css">
<link rel="stylesheet" href="../assets/css/jquery.cleditor-hack.css">
<link rel="stylesheet" href="../assets/css/bootstrap-wysihtml5-hack.css">
        
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
                        <h3><i class="fa fa-calendar"></i> Event Detail</h3>
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
                        <div class="icons"><i class="fa fa-pencil-square-o fa-2x"></i></div>
                        <h5>Edit Event</h5>
                      </header>
                         <div class="body">
                           <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                           <div class="form-group">
                                <div class="col-lg-3">
                                  <input type="text" class="validate[required] form-control" name="TXT_EventDt" id="TXT_EventDt" placeholder="Event Date" value="<?php echo $event_row['LE_Date']?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-7">
                                 <input type="text" class="validate[required] form-control" name="TXT_Event" id="TXT_Event" placeholder="Event Heading" value="<?php echo $event_row['LE_Heading']?>"/>
                                </div>
                            </div>
							<div class="form-group">
                                <div class="col-lg-12">
                                
                                  <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail"><img src="<?php echo "../../Upl_Images/EventImage/Thumbnail/".$event_row['LE_Photo']?>" alt="" width="200" height="150" /></div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div> <span class="btn btn-file btn-success"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                                      <input type="file" id="FF_NewsPhoto" name="FF_NewsPhoto" />
                                    </span> <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a> </div>
                                  </div>
                                </div>
                              </div>

 					<div class="form-group">
                        <div class="col-lg-5">
 						<input type="submit" name="BTN_Upd_Event" id="BTN_Upl_Event" value="Save Change" class="btn btn-primary btn-block" />
                        </div>
                        
                        <div class="col-lg-2">
                       <a href="UploadEventDescription.php?event_id=<?php echo $event_row['LE_Slno']; ?>" class="btn btn-warning">
                        <i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Add Content</a></div>
                        <div class="col-lg-8"></div>
                    </div>
                           </form>
                           <hr />
                        	<?php
								$res_eventData = mysql_query("SELECT * FROM `latest_news_content` WHERE `LE_C_EventId` = '$get_event'");
								
								while($row_eventData = mysql_fetch_array($res_eventData))
								{
								
							?>
                            <div class="body">
                            <a href="EventDetail.php?delcontid=<?php echo $_GET['event_id'] ?>" class=" pull-right" onclick="return confirm('It will delete permanently,\n\nAre you sure.. ? ')">
                            <i class="fa fa-times fa-2x text-danger"></i>
                            </a>
                            <a href="UpdateEventContent.php?event_id=<?php echo $_GET['event_id'] ?>&contid=<?php echo $row_eventData['LE_C_Slno']; ?>" class=" pull-right" style="padding-right: 20px;"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                           	  <?php
								
									if($row_eventData['LE_C_Type'] == "Text")
									{
										echo html_entity_decode($row_eventData['LE_C_Content'], ENT_QUOTES, "utf-8");
									}
									else if($row_eventData['LE_C_Type'] == "Image")
									{
										?>
                              <img src="../../Upl_Images/EventImage/Main/<?php echo $row_eventData['LE_C_Content']; ?>" class="thumbnail img-responsive" />
                                        <?php
									}
								?>
                            </div>
                           <hr />
                           <?php
								}
						   ?>
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
          <script src="../assets/js/main.js"></script>

        <script>
        $(function() {
            // Bootstrap
            /*$( 'textarea#MTXT_Reply' ).ckeditor({width:'98%', height: '150px', toolbar: [
				{ name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
				[ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],			// Defines toolbar group without name.
				{ name: 'basicstyles', items: [ 'Bold', 'Italic' ] }
			]});*/
          // $( 'textarea#MTXT_EventData' ).ckeditor({width:'99.6%', height: '350px'});
        });

        // Tiny MCE
       

        </script>  
  
  
  
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        


</body>
</html>