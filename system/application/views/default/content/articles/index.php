<div id="rssdata" >
<?php
if ( $feed_result )
{
$items = $feed->get_items( $start, $per_page ) ;
foreach( $items as $feed_item ):
//$m = $items->get_item( $j ) ;
$enc = $feed_item->get_item_tags( 'http://purl.org/rss/1.0/modules/content/', 'encoded' );
$data = $enc[0]['data'] ;
?>
<h1><?= $feed_item->get_title(); ?></h1>
<p class="p1">
<?= $data ; ?></p>
<div style="clear:both;" ></div>
<?php endforeach; ?>
<span style="float:right"><a href="#" name="rssdata" >Back to top</a></span>
</div>


<div id="rss_rightcol" >
	<!-- ads here -->
	 

<?php
$items = $feed->get_items( ) ;
$n = count( $items );
echo '<ol>';
for( $j=0; $j<$n; $j++):
$feed_title = $items[$j]->get_title( ) ;
$clean_feed_title = url_title( $items[$j]->get_title( ) ) ;
?>
<h1 class="h1"><li><a href="<?= site_url( "articles/index/$j/$clean_feed_title" ) ?>" ><?= $feed_title ; ?></a></li></h1>
<?php endfor; ?>
</ol>
</div>
<?php } else { ?>
	<p><?= htmlspecialchars( $feed->error( ) ) ; ?></p>
<?php } ?>