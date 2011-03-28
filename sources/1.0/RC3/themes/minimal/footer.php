<div id="footer">
	<?php echo $SITE_footer;?><a href="rodriges.org">minimal</a> (inspired by <a href="http://www.mnimal.com/">mnimal</a>)</p><?php if ($plxShow->plxMotor->maintence==1 && isset($_COOKIE["PHPSESSID"])) echo '<span style="color:red">'.$SITE_maintence_label.'</span>'; ?></div>

<?php if ($plxShow->plxMotor->twitter != '') {?> 
	<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
	<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/<?php echo $plxShow->plxMotor->twitter; ?>.json?callback=twitterCallback2&count=3"></script>
<?php };?>

</body>
</html>
