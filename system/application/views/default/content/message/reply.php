<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="leftb" ><!-- start left block -->	

	<form action="<?= site_url( "messages/send" ) ?>" method="post" >
	<fieldset class="fld4">
		<legend>Reply</legend>
		<div><label>To</label><br />
		<label class="h1"><?= $from ?></label>
		</div> 
		<br />			
		<div><label>Subject</label><br />
		<label class="h1"><?= $subject ?></label></div> 
		<div><label>Message</label><br />
		<textarea class="text ad" rows="15" name="message" ><?= $message ; ?></textarea></div>
		<div align="center" class="submit1" ><input type="submit" name="reply" value="Send Message &raquo;"  class="button" /></div>
	</fieldset>
	<input type="hidden" name="msgid" value=""  />
	</form>	

</div><!-- end left block -->	

<!-- BEGIN right block -->	
<div id="rightb" >	
	<?= $userpanel ; ?>
</div><!-- END right block -->
