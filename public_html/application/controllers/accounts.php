<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounts extends CI_Controller {

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

	function __construct()
	{
		parent::__construct();
		$this->load->library('sniffer');
		$this->load->library('Pubconfig');
		
		$property = $this->sniffer->sniffproperty();
		$this->data['property'] = $property;
		$this->data['pubmeta'] = $this->pubconfig->pubmeta($property);
		$this->data['publist'] = $this->pubconfig->pubmeta($property,'all');
		$this->data['foot'] = $this->pubconfig->pubmeta($property);
	}

	public function subscribe($type='subscribe')
        {
		$this->output->cache(5);
		$this->data['head'] = $this->data['pubmeta'];
		$this->data['type'] = trim($type);	
		$this->data['message'] = array(
			'header' => 'Welcome.',
			'main'   => 'Your local newspaper is part of a family-owned newspaper group. As an extra benefit to your subscription, we are pleased to offer you full digital access to our other online newspapers. Simply select your local paper below to start your subscription. Your digital access to all of the listed sites will be available immediately.',
			'thank'  => 'Thank you for your subscription',
			'action' => 'To subscribe, click which publication you would like to subscribe to.'
		);
		$this->load->view('ee/head',$this->data);
		$this->load->view('ee/subland');
		$this->load->view('ee/subfooter');
        }

	public function connect($type='connect')
        {
		$this->output->cache(5);
		$this->data['head'] = $this->data['pubmeta'];
		$this->data['type'] = trim($type);	
		$this->data['message'] = array(
			'header' => 'Welcome.',
			'main'   => 'Your local newspaper is part of a family-owned newspaper group.  As an extra benefit to your subscription, we are pleased to offer you full digital access to our other online newspapers.  Simply connect to your subscription below to add an e-mail address and create a password.',
			'thank'  => 'Thank you for your subscription',
			'action' => 'Connect your current print subscription to enable replica access.'
		);
		$this->load->view('ee/head',$this->data);
		$this->load->view('ee/subland');
		$this->load->view('ee/subfooter');
        }

	public function password($type='password')
        {
		$this->output->cache(5);
		$this->data['head'] = $this->data['pubmeta'];
		$this->data['type'] = trim($type);	
		$this->data['message'] = array(
			'header' => 'Forgot Your Password?<br/>No problem.',
			'main'   => 'To receive a new password via e-mail, please select the newspaper that you subscribe to below.   A system generated password will be immediately sent to you.  Use this password to log into the E-edition.',
			'thank'  => '',
			'action' => ''
		);
		$this->load->view('ee/head',$this->data);
		$this->load->view('ee/subland');
		$this->load->view('ee/subfooter');
        }

	public function upgrade($type='upgrade')
        {
		$this->output->cache(5);
		$this->data['head'] = $this->data['pubmeta'];
		$this->data['type'] = trim($type);	
		$this->data['message'] = array(
			'header' => 'Request digital access.',
			'main'   => 'Digital access to your local paper also includes access to all of our online newspapers listed here.',
			'thank'  => '',
			'action' => ''
		);
		$this->load->view('ee/head',$this->data);
		$this->load->view('ee/subland');
		$this->load->view('ee/subfooter');
        }

}
/* End of file main.php */
/* Location: ./application/controllers/main.php */
