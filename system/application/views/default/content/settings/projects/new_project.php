<?php  if (!defined('BASEPATH')) exit('No direct script access allowed') ; ?>
<div id="leftb" ><!-- start left block -->	
<div id="form_section">

<form action="<?= site_url( 'settings/projects/new_project' ) ; ?>" method="post" name="newproject" id="newproject" >
<?= !empty( $this->validation->error_string ) ? flash_message( $flash_message, $flashb, TRUE ) : '' ?>
<fieldset >
	<legend class="">Post new project</legend>
	<a href="javascript:toggles('note1')" id="shownote1" >IMPORTANT: Click here to read the message before posting a project &raquo;.</a>
	<div class="note1" id="note1" style="display:none;" >NOTE: Be sure that the project specifications you've enter here must be easy to understand and detailed. <br />
	  Always remember you can no longer change the project details once you've posted it to the public.
It's because if we allow  you to change the information it can be updated anytime and if freelancers bid on a project that is based on that original project specifications,  some buyers may claim that the freelancers did not deliver according to specifications.<br />
Hence, we do not allow to change the project details completely.
<br />However, if the information you've provided is completely wrong, you can close your project without choosing a freelancer and without any penalty. <br />You can then go ahead and open a new project.
</div>   	
	<div class="clear" >&nbsp;</div>
	<div><label>Project Title</label><br /><em class="em2" >Name of your project.</em><br />
	<input type="text" class="text2" name="title" value="<?= !empty( $this->validation->title ) ? $this->validation->title : '' ; ?>" /></div> 	
	
    <div class="clear" ></div>
    <div><label>Description</label><br />
	<em class="em2" >Describe the project in detail.  Add as much information as possible about your project.</em><br />
	
	<textarea name="description" rows="15" class="text2"><?= !empty( $this->validation->description ) ? $this->validation->description : '' ; ?></textarea></div>
    <div class="clear">&nbsp;</div>	
	<div><label>Job Type </label><br />
	<em class="em2" >Select the type of project</em>
<?php
$n = count( $project_categories ) ;
for( $i=0; $i<$n; $i++ ):
?>		
	<?php if ($i%2==0) echo "<div class='clear'></div>" ?>	
	<div class="catblk" ><label class="h6"><input type="checkbox" name="category[]" value="<?= $project_categories[$i]['category_id'] ; ?>"  <?= $this->validation->set_checkbox( "category", $project_categories[$i]['category_id'] ); ?> /><?= $project_categories[$i]['category'] ; ?></label></div>	
<?php endfor; ?>	
	</div>
	<div class="clear">&nbsp;</div>
	
	<div><label>Budget </label><br />
	<em class="em2" >Input the budget range for the project. Example. 10-15k, 20k. Dollar($) currency is also accepted. </em><br />
	<input type="text" name="budget" class="text2" value="<?= !empty( $this->validation->budget ) ? $this->validation->budget : '' ; ?>" /></div> 

	<div class="clear" ></div>		
	<div>
	  <label>Duration/Deadline </label>
	  <br />
	<em class="em2" >Sample deadline: 1-2 months, 1 week, ASAP, No Deadline(ND), 6 month contract work@home, etc...</em>
	<br />
	<input type="text" name="duration" class="text2" value="<?= !empty( $this->validation->duration ) ? $this->validation->duration : '' ; ?>" /></div>	
	
    <div class="clear" ></div>
	<div>
	  <label>Hide bid amount</label><br />
	<em class="em2" >Freelancers may not able to view the bid amount of the other freelancers. Only the project creator/service buyer can view their bid amount.</em><br />
	<select name="hide_bid_amount" >
	<option value="0" <?= $this->validation->set_select( 'hide_bid_amount', '0' ) ?> >No</option>
	<option value="1" <?= $this->validation->set_select( 'hide_bid_amount', '1' ) ?> >Yes&nbsp;&nbsp;</option>	
	</select>
	</div>
	
    <div class="clear" ></div>
	<div><label>Payment details</label> <br />
	<em class="em2" >Specify the payment details e.g by wire transfer, western union, cheque, etc.</em>
	<input type="text" name="payment_detail" class="text2" value="<?= !empty( $this->validation->payment_detail ) ? $this->validation->payment_detail : '' ; ?>" />
	</div>	
	<div align="center" class="submit1" >
    <div class="clear" ></div>
    <input type="submit"  name="preview" value="Preview Project &raquo;"  class="button" />
    </div> 
	
</fieldset>
</form>

</div>
</div><!-- end left block -->	

<!-- BEGIN right block -->	
<div id="rightb" >	
	<?= $userpanel ; ?>
</div><!-- END right block -->