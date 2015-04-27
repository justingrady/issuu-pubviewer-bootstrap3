<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Syncmeter extends CI_Controller {

        /**
        * This feeds out paymeter javascript based on:
	* ** property
	* ** mobile or desktop device
	*/

	public function ee($property)
	{
		$this->output->set_content_type('application/javascript');
		$this->load->helper('file');
		$this->load->library('user_agent');

		$htmldir = '/var/www/public_html';

		if ($this->agent->is_mobile())
		{
			$jsout = read_file($htmldir.'/js/pm-'.$property.'-mobile-ck.js');
		
		}
		
		elseif ($this->agent->is_browser())
		{
			$jsout = read_file($htmldir.'/js/pm-'.$property.'-desktop-ck.js');
		}
		
		else
		{
			$jsout = 'need js file to read';
		}

		$this->output->set_output($jsout);
	}

	public function jms($property)
	{
		$this->output->set_content_type('application/javascript');
		$this->load->helper('file');
		$this->load->library('user_agent');

		$htmldir = '/var/www/public_html';

		if ($this->agent->is_mobile())
		{
			$jsout = read_file($htmldir.'/js/pm-'.$property.'-mobile-jms-ck.js');
		
		}
		
		elseif ($this->agent->is_browser())
		{
			$jsout = read_file($htmldir.'/js/pm-'.$property.'-desktop-jms-ck.js');
		}
		
		else
		{
			$jsout = 'need js file to read';
		}

		$this->output->set_output($jsout);
	}

}
/* End of file syncmeter.php */
/* Location: ./application/controllers/syncmeter.php */

