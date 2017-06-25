<?php

$fullname 		  = isset($_POST['profile']['fullname']) ? $_POST['profile']['fullname'] : $resume['profile'][0]['up_fullname'];
$gender 	      = isset($_POST['profile']['gender']) ? $_POST['profile']['gender'] : $resume['profile'][0]['up_gender'];
$jobtitle 		  = isset($_POST['profile']['jobtitle']) ? $_POST['profile']['jobtitle'] : $resume['profile'][0]['up_jobtitle'];
$job_objective 	  = isset($_POST['profile']['job_objective']) ? $_POST['profile']['job_objective'] : $resume['profile'][0]['up_job_objective'];
$interests 		  = isset($_POST['profile']['interests']) ? $_POST['profile']['interests'] : $resume['profile'][0]['up_interests'];
$address 		  = isset($_POST['profile']['location']) ? $_POST['profile']['location'] : $resume['profile'][0]['up_location'];
$company 		  = isset($_POST['profile']['company']) ? $_POST['profile']['company'] : $resume['profile'][0]['up_company'];
$city 			  = isset($_POST['profile']['city']) ? $_POST['profile']['city'] : $resume['profile'][0]['up_city'];
$state 			  = isset($_POST['profile']['state']) ? $_POST['profile']['state'] : $resume['profile'][0]['up_state'];
$postalcode 	  = isset($_POST['profile']['postalcode']) ? $_POST['profile']['postalcode'] : $resume['profile'][0]['up_postalcode'];
$specialties      = isset($_POST['profile']['specialties']) ? $_POST['profile']['specialties'] : $resume['profile'][0]['up_specialties'];
$website 		  = isset($_POST['profile']['website']) ? $_POST['profile']['website'] : $resume['profile'][0]['up_website'];
$contactno 	      = isset($_POST['profile']['contactno']) ? $_POST['profile']['contactno'] : $resume['profile'][0]['up_contactno'];
$email 	          = isset($_POST['profile']['email']) ? $_POST['profile']['email'] : $resume['profile'][0]['email'];

$month			  = isset($_POST['profile']['month']) ? $_POST['profile']['month'] : '';
$day		      = isset($_POST['profile']['day']) ? $_POST['profile']['day'] : '';
$year		      = isset($_POST['profile']['year']) ? $_POST['profile']['year'] : '';

if ($month || $day || $year) {
	$birthday 			= "$month-$day-$year";
}
else {
	$birthday = $resume['profile'][0]['up_birthday'];
}

?>
<p style="display:none" >
<?php 

?>
</p>
<div id="leftb" ><!-- BEGIN left block -->	
<div class="resume" id="form_section" >
<?= !empty( $flash_message ) ?  flash_message($flash_message, $flashb, true) : '' ; ?>
<form method="post" action="<?= site_url('resume/edit')?>" >
<a href="#" id="scbottom" style="float:right" >scroll to bottom</a><br class="clear" />
<fieldset>
	<legend>Personal Info</legend>
	<em> * required field</em>
    <table width="100%" class="" >
    	<tr>
        <td width="18%" class="field">Full Name&nbsp;*</td>
        <td width="82%"><input type="text" name="profile[fullname]" value="<?php echo $fullname ?>" /></td>
      </tr>

    	<tr>
        <td width="18%" class="field">Gender&nbsp;</td>
        <td>
	<select name="profile[gender]" >
	<?php if (strtolower($gender) == 'male' ):?>
	<option selected="selected" value="male" <?= $this->form_validation->set_select('gender', 'male'); ?> >Male</option>
	<option value="female" <?= $this->form_validation->set_select('gender', 'female'); ?> >Female</option>						
	<?php else: ?>
	<option value="male" <?= $this->form_validation->set_select('gender', 'male'); ?> >Male</option>			
	<option  selected="selected" value="female" <?= $this->form_validation->set_select('gender', 'female'); ?> >Female</option>			
	<?php endif; ?>
	</select>
	</td>
	</tr>
	
			
    	<tr>
        <td width="18%" class="field">Job position&nbsp;*</td>
        <td width="82%"><input type="text" name="profile[jobtitle]" value="<?php echo $jobtitle ?>" /></td>
      </tr>
      
		<tr>
        <td class="field">Address&nbsp;*</td>
        <td><textarea name="profile[location]"><?php echo $address ?></textarea></td>
        </tr>

		<tr>
        <td class="field">Birthdate&nbsp;</td>
        <td><?php select_birthday( array( 'profile[month]', 'profile[day]', 'profile[year]' ), $birthday ) ; ?></td>
        </tr>
		
		<tr>
        <td class="field">City&nbsp;</td>
        <td><input type="text" name="profile[city]" value="<?php echo $city ?>"/></td>
		</tr>
        
		<tr>
        <td class="field">State/Province&nbsp;</td>
        <td><input type="text" name="profile[state]" value="<?php echo $state ?>" /></td>
        </tr>
        
        <tr>
        <td class="field">Zip&nbsp;</td>
        <td><input type="text" name="profile[postalcode]" value="<?php echo $postalcode ?>" /></td>
        </tr>    

		<tr>
		<td class="field" >Company &nbsp;</td>
		<td ><input name="profile[company]" type="text" value="<?php echo $company ?>" /></td>
		</tr>
		  
    	<tr>
        <td width="18%" class="field">Website&nbsp;</td>
        <td width="82%">
		<textarea name="profile[website]" ><?php echo $website ?></textarea>
		</td>
        </tr>

    	<tr>
        <td width="18%" class="field">Contact no&nbsp;</td>
        <td width="82%"><input type="text" name="profile[contactno]" value="<?php echo $contactno ?>" /></td>
        </tr>

    	<tr>
        <td width="18%" class="field">Email&nbsp;*</td>
        <td width="82%"><input type="text" name="profile[email]" value="<?php echo $email ?>" /></td>
        </tr>
		
    </table>
