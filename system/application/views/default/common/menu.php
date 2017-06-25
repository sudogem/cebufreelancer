<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$loggedin = ( $this->site_sentry->is_logged_in() ) ? TRUE : FALSE ;
$uri = $this->uri->segment( 1 ) ;
$uri2 = $this->uri->segment( 2 ) ;
$browse_project = ( $uri == 'projects' || $uri == 'categories' ) ? 'class="currentp"' : '' ;
$browse_member = ( $uri == 'users' && ($uri2 == 'browse' || $uri2 == '')) ? 'class="currentp"' : '' ;
$my_account = ( $uri == 'settings' || $uri == 'resume' || $uri == 'portfolio' ) ? 'class="currentp"' : '' ;
$my_account = ( $uri == 'settings' ) ? 'class="currentp"' : '' ;
$login = ( $uri == 'login' ) ? 'class="currentp"' : '' ;
$signup = ( $uri == 'signup' ) ? 'class="currentp"' : '' ;
$currentlink6 = ( $uri == 'articles' ) ? 'class="currentp"' : '' ;
$account_settings = ( $uri == 'settings' && $uri2 == 'profile') ? 'class="currentp"' : '' ;
$viewprofile =  ( $uri == 'users' && $uri2 == $this->logged_username) ? 'class="currentp"' : '' ;
?>
<div id="tabtab" >
	<ul>
		<li><a href="<?= site_url( '/projects' ) ?>" <?= $browse_project ?> >Browse Projects</a></li>
		<li><a href="<?= site_url( '/users' ) ?>" <?= $browse_member ?>>Browse Members</a></li>
		<li><a href="<?= site_url( '/articles' ) ?>" <?= $currentlink6 ?> >Freelance Articles</a></li> 				
		<?php if ( $loggedin === FALSE )  : ?>
		<li><a href="<?= site_url( '/login' ) ?>" <?= $login ?> >Login</a></li> 			
		<li><a href="<?= site_url( '/signup' ) ?>" <?= $signup ?> >Signup</a></li> 						
		<?php else: ?>		
		<li><a href="<?= site_url( "users/$this->logged_username" ) ?>" <?= $viewprofile ?> >View My Profile</a></li>
		<li><a href="<?= site_url( '/settings/profile' ) ?>" <?= $account_settings ?> >Account Settings</a></li> 		
		<li><a href="<?= site_url( '/logout' ) ?>" >Sign out</a></li> 										
		<?php endif; ?>
	</ul>
</div>	

