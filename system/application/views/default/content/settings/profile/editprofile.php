<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="leftb" ><!-- BEGIN left block -->	
<div id="form_section" >

<form action="<?= site_url( 'settings/profile/editprofile' ) ?>" method="post" enctype="multipart/form-data" >
<?= !empty( $flash_message ) ? flash_message( $flash_message, $flashb, TRUE ) : '' ; ?>
<fieldset>
	<legend>Account</legend>
<em> * required field</em>
<table width="100%" border="0" >
		  <tr>
		    <td width="18%" class="field" >Username&nbsp;</td>
		    <td><?= h($user_details[0]['username']) ?></td>
      </tr>
		  <tr>
		    <td class="field" >Full name&nbsp;*</td>
		    <td ><input name="fullname" type="text"  class="text ab" value="<?= !empty( $post_data['fullname'] ) ? h( $post_data['fullname'] ) : h( $user_details[0]['up_fullname'] ) ?>"></td>
    	</tr>

		<tr>
		    <td class="field" valign="top" >Photo&nbsp;</td>
		    <td valign="top">
			<?php if (!empty($profile_pic) && $profile_pic): ?>
				<img src="<?php echo $profile_pic ?>" />
			<?php endif; ?>
			<br />
			<input type="file" name="photo" />
			</td>
    	</tr>
		
		  <tr>
		    <td class="field" >Email *&nbsp;</td>
		    <td ><input name="email" type="text"  class="text ab" value="<?= !empty( $post_data['email'] ) ? $post_data['email'] : $user_details[0]['email'] ?>" /></td>
		  </tr>

		  </tr>
		  <tr>
		    <td class="field" >&nbsp;</td>
		    <td>&nbsp;</td>
	    </tr>
		</table>	
	</fieldset>	

<fieldset>	
	<legend>Social Media Accounts</legend>
	<table width="100%" border="0" >
    <tr>
		<td width="18%" class="field" >Facebook&nbsp;</td>
		<td><input type="text" name="socialmedia[facebook_account]" class="text ab" value="<?= !empty( $post_data['facebook_account'] ) ? $post_data['facebook_account'] : isset($user_social_media_account[0]) ? $user_social_media_account[0]['facebook_account'] : '' ?>" /></td>
    </tr>
    <tr>
		<td class="field">LinkedIn&nbsp;</td>
		<td><input type="text" name="socialmedia[linkedin_account]" class="text ab" value="<?= !empty( $post_data['linkedin_account'] ) ? $post_data['linkedin_account'] : isset($user_social_media_account[0]) ? $user_social_media_account[0]['linkedin_account'] : '' ?>" /></td>
    </tr>	
    <tr>
		<td class="field">Twitter&nbsp;</td>
		<td><input type="text" name="socialmedia[twitter_account]" class="text ab" value="<?= !empty( $post_data['twitter_account'] ) ? $post_data['twitter_account'] : isset($user_social_media_account[0]) ? $user_social_media_account[0]['twitter_account'] : '' ?>" /></td>
    </tr>		
	
	</table>
</fieldset>	
		
		<div align="center" class="submit1" ><input type="submit" name="update" value="Update Profile &raquo;"  class="button" /></div>		
	</form>
</div>



</div><!-- END left block -->

<!-- BEGIN right block -->	
<div id="rightb" >	
	<?= $userpanel ; ?>
</div><!-- END right block -->
  
