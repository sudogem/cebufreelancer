<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="leftb" ><!-- start left block -->	
	<div>
		<h1 class="h1 f" >My Bids</h1>
		<div class="clear" ></div> 
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableroll"  >
		  <tr>
			<th width="30%">Project Title</th>
			<th width="16%">Contact person</th>
			<th width="10%">Project Status</th>
		    <th width="14%"># of New Message </th>
		  </tr>
<?php
if ( $all_bids ):
	$n = count( $all_bids ) ;
	for( $i=0; $i<$n; $i++ ):
	$bid_id = $all_bids[$i]['bid_id'] ; 
	$project_title = $all_bids[$i]['title'] ; 
	$bid_status = $all_bids[$i]['bid_status'] ; 
	$project_id = $all_bids[$i]['project_id'] ; 
	$dateposted = date( "M j, Y", $all_bids[$i]['dateposted'] ) ; 	
	$amount = $all_bids[$i]['amount'] ; 
	$created_by = $this->users_model->get_user_by_id( $all_bids[$i]['created_by'], 'users.username','row' )->username ; 
	$project_title = htmlspecialchars( $all_bids[$i]['title'], ENT_QUOTES, 'UTF-8' ); 
	$budget = htmlspecialchars( $all_bids[$i]['budget'], ENT_QUOTES, 'UTF-8' ) ; 
	$duration = htmlspecialchars( $all_bids[$i]['duration'], ENT_QUOTES, 'UTF-8' ); 
	$description =  $all_bids[$i]['description']  ; 	
	//$project_status = $this->projects_model->get_project_status( NULL, array( 'status_id' => $all_bids[$i]['project_status'] ), 'row' )->status ; 	
	$project_status =  $all_bids[$i]['project_status']  ; 	
	$time_remaining = 100 ;

	$w = array( 'project_id' => $project_id, 'to' => $this->logged_userid, 'isopen' => '0'  ) ;
	$num_msg = $this->projects_messages_model->get_project_message_by_criteria( $w )  ;	
	
?>		  
		  <tr class="r<?=($i%2) ?>" >
			<td><a href="<?= site_url( "settings/projects/viewbid/$project_id" ) ?>" ><?= $project_title ?></a></td>
			<td><?= $created_by ?></td>
			<td><?= $project_status ?></td>
		    <td><?= ( $num_msg ) ? count( $num_msg ) : 0 ; ?></td>
		  </tr>
		  <tr>
		    <td colspan="7"></td>
	      </tr>

	<?php endfor; ?>
<?php else: ?> 
		<tr>
		  <td colspan="3" >No bid yet.</td>
		</tr>
<?php endif; ?>		  
		</table>
	</div>

</div><!-- end left block -->	


<!-- BEGIN right block -->	
<div id="rightb" >	
	<?= $userpanel ; ?>
</div><!-- END right block -->
