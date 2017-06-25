<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="leftb" ><!-- start left block -->	
<?php $n = count( $all_messages ) ; ?>
<h1 class="h3" ><?= $heading_title ?></h1>
<form method="post" action="<?= site_url( "messages/doaction/1" ) ?>" name="actionform" > 

<div id="nboxtool"><span style="float:right;"><input type="submit" value="Delete" class="button" /></span><div class="clear" ></div></div>
<?= !empty( $flash_message ) ? flash_message( $flash_message, $flashb, TRUE ) : '' ; ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableroll inbox" >
			<tr>
			  <th width="2%"><input type="checkbox" id="toggle" name="toggle" onclick="checkAll(<?=$n?>)" /></th>
				<th width="15%"> User </th>
				<th width="60%" >Subject</th>
				<th width="19%"> Date </th>
			</tr>
<?php
if ( $all_messages !== FALSE ):
//print_r( $all_messages ) ;
	for( $i=0; $i < $n; $i++ ):
	$messageid = $all_messages[$i]['message_id'] ; 
	$from = $this->users_model->get_user_by_id( $all_messages[$i]['from'], 'users.id, users.username', 'row' )->username ;
	$message = substr( $all_messages[$i]['message'], 0, 30 ) ; 
	$dateposted = date( 'M d, Y g:i a', $all_messages[$i]['dateposted'] ) ; 
	$subject = htmlspecialchars( $all_messages[$i]['subject'], ENT_QUOTES, 'UTF-8' ); 
	$c =  ( $all_messages[$i]['isopen'] == 1 ) ? 'visited' : '' ; 
?>				
			 <tr class="<?=$c?>" >
			    <td align="center"><input type="checkbox"  name="chk[]" id="cb<?= $i ?>" value="<?= $messageid ; ?>" class="chk" onclick="ischecked(this)" ></td>
				<td><?= $from ?></td>
				<td><a href="<?= site_url( "messages/view/$messageid" ) ?>" ><?= $subject ?></a></td>
				<td><?= $dateposted ?></td>
    </tr>
<?php
	endfor ; 
endif ;
?>			  <?php if ( isset($links) ): ?>
			  <tr >
			    <td colspan="6"><div class="pager" ><?= $links ?></div></td>
		      </tr>
			  <?php endif; ?>
		</table>
		<input type="hidden" name="boxchecked" id="boxchecked" value="0"  />
</form>
</div><!-- end left block -->	
<!-- BEGIN right block -->	
<div id="rightb" >	
	<?= $userpanel ; ?>
</div><!-- END right block -->