</fieldset>

<fieldset>
	<legend>Summary</legend>
    <table width="100%" class="" >
    	<tr>
        <td width="18%" class="field">Summary&nbsp;*</td>
        <td width="82%"><textarea name="profile[job_objective]" ><?php echo $job_objective ?></textarea></td>
      </tr>      
    </table>
</fieldset>

<fieldset>
	<legend>Interests</legend>
    <table width="100%" class="" >
    	<tr>
        <td width="18%" class="field">Interests</td>
        <td width="82%"><textarea name="profile[interests]" ><?php echo $interests ?></textarea></td>
      </tr>      
    </table>
</fieldset>

<fieldset>
	<legend>Specialties</legend>
    <table width="100%" class="" >
    	<tr>
        <td width="18%" class="field">Specialties&nbsp;*</td>
        <td width="82%"><textarea name="profile[specialties]" ><?php echo $specialties ?></textarea></td>
      </tr>      
    </table>
</fieldset>

<fieldset class="field_section" >
<a onclick="add_work(); return false;" class="add_new small button grey" >Add work experience</a>
<div class="clear"></div>
    <legend>Work experience</legend> 
	<div id="work">
 
	<?php 
	$n = count($resume['workexperience']);
	for($j=0; $j<$n; $j++) {
		$id 				= $resume['workexperience'][$j]['id'];
		$company 			= isset($_POST['workexperience']['company'][$j]) ? $_POST['workexperience']['company'][$j] : $resume['workexperience'][$j]['company'];
		$begindate 			= isset($_POST['workexperience']['begindate'][$j]) ? $_POST['workexperience']['begindate'][$j] : $resume['workexperience'][$j]['begindate'];
		$enddate 			= isset($_POST['workexperience']['enddate'][$j]) ? $_POST['workexperience']['enddate'][$j] : $resume['workexperience'][$j]['enddate'];
		$jobtitle 			= isset($_POST['workexperience']['jobtitle'][$j]) ? $_POST['workexperience']['jobtitle'][$j] : $resume['workexperience'][$j]['jobtitle'];
		$jobdetails 		= isset($_POST['workexperience']['jobdetails'][$j]) ? $_POST['workexperience']['jobdetails'][$j] : $resume['workexperience'][$j]['jobdetails'];
		$location 			= isset($_POST['workexperience']['location'][$j]) ? $_POST['workexperience']['location'][$j] : $resume['workexperience'][$j]['location'];
	?>
    <table width="100%" class="section addsection" id="twork<?php echo $id ?>" >
    	<tr>
        <td width="18%" class="field">Company name&nbsp;*</td>
        <td width="82%"><input type="text" name="workexperience[company][]" value="<?php echo $company ?>" />
		<?php if ($id) :?>
			<a href="javascript:void(0)" style="float:right" class="sortarrow tooltipsy" title="<span class='tt'>Drag</span>" ></a>
			<a href="<?= site_url("resume/delete/type/work/id/$id") ?>" class="removeico tooltipsy" title="<span class='tt'>Delete</span>" ></a> 
		<?php endif; ?>
		</td>
		</tr>
        
    	<tr>
        <td class="field">Time Period&nbsp;</td>
        <td>
			<label class="cw"><input type="checkbox" <?php echo ($enddate == 'present') ? 'checked=checked' : '' ?> id="ckcurrent<?= $id ?>" name="workexperience[chkworkexperience][<?php echo $id ?>]" onclick="toggleDate('<?php echo $id ?>')" />I currently work here.</label><br />
			<div><?php generateDropdownDate(array('field' => 'workexperience[begindate]', 'format' => 'mmyyyy', 'values' => $begindate)); ?><span class="rangeTo"> to </span>
			<span style="display:<?php echo ($enddate == 'present') ? 'none' : 'block' ?>" class="selectenddate<?= $id ?>"><?php generateDropdownDate(array('field' => 'workexperience[enddate]', 'format' => 'mmyyyy', 'values' => $enddate)); ?></span>
			</div>
			<span class="presentdate<?= $id ?>" style="display:<?php echo ($enddate == 'present') ? 'block' : 'none' ?>; line-height:2.5em" >present</span>
		</td>
        </tr>

    	<tr>
    	  <td class="field">Job title&nbsp;*</td>
    	  <td><input type="text" name="workexperience[jobtitle][]" value="<?php echo $jobtitle ?>"  /></td>
  	  </tr>
    	<tr>
    	  <td class="field">Details&nbsp;</td>
    	  <td><textarea name="workexperience[jobdetails][]" ><?php echo $jobdetails ?></textarea></td>
  	  </tr>
    	<tr>
        <td class="field">Location&nbsp;</td>
        <td><input type="text" name="workexperience[location][]"value="<?php echo $location ?>" /></td>
        </tr>
    </table>
	<input type="hidden" name="workexperience[id][]" value="<?php echo $id ?>" />
	<input type="hidden" name="workexperience[ischeck][]" value="<?php echo ($enddate == 'present') ? 'on' : 'off' ?>" id="workexperience<?php echo $id ?>" />
	<input type="hidden" name="workexperience[weight][]" value="<?php echo $id ?>" />
    <?php } ?>
    <div class="addsection" style="display:none"></div>
    </div>
