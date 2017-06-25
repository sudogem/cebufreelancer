<?php  if (!defined('BASEPATH')) exit('No direct script access allowed') ; ?>
<div id="leftb" ><!-- start left block -->
	<div id="form_section" >
<?php
$project_id = $project_details[0]['project_id'] ; 
$title = h( $project_details[0]['title'] ) ; 
$description = nl2br( h($project_details[0]['description']) ) ; 
$dateposted2 = date( "M j, Y", $project_details[0]['dateposted'] ) ;
$dateposted = $project_details[0]['dateposted'] ;
$project_status = $project_details[0]['project_status'] ; 
$created_by_id = $project_details[0]['created_by'] ;  
$created_by = $this->users_model->get_user_by_id( $project_details[0]['created_by'] , 'users.id, users.username', 'row' )->username ; 
$duration = $project_details[0]['duration'] ; 
$budget = $project_details[0]['budget'] ; 
$payment_detail = !empty( $project_details[0]['payment_detail'] ) ? nl2br( h($project_details[0]['payment_detail'])) : '<em>--- please contact the buyer about the payment details ---</em>'; 
$numofdays = $project_details[0]['numofdays']  ; 
$hide_bid_amount = ( $project_details[0]['hide_bid_amount'] == '1' ) ? 'yes' : 'no' ;
$project_categories = $this->project_categories_model->get_project_categories( array( 'project_id' => $project_id ) ) ; 
$m = count( $project_categories ) ;
$categories = '' ;
for( $i=0; $i<$m; $i++ ) {
	$category_url = $project_categories[$i]['category_url']  ;
	$categories .= "<a href='" . site_url("categories/$category_url"). "'>" . $project_categories[$i]['category'] . "</a>" ;
	if ( ($i+1) <$m) $categories .= ', ';
}
?>

<?= !empty( $flash_message ) ? flash_message( $flash_message , $flashb ) : '' ?>
<div id="viewproject" >
<script type="text/javascript" >
// google_ad_client = "pub-0672602951562966";
// /* 728x15, created 9/26/08 */
// google_ad_slot = "8702618471";
// google_ad_width = 728;
// google_ad_height = 15;
</script>
<!-- <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script> -->
		<span class="rpt_v"><a href="<?= site_url( 'projects/browse' ) ?>" >&laquo; Back to project listings</a></span>
		<div class="clear"></div>
		<h1><?= $title ; ?></h1>
	<table width="100%" border="0" class="table" >
	  <tr>
	    <td class="a">Project ID </td>
	    <td><?= $project_id ;?></td>
      </tr>
	  <tr>
		<td class="a"  width="10%">Date Posted </td>
		<td width="59%"><?= $dateposted2 ;?></td>
	  </tr>
	  <tr>
	    <td class="a" >Job type </td>
	    <td><?= $categories ;?></td>
      </tr>
	  <tr>
		<td class="a" >Buyer</td>
		<td><?= anchor("users/$created_by", $created_by)  ; ?>&nbsp;<?= ( isset($this->logged_userid) && $created_by_id === $this->logged_userid ) ? "<img src=\"{$this->assets_images}you_24.gif\"  />" : '' ?></td>
	  </tr>
	  <tr>
		<td class="a" >Status</td>
		<td><?= $project_status ; ?></td>
	  </tr>
	  <tr>
		<td class="a">Duration</td>
		<td><?= $duration ; ?></td>
	  </tr>
	  <tr>
	    <td class="a">Hide bid amount </td>
	    <td><?= $hide_bid_amount ; ?></td>
      </tr>
	  <tr>
		<td class="a">Project Budget </td>
		<td><?= $budget ; ?></td>
	  </tr>
	  <tr>
	    <td class="a">Payment detail </td>
	    <td><?= $payment_detail ; ?></td>
      </tr>
	  <tr>
		<td class="a">Description</td>
		<td>
		 <?= $description ; ?>		</td>
	  </tr>
	</table> 

<?php if ( strtolower($project_status) == 'closed' ): ?>
<p class="p2" style="float:left;"><em class="em1">*The project was closed and it cannot be bid anymore.</em></p>
	<div style="float:right;margin-left:35% ;" ><a href="<?= site_url( $sendpm ) ?>" class="buyerbtn"></a></div>
<?php else:?>	
	<div style="float:right" ><a href="#" id="bidbutton" class="bidbutton"></a><a href="<?= site_url( $sendpm ) ?>" class="buyerbtn"></a></div>
