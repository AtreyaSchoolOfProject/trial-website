<div id="left">
<div class="media user-media">
<a class="user-link" href="">
<img class="media-object img-thumbnail user-img" alt="User Picture" src="../assets/img/sankha.png">
</a>

<div class="media-body">
<h5 class="media-heading"><?php echo $_SESSION['username'];
 ?></h5>
<ul class="list-unstyled user-info">
<li><a href="javascript:void(0)">Administrator</a></li>
<!--<li style="font-size: 12px;"><i class="fa fa-calendar"></i>&nbsp;Last Access : <br>
<small style="font-size: 12px;"><?php echo date('d, M, H:i:s', strtotime($_SESSION['lastLogin'])); ?></small>
</li>-->
</ul>
</div>
</div>
<ul id="menu" class="collapse">
    <li class="nav-divider"></li>
    <li><a href="../"><i class="fa fa-home">&nbsp;</i>HOME</a></li>
    <li class="panel "><a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#component-nav"><i class="fa fa-picture-o"></i> Gallery<span class="pull-right"><i class="fa fa-angle-left"></i></span></a>
        <ul class="collapse" id="component-nav">
            <li><a <a href="../Basic-Module/GalleryIndex.php?photo"><i class="fa fa-camera">&nbsp;</i>&nbsp;Photo</a></li>
            <li><a <a href="../Basic-Module/GalleryIndex.php?video"><i class="fa fa-video-camera">&nbsp;</i>&nbsp;Video</a></li>
           <!--<li class=""><a <a href="../Basic-Module/Alb_CreateNewAlbum.php">New Album</a></li>
            <li class=""><a <a href="../Basic-Module/Alb_UploadImg.php">Upload Image</a></li>-->
        </ul>
    </li>
    
    <li class="panel "><a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle collapsed"
    data-target="#form-update"><i class="fa fa-caret-square-o-right"></i> Media Resource<span class="pull-right"><i class="fa fa-angle-left"></i></span></a>
        <ul class="collapse" id="form-update">
            <li class=""><a <a href="../Basic-Module/UploadNoticeUpdate.php">Notice</a></li>
            <li class=""><a <a href="../Basic-Module/UploadAnnouncement.php">Announcements</a></li>
            <li class=""><a <a href="../Basic-Module/Upload_PressRelease.php">Press Release</a></li>
            <li class=""><a <a href="../Basic-Module/Upload_Infographic.php">Infographic</a></li>
        </ul>
    </li>

   <li class="panel "><a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle collapsed"
    data-target="#form-nav"><i class="fa fa-flag"></i> Events<span class="pull-right"><i class="fa fa-angle-left"></i></span></a>
        <ul class="collapse" id="form-nav">
            <li class=""><a <a href="../Basic-Module/UploadEventHeading.php">Social Initiatives</a></li>
            <li class=""><a <a href="../Basic-Module/ListEvents.php">View All</a></li>
        </ul>
    </li>
    
    <li class="panel "><a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#sms"><i class="fa fa-envelope"></i> SMS <span class="pull-right"><i class="fa fa-angle-left"></i></span></a>
	  <ul class="collapse" id="sms">
		  <li class=""><a <a href="../Basic-Module/User-List.php">Send SMS</a></li>
		  <li class=""><a <a href="../Basic-Module/Message-List.php">Sent Message(s) List</a></li>
		</ul>
	</li>
    <li class=""><a <a href="../Basic-Module/MemberList.php"><i class="fa fa-group"></i> &nbsp;Member List</a></li>
	<li class=""><a <a href="../Basic-Module/MailViewList.php"><i class="fa fa-list"></i> &nbsp;Quick Message(s)</a></li>
</ul>
<!-- /#menu -->
</div>

