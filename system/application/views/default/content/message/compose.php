<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="leftb" ><!-- start left block -->

<div id="form_section">
<?= !empty( $flash_message ) ?  flash_message( $flash_message, $flashb , TRUE ) : '' ; ?>
	<form action="<?= site_url( "messages/send" ) ?>" method="post" >
<!-- <span class="rpt_v" ><a href="javascript:history.go(-1)" >&laquo;Back </a></span><div class="clear" ></div> -->
	<fieldset class="fld4">
		<legend>Compose</legend>
		<div><label>To</label><br />
		<label class="h1"><?= $owner_name ?></label>
		</div> 
		<br />			
		<div><label>Subject</label><br />
		<input type="text" name="subject" value="<?= $subject ?>" class="text ad" /></div> 
		<br class="clear" />
		<div><label>Message</label><br />
		<textarea class="text ad" rows="15" name="message" ></textarea></div>
		<br class="clear" />
		<div align="center" class="submit1" ><input type="submit" name="submit" value="Send Message &raquo;"  class="button" /></div>
	</fieldset>	
	<input type="hidden" name="to" value="<?= $to ?>"  />
	<input type="hidden" name="pid" value="<?= $project_id ?>"  />	
	</form>	
</div><!-- end form_section -->
</div><!-- end left block -->	

<!-- BEGIN right block -->	
<div id="rightb" >	
	<?= $userpanel ; ?>
</div><!-- END right block -->
