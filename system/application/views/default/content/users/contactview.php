<?php  if (!defined('BASEPATH')) exit('No direct script access allowed') ; ?>
<div id="leftc" ><!-- start left block -->
<?php
$this->load->view('default/content/users/_menu');
?>
<?php if ( $this->site_sentry->is_logged_in()) : ?>
<input type="button" class="button" onclick="$.colorbox({ 'href':'<?= site_url("users/$username/contactform") ?>', width:'650px', height:'540px', iframe: true, scrolling: true})" value="Send a message to <?php echo $fullname ?>" />
<?php else: ?>
<p class="p2" >To contact <?php echo $fullname ?>, you need to <a href="<?= site_url("/login") ?>" >login</a> first. If you dont have account yet, click <a href="<?= site_url("/signup") ?>" >here to register</a>.</p>
<?php endif; ?>
</div>
