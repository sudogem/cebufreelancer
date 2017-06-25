<?php  if (!defined('BASEPATH')) exit('No direct script access allowed') ; ?>
<?php

$portfolio_id	= $id;
$posttitle 		= isset($_POST['portfolio[title]']) ? $_POST['portfolio[title]'] : '';
$postcontent 	= isset($_POST['portfolio[content]']) ? $_POST['portfolio[content]'] : '';
$title 			= (!empty($posttitle)) ? $posttitle :  $this->htmlpurifier->purify($portfolio_data[0]['title'], $purifyconfig);
$content 		= (!empty($postcontent )) ? $postcontent  : $this->htmlpurifier->purify($portfolio_data[0]['content'], $purifyconfig);
$nPhotos		= count($portfolio_data);
?>
<div id="leftb" ><!-- start left block -->	
    <div id="form_section" class="resume">
    <?php flash_message($flash_message, $flashb, TRUE) ?>
	<form action="<?= site_url( "portfolio/form/$id" ) ; ?>" method="post" name="portfolio" enctype='multipart/form-data' >
	
    <fieldset >
        <legend class=""><?= $form_title ?></legend>
		<table width="100%">
    	<tr>
        <td width="12%" class="field">Title&nbsp;*</td>
        <td><input type="text" name="portfolio[title]" value="<?php echo $title ?>" /></td>
		</tr>

		<tr>
		<td class="field">Description *</td>
		<td><textarea name="portfolio[content]" style="width:600px !important; height:300px"><?php echo $content ?></textarea></td>
		</tr>	
		
		<tr>
		<td class="field">Photos </td>
		<td>
		
		<?php for($j=0; $j < $nPhotos; $j++) : 
		$hash_id  = $portfolio_data[$j]['hash_id'];
		$id       = $portfolio_data[$j]['id'];
		$img      = $portfolio_data[$j]['filename'];
			if(is_image_exist($img, $upload_dir_path)):
		?>
		<div style="position:relative; width: 100px;" class="photof" id="<?php echo $id ?>" >
		<a href="<?php echo site_url("portfolio/deletephoto/id/$id/p/$portfolio_id/token/$hash_id") ?>" class="deletephoto_<?php echo $id ?>" ></a>
		<img src="<?php echo $upload_path.'th_'.$img ?>" width="100" height="100" />
		</div>
			<?php endif; ?>
		<?php endfor; ?>
		
		<?php if ($numphotos == false): ?>
		<br class="clear" />
		<input type="file" name="photo" class="text" /><em class="clear" style="padding-left:10px; line-height:3em">upload up to 10 photos</em>
		<?php endif; ?>
		
		</td>
		</tr>			
		</table>
		
			<div align="center" class="submit1" >
		    	<div class="clear" ></div>
				<input type="hidden" name="portfolio[id]" value="<?php echo $portfolio_id?>" />
			    <input type="submit"  name="preview" value="Save &raquo;"  class="button" />
		    </div>		
    </fieldset>  
	</form>
    
	</div>
</div><!-- end left block -->


<!-- BEGIN right block -->	
<div id="rightb" >	
	<?= $userpanel ; ?>
</div><!-- END right block -->
	