<?php endif; ?>	
	<div class="clear" ></div>
	<div class="report_this_project" >
	<h1>How to report scams and fraud</h1>
	<p>
	If you see an ad on the site that you suspect is SPAM, illegal or otherwise violates our Terms of Service, please click on the link found below &quot;Flag this ad&quot;.<br /> 
	Flagging ads brings the ad to our attention so  that we will review and can take it down quickly if appropriate.
	Please use responsibly.</p>
	<p><img src="<?= $assets_images ?>flag_red.gif" align="absmiddle" />
	<?php if (isset($this->logged_userid)): ?>
	<a href="javascript:void(0)" onclick='$(this).replaceWith("<b>Thanks for flagging.</b>");$.post("<?= site_url("projects/flag_ads") ?>", { pid: "<?= $project_id ?>" } ); return false;' >Flag this ad</a>
	<?php else: ?>
	<a href="<?= site_url( 'projects/flag_ads' ) ?>" >Flag this ad</a>
	<?php endif; ?>
	</p>	
	</div>

	<div class="report_this_project" style="display:none" >
	<h1>Avoiding scams and fraud</h1>
	<ul>
	<li>DEAL LOCALLY WITH FOLKS YOU CAN MEET IN PERSON - follow this one simple rule and you will avoid 99% of the scam attempts on craigslist.</li>
	</ul>
	</div>
	<div class="clear" ></div>
	<div id="bidme" style="display:none;" >
		<form action="<?= site_url( 'projects/bid' ) ?>" method="post" >
		<fieldset class="fld5">
			<legend>Bid</legend>
				<em><span class="h5">*</span> - denotes required field</em><br />
		<div><br />
			  <label>Your bid for the project.<em><br />
			  This is required. Example. 10k~12k, 5k or php200 per hour</em></label><br />
<input type="text" name="amount" value="<?= isset( $this->validation->amount ) ? $this->validation->amount : '' ?>"  class="text"/>
<label class="h0"><span class="h5">*</span></label>
			</div>
		<div>
		      <br />
			  <label>In how many days can you deliver a completed project?<em><br />This is required and must be a numeric. Example. 7, 30, 60...</em></label>
			  <br />
			<input type="text" name="delivery_within" value=""  class="text"  />
			<label class="h0"><span class="h5">*</span>Day(s)</label>
		</div>
		    <br />
			<div><label>Message</label><br />
			<textarea class="text ad" rows="7%" name="message" ></textarea></div>		
			<div align="center" class="submit1" ><input type="submit" name="bid" value="Place Bid &raquo;"  class="button" /></div>
		</fieldset>
		<input type="hidden" name="project_id" value="<?= $project_id ?>" />
		
		</form>
	</div>
<table width="100%" border="0" class="table1" style="margin-top:20px" >
<tr>
<td width="68%" class="b" >Freelancer</td>
<td width="20%" class="b c" >Delivery within </td>
<td width="12%" class="b c" >Bid</td>
</tr>
<?php
if ( $bidders ):
	$n = count( $bidders ) ;
	for( $i=0; $i<$n; $i++ ):
	$bid_name = $this->users_model->get_user_by_id( $bidders[$i]['user_id'], 'users.id, users.username','row' )->username ;
	$bid_userid = $bidders[$i]['user_id'] ;
	$message = h($bidders[$i]['message']);
	$delivery_within = $bidders[$i]['delivery_within'] . ' day(s)';
	$amount = ( $hide_bid_amount == 'no' ) ? $bidders[$i]['amount'] : '<em class="em2">hidden</em>' ;
?>
<tr class="r<?=($i%2)?>" >
<td><?= $bid_name ?>&nbsp;<?= (  isset($this->logged_userid) && $bid_userid === $this->logged_userid ) ? "<img src=\"{$this->assets_images}you_24.gif\"  />" : '' ?><br /><?= $message ?></td>
<td class="c"><?= $delivery_within ?></td>
<td class="c"><?= $amount ?></td>
</tr>
<?php endfor ; ?>
<?php else: ?>
<tr><td colspan="3" ><h1 class="error1" >No bid found.</h1></td></tr>
<?php endif ; ?>
</table>
		
	<div class="clear">&nbsp;</div>
 </div>
 </div>
</div><!-- end left block -->				

<!-- BEGIN right block -->	
<div id="rightb"  >	

<script type="text/javascript">
// google_ad_client = "pub-0672602951562966"; 
// /* 160x600, created 9/3/08 */
// google_ad_slot = "7144590534";
// google_ad_width = 160;
// google_ad_height = 600;
</script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
</div><!-- END right block -->
