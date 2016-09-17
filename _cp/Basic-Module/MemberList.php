<?php
ob_start();
include("../require/session.inc.php");
include("../require/connection.inc.php");
include("../require/functions.inc.php");
include("../require/timezone.inc.php");
include("../require/common.inc.php");
include("../require/validate-user.inc.php");

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
        <link rel="stylesheet" href="../assets/lib/wysihtml5/dist/bootstrap-wysihtml5-0.0.2.css">
    	<link rel="stylesheet" href="../assets/css/jquery.cleditor-hack.css">
        <link rel="stylesheet" type="text/css" href="../assets/css/custom.css"/>
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
<script type="text/javascript" src="../assets/lib/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(e) {
		memberlist()
		$('.query').change(function(e) {
            memberlist()
        });
    });
	function removemember(memberid,membername)
	{
		if(confirm('Confirm remove '+membername+' ..?')){
			formString = 'action=removemember&id='+memberid+'&membername='+membername
			$.post('codes/C_MemberList.php',formString,function(html){
				//alert(html)
				memberlist()
			});
		}
	}
	function memberlist()
	{
		formString = $('#form-sort').serialize()
		$.post('codes/C_MemberList.php',formString,function(html){
			$('#memberList').html(html)
		});
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
                        <h3><i class="fa fa-calendar"> </i> Members</h3>
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
                  <div class="inner" style="min-height:500px">
                  
                  <br />
                      <form id="form-sort" method="post" class="form-group row">
                      <input type="hidden" name="action" id="action" value="memberlist"/>
                      	<div class="row">
                        	<div class="col-lg-12 col-md-12">
                            <label class="col-lg-2">Search by : </label>
                            <div class="col-lg-3">
                            	<div class="input-group">
                                  <input type="text" class="form-control" name="searchmobile" id="searchmobile" placeholder="mobile no."/><span class="input-group-btn">
                                    <button onclick="memberlist()" class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
                                  </span>
                                </div>
                            </div>
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                            	<label class="col-lg-2">Sort by : </label>
                                <div class="col-lg-2">
                                    <select class="query form-control" name="profile_type" id="profile_type">
                                            <option value="0">- type -</option>
                                        <?php
                                        $res_profiletype=mysql_query("SELECT DISTINCT(`ProfileType`) FROM `profile_info`");
                                        while($row_profiletype=mysql_fetch_assoc($res_profiletype))
                                        {
                                        ?>
                                            <option value="<?php echo $row_profiletype['ProfileType']?>"><?php echo $row_profiletype['ProfileType']?></option>
                                        <?php
                                        }
                                        ?>
                                        </select>
                                </div>
                                <div class="col-lg-2">
                                    <select class="query form-control" name="block" id="block">
                                        <option value="0">- block -</option>
                                    <?php
                                    $res_block=mysql_query("SELECT DISTINCT(`Block`) FROM `profile_info`");
                                    while($row_block=mysql_fetch_assoc($res_block))
                                    {
                                    ?>
                                        <option value="<?php echo $row_block['Block']?>"><?php echo $row_block['Block']?></option>
                                     <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <select class="query form-control" name="panchayat" id="panchayat">
                                        <option value="0">- panchayat -</option>
                                    <?php
                                    $res_panchayat=mysql_query("SELECT DISTINCT(`City_Pan`) FROM `profile_info`");
                                    while($row_panchayat=mysql_fetch_assoc($res_panchayat))
                                    {
                                    ?>
                                        <option value="<?php echo $row_panchayat['City_Pan']?>"><?php echo $row_panchayat['City_Pan']?></option>
                                     <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <select class="query form-control" name="village" id="village">
                                        <option value="0">- village -</option>
                                    <?php
                                    $res_village=mysql_query("SELECT DISTINCT(`Village`) FROM `profile_info`");
                                    while($row_village=mysql_fetch_assoc($res_village))
                                    {
                                    ?>
                                        <option value="<?php echo $row_village['Village']?>"><?php echo $row_village['Village']?></option>
                                     <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <select class="query form-control" name="ward" id="ward">
                                        <option value="0">- ward -</option>
                                    <?php
                                    $res_ward=mysql_query("SELECT DISTINCT(`WardNo`) FROM `profile_info`");
                                    while($row_ward=mysql_fetch_assoc($res_ward))
                                    {
                                    ?>
                                        <option value="<?php echo $row_ward['WardNo']?>"><?php echo $row_ward['WardNo']?></option>
                                     <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>
                      	</div>
                      <br />
                      <div class="row">
                      	<div class="col-lg-12 col-md-12">
                        <label class="col-lg-2">&nbsp;</label>
                        <div class="col-lg-10">
						<?php
                        $res_designation=mysql_query("SELECT `Designation` FROM `profile_designation`");
						
                        while($row_designation=mysql_fetch_assoc($res_designation))
                        {
                        ?>
                        <label class="col-lg-3">
                        <input class="query" type="checkbox" value="<?php echo $row_designation['Designation']?>" name="designation[]" id="<?php echo $row_designation['PD_Id']?>"/>&nbsp;<?php echo $row_designation['Designation']?>
                        </label>
                        <?php
						}
                        ?>
                        </div>
                        </div>
                      </div>
                    <hr />
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        	<div id="memberList" class="col-lg-8 col-md-8 col-sm-12 col-xs-12">&nbsp;</div>
                        </div>
                    </div>
                    </form>
                    
                    
                  </div>
                  <!-- end .inner -->
                </div>
                <!-- end .outer -->
            </div>
            <!-- end #content -->

            

        </div>
        <!-- /#wrap -->


        <div id="footer">
            <p>&copy; 2016 All Rights Reserved</p>
        </div>

  <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>-->
  <script>window.jQuery || document.write('<script src="assets/lib/jquery.min.js"><\/script>')</script> 
  
  
  
  
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
            /*$( 'textarea#MTXT_Reply' ).ckeditor({width:'98%', height: '150px', toolbar: [
				{ name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
				[ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],			// Defines toolbar group without name.
				{ name: 'basicstyles', items: [ 'Bold', 'Italic' ] }
			]});*/
           $( 'textarea#MTXT_EventData' ).ckeditor({width:'99.6%', height: '350px'});
        });

        // Tiny MCE
       

        </script>  
  
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
</body>
</html>