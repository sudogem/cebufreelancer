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
<?= style('reset.css')?>
<?= style('struct.css')?>
<?= style('typo.css')?>
<?= style('tableroll.css')?>
<?= style('form.css')?>
<?= style('feeds.css')?>
<?= style('colorbox.css')?>
<?= style('tipsy.css')?>
<?= style('minitabs.css')?>
<link rel="shortcut icon" href="<?= base_url() ?>favicon.ico" type="image/ico" />
<?php if ( isset( $extra_css ) ) foreach( $extra_css as $css ) echo style( $css ) ; ?>
<?= script('jquery-1.4.2.min.js') ?>
<?= script('jquery.tipsy.js') ?>
<?= script('topup/top_up-min.js?libs=core+clip') ?>
<?= script('sortable.js') ?>
<?= script('common.js') ?>
<?php if ( isset( $init_js ) ) foreach( $init_js as $jss ) echo script( $jss ) ; ?>

</head>
<body>
<noscript>
<div id="noscript">You currently have JavaScript Disabled, we advise you enable it to have the best online experience :)</div>
</noscript>

<div id="parent" >
	<div id="head" >
		<a href="<?= site_url( index_page() ) ?>" ><h1><span><?= property( 'app_headtitle1' ) ; ?></span></h1></a>
	</div>

	<div id="head2" style="margin-left:350px; _margin-left:180px;" >
		<h1><?= property( 'app_headtitle2' ) ?></h1>
  </div>	
	<div class="clear" >&nbsp;</div>
	
	<?= $mainmenu ; ?>
	<div id="contentb" ><!-- begin contentb-->
	