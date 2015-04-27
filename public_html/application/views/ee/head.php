<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $head['title']; ?></title>
	<meta name="description" content="<?php echo $head['description']; ?>">
	<meta name="author" content="">
	<!-- <link rel="shortcut icon" href="../../assets/ico/favicon.ico"> -->
	<!-- Bootstrap core CSS -->
	<link href="<?php echo $head['url']; ?>css/screen.css" rel="stylesheet">
	<link href="<?php echo $head['url']; ?>css/pubs/<?php echo $head['siteid']; ?>.css" rel="stylesheet">
	<?php if(isset($head['pwstatus']))
		{
			echo "\n";
			echo "\t".'<meta name="__sync_contentCategory" content="'.$head['pwstatus'].'"/>'."\n";
			// echo "\t".'<script async src="https://stage.syncaccess.net/wc/bb/api/scripts/syncwall?debug=true" type="text/javascript"></script>'."\n";
			// echo "\t".'<script async src="https://stage.syncaccess.net/wc/bb/api/scripts/syncwall" type="text/javascript"></script>'."\n";
		}
	?>
	<meta property="og:site_name" content="<?php echo $head['sitetitle']; ?>"/>
	<meta property="og:title" content="<?php echo $head['title']; ?>" />
	<meta property="og:url" content="<?php echo $head['canonical']; ?>" />
	<?php if(isset($images['uri']))
		{
			echo '<meta property="og:image" content="'.$images['uri'].'"/>'."\n";
		} 
	?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>
	
	<!-- 
	<script type="text/javascript" src="http://www.google.com/jsapi"></script>
	<script type="text/javascript">
		google.load("jquery", "1.9.1");
		google.load("swfobject", "2");
	</script> -->
	<!-- <script type="text/javascript" src="/js/bootstrap-ck.js"></script> -->
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<!-- Just for debugging purposes. Don't actually copy this line! -->
	<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	<?php if(isset($pubmeta['googleanalytics'])) { ?>
	<script type="text/javascript">

		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', '<?php echo $pubmeta['googleanalytics']['setaccount'] ?>']);
		_gaq.push(['_setDomainName', '<?php echo $pubmeta['googleanalytics']['domainname'] ?>']);
		_gaq.push(['_trackPageview']);

		(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();

	</script>
	<?php } ?>

</head>
<?php // echo var_dump($this->_ci_cached_vars); ?>

