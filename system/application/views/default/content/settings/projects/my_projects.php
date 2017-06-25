<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="leftb" ><!-- start left block -->	
<?= flash_message( $this->session->flashdata('flash_message') ) ; ?>
<?php
$n = count( $all_projects ) ; 
?>
		<div id="joblisting" >
					<h1 class="h1 f" >My Project Postings</h1>
					<div class="clear" ></div>
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableroll" >
					<tr>
						<th width="13%"> Date Posted </th>
						<th width="41%">Project Title </th>
					    <th width="15%" align="center" ># of New Bid </th>
					    <th width="17%" align="center"># of New Message </th>
					    <th width="14%" align="center">Project Status</th>
					</tr>
<?php
if ( $all_projects ):
for( $i=0; $i<$n; $i++ ): 
$project_id = (int)$all_projects[$i]['project_id'] ;  
$dateposted = date( "M j, Y", $all_projects[$i]['dateposted'] ) ; 
$project_title = htmlspecialchars( $all_projects[$i]['title'], ENT_QUOTES, 'UTF-8' ); 
$budget = htmlspecialchars( $all_projects[$i]['budget'], ENT_QUOTES, 'UTF-8' ) ; 
$duration = htmlspecialchars( $all_projects[$i]['duration'], ENT_QUOTES, 'UTF-8' ); 
$description =  nl2br( $all_projects[$i]['description']) ; 
$created_by = htmlspecialchars( $contact_person, ENT_QUOTES, 'UTF-8' );
$numofdaysleft = 12 ; 
$time_remaining = 100 ;
$project_status = $all_projects[$i]['project_status'] ;  
// get the messages
$w = array( 'project_id' => $project_id, 'to' => $this->logged_userid, 'isopen' => '0'  ) ;
$num_msg = $this->projects_messages_model->get_project_message_by_criteria( $w )  ;	
$num_msg = ( $num_msg ) ? count( $num_msg ) : 0 ;
$bidders = $this->bids_model->get_project_bids_by_criteria( array( 'projects.project_id' => $project_id, 'isopen' => '0' ) ) ;
$num_bids = ( $bidders ) ? count( $bidders ) : 0  ;
?>  
						
					  <tr class="r<?=($i%2) ?>" >
						<td><?= $dateposted ?></td> 
						<td><a href="<?= site_url( "settings/projects/view/$project_id" ) ?>" ><?= $project_title ?></a></td> 
					    <td><?= $num_bids ;?></td>
					    <td><?= $num_msg ?></td>
					    <td><?= $project_status ?></td>
					  </tr>
<?php endfor ; ?>
<?php else: ?>
<tr><td colspan="5"><h1 class="error1">No project yet</h1></td></tr>
<?php endif ; ?>
				</table>
				
				<div class="pager" ><?= $links ?></div>
				
  </div>
</div><!-- end left block -->	

<!-- BEGIN right block -->	
<div id="rightb" >	
	<?= $userpanel ; ?>
</div><!-- END right block -->
