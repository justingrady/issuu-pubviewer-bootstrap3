<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header wescomlogo" >
			<img src="/images/logo_wescompapers_white.png"/>
		</div>
	</div>
</div>
<div class="jumbotron">
	<div class="container sub-jumbo">
		<div class="sub-jumbo-background"></div>
		<div class="sub-jumbo-messaging">
		<?php
			$ot = NULL;
			$ot .= (isset($message['header'])) ? '<h1>'.$message['header'].'</h1>'."\n" : NULL;
			$ot .= (isset($message['main'])) ? '<p>'.$message['main'].'</p>'."\n" : NULL;
			$ot .= (isset($message['thank'])) ? '<h2>'.$message['thank'].'</h2>'."\n" : NULL;
			$ot .= (isset($message['action'])) ? '<h3>'.$message['action'].'</h3>'."\n" : NULL;
			echo $ot;
			unset($ot);
		?>
		</div>
	</div>
</div>

<div class="container">

<?php 
$row = array(
	'head' => '<div class="row">'."\n",
	'foot' => '</div><!-- // end row -->'."\n"
	);	

$output	=	NULL;
$bcount = 0;

if($type == 'subscribe')
{
		
	// account subscription
	foreach($publist as $pubid => $pubvars)
	{
		$publictitle = $pubid;
		$block[$bcount] = NULL;
		$block[$bcount] .=	'<div class="col-sm-6 col-md-6">'."\n";
		$block[$bcount] .=	"\t".'<div class="thumbnail sub-button">'."\n";
		$block[$bcount] .=	"\t\t".'<a title="subscribe today: '.$publictitle.' " href="'.$pubvars['suburl'].'"><img class="img-responsive grid-thumb" src="'.$pubvars['logourl'].'"/></a>'."\n";	
		$block[$bcount] .=	"\t\t".'<a type="button" class="btn btn-primary btn-lg btn-block" href="'.$pubvars['suburl'].'">subscribe</a>';
		$block[$bcount] .=	"\t".'</div>'."\n";
		$block[$bcount] .=	'</div>'."\n";
		$block[$bcount] .=	'<!-- '.$pubid.'-->'."\n\n";
		$bcount++;
	}

}

if($type == 'connect')
{

	// account connect
	foreach($publist as $pubid => $pubvars)
	{
		$publictitle = $pubid;
		$block[$bcount] = NULL;
		$block[$bcount] .=	'<div class="col-sm-6 col-md-6">'."\n";
		$block[$bcount] .=	"\t".'<div class="thumbnail sub-button">'."\n";
		$block[$bcount] .=	"\t\t".'<a title="connect your account: '.$publictitle.' " href="'.$pubvars['connecturl'].'"><img class="img-responsive grid-thumb" src="'.$pubvars['logourl'].'"/></a>'."\n";	
		$block[$bcount] .=	"\t\t".'<a type="button" class="btn btn-primary btn-lg btn-block" href="'.$pubvars['connecturl'].'">Connect my account</a>';
		$block[$bcount] .=	"\t".'</div>'."\n";
		$block[$bcount] .=	'</div>'."\n";
		$block[$bcount] .=	'<!-- '.$pubid.'-->'."\n\n";
		$bcount++;
	}
}

if($type == 'password')
{

	// account connect
	foreach($publist as $pubid => $pubvars)
	{
		$publictitle = $pubid;
		$block[$bcount] = NULL;
		$block[$bcount] .=	'<div class="col-sm-6 col-md-6">'."\n";
		$block[$bcount] .=	"\t".'<div class="thumbnail sub-button">'."\n";
		$block[$bcount] .=	"\t\t".'<a title="connect your account: '.$publictitle.' " href="'.$pubvars['passwordreseturl'].'"><img class="img-responsive grid-thumb" src="'.$pubvars['logourl'].'"/></a>'."\n";	
		$block[$bcount] .=	"\t\t".'<a type="button" class="btn btn-primary btn-lg btn-block" href="'.$pubvars['passwordreseturl'].'">Request new password</a>';
		$block[$bcount] .=	"\t".'</div>'."\n";
		$block[$bcount] .=	'</div>'."\n";
		$block[$bcount] .=	'<!-- '.$pubid.'-->'."\n\n";
		$bcount++;
	}
}

if($type == 'upgrade')
{

	// account upgrade
	foreach($publist as $pubid => $pubvars)
	{
		$publictitle = $pubid;
		$block[$bcount] = NULL;
		$block[$bcount] .=	'<div class="col-sm-6 col-md-6">'."\n";
		$block[$bcount] .=	"\t".'<div class="thumbnail sub-button">'."\n";
		$block[$bcount] .=	"\t\t".'<img class="img-responsive grid-thumb" src="'.$pubvars['logourl'].'"/>'."\n";	
		$block[$bcount] .=	"\t\t".'<div class="custserv">'."\n";
		$block[$bcount] .=	"\t\t\t".'<p><span class="fa fa-phone-square"></span> <a href="tel:'.$pubvars['customerservice']['phone'].'">'.$pubvars['customerservice']['phone'].'</a></p>';
		$block[$bcount] .=	"\t\t\t".'<p><span class="fa fa-envelope-square"></span> <a href="email:'.$pubvars['customerservice']['email'].'">'.$pubvars['customerservice']['email'].'</a></p>';
		$block[$bcount] .=	"\t\t".'</div>'."\n";
		$block[$bcount] .=	"\t".'</div>'."\n";
		$block[$bcount] .=	'</div>'."\n";
		$block[$bcount] .=	'<!-- '.$pubid.'-->'."\n\n";
		$bcount++;
	}
}

// now we do some processing to show blocks nicely in bootstrap

$i = 0;

// we do this so a new Boostrap row is generated every 4 thumbnails
foreach($block as $bk)
{

	// echo '<pre>';
	// print_r($bk);
	//echo '</pre>';

	if(($i    ) % 2 == 0) 
	{
		$output .= $row['head'];
	}

	$output .= $bk;
	
	if(($i - 1) % 2 == 0) 
	{
		$output .= $row['foot'];
	}

	$i++;
}

echo $output;
?>

