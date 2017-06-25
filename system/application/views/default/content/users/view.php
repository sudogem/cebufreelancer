<?php  if (!defined('BASEPATH')) exit('No direct script access allowed') ; ?>
<?php $this->load->helper('utils'); ?>
<?php $this->load->helper('url'); ?>
<?php $this->load->helper('time'); ?>
<div id="leftc" ><!-- start left block -->
<?php
$fullname 			= $profile['up_fullname'];
$postalcode 		= $profile['up_postalcode'];
$city 				= $profile['up_city'];
$state 				= $profile['up_state'];
$website 			= $profile['up_website'];
$contactno 			= $profile['up_contactno']; 
$location 			= $profile['up_location'];
$specialties 		= nl2br($profile['up_specialties']);
$jobtitle 			= $profile['up_jobtitle'];
$job_objective 		= nl2br($profile['up_job_objective']); 
$interests 			= nl2br($profile['up_interests']); 
$profile_pic        = (file_exists($upload_path_avatar.$profile['up_profile_pic'])) ? $live_path_avatar.$profile['up_profile_pic'] : '';

$websitelist        = '';
$websitelist        = make_anchor_link($website);
?>
<?php
$this->load->view('default/content/users/_menu');
?>

    <div class="resume_details" >
     <table width="100%" border="0" >
    <tbody>
        <tr>
          <td colspan="2">
          <?php if($profile_pic) : ?>
             <img src='<?= $profile_pic ?>' class="profile_pic" />          
          <?php endif; ?>
		  <h2 class="title-fullname"><?php echo $fullname ?><span class="title-job"><br><?= $jobtitle ?></span></h2>
<div align="right">
<?= $location ?><br>
<?= $city . " ". $state . " " . $postalcode ?><br>
<?= $websitelist ?>
<?= $contactno ?>
</div>          
          </td>
          </tr>
        <tr>
          <td colspan="2" class="ralign" ></td>
          </tr>
        <tr>
          <td colspan="2"><h2 class="title" >SUMMARY</h2></td>
          </tr>
        <tr>
          <td colspan="2"><?= !empty($job_objective) ? $job_objective : 'None' ?></td>
          </tr>
        <tr>
        <td colspan="2"><h2 class="title" >WORK EXPERIENCE</h2></td>
        </tr>
		<?php
		if ($workexperience && count($workexperience) > 0) {
		$n = count($workexperience);
		for($j=0; $j < $n; $j++) {
			$company 	= $workexperience[$j]['company'];
			$location 	= $workexperience[$j]['location'];
			$jobtitle 	= $workexperience[$j]['jobtitle'];
			$begindate 	= $workexperience[$j]['begindate'];
			$tsbegindate= converttimestamp(array('format' => 'mmyyyy', 'value' => $begindate));
			$enddate 	= $workexperience[$j]['enddate'];
			$jobdetails = $workexperience[$j]['jobdetails'];
			$begindate 	= convertdate(array('format' => 'mmyyyy', 'value' => $begindate));
			
			if ($enddate !== 'present') {
				$tenddate    = convertdate(array('format' => 'mmyyyy', 'value' => $enddate));
				$tsenddate  = converttimestamp(array('format' => 'mmyyyy', 'value' => $enddate));
			} else {
				$tsenddate = time();
				$tenddate = 'present';
			}
			
			$rangeDate 	= $begindate.' &mdash; '.$tenddate;
			$numofyears = numofyears($tsbegindate, $tsenddate);
		?>
        <tr>
        <td width="60%"><strong><?= $jobtitle ?></strong>, <i><?= $company ?></i></td>
        <td class="dateworked" ><?= $rangeDate ?> <em class="numyears"><?= !empty($numofyears) ? '('.$numofyears . ')' : ''  ?></em></td>
        </tr>
        <tr>
          <td colspan="2"> <?= $location ?></td>
        </tr>
        <tr>
          <td colspan="2"><?= $jobdetails ?></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <?php } ?> 
		<?php } else { ?>
		<tr>
			<td>None</td>
		</tr>
		<?php } ?>
    </tbody>
    </table>
    
    <h2 class="title">SPECIALTIES</h2>    
    <p>
    <?= !empty($specialties) ? $specialties : 'None' ?>
    </p>
    
    
    <h2 class="title">EDUCATION</h2>
	<table width="100%" >
	
	<?php
		if ($education && count($education) > 0) {
		$n = count($education);
		for($j=0; $j < $n; $j++) {
			$institution	= $education[$j]['institution'];
			$location		= $education[$j]['location'];
			$begindate		= $education[$j]['begindate'];
			$enddate		= $education[$j]['enddate'];
			$degree			= $education[$j]['degree'];
			$begindate 		= convertdate(array('format' => 'mmyyyy', 'value' => $begindate));
			$enddate 		= convertdate(array('format' => 'mmyyyy', 'value' => $enddate));
			$rangeDate 		= $begindate.' &mdash; '.$enddate;
	?>
	<tr>
		<td><?= $institution ?>, <?= $location ?></td>
		<td><div class="dateworked" ><?= $rangeDate ?></td>
	</tr>
	<tr>
		<td colspan="2"><?= $degree ?></td>
	</tr>
    <?php } ?>
	<?php } else { ?>
	<tr>
		<td>None</td>
	</tr>
	<?php } ?>
	</table>
	
    <h2 class="title">INTERESTS</h2>    
    <p><?= !empty($interests) ? $interests : 'None' ?></p>
    
    <h2 class="title">REFERENCES</h2>
	<?php
	if ($references && count($references) > 0):
		$n = count($references);
		for($j=0; $j < $n; $j++):
			$name			= $references[$j]['name'];
			$title			= $references[$j]['title'];
			$company		= $references[$j]['company'];
			$department		= $references[$j]['department'];
			$address		= $references[$j]['address'];
			$contactno		= $references[$j]['contactno'];
			$email			= $references[$j]['email'];
			$details		= $references[$j]['details'];
			
			if (!empty($title)) {
				$name = $name . ", <strong>" . $title . "</strong><br>";
			}
	?>
	
    <div><?php echo $name ?>
    <?php echo $company ? $company."<br />" : "" ?>
    <?php echo $department ? $department."<br />" : "" ?>
    <?php echo $address ? $address."<br />" : "" ?>
    <?php echo $contactno ? $contactno."<br />" : "" ?>
    <?php echo $details ? $details."<br />" : "" ?>
    </div><br />
		<?php endfor; ?>
	<?php else: ?>	
	None
    <?php endif; ?>
	
    </div>
</div>

