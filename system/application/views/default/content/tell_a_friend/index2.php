<form method="post" action="<?= site_url( 'tell_a_friend/send' ) ?>" >
<fieldset class="fld3"  style="width:82% ;" >
<legend>Tell a friend about CebuFreelancer</legend>
<div><label>Your Name</label><br />
<input type="text" name="name" class="text ab"  /></div><br />
<label>Share this site up to six of your friends.</label><br />
<?php for( $j=0; $j<100; $j++): ?>
<input type="text" name="email[]" class="text ab" value="" /><br />
<?php endfor; ?>
<input type="submit" name="tellthem" class="button" value="Send This Message &raquo;"  />
</fieldset>
</form>
