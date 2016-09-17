<?php
$query_contact = "SELECT * FROM `contact_mail_us` WHERE `M_OI_OrganisationID` = '".$_SESSION['OI_OrganisationID']."' AND";
	$lower = (isset($_GET['lower'])) ? $_GET['lower'] : 0;
	$upper = (isset($_GET['upper'])) ? $_GET['upper'] : 20;

switch ($_GET['type'])
	{
	case '1' :
			$query_contact .= " `M_Viewed`=0 ";
			$heading = "New";
	break;
	case '2' :	
			$query_contact .= " `M_Viewed`=1 ";
			$heading = "Read";
	break;		
	default : 
			$query_contact = " SELECT * FROM `contact_mail_us` WHERE `M_OI_OrganisationID` = '".$_SESSION['OI_OrganisationID']."' ";
			$heading = "All";
	}
	$totData = $query_contact;
	$query_contact .= "LIMIT $lower, $upper";

?>
<?php
if(isset($_POST['BTN_Mail_Delete1']) ||  isset($_POST['BTN_Mail_Delete2']))
	{
	$delete = $_POST['CHK_delete'];//get the id of check box which is deleted
	foreach($delete as $i)
		{			
			//The select commmend written to retrive the statusID where the status name is DELETED						
			mysql_query("DELETE FROM `contact_mail_us` where `M_ID`='$i'");
			mysql_query("OPTIMIZE TABLE `contact_mail_us`");
			mysql_query("DELETE FROM `contact_reply` WHERE `CR_C_ID`='$i' AND `CR_ReplyCategory`= 'MAIL'");
			mysql_query("OPTIMIZE TABLE `contact_reply`");
		}
	}
?>