<?php
include("../../require/session.inc.php");
include("../../require/connection.inc.php");
include("../../require/functions.inc.php");

?>
<script type="text/javascript">
$('#numberbox').keyup(function(e) {
	if(e.keyCode==13){
		countnumber()
		manuallist()
	}
	if($(this).val()==''){
		manuallist()
	}
});
$('.btn_block').click(function(e) {
	var arr = Array()
	$('.query_block').each(function(e){
        if(this.checked==true){
			arr.push(this.value)
		}
    });
	data = 'action=sortlocation&blocklist='+arr
	$.post('codes/C_User-List.php',data,function(html){
		$('#village_table').html('')
		$('#panchayat_table').html(html)
		memberlist()
	});
});
$('.btn_panchayat').click(function(e) {
	 var arr = Array()
	$('.query_panchayat').each(function(e){
        if(this.checked==true){
			arr.push(this.value)
		}
    });
	data = 'action=sortlocation&panchayatlist='+arr
	$.post('codes/C_User-List.php',data,function(html){
		$('#village_table').html(html)
		memberlist()
	});
});
$('.btn_village').click(function(e) {
	memberlist()
});

</script>
<?php
if($_POST['action']=='messagebox')
{
	?>
    <div class="col-lg-12 col-md-12">
        <div class="form-group">
            <textarea onkeyup="countmessage()" rows="7" style="font-size:12px" class="form-control" name="messagebox" id="messagebox" placeholder="Type your message...."></textarea>
        </div>
        <div class="form-group">
            <label>Choose format: <input type="radio" name="format" id="english" value="english" checked="checked"/> &nbsp;English&nbsp;&nbsp;<input type="radio" name="format" id="unicode" value="unicode"/> &nbsp;Unicode</label>
        </div>
        <div class="form-group">
            <textarea rows="7" style="font-size:12px" class="form-control" name="numberbox" id="numberbox" placeholder="Type 10 digit mobile no. & press ENTER key to add to list..."></textarea>
        </div>
        <div class="form-group">&nbsp;</div>
        <div class="form-group">
            <div class="col-lg-12 col-md-12">
                <button type="button" onclick="sendmessage('normal')" id="btn_sendmsg" name="btn_sendmsg" class="btn btn-primary btn-block"><i class="fa fa-upload">&nbsp;</i> Send Now</button>
            </div>
         </div>
         <div class="form-group">
            <div class="col-lg-12 col-md-12">
                <input onclick="locations()" type="button" id="btn_custommsg" name="btn_custommsg" class="btn btn-info btn-block" value="Customize"/>
            </div>
         </div>
       </div>
    </div>
    <?php
}
if($_POST['action']=='memberlist')
{
		if($_POST['profile_type']=='' && $_POST['designation']==''){
			$cond='WHERE 0';
		}else{
			$cond='WHERE 1';
		}
		if(isset($_POST['profile_type'])){
			$data = $_POST['profile_type'];
			$cond.=" AND (`ProfileType`='";
			$cond.=implode("' OR `ProfileType`='",$data);
			$cond.="')";
		}
		if(isset($_POST['designation'])){
			$data = $_POST['designation'];
			$cond.=" AND (`Desg`='";
			$cond.=implode("' OR `Desg`='",$data);
			$cond.="')";
		}
		if(isset($_POST['block'])){
			$data = $_POST['block'];
			$cond.=" AND (`Block`='";
			$cond.=implode("' OR `Block`='",$data);
			$cond.="')";
		}
		if(isset($_POST['panchayat'])){
			$data = $_POST['panchayat'];
			$cond.=" AND (`City_Pan`='";
			$cond.=implode("' OR `City_Pan`='",$data);
			$cond.="')";
		}
		if(isset($_POST['village'])){
			$data = $_POST['village'];
			$cond.=" AND (`Village`='";
			$cond.=implode("' OR `Village`='",$data);
			$cond.="')";
		}
		$query = "SELECT DISTINCT(`Mobile`) as `allNos` FROM `profile_info` ".$cond." GROUP BY `Mobile`" ;
		$res_query = mysql_query($query);
		if(mysql_num_rows($res_query)==0)
		{
		?>
			<div class="well text-danger h4"><?php echo "- No Contact Selected -"?></div>
			<input type="hidden" name="tot_contact" id="tot_contact" value="0"/>
		<?php
		}else
		{
			?>
			<div class="well text-success h4"><?php echo "<i class='fa fa-check'></i> Total ".mysql_num_rows($res_query)." contact(s) selected"?></div><input type="hidden" name="tot_contact" id="tot_contact" value="<?php echo mysql_num_rows($res_query)?>"/>
			<?php
			while($row_query = mysql_fetch_assoc($res_query)){
				$arrNos[] = $row_query['allNos'];
			}
			$strNos = implode(',',$arrNos);
			?>
			<input type="hidden" name="tot_nos" id="tot_nos" value="<?php echo $strNos?>"/>
			<?php
		}
}

