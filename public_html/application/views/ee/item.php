<?php

// echo '<pre>';
// echo var_dump($this->_ci_cached_vars);
// echo '</pre>';

$thumbnail      =       $item->images->thumb->medium->imgurl;
$publictitle    =       (isset($item->formattedtitle)) ? $item->formattedtitle : $item->title;
$pubnavigation= '<div class="pubNavigation">
	<ul>
	    <li><a href="#" onClick="document.getElementById(\'issuuViewer\').goToFirstPage(); return false;">first page</a></li>
	    <li><a href="#" onClick="document.getElementById(\'issuuViewer\').goToPreviousPage(); return false;">previous page</a></li>
	    <li><a href="#" onClick="document.getElementById(\'issuuViewer\').goToNextPage(); return false;">next page</a></li>
	    <li class="last"><a href="#" onClick="document.getElementById(\'issuuViewer\').goToLastPage(); return false;">last page</a></li>
	</ul>
	<br style="clear: both;"/>
</div>';
$pubnavigation = preg_replace("/\r?\n/", "", addslashes($pubnavigation));
$noflashoutput = NULL;
$noflashoutput .= '<div class="row issuutablet clearfix">'."\n";
$noflashoutput .= '<div class="col-md-4 col-sm-6 col-xs-6 text-center"><a target="_blank" title="click to read: '.$publictitle.'" href="'.$item->linkissuu.'"><img class="img-responsive img-thumbnail" src="'.$thumbnail.'"/></a></div>'."\n";
$noflashoutput .= '<div class="col-md-4 col-sm-6 col-xs-6">'."\n";
$noflashoutput .= '<p class="text-danger">Adobe Flash is not enabled or you are using a tablet or smartphone. A compatible version is available.</p>'."\n";
$noflashoutput .= '<a type="button" target="_blank" class="btn btn-primary btn-lg btn-block" title="click to read: '.$publictitle.'" href="'.$item->linkissuu.'">click to view</a>'."\n";
$noflashoutput .= '</div>';
$noflashoutput .= '</div>';
$noflashoutput = preg_replace("/\r?\n/", "", addslashes($noflashoutput));

?>

<h1><?php echo $publictitle; ?><br/><small><?php echo $item->description; ?></small></h1>
<small class="pubDate">published: <?php echo $item->longpubdate; ?></small>
<div class="pubViewerContainer">
	<div id="dperender"></div>
</div>

<script type="text/javascript">

if(swfobject.hasFlashPlayerVersion("1"))
	{
		var viewerChangeHandler = function () {
			var viewer = document.getElementById('issuuViewer');
			var pageNumber = viewer.getPageNumber();
			var totalPageCount = viewer.getPageCount();
			document.getElementById('pNumber').innerHTML = pageNumber;
			// document.getElementById('tNumber').innerHTML = totalPageCount;
		}

		function addEventHandler() {
			document.getElementById('issuuViewer').addEventListener("change", "viewerChangeHandler");
		}

		var attributes = { id: 'issuuViewer' };	
		
		var params = {
			allowfullscreen: 'true',
			allowScriptAccess: 'always',
			menu: 'false'
		};

		var flashvars = {
			jsAPIInitCallback: 'addEventHandler',
			jsAPIClientDomain: 'www.bendbulletin.com',
			mode: 'embed',
			layout: 'http%3A%2F%2Fskin.issuu.com%2Fv%2Flight%2Flayout.xml',
			showFlipBtn: 'true',
			documentId: '<?php echo $item->documentId; ?>',
			docName: '<?php echo htmlspecialchars($publictitle,ENT_QUOTES); ?>',
			username: '<?php echo strtolower($item->documentUsername); ?>',
			loadingInfoText: <?php echo json_encode($item->description); ?>,
			et: '1257366051018',
		er: '88'
		};
		
		swfobject.embedSWF("http://static.issuu.com/webembed/viewers/style1/v1/IssuuViewer.swf", "dperender", "620", "480", "9.0.0", "swfobject/expressInstall.swf", flashvars, params, attributes);
		
		/*$("document").ready(function(){
			$('.pubViewerContainer').append('<?php echo $pubnavigation; ?>');
		}); */

	}
	else
	{
		/*
		$("document").ready(function(){
			// alert('tablet view no flash');
			$('#dperender').append('<?php echo $noflashoutput; ?>');
		});
		*/
		document.addEventListener('DOMContentLoaded', function() {

			/* 
			if (typeof jQuery == 'undefined') {  
				// alert('jquery yes');
			} else {
				// alert('jquery no');
			}
			*/

			$('#dperender').append('<?php echo $noflashoutput; ?>');
		} );
		// if (_gaq) _gaq.push(['_trackEvent', 'issuuview', 'landing-noflash', '<?php echo htmlspecialchars($publictitle,ENT_QUOTES); ?>']);
	}

</script>
