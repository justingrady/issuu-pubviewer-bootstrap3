<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stacks extends CI_Controller {

        /**
        * A utility script to get the Issuu list of folders, or 'stacks' by Issuu account
	* Mon Mar 31 12:16:13 PDT 2014
	*/

	public function index()
        {
		$this->load->library('sniffer');
		$this->load->library('issuu');
		$this->load->helper('xml');	
	
		$property = $this->sniffer->sniffproperty();
		
		echo '<h1>'.$property.'</h1>';
		echo '<h2>Folders / Stacks</h2>';
		
		$foldersurl = $this->issuu->findfolders($property);

		$foldersxml = file_get_contents($foldersurl);
		
		$sxml = simplexml_load_string($foldersxml);

		echo '<pre>'."\n";
		print_r($sxml);
		echo '</pre>'."\n";
        }
	
	public function meta($folderId=NULL)	// we use this to view meta data from each folder/stack in issuu
        {
		$this->load->library('sniffer');
		$this->load->library('issuu');
		$this->load->library('pubconfig');
		$this->load->helper('xml');	
	
		$property = $this->sniffer->sniffproperty();
		
		echo '<h1>'.$property.'</h1>';

		$meta = $this->pubconfig->foldermeta($property,$folderId);
		
		print_r($meta);

        }

	public function useragent()
	{
		$this->load->library('user_agent');

		if ($this->agent->is_mobile())
		{
			$agent = $this->agent->mobile();
			$agent .= '<br/>I am mobile';
		}
		
		elseif ($this->agent->is_browser())
		{
			$agent = $this->agent->browser().' '.$this->agent->version();
			$agent .= '<br/>I am a desktop browser !mobile';
		}
		
		else
		{
			    $agent = 'Unidentified User Agent';
		}

		echo $agent;
		echo '<br/>';
		echo $this->agent->platform(); // Platform info (Windows, Linux, Mac, etc.)
		echo '<br/>User agent string: '.$this->agent->agent_string();
	}

}

/* End of file stacks.php */
/* Location: ./application/controllers/stacks.php */

