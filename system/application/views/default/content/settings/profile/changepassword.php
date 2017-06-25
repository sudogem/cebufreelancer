<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="leftb" ><!-- BEGIN left block -->	
	<div id="form_section" >
		<form action="<?= site_url( 'settings/profile/changepassword' ) ?>" method="post" >
		<?= !empty($flash_message) ? flash_message( $flash_message, $flashb, TRUE ) : '' ; ?>
		<fieldset>
			<legend>Change password</legend>
				<table width="100%" border="0" >
					  <tr>
						<td class="a" width="25%" >Old Password</td>
						<td><input type="password" name="oldpw"  class="text ab" /></td>
						</tr>
					  <tr>
						<td class="a" valign="bottom" >New Password</td>
						<td valign="top"><input type="password" name="newpw"  class="text ab" /></td>
					</tr>
					  <tr>
						<td class="a" valign="bottom" >Retype New Password</td>
						<td valign="top"><input type="password" name="newpw2"  class="text ab" /></td>
				  </tr>
				</table>

				<div align="center" class="submit1" ><input type="submit" name="changepw" value="Change Password"  class="button" /></div>		
		</fieldset>	
		</form>
	</div>

</div><!-- END left block -->

<!-- BEGIN right block -->	
<div id="rightb" >	
	<?= $userpanel ; ?>
</div><!-- END right block -->
  
