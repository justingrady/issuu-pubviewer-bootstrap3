		<?php 
			// echo '<pre>';
			// var_dump($this->_ci_cached_vars);
			// echo '</pre>';
		?>
		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->
		<!-- <script src="<?php echo $pubmeta['url']; ?>js/bootstrap-ck.js"></script> -->
	</div> <!-- /container -->
	<footer style="jtgfooter">
		<div class="container">
			<p><?php echo '&copy; '.$foot['company'].' '.date('Y'); ?></p>
		</div>
	</footer>
	<?php /*	
	<script async src="https://stage.syncaccess.net/wc/bb/api/scripts/syncwall?debug=false" type="text/javascript"></script>
	<script async src="/js/syncwall-wescom.js?debug=true" type="text/javascript"></script>
	<script async src="<?php echo $foot['url']; ?>js/pm-<?php echo $foot['siteid']; ?>-<?php echo $uam; ?>-ck.js" type="text/javascript"></script>
	<!-- <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script> -->
	<!-- <script async src="https://stage.syncaccess.net/wc/bb/api/scripts/syncwall?debug=false" type="text/javascript"></script> -->
	 */ ?>
	<script async src="/syncmeter/ee/<?php echo $foot['siteid']; ?>" type="text/javascript"></script>
</body>
</html>
