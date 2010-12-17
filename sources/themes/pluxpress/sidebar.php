<div id="sidebar">
	<div id="categories">
		<h2><?php if ($plxShow->plxMotor->categ_get==1) echo '<a onclick="toggleDiv(\'catlist\')" id="cathead">';?>Категории<?php if ($plxShow->plxMotor->categ_get==1) echo '</a>';?></h2>
		<ul id="catlist">
			<?php $plxShow->catList('','#cat_name'); ?>
		</ul>
	</div>
	<?php $plxShow->artFeed('atom'); ?>
</div>
<div class="clearer"></div>
