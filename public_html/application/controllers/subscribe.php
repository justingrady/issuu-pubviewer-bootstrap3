<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subscribe extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->driver('cache', array('adapter' => 'file'));
		$this->load->library('sniffer');
		$this->load->library('issuu');
		$this->load->library('issproc');
		$this->load->library('Pubconfig');
		
		$property = $this->sniffer->sniffproperty();
		$this->data['property'] = $property;
		$this->data['pubmeta'] = $this->pubconfig->pubmeta($property);
		$this->data['publist'] = $this->pubconfig->pubmeta($property,'all');	
		// $this->data['head'] = $this->pubconfig->pubmeta($property);
		// $this->data['nav']  = $this->navbuild($this->data['stacks']);
		$this->data['foot'] = $this->pubconfig->pubmeta($property);
	}

	public function index()
        {
		// $this->output->cache(5);
		// $this->data['head'] = $this->pubconfig->pubmeta($property);
		$this->data['head'] = $this->data['pubmeta'];
		
		// echo '<pre> 204sxml | <br/>';
		// print_r($this->data['pubmeta']);
		// echo '</pre>';
		
		$this->load->view('ee/head',$this->data);
		$this->load->view('ee/subland');
		$this->load->view('ee/subfooter');
        }





	public function stack($stackSeg,$docid=NULL)
	{
		$this->output->cache(5);
		$property = $this->data['property'];
		// $this->data['head'] = $this->pubconfig->pubmeta($property);
		$this->data['head'] = $this->data['pubmeta'];
		if($docid == NULL)
		{
			// we want to lookup the stack by url segment and now folder.  
			$count = 600;
			$this->data['stacks'] = $this->dataCollector($property,$count);
			// so we build a lookup script for it
			$lookup = array();
			$stacks = $this->data['stacks'];
			foreach($stacks as $stack)
			{
				$urlseg = $stack['urlseg'];
				$lookup[$urlseg] = $stack['folderId'];		
			}
			
			$stackDataTemp = $this->data['stacks'][$lookup[$stackSeg]];

			// unset main stack data, then reset with only the stack data we want
			unset($this->data['stacks']);
			$this->data['stacks'][0] = $stackDataTemp;
			$viewtype = 'grid';
		} 
		elseif($docid != NULL)
		{
			$this->data['head'] = array_merge($this->pubconfig->pubmeta($property), $this->issproc->decodeitem($docid, 'array'));
			$this->data['head']['canonical'] = $this->data['head']['url'].'main/stack/'.$stackSeg.'/'.$this->data['head']['documentId'];
			$this->data['item'] = $this->issproc->decodeitem($docid);
			unset($this->data['stacks']);
			$viewtype = 'item';
		}
		$this->load->view('ee/head',$this->data);
		$this->load->view('ee/body');
		$this->load->view('ee/'.$viewtype);
		$this->load->view('ee/footer');

	}

	public function dataCollector($property,$count=NULL)
	{
		$stack = NULL;
		$publicmeta = $this->pubconfig->pubmeta($property);				// look up all folders wanted within each publication, in config file
		// $foldermeta = $this->pubconfig->foldermeta($property);				// hit the API to lookup all folders contained in $property.
		$foldermeta = $this->data['foldermeta'];
		foreach($publicmeta['folders'] as $folderId => $pmstatus)
		{
			$stack[$folderId] = $foldermeta[$folderId];					// all info about folder, name, etc.
			$stack[$folderId]['items'] = $this->dataLoader($property,$folderId,$count,$pmstatus);	// all item entries within the individual folder
			// if there are no items in the folder/stack, unset the whole folder key so it does not get sent to the view
			if(empty($stack[$folderId]['items'])){
				// echo 'unset!!! '.$stack[$folderId]['name'];
				unset($stack[$folderId]);
			}
		}
		return $stack;
	}

	public function dataLoader($property,$folderId,$count=NULL,$pwstatus='FREE')
	{
		$this->load->library('issdata');
		$feedURL = $this->issuu->feedurl($property,$folderId);
		$data = array();
		
		//lets locally cache the xml so we don't overwhelm the API	
		if ( ! $sxml = $this->cache->get('itemsxml-'.$property.'-'.$folderId))
		{
			echo 'Saving to the cache! ITEMS XML '.$folderId.' <br />';
			$sxml = file_get_contents($feedURL);

			// Save into the cache for 24 hours
			$this->cache->save('itemsxml-'.$property.'-'.$folderId, $sxml, 3600);
		}
		
		// pull raw xml from the cache
		$sxml = $this->cache->get('itemsxml-'.$property.'-'.$folderId);

		$sxml = simplexml_load_string($sxml);
		// Don't like suppressing errors with @, but will only find that node if an Issuu API error
		// http://stackoverflow.com/questions/17936478/why-using-function-disabling-error-reporting-per-function-in-php-is-bad-pract
		$error = @(isset($sxml->error->attributes()->message) ? $sxml->error->attributes()->message : NULL);
		if($error == 'Request throttled')
		{
			log_message('error', $error);
			// if xml errors, we want to delete the cache file which is error garbage
			$this->cache->delete('itemsxml-'.$property.'-'.$folderId);
			// echo '<h1>error: '.$error.'</h1>';
			sleep(5);
			// rerun this function so we get the API data we want, not the error
			return $this->dataLoader($property,$folderId,$count=NULL);
		}
			
		// echo '<pre> 204sxml | <br/>';
		// echo $sxml;
		// echo '</pre>';
		
		$error = NULL;
		$entries = $sxml->result->bookmark;
		$items = $this->issdata->xmlDateSort($entries);	
		$items = $this->dataFormat($items,$pwstatus);

		// echo '<pre> TEST2001 | ';	
		// print_r($this->issdata->xmlDateSort($entries));
		// echo '<hr/>';
		// print_r($items);
		// echo '</pre>';

		$this->issproc->encoder($items); // store each item entry to a file, to be called by another controller
		$items = $this->issdata->itemCounter($items,$count);
		return $items;
	}

	public function currentpage()
	{
		if(uri_string() == '')
		{
			$curpage = 'home';
		} else {
			// returns last segment in url
			$this->load->helper('url');
			$segments = explode('/',uri_string());
			// $curpage = array_pop($segments);
			$curpage = $segments[2];
		}
		return $curpage;
	}

	public function breadcrumb($stacks)
	{
		
	}

	public function navbuild($stacks)
	{
		$this->load->helper('url');
		$currentpage = $this->currentpage();
		$class = ($currentpage == 'home') ? 'active' : 'inactive';
		$i = 0;
		$nav = array(
			'frontpage' => array(
				'title'  => 'Home',
				'class' => $class,
				'urlseg' => index_page(), 
				'urlfull' => prep_url( base_url().index_page() ) 
			)
		);

		foreach($stacks as $stack)
		{
			$urlstring = url_title($stack['name'], '_', TRUE);
			$class = ($urlstring == $currentpage) ? 'active' : 'inactive';
			$nav[$urlstring] =  array(
				'title'   => ucwords($stack['name']),
				'class'   => $class,
				'urlseg'  => $urlstring,
				'urlfull' => prep_url( base_url().'main/stack/'.$urlstring )
			);
		}
		// echo '<pre>';
		// print_r($nav);
		// echo '</pre>';
		return $nav;
	}

	public function dataFormat($entries,$pwstatus)
	{
		// This takes the object, and turns into an array, with the documenId being the main key, the a key/val array after that with all document 
		// attributes for listing. It goes from there into the view.
		// Tue May 22 13:54:20 PDT 2012 JTG
		
		$this->load->helper('file');
                $this->load->helper('url');
		$this->load->library('awsimages'); // for prefetching and processing thumbnail images 
		$property = $this->data['property'];
		$foldermeta = $this->data['foldermeta'];
		// $foldermeta = $this->pubconfig->foldermeta($property);

		// echo '<pre> TEST2003 | ';    
		// print_r($foldermeta);
		// echo '</pre>';    


		$items  =       array();
                foreach ($entries as $entry) {
                        $attrs                  =       $entry->attributes();
			$docname = (string) $attrs->name;
			// $docid = (string) $attrs['documentId'];
			$docid = (string) $attrs->documentId;
			$folderid = (string) $attrs->folderid;
			$urlpath = NULL;
			$urlpath = (isset($foldermeta[$folderid]['urlseg']) ? $foldermeta[$folderid]['urlseg'] : 'pub');
			
			// echo '<pre> TEST2003 | ';    
			// print_r($foldermeta);
			// echo '</pre>';    
			
			// we want to fetch the thumbnail image from the Issuu API.
			// The store locally, resize it, the return a local based thumbnail URL
			// Uses a separate library of Awsimages
			// Tue May 22 16:44:05 PDT 2012 JTG
			$issuuImgUrl = 'http://image.issuu.com/'.$docid.'/jpg/page_1.jpg';
			$items[$docid]['images']= $this->awsimages->imagePull($issuuImgUrl,$docname,$docid); // image url source, documentId
			$items[$docid]['link'] = base_url().'main/stack/'.$urlpath.'/'.$docid;
			$items[$docid]['pwstatus'] = $pwstatus; 
			// $items[$docid]['linksaxo'] = '/apps/pbcs.dll/section?Profile=1208&amp;Category='.$saxocategory.'&amp;docid='.$docid;
			
			foreach ($attrs as $key => $val)
			{
				$items[$docid][$key] = trim((string) $val);
				if($key == 'created')
				{
					// we want a human readable date in the array for view.
					// added 'displaydate' to $items array
					// Tue May 22 14:10:48 PDT 2012 JTG
					$cdate = (string) $val;
					$cdate = strtotime($cdate);
					$items[$docid]['displaydate'] = date('g:ia | m/d/y',$cdate);
					$items[$docid]['longpubdate'] = date('F d, Y h:iA',$cdate);
				}
				
				if($key == 'name')
				{
					$items[$docid]['linkissuu'] = 'http://issuu.com/wescom/docs/'.$val;
				}

			}
		}
		return $items;
	}
}
/* End of file Subscribe.php */
/* Location: ./application/controllers/Subscribe.php */
