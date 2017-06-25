<?php  if (!defined('BASEPATH')) exit('No direct script access allowed') ; ?>
<div id="leftb" ><!-- start left block -->

<div id="form_section" >

<form method="post" action="<?= site_url( 'settings/projects/manage_subscriptions' ) ?>" >
<?= !empty( $flash_message ) ? flash_message( $flash_message, $flashb, TRUE ) : '' ?>
<fieldset class="fld4">
	<legend>Manage Subscriptions</legend>

	<label>Project notification</label><br />
	<em><label class="em2"><input type="checkbox" name="project_posting_notification" <?php if ( $project_posting_notification ) echo 'checked="checked"' ?> />Receive project notification</label></em><br /><br />
	<label>Newsletter</label><br />
	<em><label class="em2"><input type="checkbox" name="newsletter_notification" <?php if ( $newsletter_notification ) echo 'checked="checked"' ?> />Receive news &amp; events from CebuFreelancer</label></em>
	<div class="clear">&nbsp;</div>	
	<label>Project category notifications</label>
	<br />
	<em class="em2">Select a category of projects that you would like to receive the latest postings. <br />
	Be sure that you've checked also the project notification above.</em>
<?php
	$tmpuser_category_subscriptions = array();
	if ($user_category_subscriptions !== false) {
		foreach( $user_category_subscriptions as $v ) $tmpuser_category_subscriptions[] = $v['category_id'] ;
	}
	$n = count( $project_categories ) ;
	for( $i=0; $i<$n; $i++ ):
?>		
	<?php if ($i%2==0) echo "<div class='clear'></div>" ?>	
	<div class="catblk" ><label class="h6"><input type="checkbox" name="category[]" value="<?= $project_categories[$i]['category_id'] ; ?>"  <?= in_array( $project_categories[$i]['category_id'], $tmpuser_category_subscriptions ) ? 'checked="checked"' : '' ?> /><?= $project_categories[$i]['category'] ; ?></label></div>	
<?php endfor; ?>

<div class="clear">&nbsp;</div>
<div align="center" class="submit1" ><input type="submit"  name="update" value="Update Subscriptions &raquo;"  class="button" /></div>
</fieldset>
</form>
</div>

</div><!-- end left block -->

<!-- BEGIN right block -->	
<div id="rightb" >	
	<?= $userpanel ; ?>
</div><!-- END right block -->
