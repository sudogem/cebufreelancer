<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?> 
<div id="userpanel" >
<?php
$num_msg 			= 
$my_portfolio 		= 
$my_resume 			= 
$my_account         = 
$post_new_project 	= 
$editprofile 		= 
$changepassword 	= 
$my_bids 			= 
$my_projects 		= 
$my_subscriptions 	= 
$inbox 				= '' ;
$rs = $this->projects_messages_model->get_project_message_by_criteria( array( 'to' => $this->logged_userid, 'isopen' => '0' ), NULL, NULL ) ;
if ( $rs ) $num_msg = '&nbsp;&nbsp;' . count( $rs ) . ' new messages.' ;

$uri = $this->uri->uri_to_assoc( 1 ) ;

if ( isset( $uri['settings'] ) )
{
	if ( $uri['settings'] === 'projects' && isset($uri['view']) ) $my_projects = 'class="current"' ;
	if ( isset( $uri['new_project'] )) $post_new_project = 'class="current"' ;
	if ( isset( $uri['editprofile'] )) $editprofile = 'class="current"' ;
	if ( isset( $uri['changepassword'] )) $changepassword = 'class="current"' ;
	if ( isset( $uri['my_bids'] ) || isset( $uri['viewbid']) ) $my_bids = 'class="current"' ;
	if ( isset( $uri['manage_subscriptions'] ) ) $my_subscriptions = 'class="current"' ;
}

if ( isset( $uri['portfolio'])) $my_portfolio = 'class="current"' ;
if ( isset( $uri['resume'] ) ) $my_resume = 'class="current"' ;
if ( isset( $uri['my_projects'])) $my_projects = 'class="current"' ;
if ( isset( $uri['messages'] ) ) $inbox = 'class="current"' ;
?>

<?php if($profile_pic) : ?>
	<img src='<?= base_url().$profile_pic ?>' class="profile_pic_ico" width="50"  height="50" />
<?php endif; ?>

		<h1 style="float:left" >Welcome! <?= $this->logged_username ?></h1>	
	
		<div class="clear" ></div>

		<ul class="nav">
			<li <?= $post_new_project ?> ><a href="<?= site_url( 'settings/projects/new_project' ) ;?>" >Post New Project</a></li>					
			<li <?= $changepassword ?> ><a href="<?= site_url( 'settings/profile/changepassword' ) ; ?>" >Change Password</a></li> 
			<li <?= $my_bids ?> ><a href="<?= site_url( 'settings/projects/my_bids' ) ;?>" >View My Bids</a></li> 
			<li <?= $my_projects ?> ><a href="<?= site_url( 'settings/projects/my_projects' ) ;?>" >View My Projects</a></li>
			<li <?= $my_subscriptions ?> ><a href="<?= site_url( 'settings/projects/manage_subscriptions' ) ;?>" >Manage Subscriptions</a></li>
			<li <?= $inbox ?> ><a href="<?= site_url( 'messages/inbox' ) ;?>" >Messaging<span class="newmod hide">-NEW</span>
			<?php if ( $num_msg ): ?>
			<div class="rpt" ><?= $num_msg ?></div>
			<?php endif; ?>
			</a></li> 
        	<li <?= $my_resume ?> ><a href="<?= site_url( 'resume/edit' ) ;?>" >My Resume</a></li>
            <li <?= $my_portfolio ?> ><a href="<?= site_url( 'portfolio/browse' ) ;?>" >My Portfolio</a></li>
        </ul>
				
		<div class="ad200_200" >

		</div>
		
</div>