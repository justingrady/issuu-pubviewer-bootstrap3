<?php
$output	=	NULL;
$output .= '<div class="mmPanel_h ">'."\n";
$output .= '<h4>'.$displaytitle.'</h4>';
foreach ($items as $item)
{
	$thumbnail	=	$item['images']['thumb'];
	$publictitle	=	(isset($item['formattedtitle'])) ? $item['formattedtitle'] : $item['title'];
	$output .=	'<div class="mmItem">'."\n";
	$output .=      "\t".'<a title="view publication: '.$item['description'].'" href="'.$item['linksaxo'].'"><img src="'.$thumbnail['small']['imgurl'].'"/></a>'."\n";	
	$output .=      "\t".'<div>'."\n";
	$output .=      "\t\t".'<p><a title="view publication: '.$item['description'].'" href="'.$item['linksaxo'].'">'.$publictitle.'</a></p>'."\n";
	$output .=      "\t\t".'<p class="pubDate">'.$item['displaydate'].'</p>'."\n";
	$output .=      "\t\t".'<p class="pubDesc">'.$item['description'].'</p>'."\n";	
	$output .=      "\t".'</div>'."\n";
	$output .=      "\t".'<div style="clear: both; float: none; display: block;"></div>'."\n";	
	$output .=      '</div>'."\n";
	$output .=      '<!-- '.$item['documentId'].'-->'."\n\n";
}
$output .= '<div style="clear: both;"></div>'."\n";
$output .= '</div><!-- //.mmPanel_h -->'."\n";
echo $output;
?>
