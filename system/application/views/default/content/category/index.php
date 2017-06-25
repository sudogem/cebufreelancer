<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="leftb" ><!-- start left block -->	
		<div id="joblisting" >
					<h1 class="h1 f" >Latest Project Postings in <?= $category_name ?></h1>
					
					<div class="pager" ><?= $links ?></div>
					<div class="clear" ></div> 
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableroll" >
					<tr>
						<th width="12%"> Date Posted </th>
						<th width="37%" >Project Title </th>
						<th width="19%"> Project Budget</th>
						<th width="16%">Duration</th>				
						<th width="7%">Status</th>
					</tr>	
<?php
if ( $all_projects !== FALSE ) :
	$n = count( $all_projects ) ; 
	for( $i=0; $i<$n; $i++ ): 
	$project_id = $all_projects[$i]['project_id'] ;  
	$dateposted = $all_projects[$i]['dateposted'] ; 
	$dateposted2 = date( "M j, Y", $dateposted ) ; 
	$project_title = htmlspecialchars( $all_projects[$i]['title'], ENT_QUOTES, 'UTF-8' ) ; 
	$project_title_url_title = url_title( $all_projects[$i]['title'] ) ;
	$budget = $all_projects[$i]['budget'] ; 
	$duration = $all_projects[$i]['duration'] ; 
	$description = $all_projects[$i]['description'] ; 
	$project_status = $all_projects[$i]['project_status'] ; 
?>  
					  <tr class="r<?=($i%2)?>" >
						<td><?= $dateposted2 ?></td>
						<td><a href="<?= site_url( "projects/view/$project_id/$project_title_url_title/" ) ?>" ><?= $project_title ?></a></td>
						<td><?= $budget ?></td>
						<td><?= $duration ?></td>
						<td><?= $project_status ?></td>
					  </tr>
<?php endfor ; ?>
<?php else: ?>
		<tr class="r0" ><td colspan="5" ><h1 class="error1" >Sorry, but no projects were found.</h1></td></tr>	
<?php endif;  ?>
				</table>
				
				<div class="pager" ><?= $links ?></div>
<div class="ads" >
<script type="text/javascript">
google_ad_client = "pub-0672602951562966";
/* 728x90, created 9/19/08 */
google_ad_slot = "0782369154";
google_ad_width = 728;
google_ad_height = 90;
</script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
</div>				
  </div>

</div><!-- end left block -->	

<?php echo $rightb ; ?>

