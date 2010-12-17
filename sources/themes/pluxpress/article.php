<?php include('header.php'); # On insere le header ?>
<div id="page">
<div id="content" class="artikol">
<div class="post articul">
<h2 class="title"><?php $plxShow->artTitle(); ?></h2>
<p class="post-info">Размещено <?php $plxShow->artDate(); ?> в <?php $plxShow->artHour(); ?> |  Категория: <?php $plxShow->artCat(); ?></p>
			<?php $plxShow->artContent(); ?>
		</div>
		
	</div>
	<?php include('sidebar.php'); # On insere la sidebar ?>
</div>
<?php include('footer.php'); # On insere le footer ?>
