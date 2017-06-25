<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="leftb" ><!-- start left block -->	
<div class="announcement" >
<h1 class="h1 f" >Welcome to CebuFreelancer,</h1><br class="clear"  />
<p class="p2" >
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An online marketplace for freelancers and employeers. Whether you're a professional looking for freelance employment, or a company looking for a talented freelancer for your project, then CebuFreelancer is a good place for you.
<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The goal of the site is simply to provide a platform that helps the buyers/employers to find the top freelance professionals to oursource their projects here in Cebu.
<br />
So, join the community and become a freelancer or post your projects on the site.
Just register <a href="<?= site_url( 'signup/' ) ?>" >here</a> and it takes only a few minutes. </p>
</div>
<div class="clear" ></div>

		<div id="joblisting" >
					<h1 class="h1 f" >Latest Project Postings</h1>
					
					<div class="pager" ><?= $links ?></div>
					<div class="clear" ></div> 
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableroll" >
					<tr>
						<th width="12%"> Date Posted </th>
						<th width="37%" >Project Title </th>
						<th width="19%"> Project Budget</th>
						<th width="16%">Deadline/Duration</th>				
						<th width="7%">Status</th>
					</tr>	
<?php
$n = count( $all_projects ) ; 
for( $i=0; $i<$n; $i++ ): 
$project_id = $all_projects[$i]['project_id'] ;  
$dateposted = $all_projects[$i]['dateposted'] ; 
$dateposted2 = date( "M j, Y", $dateposted ) ; 

$project_title = htmlspecialchars( $all_projects[$i]['title'], ENT_QUOTES, 'UTF-8' ) ; 
$project_title = $this->htmlpurifier->purify($project_title);

$project_title_url_title = url_title( $all_projects[$i]['title'] ) ;
$budget = $all_projects[$i]['budget'] ; 
$duration = $all_projects[$i]['duration'] ; 
$description = $all_projects[$i]['description'] ; 
$numofdays = ($all_projects[$i]['numofdays'] ) ; 
$project_status = $all_projects[$i]['project_status'] ; 
?>  
					  <tr class="r<?=($i%2)?>"  >
						<td><?= $dateposted2 ?></td>
						<td><a href="<?= site_url( "projects/view/$project_id/$project_title_url_title" ) ?>" ><?= $project_title ?></a></td>
						<td><?= $budget ?></td>
						<td><?= $duration ?></td>
						<td><?= $project_status ?></td>
					  </tr>
<?php endfor ; ?>					  
				</table>
				
				<div class="pager" ><?= $links ?></div>
<div class="ads" >
<script type="text/javascript">
// google_ad_client = "pub-0672602951562966";
// /* 728x90, created 9/19/08 */
// google_ad_slot = "0782369154";
// google_ad_width = 728;
// google_ad_height = 90;
</script>
<!-- <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script> -->
</div>
				
  </div>
<?php
if ( $this->site_sentry->check( 'bot' ) ) 
{
echo $this->load->view( 'default/content/tell_a_friend/index2', $data ); 
}	
?>  
	
</div><!-- end left block -->	

<?php echo $rightb ; ?>