</fieldset>


<fieldset>
<a onclick="add_school(); return false;" class="add_new small button grey" >Add education</a>
<div class="clear"></div>
<legend>Education</legend>
	<div id="education">
	<?php 
	$n = count($resume['education']);
	for($j=0; $j<$n; $j++) {
		$id = $resume['education'][$j]['id'];
		$institution = $resume['education'][$j]['institution'];
		$location = $resume['education'][$j]['location'];
		$begindate = $resume['education'][$j]['begindate'];
		$enddate = $resume['education'][$j]['enddate'];
		$degree = $resume['education'][$j]['degree'];
	?>		
    <table width="100%" class="section">
	    <tr>
        <td width="18%" class="field">Institution&nbsp;*</td>
        <td width="82%"><input type="text" name="education[institution][]" value="<?php echo $institution?>" />
		<?php if ($id) :?>
		<a href="javascript:void(0)" style="float:right" class="sortarrow tooltipsy" title="<span class='tt'>Drag</span>" ></a>
		<a href="<?= site_url("resume/delete/type/education/id/$id") ?>" class="removeico tooltipsy" title="<span class='tt'>Delete</span>" ></a>
		<?php endif;?>
		</td>
        </tr>

        <tr>
        <td class="field">Location&nbsp;</td>
        <td><input type="text" name="education[location][]" value="<?php echo $location ?>" /></td>
        </tr>
        
 		<tr>
        <td class="field">Begin Date&nbsp;</td>
        <td><?php generateDropdownDate(array('field' => 'education[begindate]', 'format' => 'mmyyyy', 'values' => $begindate)); ?></td>
        </tr>    
     	
        <tr>
        <td class="field">End Date&nbsp;</td>
        <td><?php generateDropdownDate(array('field' => 'education[enddate]', 'format' => 'mmyyyy', 'values' => $enddate)); ?></td>
        </tr>
        
        <tr>
        <td class="field">Degree&nbsp;</td>
        <td><input type="text" name="education[degree][]" value="<?php echo $degree ?>" /></td>
        </tr>

    </table>
	<input type="hidden" name="education[id][]" value="<?php echo $id ?>" />
	<input type="hidden" name="education[weight][]" value="<?php echo $id ?>" />
    	<?php } ?>
    	<div class="addschool" style="display:none"></div>
		
    	</div>
