<?php 
	require_once("../../require/connection.inc.php");
	require("../../require/functions.inc.php");
	
	if($_POST['action'] == "selectDist")
	{
		$res_dist = mysql_query("SELECT `DistrictName` FROM `z_district` WHERE `State_ID` IN (SELECT `State_ID` FROM `z_state` WHERE `StateName` = '".$_POST['stateVal']."')");
		?>
        <option value="">Select</option>
        <?php
		while($row_dist = mysql_fetch_assoc($res_dist))
		{
			?>
            <option value="<?php echo $row_dist['DistrictName']; ?>"><?php echo $row_dist['DistrictName']; ?></option>
            <?php
		}
	}
	
	if($_POST['action'] == "selectCity")
	{
		$res_city = mysql_query("SELECT `CityName` FROM `z_city` WHERE `District_ID` IN (SELECT `District_ID` FROM `z_district` WHERE `DistrictName` = '".$_POST['distVal']."')");
		echo "SELECT `CityName` FROM `z_city` WHERE `District_ID` IN (SELECT `District_ID` FROM `z_district` WHERE `DistrictName` = '".$_POST['distVal']."')";
		?>
        <option value="">Select</option>
        <?php
		while($row_city = mysql_fetch_assoc($res_city))
		{
			?>
           	<option value="<?php echo $row_city['CityName']; ?>"><?php echo $row_city['CityName']; ?></option>
            <?php
		}
	}
	
	if($_POST['action'] == "checkUserNm")
	{
		$res_chkUserNm = mysql_query("SELECT * FROM `login_info` WHERE `LI_UserName` = '".$_POST['userNm']."'");
		if(mysql_num_rows($res_chkUserNm) > 0)
			die("error");
		else
			die("success");
			
	}
	if($_POST['action'] == "userRegister")
	{
		$lastOrgInfo = mysql_fetch_assoc(mysql_query("SELECT `Code` FROM `org_basic_info` ORDER BY `Organisation_ID` DESC LIMIT 0, 1"));
		$orgCode = ($lastOrgInfo['Code'] != '') ? ("ORG-".end(explode("-", $lastOrgInfo['Code']))) : "ORG-100000";
		mysql_query("INSERT INTO `org_basic_info` (`Name`, `ShortName`, `Code`, `OrganisationDetails`, `Type`, `Type_Description`, `YearOrEstablish`, `Website`, `ContEmail`, `CustCareNo`, `TelNo`, `IsActive`, `CreatedBy`) VALUES ('".$_POST['orgName']."', '".$_POST['oShrtName']."', '$orgCode', '".$_POST['orgDetail']."', '".$_POST['type']."', '".$_POST['typeDetail']."', '".$_POST['yoe']."', '".$_POST['webSite']."', '".$_POST['contEmail']."', '".$_POST['ccNo']."', '".str_replace("*", "+", $_POST['telNo'])."', 1, '".$_SESSION['username']."')");
		
		mysql_query("INSERT INTO `org_address_detail` (`AddressType`, `UserType`, `Reff_Val`, `Address`, `State`, `District`, `City`, `PIN`) VALUES ('Corporate', 'Organisation', '$orgCode', '".$_POST['oaddress']."', '".$_POST['ostate']."', '".$_POST['odist']."', '".$_POST['ocity']."', '".$_POST['opin']."')");
		
		mysql_query("INSERT INTO `login_info` (`LI_UserName`, `LI_Password`, `LI_Email`, `LI_SecQue`, `LI_SecAns`, `LI_DateCreated`, `LI_Role`) VALUES ('".$_POST['userNm']."', '".password_encrypt($_POST['password'])."', '".$_POST['userNm']."', '".$_POST['secQuestion']."', '".$_POST['secAnswer']."', TIMESTAMP(NOW()), '4')");
		$userId = mysql_insert_id();
		
		mysql_query("INSERT INTO `login_status` (`LS_UserID`, `LS_TypeID`, `LS_Time`) VALUES ('".$userId."', '1', TIMESTAMP(NOW()))");
		$userImg = ($_POST['gender'] == "Male") ? "MaleUser.jpg" : "FemaleUser.jpg";
		
		mysql_query("INSERT INTO `org_emp_info` (`Org_Code`, `Emp_Type`, `BI_LoginName`, `BI_Name`, `BI_DOB`, `BI_Gender`, `BI_Mob1`, `BI_Image`, `BI_CreatedOn`) VALUES ('$orgCode', 'OrgAdmin', '".$_POST['userNm']."', '".$_POST['name']."', '".$_POST['dob']."', '".$_POST['gender']."', '".$_POST['mobNo']."', '$userImg', DATE(NOW()))");
		
		mysql_query("INSERT INTO `org_address_detail` (`AddressType`, `UserType`, `Reff_Val`, `Address`, `State`, `District`, `City`, `PIN`) VALUES ('Present', 'Employee', '".$_POST['userNm']."', '".$_POST['address']."', '".$_POST['state']."', '".$_POST['dist']."', '".$_POST['city']."', '".$_POST['pin']."')");
		
		mysql_query("UPDATE `org_basic_info` SET `Emp_logNm` = '".$_POST['userNm']."' WHERE `Code` = '$orgCode'");
	}
?>