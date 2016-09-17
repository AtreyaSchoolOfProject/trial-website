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
        <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-1669764-16', 'onokumus.com');
  ga('send', 'pageview');

</script>
<script src="../assets/lib/modernizr-build.min.js"></script>
<script type="text/javascript" src="../assets/lib/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(e) {
		messagebox()
		memberlist()
		$('.query').click(function(e) {
      		memberlist()
		});
    });
	function messagebox()
	{
		formString = 'action=messagebox'
		$.post('codes/C_User-list.php',formString,function(html){
			$('#msgcontent').html(html)
		});
	}
	function memberlist(type)
	{
		formString = $('#form-sort').serialize()+'&type='+type
		$.post('codes/C_User-list.php',formString,function(html){
			$('#memberList').html(html)
		});
	}
	function cancelmessage(){
		$('#form-sort').trigger('reset')
		memberlist()
		messagebox()
		$('#msgcounter').html('')
	}
	function sendmessage(sent_type)
	{
		var message = ($('#messagebox').val()) ? $('#messagebox').val() : $('#msg_container').val()
		message = $.trim(message)
		if(message!=''){
			var countNos = ($('#each_contact').val())?$('#each_contact').val() : '0';
			var countNos = parseInt(countNos)+parseInt($('#tot_contact').val())
			if(countNos){
				var allNos = ($('#each_nos').val())?$('#each_nos').val() : '';
				var allNos = ($('#tot_nos').val())?allNos+','+$('#tot_nos').val(): allNos
				formString = $('#form-sort').serialize()+'&sent_type='+sent_type+'&message='+message+'&allNos='+allNos+'&countNos='+countNos
				$.post('codes/C_send-message.php',formString,function(html){
					alert(html)
					$('#msgcounter').html(html)
					$('#form-sort').trigger('reset')
					memberlist()
					messagebox()
					$('#msgcounter').html('')
					$('#no_counter').html('')
				});
			}else{alert('No contact selected');}
		}else{
		alert('Warning : Please write your message first..!!');
		}
	}
	function manuallist()
	{
		formString = 'action=manual&numberbox='+$('#numberbox').val()
		$.post('codes/C_User-list.php',formString,function(html){
			$('#no_counter').html(html)
		});
	}
	function countnumber()
	{
		var strMultiLineText = $('#numberbox').val()
		var singleLineNos = strMultiLineText.replace(new RegExp( "\\n", "g" ), ",");
		singleLineNos = singleLineNos.replace(/,\s/g, "") 
		if(singleLineNos!=''){
			eachnumber = singleLineNos.split(',')
			for(c=0;c<eachnumber.length;c++)
			{
				if(eachnumber[c]!='')
				{
					IsMobileNumber(eachnumber[c],eachnumber.length)
				}
			}
		}
	}
	function IsMobileNumber(mobile,position) {
		var mob = /^[7-9]{1}[0-9]{9}$/;
		if (mob.test(mobile) == false) {
			alert('invalid mobile no. '+mobile)
			//return false;
		}
		return true;
	}
	function countmessage()
	{
		var count=$('#messagebox').val().length;
		var total=Math.ceil(count/160);
		$('#msgcounter').html('<div class="well text-info" id="msgcount"><strong>Total characters ('+count+')</stromg></div><input type="hidden" name="tot_msgcount" id="tot_msgcount" value="'+total+'"/>')
		$('#msgcount').append('<br /><strong>Total Message count ('+total+')</stromg>')
	}
	function locations(){
		var message = $('#messagebox').val()
		message = $.trim(message)
		if(message!=''){
			formString = 'action=locations&message='+$('#messagebox').val()
			$.post('codes/C_User-list.php',formString,function(html){
				$('#msgcontent').html(html)
				$('#msgcounter').append('<button type="button" onclick="sendmessage(\'customize\')" id="btn_sendmsg" name="btn_sendmsg" class="btn btn-primary btn-block"><i class="fa fa-upload">&nbsp;</i> Send Now</button><button type="button" onclick="cancelmessage()" id="btn_cancelmsg" name="btn_cancelmsg" class="btn btn-warning btn-block"><i class="fa fa-reply">&nbsp;</i>Cancel & Reset</button>')
			});
		}else{
			alert('Warning : Please write your message first..!!');
		}
	}
	
</script>
<style type="text/css">
.form-control::-webkit-input-placeholder { color: #3E3E3E; }
.form-control:-moz-placeholder { color: #3E3E3E; }
.form-control::-moz-placeholder { color: #3E3E3E; }
.form-control:-ms-input-placeholder { color: #3E3E3E; }</style>
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
                        <!--<div class="row">
                        <div class="col-lg-12 col-md-12">
                        <label class="col-lg-2">Type</label>
                        <div class="col-lg-10">
                            <?php
                            $prof_key = 1;
                            $res_profiletype=mysql_query("SELECT DISTINCT(`ProfileType`) FROM `profile_info`");
                            while($row_profiletype=mysql_fetch_assoc($res_profiletype))
                            {
                            ?>
                            <label class="col-lg-2">
                            <input class="query" type="checkbox" value="<?php echo $row_profiletype['ProfileType']?>" name="profile_type[]" <?php if($row_profiletype['ProfileType']=='member'){ echo "checked";}?> id="<?php $prof_key?>"/>&nbsp;<?php echo $row_profiletype['ProfileType']?>
                            </label>
                            <?php
                            $prof_key++;
                            }
                            ?>
                        </div>
                        </div>
                        </div>-->
                        <br />
                        <div class="row">
                        <div class="col-lg-12 col-md-12">
                        <label class="col-lg-2">Designation</label>
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
                        	<div id="msgcontent" class="col-lg-4 col-md-4">&nbsp;</div>
                            <div class="col-lg-4 col-md-4">
                                    <ul class="list-unstyled">
                                    <?php
                                    $prof_key = 1;
                                    $res_profiletype=mysql_query("SELECT DISTINCT(`ProfileType`) FROM `profile_info`");
                                    while($row_profiletype=mysql_fetch_assoc($res_profiletype))
                                    {
										$res_count = mysql_query("SELECT DISTINCT(`Mobile`) FROM `profile_info` WHERE `ProfileType`='".$row_profiletype['ProfileType']."' GROUP BY `Mobile`");
                                    ?>
                                    <li>
                                    <label class="pull-left col-lg-7"><input class="query" type="checkbox" value="<?php echo $row_profiletype['ProfileType']?>" name="profile_type[]" id="<?php $prof_key?>" <?php /*if($row_profiletype['ProfileType']=='member'){ echo 'checked="checked"';}*/?>/>&nbsp;<?php echo ucwords($row_profiletype['ProfileType'])?></label>
                                    <label class="pull-right col-lg-5"><?php echo 'Count : '.mysql_num_rows($res_count)?></label>
                                    </li>
                                    <?php
                                    $prof_key++;
                                    }
                                    ?>
                                    </ul>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div id="memberList" class="row col-lg-12 col-md-12">&nbsp;</div>
                                <div id="no_counter" class="row col-lg-12 col-md-12">&nbsp;</div>
                                <div id="msgcounter" class="row col-lg-12 col-md-12">&nbsp;</div>
                            </div>
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