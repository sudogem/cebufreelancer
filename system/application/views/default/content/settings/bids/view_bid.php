<?php  if (!defined('BASEPATH')) exit('No direct script access allowed') ; ?>
<div id="leftb" ><!-- start left block -->
<?php
//print_r( $bid_details ) ;
$bid_id = $bid_details[0]['bid_id'] ;
$project_id = $bid_details[0]['project_id'] ;
$amount = $bid_details[0]['amount'] ;
$datebidded = date( 'M d, Y g:h a', $bid_details[0]['datebidded'] ) ;
$message = $bid_details[0]['message'] ; 
$bid_status = $bid_details[0]['bid_status'] ;
$style_bid_status = ''; 
switch( $bid_status )
{
	case 'waiting for buyer\'s confirmation' :
		$style_bid_status = 'bid_waiting' ;
		break ;
	case 'bid accepted' :
		$style_bid_status = 'bid_accepted'; 
		break ;
}

?>
<span class="rpt_v"><a href="<?= site_url( "settings/projects/view/$project_id" ) ?>" >&laquo; Back to project details</a></span>
<h1 class="h1 f">Bid details</h1><div class="clear" ></div>
<?= flash_message( $flash_message ) ?>
<table width="100%" border="0" class="table" >
	  <tr>
		<td class="a" width="10%">Freelancer</td>
		<td width="59%"><?= $biddername ;?></td>
	  </tr>
	  <tr>
	    <td class="a" >Bid</td>
	    <td><?= $amount ;?></td>
      </tr>
	  <tr>
	    <td class="a" >Date bidded </td>
	    <td><?= $datebidded ; ?></td>
    </tr>
	  <tr>
		<td class="a" >Message</td>
		<td valign="top" ><?= $message ; ?></td>
	  </tr>
	  <tr>
	    <td class="a" > Status </td>
	    <td valign="top" ><span class="<?= $style_bid_status ?>" ><?= $bid_status ?></span></td>
    </tr>
	</table>
	
	<div style="margin-left:30% ; _margin-left:20% ;" ><a href="<?= site_url( $sendpm ) ?>" class="lancerbtn"></a><a href="<?= site_url( "settings/bid/acceptbid/$bid_id" ) ?>" class="btnacceptbidp"></a></div>
	
</div><!-- end left block -->				
<script type="text/javascript" >
	$('.flash')
	.fadeIn(1000)
	.animate({opacity:1.0}, 2000)
	.fadeOut(1000, function() {
		$(this).remove();
	}) ;
</script>

<!-- BEGIN right block -->	
<div id="rightb" >	
	<?= $userpanel ; ?>
</div><!-- END right block -->
