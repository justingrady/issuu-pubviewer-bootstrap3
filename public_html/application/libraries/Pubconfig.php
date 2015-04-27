<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Issproc Library
 *
 * A library for Issuu API app file management
 *
 * @author        Justin Grady | www.bendbulletin.com | jgrady@wescompapers.com
 * @copyright    Copyright (c) 2013, Western Communications
 * @version        Version 0.1
 */

class Pubconfig {

	public function apiCreds($mediasource)
        {
                $properties = array(
                        'bendbulletin'          =>      array('apikey' => '#', 'apisecret' => '#'),
                        'bakercityherald'       =>      array('apikey' => '#', 'apisecret' => '#'),
                        'lagrandeobserver'      =>      array('apikey' => '#', 'apisecret' => '#'),
                        'uniondemocrat'      	=>      array('apikey' => '#', 'apisecret' => '#')
                );
                return $properties[$mediasource];
        }

        public function pubMeta($mediasource,$type=NULL)
        {
		$vars = array(
			'connectroot' 	=> 'https://tbbiservices.dticloud.com/cgi-bin/cmo_cmo.sh/custservice/web/registration.html?siteid=',
			'subroot'	=> 'https://tbbiservices.dticloud.com/cgi-bin/cmo_cmo.sh/custservice/web/zipcampaign.html?siteid=',
			'passroot'	=> 'https://tbbiservices.dticloud.com/cgi-bin/cmo_cmo.sh/custservice/web/passwd.html?siteid='
		);

		$properties = array(
                        'bendbulletin'		=>      array(
				'issuser' => 'wescom',
				'sitetitle' => 'Print publications from The Bulletin',
				'headtitle' => 'print publications',
				'siteid' => $mediasource,
				'title'	=> 'The Bulletin', 
				'company' => 'The Bulletin',
				'description' => 'Print publications from The Bulletin',
				'canonical' => base_url(),
				'url' => base_url(),
				'logourl' => base_url().'/images/logo_bendbulletin.png',
				'image'	=> '',
				'suburl' => 'https://tbbiservices.dticloud.com/cgi-bin/cmo_cmo.sh/custservice/web/zipcampaign.html?siteid=BULL',
				'connecturl' => $vars['connectroot'].'BULL',
				'passwordreseturl' => $vars['passroot'].'BULL',
				'googleanalytics' => array(
					'setaccount' => 'UA-1968161-1',
					'domainname' => $mediasource.'.com'
				),
				'folders' => array(
					'fdfdd10d-0e72-410d-8cdc-f25d8827151e' => 'pwzero',
					'303d2682-db52-4810-be7a-55228632db57' => 'default',
					'71394465-bbd6-4e3e-a080-285429061953' => 'FREE'
				),
				'customerservice' => array(
					'phone' => '541-385-5800',
					'email' => 'circulation@bendbulletin.com'
				)	
			),

                        'bakercityherald'	=>      array(
				'issuser' => 'NortheastOregonNews',
				'sitetitle' => 'Print publications from The Baker City Herald',
				'headtitle' => 'print publications',
				'siteid' => $mediasource,
				'title'	=> 'Baker City Herald', 
				'company' => 'Baker City Herald',
				'description' => 'Print publications from Tie Baker City Herald',
				'canonical' => base_url(),
				'url' => base_url(),
				'logourl' => base_url().'/images/logo_bakercityherald.png',
				'image'	=> '',
				'suburl' => 'https://tbbiservices.dticloud.com/cgi-bin/cmo_cmo.sh/custservice/web/addrfind.html?siteid=BCH',
				'connecturl' => $vars['connectroot'].'BCH',
				'passwordreseturl' => $vars['passroot'].'BCH',
				'googleanalytics' => array(
					'setaccount' => 'UA-1815236-2',
					'domainname' => $mediasource.'.com'
				),
				'folders' => array(
					'4ce09d69-26ed-4fc1-8df8-9ad0c7fcf007' => 'pwzero',
					'3a81f307-8166-4957-83c5-7fe83658483e' => 'FREE',
					'57275b41-2e44-4a27-90e5-bdc67bc05dde' => 'FREE'
				),
				'customerservice' => array(
					'phone' => '541-523-3673',
					'email' => 'circ@bakercityherald.com'
				)	
			),

                        'lagrandeobserver'	=>      array(
				'issuser' => 'NortheastOregonNews',
				'sitetitle' => 'Print publications from The La Grande Observer',
				'headtitle' => 'print publications',
				'siteid' => $mediasource,
				'title'	=> 'La Grande Observer', 
				'company' => 'La Grande Observer',
				'description' => 'Print publications from The La Grande Observer',
				'canonical' => base_url(),
				'url' => base_url(),
				'logourl' => base_url().'/images/logo_lagrandeobserver.png',
				'image'	=> '',
				'suburl' => 'https://tbbiservices.dticloud.com/cgi-bin/cmo_cmo.sh/custservice/web/addrfind.html?siteid=OBSERVER',
				'connecturl' => $vars['connectroot'].'OBSERVER',
				'passwordreseturl' => $vars['passroot'].'OBSERVER',
				'googleanalytics' => array(
					'setaccount' => 'UA-1815236-1',
					'domainname' => $mediasource.'.com'
				),
				'folders' => array(
					'48e7515f-fc67-4062-b849-a3099949934a' => 'pwzero',
					'4157c76b-c72f-4833-89ed-dcf705841f83' => 'FREE',
					'57275b41-2e44-4a27-90e5-bdc67bc05dde' => 'FREE'
				),
				'customerservice' => array(
					'phone' => '541-963-3161',
					'email' => 'circ@lagrandeobserver.com'
				)	
			),

                        'uniondemocrat'	=>      array(
				'issuser' => 'uniondemocrat',
				'sitetitle' => 'Print publications from The Union Democrat',
				'headtitle' => 'print publications',
				'siteid' => $mediasource,
				'title'	=> 'Union Democrat', 
				'company' => 'Union Democrat',
				'description' => 'Print publications from The Union Democrat',
				'canonical' => base_url(),
				'url' => base_url(),
				'logourl' => base_url().'/images/logo_uniondemocrat.png',
				'image'	=> '',
				// 'suburl' => 'https://tbbiservices.dticloud.com/cgi-bin/cmo_cmo.sh/custservice/web/zipcampaign.html?siteid=UD',
				// 'suburl' => 'https://tbbiservices.dticloud.com/cgi-bin/cmo_cmo.sh/custservice/web/addrfind.html?siteid=UD',
				'suburl' => 'https://tbbiservices.dticloud.com/cgi-bin/cmo_cmo.sh/custservice/web/zipcampaign.html?siteid=UD',
				'connecturl' => $vars['connectroot'].'UD',
				'passwordreseturl' => $vars['passroot'].'UD',
				'googleanalytics' => array(
					'setaccount' => 'UA-1815236-6',
					'domainname' => $mediasource.'.com'
				),
				'folders' => array(
					'0bdbba43-5dd0-4189-8b24-e07410b40d90' => 'pwzero', // daily
					'a5a44a92-cf2f-4a63-a8e2-fd637eb2c9ce' => 'FREE',   // weekender
					'acb6fe50-b47b-467d-ac46-8adc45b0c1c2' => 'FREE',   // UD special publications
					'e4e9a4ed-ab30-450e-a971-8f72401f6a04' => 'FREE'    // Ads
				),
				'customerservice' => array(
					'phone' => '209-533-3614',
					'email' => 'ud_circ@uniondemocrat.com'
				)	
			),

                        'wescompapers'	=>      array(
				'sitetitle' => 'Print publications from Western Communications',
				'headtitle' => 'print publications',
				'siteid' => $mediasource,
				'title'	=> 'Western Communications', 
				'company' => 'Western Communications',
				'description' => 'Print publications from Western Communications',
				'canonical' => base_url(),
				'url' => base_url(),
				'image'	=> '',
				'googleanalytics' => array(
					'setaccount' => 'UA-1815236-13',
					'domainname' => $mediasource.'.com'
				),
				'folders' => array(
					'48e7515f-fc67-4062-b849-a3099949934a' => 'pwzero',
					'4157c76b-c72f-4833-89ed-dcf705841f83' => 'FREE'
				)	
			)
		);

		if($type == 'all')
		{
			unset($properties[$mediasource]);
			return $properties;
		} 
		else
		{
                	return $properties[$mediasource];
		}
        }

