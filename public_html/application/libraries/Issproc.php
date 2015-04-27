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

class Issproc {

	public function widgetjson($entries,$fname)
	{
		// we want to store each /item to a file with documentID as filename
		$CI =& get_instance();
		$CI->load->helper('file');
		$filedata = json_encode($entries);
		$filename = $fname.'.json';
		$fnp = '/var/www/public_html/statics/'.$filename;
		if (!file_exists($fnp) || ( md5(read_file($fnp)) != md5($filedata) ) )
		{
			write_file($fnp, $filedata, 'wt');
			echo '<p style="color: red;">file written: '.$fnp.'</p>';
		}
	}
	
	public function encoder($entries)
	{
		// we want to store each /item to a file with documentID as filename
		$CI =& get_instance();
		$CI->load->helper('file');
		foreach ($entries as $entry)
		{
			$filedata = json_encode($entry);
			$filename = $entry['documentId'].'.json';
			$fnp = '/var/www/public_html/statics/'.$filename;
			if (!file_exists($fnp) || ( md5(read_file($fnp)) != md5($filedata) ) )
			{
				write_file($fnp, $filedata, 'wt');
				// echo '<p style="color: red;">file written: '.$fnp.'</p>';
			}
		}
	}
	
	public function jsonpfiles($docid,$filedata)
	{
		// we want to store each /item to a file with documentID as filename
		$CI =& get_instance();
		$CI->load->helper('file');
		$filename = $docid.'.jsonp';
		$fnp = '/var/www/public_html/statics/'.$filename;
		if (!file_exists($fnp) || ( md5(read_file($fnp)) != md5($filedata) ) )
		{
			write_file($fnp, $filedata, 'wt');
			// echo '<p style="color: red;">file written: '.$fnp.'</p>';
		}
	}
	
	public function decodeitem($docid,$format='objects')
	{
		$CI =& get_instance();
		$CI->load->helper('file');
		$filename = $docid.'.json';
		$fnp = '/var/www/public_html/statics/'.$filename;
		$data = read_file($fnp);
		if($format == 'objects')
		{
			$output = json_decode($data);

		} elseif($format == 'array')
		{
			$output = json_decode($data, true);
		}
		return $output;		
	} 
	
	public function getjsonitem($docid)
	{
		$CI =& get_instance();
		$CI->load->helper('file');
		$filename = $docid.'.json';
		$fnp = '/var/www/public_html/statics/'.$filename;
		$data = read_file($fnp);
		$output = $data;
		// we want the raw json data passed back to the controller
		return $output;		
	} 
}

