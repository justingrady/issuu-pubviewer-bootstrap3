<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Issproc Library
 *
 * A library for sniffer what domain we are on and if we are on a mobile device or not
 *
 * @author        Justin Grady | www.bendbulletin.com | jgrady@wescompapers.com
 * @copyright    Copyright (c) 2014, Western Communications
 * @version        Version 0.1
 * Thu Mar 27 12:14:46 PDT 2014
 */

class Sniffer {

	public function sniffProperty()
	{
                // this function takes the browser base URL, then return the root property, such as uniondemocrat, or bakercityherald.
                // Results are then used to reference keys in _properties k/v array for output
                $CI =& get_instance();
		$CI->load->helper('url');
                $vars   =       explode('.',base_url());
                return $vars[1];
        }

	public function ismobile()
        {
		$CI =& get_instance();
		$CI->load->library('user_agent');

                if ($CI->agent->is_mobile())
                {
                        // $agent = $this->agent->mobile();
			$agent = 'mobile';
                }
                
                elseif ($CI->agent->is_browser())
                {
                        // $agent = $this->agent->browser().' '.$this->agent->version();
			$agent = 'desktop';
                }
                
                else
                {
			$agent = 'unknown';
                }

		return $agent;
        }
}
