<?php if (!defined('BASEPATH')) exit('No direct script access allowed') ; ?>
<div id="leftb" ><!-- start left block -->	

<form action="<?= site_url( "settings/projects/view_project/$project_id" ) ?>" method="post" >
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
	#print_r( $tmp_categories ) ;
	#$tmp_categories_val = array_values( $tmp_categories ) ;
#	print_r($tmp_categories_val ) ;
	$m = count( $tmp_categories );
	for( $j=0; $j<$m; $j++ ) $tmp_cat[] = $tmp_categories[$j]['category_id'];
	$n = count( $project_categories ) ;
	for( $i=0; $i<$n; $i++ ):
//	if (in_array( $project_categories[$i]['category_id'], $tmp_cat )) echo 'f';
	//( $tmp_categories[$i]['category_id'] == $project_categories[$i]['category_id'] ) ? "checked=checked" : '';	
	?>		
	<?php if ($i%3==0) echo "<div class='clear'></div>" ?>	
	<div class="catblk" ><label><input type="checkbox" name="category[]" value="<?= $project_categories[$i]['category_id'] ; ?>" <?= (in_array( $project_categories[$i]['category_id'], $tmp_cat )) ? 'checked="checked"' : '' ?>/><?= $project_categories[$i]['category'] ; ?></label></div>	
	<?php endfor; ?>	
	</div>
	<div class="clear">&nbsp;</div>
		
	<div><label>Budget </label><br /><em>Input the budget range for the project. </em>
	<br />
	<input type="text" name="budget" class="text ad" value="<?= isset( $post_data['budget'] ) ? $post_data['budget'] : $project_details[0]['budget'] ; ?>" /></div> 
	<div>
	  <label>Deadline </label>
	  <br />
	  <em>Sample deadline: 1-2 months, 1 week, ASAP, No Deadline(ND), 6 month contract work@home, etc...</em>
	<br />
	<input type="text" name="duration" class="text ad" value="<?= isset( $post_data['duration'] ) ? $post_data['duration'] : $project_details[0]['duration'] ; ?>" /></div>	
	
	<div align="center" class="submit1" ><input type="submit" name="update" value="Update Project &raquo;"  class="button" /></div> 

</fieldset>
</form>

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
