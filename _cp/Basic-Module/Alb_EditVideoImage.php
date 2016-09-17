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
$alb_id = $_GET['alb'];
$img_id = $_GET['imgid'];

$res_img = mysql_query("SELECT * FROM `media_content` WHERE `slno` = '$img_id'");

if(mysql_num_rows($res_img) == 0)
	{
		//header("refresh:5;url=Alb_ViewImage.php?aid=".$alb_id);
		//die("The content you are trying to access no longer available. Thank you.");
	}
$row_img = mysql_fetch_array($res_img);
if(isset($_POST['BTN_EditVideo']))
	{
$publish_dt = $_POST['TXT_PublishDt'];
		$video_subject = htmlentities($_POST['TXT_Subject'], ENT_QUOTES, "UTF-8");
		$video_url= $_POST['MTXT_VideoUrl'];//htmlentities($_POST['MTXT_VideoUrl'], ENT_QUOTES, "UTF-8");
		$upload_date=date('Y-m-d');
		mysql_query("UPDATE `media_content` SET `media`='$video_url', `publish_date`='$publish_dt', `description`='$video_subject', `upload_date`='$upload_date', `upload_by`='".$_SESSION['username']."'") or die(mysql_error());
		if(!empty($_FILES['FF_AlbumImage']['name']))
		{
			$image_nm = $img_id."_videoImage".".jpg"; 
			upload_image($_FILES['FF_AlbumImage'], $dir."Thumbnail/", $image_nm, 200, 130, "no");
			//mysql_query("UPDATE `media_content` SET `media_screen` = '$image_nm' WHERE `slno` = '$img_id'") or $error[] = "Update Failed";
		}
		header("location:Alb_UplNewVideo.php?upload=true&alb=$alb_id");
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
                        <h3><i class="fa fa-video-camera"></i> Gallery</h3>
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
                            <div class="icons"><i class="fa fa-pencil-square-o fa-2x"></i></div>
                            <h5>Edit Album</h5>
                          </header>
                          <div class="body">
                            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                              <div class="form-group">
                                <div class="col-lg-5">
                                  <input type="text" name="TXT_PublishDt" id="TXT_PublishDt" class="form-control" placeholder="Publlish Date" value="<?php echo $row_img['publish_date']?>"/>
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="col-lg-12">
                                  <input type="text" name="TXT_Subject" id="TXT_Subject" class="form-control" placeholder="Video Subject" value="<?php echo $row_img['description']?>"/>
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="col-lg-12">
                                  <textarea name="MTXT_VideoUrl" class="form-control" id="MTXT_VideoUrl" cols="35" rows="4" placeholder="Add video url"><?php echo $row_img['media']?></textarea>
                                </div>
                              </div>
                            <div class="form-group">
                                <div class="col-lg-9">
                                  <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="../../Upl_Images/Gallery/Thumbnail/<?php echo $row_img['media_screen']?>" /></div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div> <span class="btn btn-file btn-success"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                                      <input type="file" id="FF_AlbumImage" name="FF_AlbumImage" />
                                    </span> <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a> </div>
                                  </div>
                                </div>
                              </div>
                            <div class="form-actions no-margin-bottom">
                              <input type="submit" name="BTN_EditVideo" id="BTN_EditVideo" value="Save Changes" class="btn btn-primary col-lg-3" />
                               </div>
                               </form>
                           
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="box">
                          <div class="body">
                            <table width="100%">
                              <tr>
                                <td>&nbsp;</td>
                              </tr>
                            </table>
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