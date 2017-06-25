<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?> 
<div id="rightb" >
		<div class="announcement2" >
			<p>To all users who register the site and did not receive an activation code, please enter your email address below. We will send you a new activation code. Thanks</p>
			<input type="text" name="email"  /><input type="submit" name="sendactcode" value="Send"  />
		</div>
		<div id="cats" >
			<div class="bannerad note">
			<p>Do you want to advertise your product with us? Kindly contact us at cebufreelancerph [at] gmail.com</p>
			</div>
			<div class="clear" >&nbsp;</div>
			<a href="#" onclick="blocking('catlist','darrow'); return false;" >
			<h1 class="drophead" ><img id="darrow"  src="<?= $assets_images ; ?>arrowd_18.gif"  />&nbsp;Project Type </h1>
			</a>
			<ul id="catlist" >
			<li><a href="<?= site_url( "projects/browse" ) ?>" >All Categories</a></li>
			<?php 
			$n = count( $all_categories ) ;
			for( $i=0; $i<$n; $i++ ) :
			$c = url_title( $all_categories[$i]['category'] ) ;
			$category_url = $all_categories[$i]['category_url'] ;
			$nitem = $this->categories_model->get_all_project_categories( $category_url  ) ;
			$nitem = ( $nitem ) ? count( $nitem ) : 0 ;
			?>
				<li><a href="<?= site_url( "categories/$category_url" ) ?>" ><?= $all_categories[$i]['category'] ; ?></a>&nbsp;(<?= $nitem?>)</li>
			<?php endfor; ?>	
			</ul>

<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like-box href="http://www.facebook.com/pages/CebuFreelancer/163674500333934" width="292" show_faces="true" border_color="#fff" stream="false" header="false"></fb:like-box>			
			
			<div class="clear" ></div>
			<div id="ads">
			<script type="text/javascript" >
			// google_ad_client = "pub-0672602951562966";
			// /* 180x150, created 10/23/08 */
			// google_ad_slot = "8016624662";
			// google_ad_width = 180;
			// google_ad_height = 150;
			</script>
			<!-- <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script> -->
			</div>
		</div>
		
  </div>
  
<script type="text/javascript">
OPEN_IMAGE = '<?= $assets_images ; ?>arrowr_18.gif';
CLOSED_IMAGE = '<?= $assets_images ; ?>arrowd_18.gif';
</script>  

