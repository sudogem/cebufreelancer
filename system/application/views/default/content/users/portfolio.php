<?php  if (!defined('BASEPATH')) exit('No direct script access allowed') ; ?>
<div id="leftc" ><!-- start left block -->
<?php
$this->load->view('default/content/users/_menu');
?>
<?php
$n = count($portfolio_data['result']);
if ($n > 0) :
for($j=0; $j<$n; $j++) : 
	$id = $portfolio_data['result'][$j]['id'];
	
?>
<div class="post postclear">
    <div class="entry" >
    <h1 class="title-project"><?php echo $portfolio_data['result'][$j]['title'] ?></h1>
     <?php echo nl2br($portfolio_data['result'][$j]['content']) ?>
	 <br /><br />

			 <div id="portfolio_photos" >
			 <?php 
			 $m = count($portfolio_photodata[$id]);
			 for($k=0; $k < $m; $k++):
				$filename = $portfolio_photodata[$id][$k]['filename'];
				if (is_image_exist($filename, $upload_dir_path)):
			 ?>
				<a href="<?= $live_path_portfolio.$filename ?>" ><img src="<?= $live_path_portfolio.'th_'.$filename ?>" class="imgleft" width="150" height="100" /></a> 
			<?php endif; ?>   
			<?php endfor; ?>
			</div>
			<div class="clear"></div>
    </div>
</div>
<?php endfor; ?>
<?php else: ?>
	<p class="p2">No portfolio yet.</p>
<?php endif; ?>
<div class="clear"></div>
<div class="pager"><?php echo $portfolio_data['pagination'] ?></div>

</div>

<script type="text/javascript">
      TopUp.addPresets({
        "#portfolio_photos a": {
          group: "portfolio_photos",
          readAltText: 1,
		  overlayClose: 1,
          shaded: 1
        }
      });
</script>