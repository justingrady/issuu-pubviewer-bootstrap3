<?php
$output	=	NULL;
$output .= '<div class="dpeSideBlock">'."\n";
foreach ($items as $item)
{
	$thumbnail	=	$item['images']['thumb']['small']['imgurl'];
	$publictitle	=	(isset($item['formattedtitle'])) ? $item['formattedtitle'] : $item['title'];
	$output .=	"\t".'<div class="dpeItem">'."\n";
	$output .=      "\t\t".'<a title="view publication: '.$item['description'].'" href="'.$item['linksaxo'].'"><img src="'.$thumbnail.'"/></a>'."\n";	
	$output .=      "\t\t".'<div>'."\n";
	$output .=      "\t\t\t".'<p><a title="view publication: '.$item['description'].'" href="'.$item['linksaxo'].'">'.$publictitle.'</a></p>'."\n";
	$output .=      "\t\t\t".'<p class="pubDate">'.$item['displaydate'].'</p>'."\n";
	$output .=      "\t\t\t".'<p class="pubDesc">'.$item['description'].'</p>'."\n";	
	$output .=      "\t\t".'</div>'."\n";
	$output .=      "\t\t".'<div style="clear: both; float: none; display: block;"></div>'."\n";	
	$output .=      "\t".'</div>'."\n";
	$output .=      "\t".'<!-- '.$item['documentId'].'-->'."\n";
}
$output .= "\t".'<div style="clear: both;"></div>'."\n";
$output .= '</div><!-- //.dpeBlock | buildtime: '.date(DATE_RSS).' -->'."\n";
echo $output;
?>
