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
$dir = "../../Upl_Images/Gallery/";

$alb_cover_id = $_GET['alb'];
//$alb_cat_id = $_GET['cat'];

$res_coverImg = mysql_query("SELECT * FROM `media_album` WHERE `slno` = '$alb_cover_id'");
$row_coverImg = mysql_fetch_array($res_coverImg);

if(isset($_POST['BTN_Submit_UplIMg']))
	{
		$publish_dt = $_POST['TXT_PublishDt'];
		$video_subject = htmlentities($_POST['TXT_Subject'], ENT_QUOTES, "UTF-8");
		$video_url= $_POST['MTXT_VideoUrl'];//htmlentities($_POST['MTXT_VideoUrl'], ENT_QUOTES, "UTF-8");
		$upload_date=date('Y-m-d');
		mysql_query("INSERT INTO `media_content`(`album_id`, `media_type`, `media`, `publish_date`, `description`, `upload_date`, `upload_by`)VALUES('$alb_cover_id', 'video', '$video_url', '$publish_dt', '$video_subject', '$upload_date', '".$_SESSION['username']."')") or die(mysql_error());
		if(!empty($_FILES['FF_AlbumImage']['name']))
		{
			$last_id = mysql_insert_id();// primary id from Table "album_name"
			$image_nm = $last_id."_videoImage".".jpg"; //image to be insert as album insert
			
			//Code for insert image to the directory folder 
			upload_image($_FILES['FF_AlbumImage'], $dir."Thumbnail/", $image_nm, 200, 130, "no");
			
			// Insert the above image name by updating the table "album_name"
			mysql_query("UPDATE `media_content` SET `media_screen` = '$image_nm' WHERE `slno` = '$last_id'") or $error[] = "Update Failed";
		}
		header("location:".$_SERVER['PHP_SELF']."?upload=true&alb=$alb_cover_id");
	}
	
	if(isset($_GET['delimg']))
	{
		$row_image = mysql_fetch_assoc(mysql_query("SELECT `media_screen` FROM `media_content` WHERE `slno` = '".$_GET['delimg']."'"));
		unlink('../../Upl_Images/Gallery/Thumbnail/'.$row_image['media_screen']);
		mysql_query("DELETE FROM `media_content` WHERE `slno` = '".$_GET['delimg']."'") or $error[] = mysql_error();
		mysql_query("OPTIMIZE TABLE `media_content`");
		header("location:".$_SERVER['PHP_SELF']."?upload=true&alb=".$_GET['alb']);
	}

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
        <link rel="stylesheet" href="../assets/lib/validationengine/css/validationEngine.jquery.css">
        <link rel="stylesheet" href="../assets/lib/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css">
        <link rel="stylesheet" href="../assets/lib/gritter/css/jquery.gritter.css">
        <link rel="stylesheet" href="../assets/lib/uniform/themes/default/css/uniform.default.min.css">
        <link rel="stylesheet" href="../assets/css/bootstrap-fileupload.min.css">
      <link rel="stylesheet" href="../assets/lib/fullcalendar-1.6.2/fullcalendar/fullcalendar.css">
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
dp_cal = new Epoch('epoch_popup','popup',document.getElementById('TXT_PublishDt'));
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
                        <h3><i class="fa fa-camera"></i> Gallery</h3>
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
                      <div class="col-lg-6">
                        <div class="box">
                          <header class="dark">
                            <div class="icons"><i class="fa  fa fa-plus fa-2x"></i></div>
                            <h5>Add video in <?php echo $row_coverImg['album_name']; ?></h5>
                          </header>
                          <div class="body">
                            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                              <div class="form-group">
                                <div class="col-lg-5">
                                  <input type="text" name="TXT_PublishDt" id="TXT_PublishDt" class="form-control" placeholder="Publlish Date"/>
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="col-lg-12">
                                  <input type="text" name="TXT_Subject" id="TXT_Subject" class="form-control" placeholder="Video Subject"/>
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="col-lg-12">
                                  <textarea name="MTXT_VideoUrl" class="form-control" id="MTXT_VideoUrl" cols="35" rows="4" placeholder="Add video url"></textarea>
                                </div>
                              </div>
                            <div class="form-group">
                                <div class="col-lg-9">
                                  <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=album+image" alt="" /></div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div> <span class="btn btn-file btn-success"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                                      <input type="file" id="FF_AlbumImage" name="FF_AlbumImage" />
                                    </span> <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a> </div>
                                  </div>
                                </div>
                              </div>
                            <div class="form-actions no-margin-bottom">
                              <input type="submit" name="BTN_Submit_UplIMg" id="BTN_Submit_UplIMg" value="Upload" class="btn btn-primary col-lg-3" />
                               </div>
                               </form>
                           
                          </div>
                        </div>
                      </div>
                      
                      
                      <div class="col-lg-6">
                      <div class="box">
                          <header class="dark">
                            <div class="icons"><i class="fa fa-camera  fa-2x"></i></div>
                            <?php 
							$res_imgList = mysql_query("SELECT * FROM `media_content` WHERE `album_id` = '".$_GET['alb']."'");
							?>
                            <h5>Available video(s) in <?php echo $row_coverImg['album_name']; ?> (<?php echo mysql_num_rows($res_imgList); ?>)</h5>
                          </header>
                          
                          <div class="body">
                          <table width="100%">
                          <tr>
                          <td>
                         <?php 
						 	
							while($row_imgList = mysql_fetch_array($res_imgList))
							{
						 ?>
                         <table width="100%" align="left" cellpadding="10" class="table-bordered hover" style="margin: 0.5%">
                         <tr>
                         <td align="default">
                         <img src="<?php echo "../../Upl_Images/Gallery/Thumbnail/".$row_imgList['media_screen'];?>" alt=""  class="img img-thumbnail" width="120px"/>
                          </td>
                          <td align="left" valign="middle"><?php echo $row_imgList['description']; ?></td>
                          </tr>
                         <tr>
                            <td width="50%" align="center" valign="middle"><a href="Alb_EditVideoImage.php?imgid=<?php echo $row_imgList['slno']?>&alb=<?php echo $_GET['alb']?>" class="text-info"><i class="fa fa-pencil-square-o"></i>&nbsp;Edit</a></td> 
                           <td width="50%" align="center" valign="middle"><a href="<?php echo $_SERVER['PHP_SELF']."?alb=".$_GET['alb']."&delimg=".$row_imgList['slno']; ?>" class="text-danger" onclick="return confirm('Delete this file . . . ?')"><i class="fa fa-times"></i>&nbsp;Delete</a></td>
                         </tr>
                         </table>
                          
                            <?php
							}
							?>
                            </td></tr></table>
                          </div>
                        </div>
                          
                          
                          
                          </div>
                      </div>
                      
                    </div>
                    
                   <hr>
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

  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="../assets/lib/jquery.min.js"><\/script>')</script> 
  
 <script src="../assets/lib/daterangepicker/daterangepicker.js"></script>
