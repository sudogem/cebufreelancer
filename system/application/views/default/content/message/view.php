<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="leftb" ><!-- start left block -->	
<div id="form_section">

<?php
#print_r($message_details) ;
$subject = $this->htmlpurifier->purify($message_details[0]['subject']);
$from = $this->users_model->get_user_by_id( $message_details[0]['from'], 'users.id, users.username', 'row' )->username ;
$message = $this->htmlpurifier->purify($message_details[0]['message']);
$message_id = $message_details[0]['message_id'] ;
$date = date( 'M d, Y D h:i:s A', $message_details[0]['dateposted'] ) ; 
$nl = "\n\r"; 
$nl = repeater($nl, 1) ; 
$s = " ";
$nl2 = "-";
$nl2 = repeater($nl2, 130) ; 
$message2 = "$s{$nl}{$nl}{$nl2}\n" ; 
$message2 .= "On $date, $from wrote: \n" ; 	
$message2 .= trim( $message ) ; 
?>
<form action="<?= site_url( 'messages/reply' ) ;?>" method="post" name="inbox" id="inbox" >
<?= !empty( $flash_message ) ? flash_message( $flash_message, $flashb, TRUE ) : '' ; ?>
<span class="rpt_v"><a href="<?= site_url('messages/inbox') ?>" >&laquo; Back to inbox</a></span><div class="clear" ></div>
		<fieldset class="fld4" >
			<legend>Inbox</legend>
			<div><label class="msglabel">From</label>&nbsp;<?= $from ?></div> 
			<div><label class="msglabel">Posted</label>&nbsp;<?= $date ?></div> 
			<div><label class="msglabel">Subject</label><?= $subject?><br /></div>
			<br />
			<div class="msg" ><?= nl2br_except_pre($message) ; ?></div>
			<div align="center" >
			<a href="#" id="cmdreply" class="replybtn" ></a>
			</div>
		</fieldset>	
		
			<div id="replyb" style="display:none ; " >
				<fieldset class="fld4" >
					<legend class="h1">Reply</legend>
					<div><label>To&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;</label><?= $from ?><br /></div> 
					<div><label>Subject&nbsp;&nbsp;:&nbsp;</label><?= $subject?><br /></div>
					<div><label>Message:</label><br /> 
					<textarea class="text ad" rows="15" name="message" id="message" ><?= $message2 ; ?></textarea></div>
					<div align="center" class="submit1" ><br class="clearfix" />
					<input type="submit" name="reply" value="Send Message &raquo;"  class="button" /></div>
				</fieldset>
				<input type="hidden" name="msg_id" value="<?= $message_id ?>"  />
			</div>		

		</form>

</div>

</div><!-- end left block -->	

<!-- BEGIN right block -->	
<div id="rightb" >	
	<?= $userpanel ; ?>
</div><!-- END right block -->
