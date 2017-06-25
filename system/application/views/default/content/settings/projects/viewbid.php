<?php  if (!defined('BASEPATH')) exit('No direct script access allowed') ; ?>
<div id="leftb" ><!-- start left block -->
<?php
// project details
$project_id = $project_details[0]['project_id'] ; 
$title = htmlspecialchars( $project_details[0]['title'], ENT_QUOTES, 'UTF-8' ) ; 
$description = nl2br( $project_details[0]['description'] ) ; 
$dateposted2 = date( "M j, Y", $project_details[0]['dateposted'] ) ;
$dateposted = $project_details[0]['dateposted'] ;
$project_status = $project_details[0]['project_status'] ; 
$rs1 = $this->users_model->get_user_by_id( $project_details[0]['created_by'] , 'users.id, users.username', 'result_array' ) ; 
$created_by_id = $project_details[0]['created_by'] ;  
$created_by = $rs1[0]['username'] ;
$duration = $project_details[0]['duration'] ; 
$budget = $project_details[0]['budget'] ; 
$numofdays = $project_details[0]['numofdays']  ; 
$project_categories = $this->project_categories_model->get_project_categories( array( 'project_id' => $project_id ) ) ; 
$m = count( $project_categories ) ;
$categories = '' ;
for( $i=0; $i<$m; $i++ ) {
	$category_url = $project_categories[$i]['category_url']  ;
	$categories .= "<a href='" . site_url("categories/$category_url"). "'>" . $project_categories[$i]['category'] . "</a>" ;
	if ( ($i+1) <$m) $categories .= ', ';
}

$uri = $this->uri->uri_to_assoc( 1 ) ;
if ( isset( $uri['viewbid'] ) )
{
	$m = "&laquo; Back to your bid listings" ;		
	$burl = 'settings/projects/my_bids' ;
}
else
{
	$m = "&laquo; Back to your project listings" ;	
	$burl = 'settings/projects/my_projects' ;
}
?>
<?= !empty( $flash_message ) ? flash_message( $flash_message  ) : '' ?>
<div id="viewproject" >
		<span class="rpt_v"><a href="<?= site_url( $burl ) ?>" ><?= $m ?></a></span>
		<h1><?= $title ; ?></h1><a href="javascript:toggles('proj_detail');" class="lnk1" >Show project details <img src="<?= $assets_images ?>resultset_next.png"  /></a>
	<div id="proj_detail" style="display:none; padding:2px" >
	<table width="100%" border="0" class="table" >
	  <tr>
		<td class="a"  width="10%">Date Posted </td>
		<td width="59%"><?= $dateposted2 ;?></td>
	  </tr>
	  <tr>
	    <td class="a" >Job type </td>
	    <td><?= $categories ;?></td>
      </tr>
	  <tr>
		<td class="a" >Buyer</td>
		<td><?= $created_by ; ?>&nbsp;<?= ( isset($this->logged_userid) && $created_by_id === $this->logged_userid ) ? "<img src=\"{$this->assets_images}you_24.gif\"  />" : '' ?></td>
	  </tr>
	  <tr>
		<td class="a" >Status</td>
		<td><?= $project_status ; ?></td>
	  </tr>
	  <tr>
		<td class="a">Duration</td>
		<td><?= $duration ; ?></td>
	  </tr>
	  <tr>
		<td class="a">Project Budget </td>
		<td><?= $budget ; ?></td>
	  </tr>
	  <tr>
		<td class="a">Description</td>
		<td>
		 <?= $description ; ?>		</td>
	  </tr>
	</table> 
	<?php if ( isset( $uri['viewbid'] ) ) : ?>
	<div style="margin-left:40% ; _margin-left:27%" ><a href="<?= site_url( $sendpm ) ?>" class="buyerbtn"></a></div>
	<?php else:?>	
	<div style="margin-left:30% ; _margin-left:27%" ><a href="<?= site_url( "settings/projects/close/$project_id" ) ?>" class="closepbtn" id="closepbtn" ></a></div>	

	<?php endif ; ?>
</div>
<div class="clear" >&nbsp;</div>
<h2>Your Bids</h2>
<table width="100%" border="0"  class="table1" >
  <tr>
    <td width="30%" class="b" >Bid</td>
    <td width="21%" class="b" >Date</td>
    <td class="b" width="27%" >Status</td>
    <td class="b" width="14%" >&nbsp;</td>
  </tr>
<?php
if ( $bidders ):
$n = count( $bidders ) ;
for( $i=0; $i<$n; $i++ ):
$bid_id = $bidders[$i]['bid_id'] ;
?>  
  <tr>
    <td><?= $bidders[$i]['amount'] ?>&nbsp;&nbsp;
	<?php if ( !empty( $bidders[$i]['message'] )): ?><a href="javascript:toggles('bidblck<?=$bid_id?>')" >&raquo;</a><?php endif; ?><div id="bidblck<?=$bid_id?>" style="display:none" ><?= $bidders[$i]['message'] ?></div></td>
    <td><?= date( 'M d,Y g:m a', $bidders[$i]['datebidded'] ) ?></td>
    <td><?= $bidders[$i]['bid_status'] ?></td>
    <td><a href="<?= site_url( "settings/bid/deletebid/$bid_id" ) ?>" class="cancelpbtn_flat" >remove my bid</a></td>
  </tr>
<?php 
endfor; 
else:
?>  
	<tr>
		<td colspan="4" ><h1 class="error1">No bid found.</h1></td>
	</tr>
<?php endif; ?>	
</table>

	<div class="clear">&nbsp;</div>
	<h2>Private Message Board</h2>	
	<table width="101%" border="0" class="table1" id="bidders" style="xdisplay:none">
	<tr>
	<td width="56%" class="b" >Buyers</td>
	<td width="20%" class="b" >&nbsp;</td>
	</tr>
	<?php
	if ( $messages ):
	$n2 = count($messages) ;
	for( $j=0; $j<$n2; $j++ ):
	$rs = array() ;
	$rs = $this->users_model->get_user_by_id( $messages[$j]['from'], 'users.username' ) ;
	$from = $rs[0]['username'] ;
	$from_id = $messages[$j]['from'] ;
	$message_id = $messages[$j]['message_id'] ;
	$message = $messages[$j]['message'] ; 
	$dateposted = date('M d,Y', $messages[$j]['dateposted'] ) ; 
	// get the messages
	//$this->projects_messages_model->group_by_ = 'from' ;
	$w = array( 'project_id' => $project_id, 'from' => $from_id, 'to' => $this->logged_userid, 'isopen' => '0'  ) ;
	$num_msg = $this->projects_messages_model->get_project_message_by_criteria( $w )  ;	
	
	?>
	
	<tr class="r<?=($j%2)?>" >
	<td><a href="<?= site_url( "messages/p/$project_id/b/$from_id" ) ?>" ><?= $from ?></a></td>
	<td class="bold1x" ><strong><?= ($num_msg) ? count($num_msg) . " new message(s)" : 0 ?></strong></td>
	</tr>
	<?php endfor ; ?>
	<?php else: ?>
	<tr><td colspan="3" ><h1 class="error1" >None</h1></td></tr>
	<?php endif ; ?>
	</table>
		
  </div>
</div><!-- end left block -->				

<!-- BEGIN right block -->	
<div id="rightb" >	
	<?= $userpanel ; ?>
</div><!-- END right block -->
