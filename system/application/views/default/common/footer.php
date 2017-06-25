<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?> 
		</div><!-- end contentb-->
	<div class="clear" ></div>
</div>

<div id="tail" >
		<ul>
			<li><a href="<?= site_url( 'privacy/' ) ;?>" >Privacy</a></li>									
			<li><a href="<?= site_url( 'tos/' ) ;?>" >Terms of Service</a></li>
			<li><a href="<?= site_url( 'contact/' ) ;?>" >Contact Us</a></li>
			<li><a href="<?= site_url( 'tell_a_friend/' ) ;?>" >Tell A Friend</a></li> 
			<li><a href="<?= site_url( '/about' ) ?>" >About CebuFreelancer</a></li>				
			<li>&copy; 2008 &mdash; <?php echo date('Y') ?>. CebuFreelancer. All rights reserved.</li>
		</ul>
	</div>
	
<?php 
if ( isset( $extra_js ) ) foreach( $extra_js as $jss ) echo script( $jss ) ; ?>

<!-- Start of StatCounter Code for Default Guide -->
<script type="text/javascript">
var sc_project=3713970; 
var sc_invisible=1; 
var sc_security="41ebb283"; 
</script>
<script type="text/javascript"
src="http://www.statcounter.com/counter/counter.js"></script>
<noscript><div class="statcounter"><a title="custom
counter" href="http://statcounter.com/free-hit-counter/"
target="_blank"><img class="statcounter"
src="http://c.statcounter.com/3713970/0/41ebb283/1/"
alt="custom counter"></a></div></noscript>
<!-- End of StatCounter Code for Default Guide -->

</body>
</html>
