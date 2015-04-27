<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jsonp extends CI_Controller {

	/**
	 * Used to display a specific Issuu output
	 * based on incoming var of $docid
	 * It then pulls a json file and formats it into a view
	 * Thu Jan 17 19:14:17 PST 2013
	 */
        public function id($docid,$type='jsonp')
        {
		// $this->output->cache(120);
		$this->load->library('issproc');
		$data = array(
			'item' => $this->issproc->getjsonitem($docid)
		);
		$this->output->set_content_type('application/json');
		// $typs are types of views, sush as title, page, decriptions, etc.
		// item
		// $this->load->view('jsonp/'.$type,$data);
		// echo $data['item'];
		$output = $_GET['callback'] . '('.$data['item'].')';
		echo $output;
		$this->issproc->jsonpfiles($docid,$output);

        }

}
/* End of file jsonp.php */
/* Location: ./application/controllers/jsonp.php */
