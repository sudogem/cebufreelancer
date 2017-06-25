<div id="leftb" ><!-- start left block -->	
<?php
$dateposted = date( "M j, Y", $post_data['dateposted'] ) ;
$title = h( $post_data['title']  ) ;
$created_by = $post_data['created_by'] ;
$time_remaining = '' ; 
$duration = h( $post_data['duration'] ) ;
$budget = h( $post_data['budget'] ) ;
$payment_detail = !empty( $post_data['payment_detail'] ) ? nl2br( h( $post_data['payment_detail'] ) ) : '<em>--- please contact the buyer about the payment details ---</em>'; 
$description = nl2br( h($post_data['description']) ) ;
$project_status = $post_data['project_status'] ; 
$hide_bid_amount = ( $post_data['hide_bid_amount'] == '1' ) ? 'yes' : 'no' ;
$categories = $post_data['categories'] ;
$nc = count($categories) ;
$pc = count($project_categories);
$linkcategories = '';
foreach( $project_categories as $row ) $tmpproject_categories[$row['category_id']] = $row ;
for( $i=0; $i<$nc; $i++ ) {
	$category_url = $tmpproject_categories[$categories[$i]]['category_url'] ;
	$linkcategories .= "<a href='" . site_url("categories/$category_url"). "'>" . $tmpproject_categories[$categories[$i]]['category'] . "</a>" ;
	if ( ($i+1) <$nc) $linkcategories .= ', ';
}
?>
<div id="viewproject" >
	<form action="<?= site_url( 'settings/projects/save_project' ) ; ?>" method="post" >
<h3 class="prev">Preview Project:</h3>
<h1><?= $title ; ?></h1>
<table width="99%" border="0" class="table" >
	  <tr>
		<td class="a"  width="10%">Date Posted </td>
		<td width="59%"><?= $dateposted ; ?></td>
	  </tr>
	  <tr>
	    <td class="a" >Job type </td>
	    <td><?= $linkcategories ;?></td>
	    </tr>
	  <tr>
		<td class="a" >Buyer</td>
		<td><?= $created_by ; ?></td>
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
	<div align="center" class="submit1" ><input type="button" value="Edit"  onClick="history.go(-1)" class="button" style="margin-left:15px;"  > <input type="submit"  name="save" value="Post Project &raquo;"  class="button" /> </div> 		
 
<input type="hidden" name="title" value="<?= $title ?>" />
<input type="hidden" name="description" value="<?= $description ?>" />
<input type="hidden" name="budget" value="<?= $budget ?>" />
<input type="hidden" name="duration" value="<?= $duration ?>" />
<input type="hidden" name="payment_detail" value="<?= $payment_detail ?>" />
<?php for( $i=0; $i<$nc; $i++) :?>
<input type="hidden" name="category[]" value="<?= $categories[$i] ?>" />
<?php endfor; ?>
</form>		
  </div>
</div><!-- end left block -->	



<!-- BEGIN right block -->	
<div id="rightb" >	
	<?= $userpanel ; ?>
</div><!-- END right block -->