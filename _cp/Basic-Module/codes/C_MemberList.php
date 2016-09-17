<?php
include("../../require/session.inc.php");
include("../../require/connection.inc.php");
include("../../require/functions.inc.php");

?>
<?php
if($_POST['action']=='removemember')
{
	$row = mysql_fetch_Assoc(mysql_query("SELECT `Mobile` FROM `profile_info` WHERE `PI_Id` = '".$_POST['id']."'"));
	$removed = mysql_query("DELETE FROM `profile_info` WHERE `PI_Id`='".$_POST['id']."'");
	 mysql_query("OPTIMIZE TABLE `profile_info`"); 
	 if($removed){
		mysql_query("DELETE FROM `login_info` WHERE `LI_UserName`='".$row['Mobile']."'");
		mysql_query("DELETE FROM `login_status` WHERE `LS_UserID`='".$row['Mobile']."'");
		mysql_query("OPTIMIZE TABLE `login_info`");
		mysql_query("OPTIMIZE TABLE `login_status`");
		 echo 'success';
	 }else{
	 	echo 'ERROR : Failed to Remove '.$memberName;
	 }
}

if($_POST['action']=='memberlist')
{
	?>
	<script type='text-javascript'>
	function sortPaging(lower, upper)
		{
			var itemGroup = ($('#SE_ItemGroup').val()) ? $('#SE_ItemGroup').val() : "";
			var itemType = ($('#SE_ItemType').val()) ? $('#SE_ItemType').val() : "";
			var sortNm = $('#HD_SortName').val();
			$('#itemList').html('&nbsp;&nbsp;Loading . . .')
			dataCont = "action=viewItemList&type=pageSort&itemGroup="+itemGroup+"&itemType="+itemType+"&sortNm="+sortNm+"&lower="+lower+"&uppper="+upper;
			//alert(dataCont);
			$.ajax({
				type: 'POST',
				url: "codes/c_itemMaster.php",
				data: dataCont,
				success: function(html){
					$('#itemList').fadeOut(300, function(){
						$('#itemList').html('')
					})
					$('#itemList').fadeIn(300, function(){
						$('#itemList').html(html)
					})
				}
			});
		}
	</script>
	<?php
	if(isset($_POST['profile_type'])){
		$data = $_POST['profile_type'];
		$cond.=($_POST['profile_type']!='0') ? " AND `ProfileType`='".$data."'":'';
		//$cond.=implode("' OR `ProfileType`='",$data);
		//$cond.="')";
	}
	if(isset($_POST['designation'])){
		//$data = $_POST['designation'];
		$cond.=" AND (`Desg`='";
		$cond.=implode("' OR `Desg`='",$_POST['designation']);
		$cond.="')";
	}
	if(isset($_POST['block'])){
		$data = $_POST['block'];
		$cond.=($_POST['block']!='0') ? " AND `Block`='".$data."'":'';
		//$cond.=implode("' OR `Block`='",$data);
		//$cond.="')";
	}
	if(isset($_POST['panchayat'])){
		$data = $_POST['panchayat'];
		$cond.=($_POST['panchayat']!='0') ? " AND `City_Pan`='".$data."'":'';
		//$cond.=implode("' OR `City_Pan`='",$data);
		//$cond.="')";
	}
	if(isset($_POST['village'])){
		$data = $_POST['village'];
		$cond.=($_POST['village']!='0') ? " AND `Village`='".$data."'":'';
		//$cond.=implode("' OR `Village`='",$data);
		//$cond.="')";
	}
	if(isset($_POST['searchmobile']) && $_POST['searchmobile']!=''){
		$data = $_POST['searchmobile'];
		$cond =" AND `Mobile`='".$data."'";
		//$cond.=implode("' OR `Village`='",$data);
		//$cond.="')";
	}
	
	$lower = (isset($_POST['lower'])) ? $_POST['lower'] : 0;
	$upper = (isset($_POST['upper'])) ? $_POST['upper'] : 25;
	$totContact = mysql_query("SELECT `PI_Id` FROM `profile_info` WHERE 1".$cond." GROUP BY `Mobile`");
	$query = "SELECT `PI_Id`, `Name`, `Mobile` FROM `profile_info` WHERE 1".$cond." GROUP BY `Mobile` ORDER BY `Name` ASC LIMIT $lower, $upper" ;
	$res_query = mysql_query($query);
	if(mysql_num_rows($res_query)==0)
	{
	?>
    	<div class="well text-danger h4"><?php echo "- No Record Found -"?></div>
        <input type="hidden" name="tot_contact" id="tot_contact" value="0"/>
    <?php
	}else
	{
		?>
        <!--<div class="well text-success h4"><?php echo "<i class='fa fa-check'></i> Total ".mysql_num_rows($res_query)." contact(s) selected"?></div><input type="hidden" name="tot_contact" id="tot_contact" value="<?php echo mysql_num_rows($res_query)?>"/>-->
        
        <table class="table table-primary table-responsive">
        	<thead>
            	<tr>
                	<th>Name</th>
                    <th>Mobile</th>
                    <th colspan="2"></th>
                </tr>
            </thead>
            <tbody>
        <?php
		while($row_query = mysql_fetch_assoc($res_query))
		{
		?>
            	<tr>
                	<td><?php echo $row_query['Name']?></td>
                    <td><?php echo $row_query['Mobile']?></td>
                    <td><a class="btn btn-default btn-sm" href="MemberDetail.php?query_id=<?php echo $row_query['PI_Id']?>"><i class="fa fa-pencil"></i> Edit</a></td>
                    <td><a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="removemember(<?php echo $row_query['PI_Id']?>,'<?php echo $row_query['Name']?>')"><i class="fa fa-trash-o"></i> Remove</a></td>
                </tr>
        <?php
		}
		?>
            </tbody>
			<tfoot>
				<tr>
					<td colspan="7">
					<div class="text-right">
					<nav>
					  <ul class="pagination pagination-sm">
						<?php 
						//echo $totItems;
							for($i = 0; $i < (mysql_num_rows($totContact) / 25); $i++)
							{
								?>
								<li class="<?php if($lower == $i*25) echo 'active'; ?>"><a href="javascript:void(0)" onClick="sortPaging(<?php echo $i*25 ?>, 10)"><?php echo $i+1; ?></a></li>
								<?php
							}
						?>
					  </ul>
					</nav>
					</div></td>
				</tr>
			</tfoot>
        </table>
        <?php

	}
}

if($_POST['action']=='memberUpdate')
{
	$updated = mysql_query("UPDATE `profile_info` SET `ProfileType`='".$_POST['profile_type']."', `Desg`='".$_POST['']."', `Name`='".$_POST['TF_FirstName']."', `Gender`='".$_POST['RG_Gender']."', `DOB`='".$_POST['TF_DateOfBirth']."', `About`='".$_POST['about']."', `State`='".$_POST['state']."', `Dist`='".$_POST['district']."', `Zone`='".$_POST['zone']."', `Block`='".$_POST['block']."', `City_Pan`='".$_POST['panchayat']."', `WardNo`='".$_POST['ward']."', `Village`='".$_POST['village']."', `PIN`='".$_POST['pincode']."', `Tel`='".$_POST['telephone']."', `Mobile`='".$_POST['mobile']."', `Email`='".$_POST['TF_EmailId']."', `Address`='".$_POST['address']."' WHERE `PI_Id`='".$_POST['id']."'");
	
	if($updated){
		echo "success";
	}else{
		echo "Error : Unable to update profile.!!";
	}
}
?>