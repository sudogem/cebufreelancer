<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="xleftb" ><!-- start left block -->	
<h1 class="h1 f" >Member List</h1>
<input type="button" value="Search" class="button blue" id="searchcmd" />

<br class="clear" />
<?php
$userid 	 = '';
$fullname 	 = '';
$specialties = '';
$jobtitle 	 = '';
if ($this->session->userdata('search')) {
	$d 			 = '';
	$userid 	 = $this->session->userdata('username');
	$fullname 	 = $this->session->userdata('fullname');
	$specialties = $this->session->userdata('specialties');
	$jobtitle 	 = $this->session->userdata('jobtitle');
}
else {
	$d = 'style="display:none"';
}

?>
<div id="searchbx" <?= $d ?> >
<form method="post" action="<?= site_url( 'users/s' ) ?>" >
<table border=1 class="searchbox" >
	<tr>
	<td>UserId&nbsp;</td>
	<td><input type="text" name="username" class="text ab" value="<?= $userid ?>" /></td>
	</tr>
	
	<tr>
	<td>Contact Person&nbsp;</td>
	<td><input type="text" name="fullname" class="text ab" value="<?= $fullname ?>" /></td>
	</tr>

	<tr>
	<td>Job position&nbsp;</td>
	<td><input type="text" name="jobtitle" class="text ab" value="<?= $jobtitle ?>" /></td>
	</tr>
	
	<tr>
	<td>Specialties&nbsp;</td>
	<td><input type="text" name="specialties" class="text ab" value="<?= $specialties?>" /></td>
	</tr>

	<tr>
	<td></td>
	<td><input type="submit" value="Submit" class="button" />&nbsp;&nbsp;
	<?php if($this->session->userdata('search')):?>
	<a href="<?= site_url('users')?>" >Reset</a>
	<?php endif; ?>
	</td>
	</tr>
</table>
</form>
</div>

<table width="99%" border="0" class="tableroll" >
  <tr>
    <th width="9%">UserId</th>
    <th width="19%">Job position</th>
    <th width="19%">Home Address</th>
	<th width="19%">Company</th>
    <th width="18%">Contact Person</th>
    <th width="35%">Specialties</th>
  </tr>
<?php
$n = count( $all_freelancers ) ;
for( $i=0; $i<$n; $i++ ):
$username 		= $all_freelancers[$i]['username'] ; 
$username 		= $this->htmlpurifier->purify($username, $purifyconfig);

$jobtitle 		= $all_freelancers[$i]['jobtitle'] ; 
$jobtitle 		= $this->htmlpurifier->purify($jobtitle, $purifyconfig);
$jobtitle_url   = $this->htmlpurifier->purify(url_title($jobtitle), $purifyconfig);

$location 		= $all_freelancers[$i]['location'] ;
$location 		= $this->htmlpurifier->purify($location, $purifyconfig);

$company 		= $all_freelancers[$i]['company'] ; 
$company 		= $this->htmlpurifier->purify($company, $purifyconfig);

$fullname	 	= $all_freelancers[$i]['fullname'] ; 
$fullname 		= $this->htmlpurifier->purify($fullname, $purifyconfig);

$specialties 	= nl2br($all_freelancers[$i]['specialties']); 

$limit = 300;
if ( strlen($specialties) > $limit ) 
{
	$specialties_summary = substr( $all_freelancers[$i]['specialties'],0,$limit) .'.....' ; 
	$cut = TRUE ;
}
else
{
	$specialties_summary = $specialties ;
	$cut = FALSE ;	
}

$profile_url = site_url("users/$username/");
?>  
  <tr class="r<?= ($i%2) ?>" >
    <td><a href="<?= $profile_url ?>" ><?= $username ?></a></td>
    <td><?= $jobtitle ?></td>
    <td><?= $location ?></td>
	<td><?= $company ?></td>
    <td><?= $fullname ?></td>
    <td><?= $specialties ?></td>
  </tr>
<?php endfor; ?>
<tr><td colspan="7"><div class="pager"  ><?= $links ?></div></td></tr>
</table>
</div><!-- end left block -->	