	public function folderMeta($mediasource,$folderId=NULL)
	{
		
		// This is used to get folder/stack meta data
		// then, rekey it to meta data is indexed by folderid
		$CI =& get_instance();
		$CI->load->driver('cache', array('adapter' => 'file'));
		$CI->load->helper('xml');
		$CI->load->helper('url');
		$CI->load->library('Issuu');

		$foldersurl = $CI->issuu->findfolders($mediasource);

		// echo '<pre>';
		// echo $foldersurl;
		// echo '</pre>';

		if ( ! $foldersxml = $CI->cache->get('foldersxml-'.$mediasource))
		{
			log_message('cache-folders', 'foldersxml-'.$mediasource);
			// echo 'Saving to the cache!<br />';
			$foldersxml = file_get_contents($foldersurl);

			// Save into the cache for 24 hours
			$CI->cache->save('foldersxml-'.$mediasource, $foldersxml, 86400);
		}

		$foldersxml = $CI->cache->get('foldersxml-'.$mediasource);

		// echo '<pre> 202 | <br/>';
		// echo $foldersxml;
		// echo '</pre>';
		
		// $foldersxml = file_get_contents($foldersurl);
		$sxml = simplexml_load_string($foldersxml);
		
		$json = json_encode($sxml);
		$array = json_decode($json, TRUE);
		$folders = $array['result']['folder'];

		// we gonne rekey this fucker
		$stacks = array();
		$i = 0;
		foreach($folders as $folder)
		{
			$fid = $folder['@attributes']['folderId'];
			$stacks[$fid] = $folder['@attributes'];
			$urlseg = url_title($stacks[$fid]['name'], '_', TRUE);
			$stacks[$fid]['urlseg'] = $urlseg;
			$i++;
			$fid = NULL;
		}

		// print_r($stacks);

		if($folderId != NULL)
		{
			return $stacks[$folderId];
		} else {
			return $stacks;
		}

	}

}
