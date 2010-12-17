<div id="sidebar">
	<div id="categories">
		<h2><?php if ($plxShow->plxMotor->categ_get==1) echo '<a onclick="toggleDiv(\'catlist\')" id="cathead">';?><?php echo $SITE_categories_title; ?><?php if ($plxShow->plxMotor->categ_get==1) echo '</a>';?></h2>
		<ul id="catlist">
			<?php $plxShow->catList('','#cat_name'); ?>
		</ul>
	</div>
	<?php $plxShow->artFeed('atom'); ?>
	<?php if ($plxShow->plxMotor->twitter != '') {; ?>
	<br><br>
    <div id="tweets">
		<h2><?php echo $SITE_twitts_title; ?></h2>
		<div id="twitter_update_list"></div>
		<?php echo '<a href="http://twitter.com/'.$plxShow->plxMotor->twitter.'">'.$SITE_twitts_mytwitter.'</a>';?>
	</div>
	<?php }; ?>
</div>
<div class="clearer"></div>