if($_POST['action']=='locations')
{
	?>
	<div class="form-group well"><i class="fa fa-comments text-primary" style="font-weight:bold">&nbsp;Message : </i><?php echo $_POST['message']?><input name="msg_container" id="msg_container" type="hidden" value="<?php echo $_POST['message']?>" /></div>

<div class="form-group well">
    <div class="row">
        <div class="form-group text-primary">
            <h4>Blocks</h4>
        </div>
        <div class="form-group">
        <?php
        $block_key=1;
        $res_block=mysql_query("SELECT DISTINCT(`Block`) FROM `profile_info` WHERE `Block`!='' ORDER BY `Block` ASC");
        $col_count=1;
        while($row_block=mysql_fetch_assoc($res_block))
        {
        ?>
        <div class="col-lg-2">
            <label style="font-size:12px"><input class="query_block" type="checkbox" value="<?php echo $row_block['Block']?>" name="block[]" id="<?php echo $block_key?>"/>&nbsp;<?php echo ucwords($row_block['Block'])?></label>
        </div>
        <?php
        $col_count++;
        $block_key++;
        }
        ?>
        </div>
        <div class="form-group pull-right">
            <div class="col-lg-2">
             <a href="javascript:void(0)" id="btn_block" class="btn_block btn btn-info btn-sm" style="font-weight:bold">
                <i class="fa fa-filter"> Apply Filter</i>
              </a>
            </div>
        </div>
    </div>
    <div id="panchayat_table" class="row">&nbsp;</div>
    <div id="village_table" class="row"></div>
</div>    
    <?php
}

if($_POST['action']=='sortlocation')
{
	if($_POST['blocklist'])
	{
		?>  
        <div class="form-group text-primary">
           <h4>Panchayat(s)</h4>
        </div>
        <div class="form-group">
         <?php
            $pan_key=1;
			$data = explode(',',$_POST['blocklist']);
			foreach($data as $key => $value){
				$res_panchayat=mysql_query("SELECT DISTINCT(`City_Pan`) FROM `profile_info` WHERE `City_Pan`!='' AND `Block`='$value' ORDER BY `City_Pan` ASC");
            $col_count=1;
            while($row_panchayat=mysql_fetch_assoc($res_panchayat))
            {
            ?>
            <div class="col-lg-2">
               <label style="font-size:12px"><input class="query_panchayat" type="checkbox" value="<?php echo $row_panchayat['City_Pan']?>" name="panchayat[]" id="<?php echo $pan_key?>"/>&nbsp;<?php echo ucwords($row_panchayat['City_Pan'])?></label>
            </div>
            <?php
            $col_count++;
            $pan_key++;
            }	
			}
            ?>
		</div>
        <div class="form-group pull-right">
            <div class="col-lg-2">
             <a href="javascript:void(0)" id="btn_panchayat" class="btn_panchayat btn btn-info btn-sm" style="font-weight:bold">
                <i class="fa fa-filter"> Apply Filter</i>
              </a>
            </div>
        </div>
        <?php
	}
	
	if($_POST['panchayatlist'])
	{
		?>
        <div class="form-group text-primary">
            <h4>Village(s)</h4>
        </div>
        <div class="form-group">
			<?php
            $vill_key=1;
            $data = explode(',',$_POST['panchayatlist']);
            foreach($data as $key => $value){
            $res_block=mysql_query("SELECT DISTINCT(`Village`) FROM `profile_info` WHERE `Village`!='' AND `City_Pan`='$value' ORDER BY `Village` ASC");
            $col_count=1;
            while($row_block=mysql_fetch_assoc($res_block))
            {
            ?>
            <div class="col-lg-2">
                <label style="font-size:12px"><input class="query_village" type="checkbox" value="<?php echo $row_block['Village']?>" name="village[]" id="<?php echo $vill_key?>"/>&nbsp;<?php echo ucwords($row_block['Village'])?></label>
            </div>
            <?php
            $col_count++;
            $vill_key++;
            }
            }
            ?>
        </div>
        <div class="form-group pull-right">
            <div class="col-lg-2">
             <a href="javascript:void(0)" id="btn_village" class="btn_village btn btn-info btn-sm" style="font-weight:bold">
                <i class="fa fa-filter"> Apply Filter</i>
              </a>
            </div>
        </div>
    <?php
	}
}

if($_POST['action']=='manual')
{
	$manual_nos = trim($_POST['numberbox']);
	$final_nos = preg_replace('#\s+#',',',trim($manual_nos));
	if($final_nos!='')
	{
		$arrNos = explode(',',$final_nos);
		?><div class="well text-success h4"><?php echo "<i class='fa fa-check'></i> Manually ".count($arrNos)." contact(s) added"?></div><input type="hidden" name="each_contact" id="each_contact" value="<?php echo count($arrNos)?>"/>
        <input type="hidden" name="each_nos" id="each_nos" value="<?php echo $final_nos?>"/>
        <?php
	}
}

?>