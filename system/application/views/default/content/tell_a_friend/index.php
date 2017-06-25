<?php  if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="leftb" >
	<div id="page" >
	<?= !empty( $flash_message ) ? flash_message( $flash_message,'green' ) : '' ?>	
	<form method="post" action="<?= site_url( 'tell_a_friend/send' ) ?>" >
	<fieldset class="fld3"  style="width:82% ;" >
	<legend>Tell a friend about CebuFreelancer</legend>
	<div><label>Your Name</label><br />
	<input type="text" name="name" class="text ab"  /></div><br />
	<label>Share this site up to six of your friends emailaddress.</label><br />
	<?php for( $j=0; $j<6; $j++): ?>
	<input type="text" name="email[]" class="text ab" value="" /><br />
	<?php endfor; ?>
	<input type="submit" name="tellthem" class="button" value="Send This Message &raquo;"  />
	</fieldset>
	</form>
	</div>
</div>	

