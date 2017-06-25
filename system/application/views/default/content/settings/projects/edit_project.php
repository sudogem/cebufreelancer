<?php if (!defined('BASEPATH')) exit('No direct script access allowed') ; ?>
<div id="leftb" ><!-- start left block -->	

<form action="<?= site_url( "settings/projects/edit/$project_id" ) ?>" method="post" >
<?= !empty( $this->validation->error_string ) ? flash_message( $this->validation->error_string ) : '' ?>
<?php
$f = $this->session->flashdata( 'flash_message' ) ;
$post_data = $this->session->flashdata( 'post_data' ) ;  
if (!empty( $this->validation->error_string )) echo flash_message( $this->validation->error_string ) ;
elseif ( !empty( $f ) ) echo flash_message( $f ) ;
?>
<fieldset class="fld4" >
	<legend>Edit project</legend>	
	<div><label>Project Title</label><br /><em>Name of your project.</em><br />
	<input type="text" name="title" class="text ad" value="<?= isset( $post_data['title'] ) ? $post_data['title'] :  $project_details[0]['title'] ; ?>" /></div> 	
	<div><label>Description</label><br />
	<em>Describe the project in detail.  Add as much information as possible about your project.</em><br />
	
	<textarea name="description" class="text ad" rows="15"><?= isset( $post_data['description'] ) ? $post_data['description'] : $project_details[0]['description'] ; ?></textarea></div>

	<div class="clear">&nbsp;</div>	
	<div><label>Job Type </label><br />
	<em>Select the type of project</em>
	<?php
	$m = count( $tmp_categories );
	for( $j=0; $j<$m; $j++ ) $tmp_cat[] = $tmp_categories[$j]['category_id'];
	$n = count( $project_categories ) ;
	for( $i=0; $i<$n; $i++ ):
	?>		
	<?php if ($i%3==0) echo "<div class='clear'></div>" ?>	
	<div class="catblk" ><label class="h6"><input type="checkbox" name="category[]" value="<?= $project_categories[$i]['category_id'] ; ?>" <?= (in_array( $project_categories[$i]['category_id'], $tmp_cat )) ? 'checked="checked"' : '' ?>/><?= $project_categories[$i]['category'] ; ?></label></div>	
	<?php endfor; ?>	
	</div>
	<div class="clear">&nbsp;</div>
	
	<div><label>Status</label><br  />
	<select name="project_status">
	<option value="closed" <?php echo ( $project_details[0]['project_status'] == 'closed' ) ? 'selected="selected"' : '' ?> >closed</option>
	<option value="open" <?php echo ( $project_details[0]['project_status'] == 'open' ) ? 'selected' : '' ?> >open</option>
	</select>
	</div>
			
	<div><label>Budget</label><br /><em>Input the budget range for the project. </em>
	<br />
	<input type="text" name="budget" class="text ad" value="<?= isset( $post_data['budget'] ) ? $post_data['budget'] : $project_details[0]['budget'] ; ?>" /></div>

	<div><label>Date Posted</label><br />
	<input type="text" name="dateposted" id="dateposted"  class="text ad" value="<?= isset( $post_data['dateposted'] ) ? $post_data['dateposted'] : date( 'm/d/Y', $project_details[0]['dateposted'] ) ; ?>" /><input type="button" name="trigger" id="trigger" value=". . ."  />
	</div>
	 
	<div>
	  <label>Deadline </label>
	  <br />
	  <em>Sample deadline: 1-2 months, 1 week, ASAP, No Deadline(ND), 6 month contract work@home, etc...</em>
	<br />
	<input type="text" name="duration" class="text ad" value="<?= isset( $post_data['duration'] ) ? $post_data['duration'] : $project_details[0]['duration'] ; ?>" /></div>	

	<div>
	<label>Hide bid amount</label><br />
	<em>Freelancers may not able to view the bid amount of the other freelancers. Only the project creator/service buyer can view their bid amount.</em><br />
	<select name="hide_bid_amount" >
	<option value="1" <?php echo ( $project_details[0]['hide_bid_amount'] == '1' ) ? 'selected="selected"' : '' ?> >Yes</option>
	<option value="0" <?php echo ( $project_details[0]['hide_bid_amount'] == '0' ) ? 'selected="selected"' : '' ?> >No</option>
	</select>
	</div>
	
	<div><label>Payment details</label> <br />
	<em>Specify the payment details e.g by wire transfer, western union, cheque, etc.</em>
	<textarea name="payment_detail"  class="text ad" ><?= isset( $post_data['payment_detail'] ) ? $post_data['payment_detail'] : $project_details[0]['payment_detail'] ; ?></textarea></div>
	
	<div align="center" class="submit1" ><input type="submit" name="update" value="Update Project &raquo;"  class="button" /></div> 

</fieldset>
</form>

</div><!-- end left block -->	
<?php if ( isset( $extra_js_mid ) ) foreach( $extra_js_mid as $jss ) echo script( $jss ) ; ?>

<script type="text/javascript" >
	$('.flash')
	.fadeIn(1000)
	.animate({opacity:1.0}, 2000)
	.fadeOut(500, function() {
		$(this).remove();
	}) ;

 Calendar.setup(
    {
      inputField  : "dateposted",         // ID of the input field
      ifFormat    : "%m/%d/%Y",    // the date format
      button      : "trigger"       // ID of the button
    }
  );		
</script>

<!-- BEGIN right block -->	
<div id="rightb" >	
	<?= $userpanel ; ?>
</div><!-- END right block -->
