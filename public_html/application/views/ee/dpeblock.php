<?php
$output	=	NULL;
$output .= '<div class="dpeBlock">'."\n";
foreach ($items as $item)
{
	$thumbnail	=	$item['images']['thumb']['medium']['imgurl'];
	$publictitle	=	(isset($item['formattedtitle'])) ? $item['formattedtitle'] : $item['title'];
	$output .=	"\t".'<div class="dpeItem">'."\n";
	$output .=      "\t\t".'<a title="view publication: '.$item['description'].'" href="'.$item['linksaxo'].'"><img src="'.$thumbnail.'"/></a>'."\n";	
	$output .=      "\t\t".'<div>'."\n";
	// $output .=      "\t\t\t".'<p><a title="view publication: '.$item['description'].'" href="'.$item['linksaxo'].'">'.$publictitle.'</a></p>'."\n";
	// $output .=      "\t\t\t".'<p class="pubDate">'.$item['displaydate'].'</p>'."\n";
	$output .=      "\t\t\t".'<p class="pubDesc"><a onclick="_gaq.push([\'_trackEvent\', \'issuuview\', \'frontpage-clickthru\', \''.$publictitle.'\']);return true;" title="view publication: '.$item['description'].'" href="'.$item['linksaxo'].'">'.$item['description'].'</a></p>'."\n";	
	$output .=	"\t\t\t".'<h3><a onclick="_gaq.push([\'_trackEvent\', \'issuuview\', \'frontpage-clickthru\', \''.$publictitle.'\']);return true;" href="'.$item['linksaxo'].'">read issue</a></h3>'."\n";
	$output .=	"\t\t\t".'<p><a style="font-weight: normal" href="/apps/pbcs.dll/section?Profile=1208&ExpNodes=1208&Category=PUBLICATIONS" title="View all Bulletin Digital Print publications">View all Bulletin Digital Print publications &raquo;</a></p>'."\n";
	$output .=	"\t\t\t".'<p><a style="font-weight: normal" href="/apps/pbcs.dll/section?Profile=1085&amp;ExpNodes=1001&amp;Category=DEALERLOCATIONS" title="Find a Bulletin Newsstand or Retailer in your area">Find a Bulletin Newsstand &raquo;</a></p>'."\n";
	$output .=      "\t\t".'</div>'."\n";
	$output .=      "\t\t".'<div style="clear: both; float: none; display: block;"></div>'."\n";	
	$output .=      "\t".'</div>'."\n";
	$output .=      "\t".'<!-- '.$item['documentId'].'-->'."\n";
}
$output .= "\t".'<div style="clear: both;"></div>'."\n";
$output .= '</div><!-- //.dpeBlock | buildtime: '.date(DATE_RSS).' -->'."\n";
echo $output;
?>
