<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $n = count( $all_messages ) ; ?>
<div id="leftb" ><!-- start left block -->	
<h1 class="h1 f"><?= $heading_title ?></h1><div class="clear" ></div>
<?= !empty( $flash_message ) ?  flash_message( $flash_message ) : '' ; ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableroll inbox" >
			<tr>
			  <th width="2%"><input type="checkbox" onclick="checkAll(<?=$n?>)" /></th>
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
	$dateposted = date( 'M d, Y g:i:s a', $all_messages[$i]['dateposted'] ) ; 
	$subject = htmlspecialchars( $all_messages[$i]['subject'], ENT_QUOTES, 'UTF-8' ); 
	$c =  ( $all_messages[$i]['isopen'] == 1 ) ? 'visited' : '' ; 
?>				
			 <tr class="<?=$c?>" >
			    <td><div align="center"><input name="checkbox2" type="checkbox"></div></td>
				<td><?= $from ?></td>
				<td><a href="<?= site_url( "messages/view/$messageid" ) ?>" ><?= $subject ?></a></td>
				<td><?= $dateposted ?></td>
			  </tr>
<?php
	endfor ; 
endif ;
?>			  <?php if ( $links ): ?>
			  <tr >
			    <td colspan="6"><div class="pager" ><?= $links ?></div></td>
		      </tr>
			  <?php endif; ?>
		</table>

</div><!-- end left block -->	

<script type="text/javascript" >
	$('.flash')
	.fadeIn(1000)
	.animate({opacity:1.0}, 2000)
	.fadeOut(500, function() {
		$(this).remove();
	}) ;

</script>

<!-- BEGIN right block -->	
<div id="rightb" >	
	<?= $userpanel ; ?>
</div><!-- END right block -->
