<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Spec extends CI_Controller {

	/**
	 * Used to display a specific Issuu output
	 * based on incoming var of $docid
	 * It then pulls a json file and formats it into a view
	 * Thu Jan 17 19:14:17 PST 2013
	 */
        
	public function id($docid,$type='item')
        {
		// $this->output->cache(120);
		
		$this->load->library('issproc');
		$this->load->library('sniffer');
		$this->load->library('pubconfig');
		$property = $this->sniffer->sniffproperty();
		print_r($this->pubconfig->headdata($property));
		$data = array(
			'head' => $this->pubconfig->headdata($property),
			'item' => $this->issproc->decodeitem($docid),
			'flashnav' => '',
			'noflash' => ''
		);
		
		// $typs are types of views, sush as title, page, decriptions, etc.
		// item
		
		$this->load->view('ee/head',$data['head']);
		$this->load->view('ee/body');
		$this->load->view('ee/'.$type,$data);
		// echo $docid;
		$this->load->view('ee/footer');
        }

}
/* End of file spec.php */
/* Location: ./application/controllers/spec.php */
