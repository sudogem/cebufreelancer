<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div style="width:98%;  float:left" id="form_section" >
<?= !empty( $flash_message ) ? flash_message( $flash_message,'red' ) : '' ?>
		<div style=" width:100% ; float:left ; " >
		<form method="post" action="<?= site_url( 'lostpassword/index' ) ?>" >
		<fieldset class="fld5"  >
		<legend>Forgot password? </legend>
		<div>
		Put in your email address below and we'll reset it for you.<br />
		  <label>Email</label>
		  <br />
		<input type="text" name="email" class="text ab" /></div>
		<div><label></label></div>
		
		<br />		
		<input type="submit" name="resetpw" value="Submit"  class="button" /> 
		&nbsp;&nbsp;<a href="<?= site_url( '/login' ) ;?>" >&laquo;Back to Login page</a>
		</fieldset>
		</form>
		</div>
</div>

<script type="text/javascript" >
	$('.flash')
	.fadeIn(1000)
	.animate({opacity:1.0}, 2000)
	.fadeOut(1000, function() {
		$(this).remove();
	}) ;
</script>
