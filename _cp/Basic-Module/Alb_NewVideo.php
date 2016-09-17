<?php
ob_start();
session_start();
include("../require/session.inc.php");
include("../require/connection.inc.php");
include("../require/functions.inc.php");
include("../require/timezone.inc.php");
include("../require/common.inc.php");
include("../require/validate-user.inc.php");

$dir = "../../Upl_Images/Gallery/"; // Album and Image Directory
if(isset($_POST['BTN_CreateAlbum'])) //Create Album after this button click 
	{
	if(count($error) == 0)// If no error(s) occures
		{
		$alb_nm = htmlentities($_POST['TXT_AlbNm'], ENT_QUOTES, "UTF-8");// Album NAme

		// Insert a New Album Information in Table (album_name) 
		mysql_query("INSERT INTO `media_album`(`media_type`, `album_name`, `updated_by`, `visibility`) VALUES('video', '$alb_nm', '".$_SESSION['username']."', '1')") or $error[] = "Insert Failed";
		if(!empty($_FILES['FF_AlbumImage']['name']))
		{
			$last_id = mysql_insert_id();// primary id from Table "album_name"
			$image_nm = $last_id."_videoAlbum".".jpg"; //image to be insert as album insert
			
			//Code for insert image to the directory folder 
			upload_image($_FILES['FF_AlbumImage'], $dir."Thumbnail/", $image_nm, 200, 130, "no");
			//upload_image($_FILES['FF_AlbumImage'], $dir."Main/", $image_nm, 600, 400, "no");
			
			// Insert the above image name by updating the table "album_name"
			mysql_query("UPDATE `media_album` SET `album_screen` = '$image_nm' WHERE `slno` = '$last_id'") or $error[] = "Update Failed";
		}
		header("location:".$_SERVER['PHP_SELF']);// redirect after command execute
		}// Close error count 'IF'
	}// Close Create Album 'IF'
	
	
	if(isset($_GET['daid'])) // Album query string "daid"
	{
		$did = $_GET['daid'];
		$res_album_content = mysql_query("SELECT * FROM `media_content` 
							WHERE `album_id` = '$did'");
		if(mysql_num_rows($res_album_content) > 0 )
		{
			while($row_album_content = mysql_fetch_array($res_album_content))
			{
				$video_id = $row_album_content['slno'];
				$res_video = mysql_query("SELECT * FROM `media_content` WHERE `AI_ID` = '$video_id'");
				$row_video = mysql_fetch_array($res_video);
				mysql_query("DELETE FROM `media_content` WHERE slno = '$video_id'");
				mysql_query("OPTIMIZE TABLE `media_content`");
			}
		}
		$row_albumImg = mysql_fetch_array(mysql_query("SELECT * FROM `media_album` WHERE `slno` = '$did'"));
		//unlink($dir."Main/".$row_albumImg['AN_Image']);
		unlink($dir."Thumbnail/".$row_albumImg['album_screen']);
		
		mysql_query("DELETE FROM `media_album` WHERE `slno` = '$did'") or die(mysql_error());
		mysql_query("OPTIMIZE TABLE `media_album`");
		$error[] = "Album Deleted Successfully. ";
		header("location:".$_SERVER['PHP_SELF']);
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


        <link rel="stylesheet" href="../assets/lib/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css">
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
                        <h3><i class="fa fa-video-camera"></i>Video Gallery</h3>
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
                            <div class="icons"><i class="fa fa-folder-open fa-2x"></i></div>
                            <h5>Add a Album</h5>
                          </header>
                          <div class="body">
                            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                              
                              <div class="form-group">
                                <div class="col-lg-9">
                                  <input type="text" class="validate[required] form-control" name="TXT_AlbNm" id="TXT_AlbNm" placeholder="Album Name"/>
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
                              <input type="submit" name="BTN_CreateAlbum" id="BTN_CreateAlbum" value="Create this album" class="btn btn-primary" />
                               </div>
                               </form>
                           
                          </div>
                        </div>
                      </div>
                      
                      
                      <div class="col-lg-6">
                      <div class="box">
                          <header class="dark">
                            <div class="icons"><i class="fa fa-video-camera  fa-2x"></i></div>
                            <h5>Pick an album to upload video</h5>
                          </header>
                          
                          <div class="body">
                          <table width="100%">
                          <tr>
                          <td>
                         <?php 
						 	$res_albList = mysql_query("SELECT * FROM `media_album` WHERE `visibility` = '1'");
							while($row_albList = mysql_fetch_array($res_albList))
							{
						 ?>
                         <table width="32.3%" align="left" cellpadding="10" class="table-bordered" style="margin: 0.5%">
                         <tr>
                         <td height="120" colspan="2" align="center">
                          <a href="Alb_UplNewVideo.php?alb=<?php echo $row_albList['slno']; ?>"><img src="../../Upl_Images/Gallery/Thumbnail/<?php echo $row_albList['album_screen']; ?>" class="img-responsive" style="margin-bottom: 2px;" alt="<?php echo $row_albList['album_name']; ?>" title="<?php echo $row_albList['album_name'];?>" /></a>
                          </td>
                          
                          </tr>
                          <tr>
                          <td colspan="2" align="center"><a href="Alb_UplNewVideo.php?alb=<?php echo $row_albList['slno']; ?>"><?php echo html_entity_decode($row_albList['album_name'], ENT_QUOTES, "UTF-8"); ?></a></td>
                          </tr>
                          <tr><td width="50%" align="center"><a href="Alb_EditVdoAlbum.php?aid=<?php echo $row_albList['slno']; ?>" class="text-info"><i class="fa fa-pencil-square-o"></i>&nbsp;Edit</a></td>
                            <td width="50%" align="center"><a href="<?php echo $_SERVER['PHP_SELF']."?daid=".$row_albList['slno'] ?>" onclick="return confirm('This action will remove the album and all it\'s images permanently.\n\nDo you still want to continue . . .?')" class="text-danger"><i class="fa fa-times"></i>&nbsp;Delete</a></td>
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
<!--query on product image & other-->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="../assets/lib/jquery.min.js"><\/script>')</script> 
  <script src="../assets/lib/bootstrap/js/bootstrap.js"></script>
  
<script src="../assets/lib/plupload/js/jquery.plupload.queue/jquery.plupload.queue.min.js"></script>
<script src="../assets/lib/plupload/js/plupload.full.min.js"></script>
<script src="../assets/lib/jasny/js/bootstrap-fileupload.js"></script>
<script src="../assets/lib/form/jquery.form.js"></script>
<script src="../assets/lib/formwizard/js/jquery.form.wizard.js"></script>
        
    

        <script src="../assets/js/main.js"></script>

        
        <script>
            //$(function() { formWizard(); });
            $(function() { formValidation(); });
        </script>
        
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
 <!-- ---------------------------------------------------------  ------------------------------------ --> 
 
<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="assets/lib/jquery.min.js"><\/script>')</script> 
<script src="../assets/lib/bootstrap/js/bootstrap.js"></script>
-->

<script src="../assets/lib/daterangepicker/daterangepicker.js"></script>
<script src="../assets/lib/daterangepicker/moment.min.js"></script>
<script src="../assets/lib/datepicker/js/bootstrap-datepicker.js"></script> 
        <script src="../assets/lib/jquery-1.9.1.min.js"></script>
		<script src="../assets/lib/ckeditor/ckeditor.js"></script>
		<script src="../assets/lib/ckeditor/adapters/jquery.js"></script>
          <script src="../assets/js/main.js"></script>
  
  
  
        
</body>
</html>