<script src="../assets/lib/daterangepicker/moment.min.js"></script>
<script src="../assets/lib/datepicker/js/bootstrap-datepicker.js"></script> 


<script src="../assets/lib/plupload/js/jquery.plupload.queue/jquery.plupload.queue.min.js"></script>
<script src="../assets/lib/plupload/js/plupload.full.min.js"></script>
<script src="../assets/lib/gritter/js/jquery.gritter.min.js"></script>
<script src="../assets/lib/uniform/jquery.uniform.min.js"></script>
<script src="../assets/lib/jasny/js/bootstrap-fileupload.js"></script>
<script src="../assets/lib/form/jquery.form.js"></script>
<script src="../assets/lib/formwizard/js/jquery.form.wizard.js"></script>
<script src="../assets/lib/jquery-validation-1.11.1/dist/jquery.validate.min.js"></script>
<script src="../assets/lib/jquery-validation-1.11.1/localization/messages_ja.js"></script>
<script src="../assets/lib/validationengine/js/jquery.validationEngine.js"></script>
<script src="../assets/lib/validationengine/js/languages/jquery.validationEngine-en.js"></script>
<script src="../assets/lib/jquery-validation-1.11.1/dist/jquery.validate.min.js"></script>
<script src="../assets/lib/jquery-validation-1.11.1/localization/messages_ja.js"></script>
        

    <script src="../assets/lib/bootstrap/js/bootstrap.js"></script>

  
        

        <script src="../assets/js/main.js"></script>

        
        <script>
            //$(function() { formWizard(); });
            $(function() { formValidation(); });
        </script>
        
  
  
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        
</body>
</html>