</fieldset>

<fieldset>
<a onclick="add_references(); return false;" class="add_new small button grey" >Add references</a>
<div class="clear"></div>
	<legend>References</legend>
	<div id="references" >
	<?php 
	$n = count($resume['references']);
	for($j=0; $j<$n; $j++) {
		$id = $resume['references'][$j]['id'];
		$name = $resume['references'][$j]['name'];
		$title = $resume['references'][$j]['title'];
		$company = $resume['references'][$j]['company'];
		$department = $resume['references'][$j]['department'];
		$address = $resume['references'][$j]['address'];
		$city = $resume['references'][$j]['city'];
		$state = $resume['references'][$j]['state'];
		$postalcode = $resume['references'][$j]['postalcode'];
		$country = $resume['references'][$j]['country'];
		$contactno = $resume['references'][$j]['contactno'];
		$email = $resume['references'][$j]['email'];
		$details = $resume['references'][$j]['details'];
	?>
    <table width="100%" class="section">
	    <tr>
        <td width="18%" class="field">Name&nbsp;</td>
        <td width="82%"><input type="text" name="references[name][]" value="<?php echo $name ?>" />
		<?php if ($id) :?>
		<a href="javascript:void(0)" style="float:right" class="sortarrow tooltipsy" title="<span class='tt'>Drag</span>" ></a>
		<a href="<?= site_url("resume/delete/type/references/id/$id") ?>" class="removeico tooltipsy" title="<span class='tt'>Delete</span>" ></a>
		<?php endif; ?>
		</td>
        </tr>

        <tr>
        <td class="field">Position&nbsp;</td>
        <td><input type="text" name="references[title][]" value="<?php echo $title ?>" /></td>
        </tr>

        <tr>
        <td class="field">Details&nbsp;</td>
        <td><input type="text" name="references[details][]" value="<?php echo $details ?>" /></td>
        </tr>
        
 		<tr>
        <td class="field">Company&nbsp;</td>
        <td><input type="text" name="references[company][]" value="<?php echo $company ?>" /></td>
        </tr>    
     	
        <tr>
        <td class="field">Department&nbsp;</td>
        <td><input type="text" name="references[department][]" value="<?php echo $department ?>" /></td>
        </tr>
        
        <tr>
        <td class="field">Address&nbsp;</td>
        <td><input type="text" name="references[address][]" value="<?php echo $address ?>" /></td>
        </tr>

        <tr>
        <td class="field">City&nbsp;</td>
        <td><input type="text" name="references[city][]" value="<?php echo $city ?>" /></td>
        </tr>

        <tr>
        <td class="field">State&nbsp;</td>
        <td><input type="text" name="references[state][]" value="<?php echo $state ?>" /></td>
        </tr>

        <tr>
        <td class="field">Postalcode&nbsp;</td>
        <td><input type="text" name="references[postalcode][]" value="<?php echo $postalcode ?>" /></td>
        </tr>

        <tr>
        <td class="field">Country&nbsp;</td>
        <td><input type="text" name="references[country][]" value="<?php echo $country ?>" /></td>
        </tr>

        <tr>
        <td class="field">Contact no&nbsp;</td>
        <td><input type="text" name="references[contactno][]" value="<?php echo $contactno ?>" /></td>
        </tr>

        <tr>
        <td class="field">Email&nbsp;</td>
        <td><input type="text" name="references[email][]" value="<?php echo $email ?>" /></td>
        </tr>
		
    </table>
	<input type="hidden" name="references[id][]" value="<?php echo $id ?>" />
	<input type="hidden" name="references[weight][]" value="<?php echo $id ?>" />
	<?php } ?>
	</div>
</fieldset>

<div align="center">
 <input type="submit" name="submit" value="Save &raquo;" class="button" />
</div>
<a href="#" id="sctop" style="float:right" >scroll to top</a><br class="clear" />

</form>
</div><!-- END resume -->
</div><!-- END left block -->

