<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Publist extends CI_Controller {

        /**
         * Index Page for this controller.
         *
         * Maps to the following URL
         *              http://example.com/index.php/welcome
         *      - or -  
         *              http://example.com/index.php/welcome/index
         *      - or -
         * Since this controller is set as the default controller in 
         * config/routes.php, it's displayed at http://example.com/
         *
         * So any other public methods not prefixed with an underscore will
         * map to /index.php/welcome/<method_name>
         * @see http://codeigniter.com/user_guide/general/urls.html
         */
        public function id($mediasource,$folderid,$count=NULL,$displaytitle,$pwtoggle=NULL,$type='list')
        {
		// $this->output->cache(60);
		$data = array();
		$this->load->library('issuu');
		$this->load->library('issproc');
		
		$this->load->library('sniffer');
                $property = $this->sniffer->sniffproperty();
                echo '<h1>'.$property.'</h1>';

		$feedURL = $this->issuu->feedurl($property,$folderid);
		$sxml = file_get_contents($feedURL);
		$sxml = simplexml_load_string($sxml);
		// var_dump($sxml);
		$entries = $sxml->result->bookmark;
		// print_r($entries);
		$items = $this->xmlDateSort($entries);	
		$items = $this->dataFormat($items,$pwtoggle);
		$this->issproc->encoder($items); // store each item entry to a file, to be called by another controller
		$items = $this->itemCounter($items,$count);
		// print_r($items);
		$data['items'] = $items;
		$data['displaytitle'] = $this->displayTitleFormatter($displaytitle);
                $this->load->view('ee/'.$type,$data);
        }

	private function displayTitleFormatter($string)
	{
		$string = urldecode($string);
		$string = trim($string);
		$string = mb_convert_case($string,MB_CASE_TITLE);
		return $string;
	}

	public function itemCounter($items,$count=NULL)
	{
		// Limit the array to a specified output count starting at 0.  
		// if $count is NULL, just return the $items array unchanged
		if($count != NULL)
		{
			$output = array_slice($items, 0, $count, true);
			return $output;
		}
		else
		{
			return $items;
		}
	}

	public function dataFormat($entries,$pwtoggle)
	{
		// This takes the object, and turns into an array, with the documenId being the main key, the a key/val array after that with all document 
		// attributes for listing. It goes from there into the view.
		// Tue May 22 13:54:20 PDT 2012 JTG
		
		$this->load->helper('file');
                $this->load->helper('url');
		$this->load->library('awsimages'); // for prefetching and processing thumbnail images 

		// preproxessing
		$saxocategory = ($pwtoggle == 1 ? 'PUBLICATIONS01' : 'PUBLICATIONS'); 
	
		$items  =       array();
                foreach ($entries as $entry) {
                        $attrs                  =       $entry->attributes();

			$docname = (string) $attrs->name;
			$docid = (string) $attrs->documentId;
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
		
				if($key == 'documentId')
                                {
                                        // we want to fetch the thumbnail image from the Issuu API.
                                        // The store locally, resize it, the return a local based thumbnail URL
					// Uses a separate library of Awsimages
                                        // Tue May 22 16:44:05 PDT 2012 JTG
                                        $issuuImgUrl = 'http://image.issuu.com/'.$val.'/jpg/page_1.jpg';
					$items[$docid]['images']= $this->awsimages->imagePull($issuuImgUrl,$docname,$val); // image url source, documentId
					$items[$docid]['link'] = base_url().'index.php/pubspec/'.$docid;
					$items[$docid]['linksaxo'] = '/apps/pbcs.dll/section?Profile=1208&amp;Category='.$saxocategory.'&amp;docid='.$docid;
				}
				if($key == 'name')
				{
					$items[$docid]['linkissuu'] = 'http://issuu.com/wescom/docs/'.$val;
				}
			}
		}
		// print_r($items);
		return $items;
	}

	public function xmlDateSort($entries) 
	{
        	// this function sorts entries by the human readable date in the 'title' attribute. So, publications can be uploaded out of 
		// order, but still display in descending order by date of printed publication
		// Mon May 21 13:17:17 PDT 2012 JTG

		$items  =       array();                                                                                                                                   
		foreach ($entries as $entry) {                                                                                                                             
			$attrs                  =       $entry->attributes();                                                                                              
			$createdDate            =       strtotime($attrs['created']);
			$folder                 =       $entry->folders->folder;                                                                                           
			$folderid               =       (string) $folder['id'];                                                                                            
			if($folderid == 'fdfdd10d-0e72-410d-8cdc-f25d8827151e')
			{                                                                                                                                                  
				$titleArr               =       explode(' ',$attrs['title']); // turn 'title' string into an array, to pop off human readable date           
				$humandate              =       array_pop($titleArr); // get human readable date from 'title' attribute                                    
				$slasheddate            =       str_replace('-','/',$humandate); // takes care of crappy dashed dates uploders use | Wed Jan  2 10:58:15 PST 2013
				$unixDate               =       strtotime($slasheddate); // turn human readable date into unix format                                      
				$prettyDate             =       date('m/d/y',$unixDate);                                                                                   
				$prettyTitle            =       implode(' ',$titleArr);                                                                                    
				$items[$unixDate]       =       $entry; // use unix timestamp of human readable date from title as array key.                              
				$items[$unixDate][]['formattedtitle'] = $prettyTitle.' '.$prettyDate; // use unix timestamp of human readable date from title as array key.
			}                                                                                                                                                  
			else                                                                                                                                               
			{                                                                                                                                                  
				if( isset($iDupeKey) && isset($items[$iDupeKey]) )
				{
					// sort of a hack job.  If there are entries with the same created time stamp, each subsequent entry has 10 seconds deleted from it, so it has a unique key for soriting
					// Wed May 29 16:45:09 PDT 2013 JTG
					$unixDate	=	$iDupeKey - (30); // subtrack 30 seconds from unix/epoch time
				}
				else
				{
					$unixDate	=	strtotime($attrs['created']);
				}
				$items[$unixDate]       =       $entry; // use unix timestamp of human readable date from title as array key.
				$iDupeKey               =       $unixDate; 
			}      
		}                                                                                                                                                          
		krsort($items); // sort array by key (human readable timestamp), in descending/most recent first order                                                     
		return $items;
	}

        public function loadConfig($pubid)
        {
                $this->load->helper('file');
                $fcontent = read_file('/var/www/instances.txt');
                $fcontent = trim($fcontent);
                $data = explode("\n",$fcontent);
                $configs = array();
                foreach($data as $line) {
                        $d = explode(',',$line);
                        // each data line looks like this: trp,conskey,conssec.  So we want to put into an keyed array by pubid
                        $configs[$d[0]] = array(
                                'consKey'  => $d[1],
                                'consSec'  => $d[2],
                                'property' => trim($d[3])
                        );
                }
                return $configs[$pubid];
        }

	public function _sniffProperty()
        {
                // this function takes the browser base URL, then return the root property, such as uniondemocrat, or bakercityherald.
                // Results are then used to reference keys in _properties k/v array for output
                $this->load->helper('url');
                $vars   =       explode('.',base_url());
                return $vars[1];
        }

}
/* End of file Publist.php */
/* Location: ./application/controllers/Publist.php */
