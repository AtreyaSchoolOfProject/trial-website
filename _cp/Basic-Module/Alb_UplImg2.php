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

$res_coverImg = mysql_query("SELECT * FROM `album_name` WHERE `AN_ID` = '$alb_cover_id' AND `AN_OI_OrganisationID` = '".$_SESSION['OI_OrganisationID']."'");
$row_coverImg = mysql_fetch_array($res_coverImg);

if(isset($_POST['BTN_Submit_UplIMg']))
	{
		$alb_desc = htmlentities($_POST['MTXT_ImgDesc'], ENT_QUOTES, "UTF-8");
		
		mysql_query("INSERT INTO `album_image` (`AI_AN_ID`, `AI_Description`, `AI_Date`, `AI_Visibility`) VALUES ('$alb_cover_id',  '$alb_desc', '$date', '1')") or die(mysql_error());
		$last_id = mysql_insert_id();
		$image_nm = $row_coverImg['AN_ID']."_AlbumImg".$last_id.".jpg";
		upload_image($_FILES['FF_AlbImg'],$dir."/Main", $image_nm, 600, 400, "yes");
		upload_image($_FILES['FF_AlbImg'],$dir."/Thumbnail", $image_nm, 250, 170, "no");
		mysql_query("UPDATE album_image SET AI_Image = '$image_nm' WHERE AI_ID = '$last_id'") or $error[] = mysql_error();
		header("location:".$_SERVER['PHP_SELF']."?upload=true&alb=$alb_cover_id");
	}
	if(isset($_GET['delimg']))
	{
		$row_albumImg = mysql_fetch_array(mysql_query("SELECT `AI_Image` FROM `album_image` WHERE `AI_ID` = '".$_GET['delimg']."'"));
		unlink($dir."Main/".$row_albumImg['AI_Image']);
		unlink($dir."Thumbnail/".$row_albumImg['AI_Image']);
		mysql_query("DELETE FROM album_image WHERE AI_ID = '".$_GET['delimg']."'") or $error[] = mysql_error();
		mysql_query("OPTIMIZE TABLE album_image");
		header("location:".$_SERVER['PHP_SELF']."?upload=true&alb=".$_GET['alb']);
	}
	
function validate_upl()
	{
	global $error;
	if($_FILES['FF_AlbImg']['error'] > 0)
		{
		validate_img($_FILES['FF_AlbImg']);
		}
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
                            <h5>Add new image in <?php echo $row_coverImg['AN_Name']; ?></h5>
                          </header>
                          <div class="body">
                            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                              <div class="form-group">
                                <label class="control-label col-lg-3">Select a File</label>
                                <div class="col-lg-9">
                                
                                  <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" /></div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div> <span class="btn btn-file btn-success"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                                      <input type="file" id="FF_AlbImg" name="FF_AlbImg" />
                                    </span> <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a> </div>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-lg-3">Description</label>
                                <div class="col-lg-9">
                                  <textarea name="MTXT_ImgDesc" class="form-control" id="MTXT_ImgDesc" cols="35" rows="4"></textarea>
                                </div>
                              </div>
<label class="control-label col-lg-3"></label>
                            
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
							$res_imgList = mysql_query("SELECT * FROM album_image WHERE AI_AN_ID = '".$_GET['alb']."'");

							?>
                            <h5>Available images in <?php echo $row_coverImg['AN_Name']; ?> (<?php echo mysql_num_rows($res_imgList); ?>)</h5>
                          </header>
                          
                          <div class="body">
                          <img src="../../Upl_Images/Gallery/Thumbnail/<?php echo $row_coverImg['AN_Image']; ?>" class="img-responsive img-responsive" />
                          </div>
                          <div class="body">
                          <table width="100%">
                          <tr>
                          <td>
                         <?php 
						 	
							while($row_imgList = mysql_fetch_array($res_imgList))
							{
						 ?>
                         <table width="32.3%" align="left" cellpadding="10" class="table-bordered hover" style="margin: 0.5%">
                         
                         <tr>
                         <td height="120" colspan="2" align="center"><a href="javascript:void(0)" class="label"><img src="../../Upl_Images/Gallery/Thumbnail/<?php echo $row_imgList['AI_Image']; ?>" class="" style="margin-bottom: 5px;" alt="<?php echo $row_imgList['AN_Name']; ?>" title="<?php echo $row_albList['AN_Name']; ?>" width="190" />	</a>
                          </td></tr>
                         <tr>
                           <td width="50%" align="center" valign="middle"><a href="Alb_EditImage.php?albid=<?php echo $_GET['alb']; ?>&imgid=<?php echo $row_imgList['AI_ID']; ?>" class="text-info"><i class="fa fa-pencil-square-o"></i>&nbsp;Edit</a></td> 
                           <td width="50%" align="center" valign="middle"><a href="<?php echo $_SERVER['PHP_SELF']."?alb=".$_GET['alb']."&delimg=".$row_imgList['AI_ID']; ?>" class="text-danger" onclick="return confirm('Delete this Image . . . ?')"><i class="fa fa-times"></i>&nbsp;Delete</a></td>
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