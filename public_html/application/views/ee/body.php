<div class="logoHeader">
	<div class="container clearfix">
		<div class="col-md-3 col-xs-12"><a title="Home: <?php echo $pubmeta['sitetitle']; ?>" href="<?php echo $pubmeta['url']; ?>"><img class="text-left img-responsive" src="<?php echo $pubmeta['logourl']; ?>"/></a></div>
		<div class="col-md-9 col-xs-12"><p class="headtitle"><?php echo $head['headtitle']; ?></p></div>
	</div>
</div>
<div class="container">
	<div class="navbar navbar-inverse" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<?php foreach($nav as $navitem)
						{
							echo '<li class="'.$navitem['class'].'"><a href="'.$navitem['urlfull'].'">'.$navitem['title'].'</a></li>'."\n";
						}
					?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Switch publication <b class="caret"></b></a>
						<ul class="dropdown-menu">
						  <li><a href="http://ee.bakercityherald.com">Baker City Herald</a></li>
						  <li><a href="http://ee.lagrandeobserver.com">LaGrande Observer</a></li>
						  <li><a href="http://ee.bendbulletin.com">The Bulletin</a></li>
						  <li><a href="http://ee.uniondemocrat.com">The Union Democrat</a></li>
						</ul>
					</li>
				</ul>
			</div><!--/.nav-collapse -->
		</div><!--/.container-fluid -->
	</div>
	<?php /*
		<l class="breadcrumb">
			<li><a href="#">Home</a></li>
			<li><a href="#">Library</a></li>
			<li class="active">Data</li>
		</ol>
	*/  ?>