<!-- BEGIN right block -->	
<div id="rightb" >	
	<?= $userpanel ; ?>
</div><!-- END right block -->
  

<script type="text/javascript" >

var workId = 1;
var educationId = 1;

function add_work() {
workId++;        
    

	var work_block = '<table width="100%" class="section addsection" style="display:none" >' +
    	'<tr>' +
        '<td width="18%" class="field">Company name&nbsp;*</td>' +
        '<td width="82%"><input type="text" name="workexperience[company][]" />' +
		'<a href="javascript:void(0)" style="float:right" class="sortarrow tooltipsy" title="<span class=tt>Drag</span>" ></a>' + 
		'<a href="javascript:void(0)" onclick=hideblock(); class="removeico tooltipsy" title="<span class=tt>Delete</span>" ></a></td>' +
		
      '</tr>' +
    	'<tr>' +
        '<td class="field">Time Period&nbsp;</td>' +
			'<td>' +
			'<label class="cw"><input type="checkbox" id="ckcurrent0' + workId +  '" onclick="toggleDate(' + workId + ', 0)" />I currently work here.</label><br />' +
			'<div><?php generateDropdownDate(array('field' => 'workexperience[begindate]', 'format' => 'mmyyyy')); ?><span class="rangeTo"> to </span>' +
			'<span class="selectenddate0' + workId + '" ><?php generateDropdownDate(array('field' => 'workexperience[enddate]', 'format' => 'mmyyyy')); ?></span></div>' +
			'<span class="presentdate0' + workId + '" style="display:none; line-height:2.5em" >present</span>' +
			'</td>' +
		'</tr>' +

    	'<tr>' +
    	  '<td class="field">Job title&nbsp;*</td>' +
    	  '<td><input type="text" name="workexperience[jobtitle][]" /></td>' +
  	  '</tr>' + 
    	'<tr>' +
    	  '<td class="field">Details&nbsp;</td>' +
    	  '<td><textarea name="workexperience[jobdetails][]" ></textarea></td>' +
  	  '</tr>' +
    	'<tr>' +
        '<td class="field">Location&nbsp;</td>' +
        '<td><input type="text" name="workexperience[location][]" /></td>' +
        '</tr>' +
    '</table><input type="hidden" name="workexperience[weight][]" value="' + workId + '" /><input type="hidden" name="workexperience[ischeck][]" value="off" id="workexperience' + workId + '" />';

	$('#work').prepend(work_block); 
    $('.addsection').fadeIn(1000).animate({opacity:1.0}, 2000) ;   
    $('.tooltipsy').tipsy({html:true});	
}

function add_school() 
{
educationId++;    
	var school_block = '<table width="100%" class="section addschool" style="display:none" >' +
    	'<tr>' +
        '<td width="18%" class="field">Institution&nbsp;*</td>' +
        '<td width="82%"><input type="text" name="education[institution][]" />' +
		'<a href="javascript:void(0)" style="float:right" class="sortarrow tooltipsy" title="<span class=tt>Drag</span>" ></a>' + 
		'<a href="javascript:void(0)" onclick=hideblock(); class="removeico tooltipsy" title="<span class=tt>Delete</span>" ></a></td>' +
        '</tr>' +

    	'<tr>' +
        '<td class="field">Location&nbsp;</td>' +
        '<td><input type="text" name="education[location][]" />' +
        '</tr>' +
		
    	'<tr>' +
        '<td class="field">Begin Date&nbsp;</td>' +
        '<td><?php generateDropdownDate(array('field' => 'education[begindate]', 'format' => 'mmyyyy')); ?></td>' +
        '</tr>' +
		
    	'<tr>' +
        '<td class="field">End Date&nbsp;</td>' +
        '<td><?php generateDropdownDate(array('field' => 'education[enddate]', 'format' => 'mmyyyy')); ?></td>' +
        '</tr>' +
    	'<tr>' +
    	  '<td class="field">Degree&nbsp;</td>' +
    	  '<td><input type="text" name="education[degree][]" /></td>' +
  	  '</tr>' +
    '</table><input type="hidden" name="education[weight][]" value="' + educationId + '" /><input type="hidden" name="education[id][]" value="" />';

    	
	$('#education').prepend(school_block); 
    $('.addschool').fadeIn(1000).animate({opacity:1.0}, 2000) ;
    $('.tooltipsy').tipsy({html:true});	   	
}



</script>
