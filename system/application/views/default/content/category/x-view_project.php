<?php  if (!defined('BASEPATH')) exit('No direct script access allowed') ; ?>
<div id="leftb" ><!-- start left block -->
<?php
$project_id = $project_details[0]['project_id'] ; 
$title = htmlspecialchars( $project_details[0]['title'], ENT_QUOTES, 'UTF-8' ) ; 
$description = $project_details[0]['description'] ; 
$dateposted = date( "M j, Y", $project_details[0]['dateposted'] ) ;
$project_status = $project_details[0]['project_status'] ; 
$created_by = $this->users_model->get_user_by_id( $project_details[0]['created_by'] , 'users.id, users.username', 'row' )->username ; 
$owner_id = $this->users_model->get_user_by_id( $project_details[0]['created_by'] , 'users.id, users.hash_id', 'row' )->hash_id ; 
$time_remaining = days_remaining( $dateposted ) ; 
// 'Days left : 7 days (out of 30 days) ' ;
$duration = $project_details[0]['duration'] ; 
$budget = $project_details[0]['budget'] ; 
?>
<div id="viewproject" >
		<span class="rpt_v"><a href="<?= site_url( 'projects/browse' ) ?>" >Back to project listings</a></span>
		<h1><?= $title ; ?></h1>
	<table width="100%" border="0" class="table" >
	  <tr>
		<td class="a"  width="10%">Date Posted </td>
		<td width="59%"><?= $dateposted ;?></td>
	  </tr>
	  <tr>
		<td class="a" >Contact Person  </td>
		<td><?= $created_by ; ?>&nbsp;&nbsp;<a href="<?= site_url( $sendpm ) ?>" >Send PM</a></td>
	  </tr>
	  <tr>
		<td class="a" >Status</td>
		<td><?= $project_status ; ?></td>
	  </tr>
	  <tr>
	    <td class="a">Time Remaining </td>
	    <td><?= $time_remaining ; ?></td>
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
		<td><span class="rpt_v" >(<a href="" >report violation</a>)</span>
		 <?= $description ; ?>
		</td>
	  </tr>
	</table> 


		<div align="center"><a href="#" id="bidbutton" class="bidbutton"><span class="b">Bid on this Project</span></a>		</div>
	
	<div id="bidme" style="display:none;" >
		<form action="<?= site_url( 'projects/bid' ) ?>" method="post" >
		<fieldset>
			<legend>Bid</legend>
			<div><label>Your bid for the total project</label><br />
			Php <input type="text" name="amount" value=""  class="text"/></div>
			<div><label>Message</label><br />
			<textarea class="text ad" rows="7%" name="message" ></textarea></div>		
			<div align="center" class="submit1" ><input type="submit" name="bid" value="Place Bid &raquo;"  class="button" /></div>
		</fieldset>
		<input type="hidden" name="project_id" value="<?= $project_id ?>" />
		</form>
	</div>
	
	
		<table width="100%" border="0" class="table1" style="margin-top:20px" >
		<tr>
		<td width="72%" class="b" >Freelancer</td>
		<td width="7%" class="b c" >Bid</td>
		</tr>
		<tr>
		<td><a href="" >freakyhair </a><br />
Experienced and quality designer here. Pls check PMB for details. Thx			
		<span class="rpt_v" >(<a href="" >report violation </a>)</span></td>
		<td class="c"><em>hidden</em></td>
		</tr>
		</table>

		
  </div>
</div><!-- end left block -->				

<script type="text/javascript" >
	$(function() {
		$("#bidbutton").click( function(event){
			event.preventDefault( ) ;
			$("#bidme").slideToggle( ) ;
		}) ;
	}) ;
</script>

