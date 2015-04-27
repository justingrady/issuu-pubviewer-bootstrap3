<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Issdata Library
 *
 * A library for Issuu API app file management
 *
 * @author        Justin Grady | www.bendbulletin.com | jgrady@wescompapers.com
 * @copyright    Copyright (c) 2014, Western Communications
 * @version        Version 0.1
 */

class Issdata {

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
			if($folderid == 'fdfdd10d-0e72-410d-8cdc-f25d8827151e' || $folderid == '48e7515f-fc67-4062-b849-a3099949934a' || $folderid == '0bdbba43-5dd0-4189-8b24-e07410b40d90')
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
                                        // sort of a hack job.  If there are entries with the same created time stamp, eaxh subsequent entry has 10 seconds deleted from it, so it has a unique key for soriting
                                        // Wed May 29 16:45:09 PDT 2013 JTG
                                        $unixDate       =       $iDupeKey - (30); // subtrack 30 seconds from unix/epoch time
                                }
                                else
                                {
                                        $unixDate       =       strtotime($attrs['created']);
                                }
                                $items[$unixDate]       =       $entry; // use unix timestamp of human readable date from title as array key.
                                $iDupeKey               =       $unixDate;
			}
			$items[$unixDate][]['folderid'] = $folderid;
                }
                krsort($items); // sort array by key (human readable timestamp), in descending/most recent first order                                                     
                return $items;
        }

	public function displayTitleFormatter($string)
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


}
