<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $n = count( $portfolio_data['result'] ) ;  ?>
<div id="leftb" ><!-- start left block -->	
	<div>
		<form method="post" action="<?= site_url( "portfolio/doaction/1" ) ?>" name="actionform" > 	
		<h1 class="h1 f" >My Portfolio</h1>
		<ul class="actionmenu" >
			<li><input type="button" value="Add portfolio" class="button" onclick="gotoURL('<?php echo site_url("portfolio/form") ?>')" /></li>
			<li><input type="submit" value="Delete" class="button" /></li>
		</ul>		
		<div class="clear" ></div> 

<?= !empty( $flash_message ) ? flash_message( $flash_message, $flashb, TRUE ) : '' ; ?>		
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableroll inbox"  >
		  <tr>
			<th width="2%"><input type="checkbox" id="toggle" name="toggle" onclick="checkAll(<?=$n?>)" /></th>
			<th width="35%">Title</th>
			<th width="15%">Date created</th>
			<th width="15%">Last updated</th>
		  </tr>
<?php
if ( $portfolio_data['result'] ):
	for( $j=0; $j<$n; $j++ ):
		$id = $portfolio_data['result'][$j]['id'];
		$project_title = $portfolio_data['result'][$j]['title'];
		$date_created = $portfolio_data['result'][$j]['fmtcreated_at'];
		$last_updated = $portfolio_data['result'][$j]['fmtupdated_at'];
?>		  
		  <tr class="r<?=($j%2) ?>" >
			<td align="center"><input type="checkbox"  name="chk[]" id="cb<?= $j ?>" value="<?= $id ; ?>" class="chk" onclick="ischecked(this)" ></td>
			<td><a href="<?= site_url( "portfolio/form/$id" ) ?>" ><?= $project_title ?></a></td>
			<td><?= $date_created ?></td>
			<td><?= $last_updated ?></td>
		  </tr>
	<?php endfor; ?>
<?php else: ?> 
		<tr>
		  <td colspan="4" >No portfolio yet.</td>
		</tr>
<?php endif; ?>		  
		</table>
		<input type="hidden" name="boxchecked" id="boxchecked" value="0"  />
		</form>
	</div>
<?php print '<div class="pager">' . $portfolio_data['pagination'] . '</div>' ?>
</div><!-- end left block -->	


<!-- BEGIN right block -->	
<div id="rightb" >	
	<?= $userpanel ; ?>
</div><!-- END right block -->
