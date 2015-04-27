<?php

$row = array(
	'head' =>  "\n".'<div class="row">'."\n",
	'foot' => "\n".'</div><!-- // end row -->'."\n"
	);	

$output	=	NULL;

foreach($stacks as $stack)
{
	$bcount = 0;
	$block = NULL;
	// print_r($stack);
	// $output .= '<div class="row">'."\n";
	$output .= '<h2>'.$stack['name'].'</h2>';
	$output .= (isset($stack['description']) ? '<p>'.$stack['description'].'</p>' : NULL);
	foreach ($stack['items'] as $item)
	{
		$thumbnail	=	$item['images']['thumb'];
		$publictitle	=	(isset($item['formattedtitle'])) ? $item['formattedtitle'] : $item['title'];
		$description	=	(isset($item['description'])) ? $item['description'] : NULL;
		
		$block[$bcount] = NULL;
		$block[$bcount] .=	'<div class="col-sm-6 col-md-4">'."\n";
		$block[$bcount] .=	"\t".'<div class="thumbnail">'."\n";
		$block[$bcount] .=	"\t\t".'<a title="view publication: '.$description.'" href="'.$item['link'].'"><img class="img-responsive grid-thumb" src="'.$thumbnail['medium']['imgurl'].'"/></a>'."\n";	
		$block[$bcount] .=	"\t\t".'<div class="caption">'."\n";
		$block[$bcount] .=	"\t\t\t".'<h4><a title="view publication: '.$description.'" href="'.$item['link'].'">'.$publictitle.'</a></h4>'."\n";
		$block[$bcount] .=	"\t\t\t".'<p class="pubDate">'.$item['displaydate'].'</p>'."\n";
		$block[$bcount] .=	"\t\t\t".'<p class="pubDesc">'.$description.'</p>'."\n";	
		$block[$bcount] .=	"\t\t".'</div>'."\n";
		// $output .=      "\t".'<div style="clear: both; float: none; display: block;"></div>'."\n";	
		$block[$bcount] .=	"\t".'</div>'."\n";
		$block[$bcount] .=	'</div>'."\n";
		$block[$bcount] .=	'<!-- '.$item['documentId'].' '.$bcount.' -->'."\n\n";
		$bcount++;
		if($bcount == $rendercount) {
			// how many thumbnails we want, rendercount passsed in from controller
			break;
		}
	}

	$i = 0;

	// we do this so a new Boostrap row is generated every 4 thumbnails
	foreach($block as $bk)
	{
		if(($i    ) % 3 == 0) 
		{
			$output .= $row['head'];
		}

		$output .= $bk;
		
		if( ($i - 2) % 3 == 0 || $i == ($bcount - 1)) // bcount - 1 is to find last item in array for $block. If so, output the foot 
		{
			$output .= $row['foot'];
		}
		
		$output .= '<!-- icount: '.$i.' -->';

		$i++;	
	}
}

echo $output;
?>
