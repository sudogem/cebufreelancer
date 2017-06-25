<?php  if (!defined('BASEPATH')) exit('No direct script access allowed') ; ?>
<div id="leftb" ><!-- start left block -->
<?php
$project_id = $project_details[0]['project_id'] ; 
$title = h( $project_details[0]['title'] ) ; 
$description = nl2br( h($project_details[0]['description']) ) ; 
$dateposted2 = date( "M j, Y", $project_details[0]['dateposted'] ) ;
$dateposted = $project_details[0]['dateposted'] ;
$project_status = $project_details[0]['project_status'] ; 
$rs1 = $this->users_model->get_user_by_id( $project_details[0]['created_by'] , 'users.id, users.username', 'result_array' ) ; 
$created_by_id = $project_details[0]['created_by'] ;  
$created_by = $rs1[0]['username'] ;
$owner_id = $rs1[0]['id'] ;
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
<?= !empty( $flash_message ) ? flash_message( $flash_message , $flashb, TRUE ) : '' ?>
<div id="viewproject"  >
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
	<div class="clear">&nbsp;</div>	
	<?php if ( isset( $uri['viewbid'] ) ) : ?>
	<div style="float:right" ><a href="<?= site_url( $sendpm ) ?>" class="buyerbtn"></a></div>
	<?php else:?>	
	<div style="float:right" ><a href="<?= site_url( "settings/projects/close/$project_id" ) ?>" class="closepbtn" id="closepbtn" ></a></div>	
	<?php endif ; ?>
	<div class="clear">&nbsp;</div>
</div>

<div class="clear" >&nbsp;</div>
<h2>User(s) who made a bid on the project </h2>
<div id="bidders" >
<table width="101%" border="0" class="table1">
	<tr>
	<td width="56%" class="b" >Users </td>
	<td width="20%" class="b" >Date Bidded </td>
	</tr>
	<?php
	if ( $bidders ):
	$n2 = count( $bidders ) ;
	for( $j=0; $j<$n2; $j++ ):
	$rs = array() ;
	$bid_id = $bidders[$j]['bid_id'] ;
	$rs = $this->users_model->get_user_by_id( $bidders[$j]['user_id'], 'users.username, users.id'  ) ;
	$user_id = $rs[0]['id'] ;
	$username = $rs[0]['username'] ;
	$datebidded = date( 'M d, Y g:i a', $bidders[$j]['datebidded'] ) ;
	$bid_status = $bidders[$j]['bid_status'] ;
	switch( $bid_status )
	{
		case 'waiting for buyer\'s confirmation' :
			$bid_status = 'waiting for your confirmation.' ;
			$style_bid_status = 'bid_waiting' ;
			break ;
		case 'bid accepted' :
			$style_bid_status = 'bid_accepted'; 
			break ;
	}
	?>
	
	<tr class="r<?=($j%2)?>" >
	<td><a href="<?= site_url( "settings/bid/p/$project_id/v/$bid_id" ) ?>" ><?= $username ?></a>&nbsp;&nbsp;<?= ($bid_status) ? "<span class='$style_bid_status'>$bid_status</span>" : '' ?></td>
	<td><?= $datebidded ?></td>
	</tr>
	<?php endfor ; ?>
	<?php else: ?>
	<tr><td colspan="2" ><h1 class="error1" >No bid found.</h1></td></tr>
	<?php endif ; ?>
	</table>
</div>
	
	<div class="clear">&nbsp;</div>
	<h2>Private Message Board</h2>	
	<table width="101%" border="0" class="table1" id="bidders" style="xdisplay:none">
	<tr>
	<td width="56%" class="b" >Freelancers</td>
	<td width="20%" class="b" >&nbsp;</td>
	</tr>
	<?php
	if ( $messages ):
	$n2 = count($messages) ;
	for( $j=0; $j<$n2; $j++ ):
	$rs = array() ;
	$rs = $this->users_model->get_user_by_id( $messages[$j]['from'],'users.username' ) ;
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
	<td class="bold1x" ><strong><?= ($num_msg) ? count($num_msg) . " new messages" : '' ?></strong></td>
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
