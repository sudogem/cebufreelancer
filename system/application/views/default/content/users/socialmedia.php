<?php  if (!defined('BASEPATH')) exit('No direct script access allowed') ; ?>
<div id="leftc" ><!-- start left block -->
<?php
$this->load->helper('url');
$this->load->view('default/content/users/_menu');
?>
<?php 
if ( (empty($user_social_media_account['facebook_account'])) &&
(empty($user_social_media_account['linkedin_account'])) &&
(empty($user_social_media_account['twitter_account'])) ) :
?>
<p class="txt"> None</p>
<?php else: ?>
<ul class="socialmedia-list" >
    <?php if (!empty($user_social_media_account['facebook_account'])) : ?>
	<li><a href="<?= prep_url($user_social_media_account['facebook_account'])?>" ><img src="<?= $assets_path ?>/images/socialmedia/facebook.png" /></a></li>
	<?php endif; ?>
	
	<?php if (!empty($user_social_media_account['linkedin_account'])) : ?>
	<li><a href="<?= prep_url($user_social_media_account['linkedin_account'])?>" ><img src="<?= $assets_path ?>/images/socialmedia/linkedin.png" /></a></li>
	<?php endif; ?>
	
	<?php if (!empty($user_social_media_account['twitter_account'])) : ?>
	<li><a href="<?= prep_url($user_social_media_account['twitter_account'])?>" ><img src="<?= $assets_path ?>/images/socialmedia/twitter.png" /></a></li>
	<?php endif; ?>
</ul>
<?php endif; ?>



</div>
