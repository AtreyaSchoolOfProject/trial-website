<?php
ob_start();
session_start();
include("../require/session.inc.php");
include("../require/connection.inc.php");
include("../require/functions.inc.php");
include("../require/timezone.inc.php");
include("../require/common.inc.php");
include("../require/validate-user.inc.php");


$query_id = $_GET['query_id'];
if(!isset($query_id)){
	die('Invalid access to this page. <a href="MemberList.php">Click here</a> to redirect.');
}
$row_Member = mysql_fetch_assoc(mysql_query("SELECT * FROM `profile_info` WHERE `PI_Id`='$query_id'"));
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
dp_cal = new Epoch('epoch_popup','popup',document.getElementById('TF_DateOfBirth'));
};
</script>
<script type="text/javascript">
	function accountUpdate()
	{
		if($('#id').val()!=''){
			var formString = $('form').serialize()
			$.post('codes/C_MemberList.php', formString, function(html){
				//var value = html.trim().split('@')
				if(html=='success'){
					alert(html)
				}else{alert(html)}
			});
		}else alert('ERROR : Invalid Member Id..!!');
	}
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
                        <h3>&nbsp;</h3>
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
                        <h5>Member Detail</h5>
                      </header>
                      <div class="body">
                        <form class="form-horizontal" name="formprofile" id="formprofile">
                        <div class="row">
                        	<div class="col-md-9">
                                <div class="form-group">
                                	<input type="hidden" name="id" id="id" value="<?php echo $_GET['query_id']?>" />
                                    <label class="col-lg-2 col-md-2 col-sm-2 control-label">Profile Type:</label>
                                    <div class="col-lg-5 col-md-5">
                                    <select class="form-control" name="profile_type" id="profile_type">
                                        <?php
                                        $res_profiletype=mysql_query("SELECT DISTINCT(`ProfileType`) FROM `profile_info`");
                                        while($row_profiletype=mysql_fetch_assoc($res_profiletype))
                                        {
                                        ?>
                                            <option value="<?php echo $row_profiletype['ProfileType']?>" <?php if($row_profiletype['ProfileType']==$row_Member['ProfileType']){echo 'selected';}?>><?php echo $row_profiletype['ProfileType']?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-md-2 col-sm-2 control-label">Name:</label>
                                    <div class="col-lg-5 col-md-5">
                                    <input class="form-control" id="TF_FirstName" value="<?php echo $row_Member['Name']?>" name="TF_FirstName" placeholder="Enter your name" type="text">
                                    </div>
                                    <div class="col-lg-5 col-md-5">
                                    <input class="form-control" id="TF_EmailId" value="<?php echo $row_Member['Email']?>" name="TF_EmailId" placeholder="Email Id" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-md-2 col-sm-6 control-label">Gender:</label>
                                    <div class="col-lg-5 col-md-5">
                                    <select class="form-control" name="RG_Gender" id="RG_Gender">
                                        <option selected value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                    </div>
                                    <div class="col-lg-5 col-md-5">
                                    <input class="form-control" id="TF_DateOfBirth" value="<?php echo $row_Member['DOB']?>" name="TF_DateOfBirth" placeholder="Date Of Birth (e.g. YYYY-MM-DD)" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-md-2 control-label">Contact:</label>
                                    <div class="col-lg-5 col-md-5">
                                    <input class="form-control" id="telephone" value="<?php echo $row_Member['Tel']?>" name="telephone" placeholder="Telephone number" type="text">
                                    </div>
                                    <div class="col-lg-5 col-md-5">
                                    <input class="form-control" id="mobile" value="<?php echo $row_Member['Mobile']?>" name="mobile" placeholder="Enter 10 digit mobile number" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-md-2 col-sm-6 control-label">Location:</label>
                                    <div class="col-lg-10">
                                        <div class="col-lg-4 col-md-3">
                                        <select class="form-control" name="state" id="state">
                                            <option selected value="0">- state -</option>
                                            <option value="odisha">Odisha</option>
                                        </select>
                                        </div>
                                        <div class="col-lg-4 col-md-3">
                                        <select class="form-control" name="district" id="district">
                                            <option selected value="0">- district -</option>
                                            <option value="ganjam">Ganjam</option>
                                            <option value="gajapati">Gajapati</option>
                                        </select>
                                        </div>
                                        <div class="col-lg-4 col-md-3">
                                        <select class="form-control" name="zone" id="zone">
                                            <option selected value="0">- zone -</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-md-2 col-sm-6 control-label">&nbsp;</label>
                                    <div class="col-lg-10">
                                        <div class="col-lg-4 col-md-3">
                                        <select class="form-control col-lg-4 col-md-3" name="block" id="block">
                                            <option selected value="0">- block -</option>
                                            <?php
                                    $res_block=mysql_query("SELECT DISTINCT(`Block`) FROM `profile_info`");
                                    while($row_block=mysql_fetch_assoc($res_block))
                                    {
                                    ?>
                                        <option value="<?php echo $row_block['Block']?>" <?php if($row_block['Block']==$row_Member['Block']){echo 'selected';}?>><?php echo $row_block['Block']?></option>
                                     <?php
                                    }
                                    ?>
                                        </select>
                                        </div>
                                        <div class="col-lg-4 col-md-3">
                                        <select class="form-control col-lg-4 col-md-3" name="panchayat" id="panchayat">
                                            <option selected value="0">- panchayat -</option>
                                             <?php
                                    $res_panchayat=mysql_query("SELECT DISTINCT(`City_Pan`) FROM `profile_info`");
                                    while($row_panchayat=mysql_fetch_assoc($res_panchayat))
                                    {
                                    ?>
                                        <option value="<?php echo $row_panchayat['City_Pan']?>" <?php if($row_panchayat['City_Pan']==$row_Member['City_Pan']){echo 'selected';}?>><?php echo $row_panchayat['City_Pan']?></option>
                                     <?php
                                    }
                                    ?>
                                        </select>
                                        </div>
                                        <div class="col-lg-4 col-md-3">
                                        <select class="form-control col-lg-4 col-md-3" name="village" id="village">
                                            <option selected value="0">- village -</option>
                                            <?php
                                    $res_village=mysql_query("SELECT DISTINCT(`Village`) FROM `profile_info`");
                                    while($row_village=mysql_fetch_assoc($res_village))
                                    {
                                    ?>
                                        <option value="<?php echo $row_village['Village']?>" <?php if($row_village['Village']==$row_Member['Village']){echo 'selected';}?>><?php echo $row_village['Village']?></option>
                                     <?php
                                    }
                                    ?>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-md-2 col-sm-6 control-label">&nbsp;</label>
                                    <div class="col-lg-10">
                                        <div class="col-lg-4 col-md-3">
                                        <select class="form-control col-lg-4 col-md-4" name="ward" id="ward">
                                            <option selected value="0">- ward -</option>
                                            <?php
                                    $res_ward=mysql_query("SELECT DISTINCT(`WardNo`) FROM `profile_info`");
                                    while($row_ward=mysql_fetch_assoc($res_ward))
                                    {
                                    ?>
                                        <option value="<?php echo $row_ward['WardNo']?>" <?php if($row_ward['WardNo']==$row_Member['WardNo']){echo 'selected';}?>><?php echo $row_ward['WardNo']?></option>
                                     <?php
                                    }
                                    ?>
                                        </select>
                                        </div>
                                        <label class="col-lg-1">&nbsp;</label>
                                        <label class="col-lg-1">PIN:</label>
                                        <div class="col-lg-6 col-md-6">
                                        <input class="form-control " id="pincode" value="<?php echo $row_Member['PIN']?>" name="pincode" placeholder="Pincode" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-md-2 col-sm-6 control-label">Address</label>
                                    <div class="col-lg-10">
                                    <textarea class="form-control" id="address" name="address" placeholder="Your street address" type="text"><?php echo $row_Member['Address']?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-md-2 col-sm-6 control-label">About</label>
                                    <div class="col-lg-10">
                                    <textarea class="form-control" id="about" name="about" placeholder="Something about yourself" type="text"><?php echo $row_Member['About']?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-10">
                                    <div class="col-lg-6">
                                    <input type="button" onClick="accountUpdate()" class="btn btn-primary btn-block" name="BTN_Save" id="BTN_Save" value="Save Information"/>
                                    </div>
                                    <div class="col-lg-6">
                                    <a href="MemberList.php" class="btn btn-default btn-block"><i class="fa fa-reply"></i>&nbsp; Back To List</a>
                                    </div>
                                    <input type="hidden" name="action" value="memberUpdate" />
                                    </div>
                                </div>
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