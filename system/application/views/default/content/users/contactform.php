<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="verify-v1" content="i/aLRi20omGLiB2OVe72QlaDKEmFK7ip+RabVd1k9nI=" />
<meta name="description" content= "<?= !empty( $meta_description ) ? $meta_description : property("app_description") ;  ?>" />
<meta name="keywords" content="<?= !empty( $meta_keywords ) ? $meta_keywords : property("app_keywords") ;  ?>" />
<meta name="robots" content= "<?= !empty( $meta_robots ) ? $meta_robots : property("app_robots") ;  ?>" />
<title><?= !empty( $meta_title ) ? $meta_title : property("app_title") ;  ?></title>
<link rel="shortcut icon" href="<?= base_url() ?>favicon.ico" type="image/ico" />
<?= style('form.css')?>
<?= style('reset.css')?>
<?php if ( isset( $extra_css ) ) foreach( $extra_css as $css ) echo style( $css ) ; ?>
<?= script('jquery-1.4.2.min.js') ?>
<?= script('common.js') ?>
<?php if ( isset( $init_js ) ) foreach( $init_js as $jss ) echo script( $jss ) ; ?>
</head>
<body>

<?= !empty( $flash_message ) ? flash_message( $flash_message, $flashb ) : '' ; ?>
<div class="contact_user" id="form_section">
<form method="post" action="<?php echo site_url("users/$username/contactform") ?>" id="marginForm" >
 <fieldset class="fld5">
	<legend style="text-transform:capitalize" >Send a message to <?php echo $fullname ?></legend>

<div class="wrap">
	<label>Subject</label>
	<input type="text" name="subject" class="text ab" value="<?= isset($post_data['subject']) ? $post_data['subject'] : ''  ?>" />
</div>
	
<div class="wrap">
 <label>Message</label><textarea  name="message" rows="8"><?= isset($post_data['message']) ? $post_data['message'] : ''  ?></textarea> 
</div>
 
<div class="b" ><label>Verification code </label><br />
	<div id="captchas"><?= $captcha_img ; ?></div><br />
	<a href="javascript:void(0)" style="margin-left:140px" onclick="$.post('<?= site_url('signup/generate_form_captcha')?>', function(data) { $('#captchas').replaceWith('<div id=captchas >' + data + '</div>') } )" >
	Cannot read? Generate a new one.</a>
	<br />
	<label></label> 
	<input type="text" name="seccode" class="text ab" /><br /><br />
	<label></label> Enter the characters shown in the image above.
</div> 
	
</fieldset>

<div align="center"> <input class="button" type="submit" name="submit" value="Submit" /></div>
 
</form>


</div><!-- END form_section -->


<script type="text/javascript" >
 	if ( document.getElementById('closeme') )
	{	
		$('.flash')
		.fadeIn(1000)
		.animate({opacity:1.0}, 2000) ;
		$('#closeme').click( function(){
			$('.flash')
			.fadeOut('slow', function(){
			$(this).remove();
			});
		});
	}
	else
	{
		$('.flash')
		.fadeIn(1000)
		.animate({opacity:1.0}, 2000)
		.fadeOut(1000, function() {
			$(this).remove();
		}) ;
	}
</script>
</body>