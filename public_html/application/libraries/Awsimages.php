<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Awsimages {

	/* Image processling library
	 * Images are pulled, stored, and then resized
	 * stored locally on server
	 */


	public function imagePull($source,$docname,$docid,$prefix=NULL)
	{
                $CI =& get_instance();
		$CI->load->helper('file');
                $CI->load->helper('url');
                $CI->load->library('Awsimages');
			
		$prefix  = ($prefix != NULL ? $prefix.'-' : NULL);
		$filestring = $docname.'-'.$docid.'.jpg';

                if($source == NULL)
                {
                        return NULL;
                }
                else
                {
                        $path           =       '/var/www/public_html/images/';
                        $filename       =       $path.$filestring;
                        $imageURI       =       base_url().'images/'.$filestring;

                        if (!file_exists($filename))
                        {
                                $source = trim($source);
                                write_file($filename, file_get_contents($source), 'c'); 
                        }
			$output = array( 
                                'uri'           =>      $imageURI,
				'orig'		=>	$imageURI,
				'thumb'         =>      $CI->awsimages->thumbnailGen($filename), // returns array of small,medium keys
				'timestamp'     =>      filemtime($filename) // want 'last updated' time of file 
                        );
			return $output;
                } 
        } 

	public function thumbnailGen($imageSrc)
        {
                $CI =& get_instance();
		$CI->load->helper('url');
		// Two things:
                // 1. Hands out filename of thumbnail images, just string processing/
                // 2. Created thumbnail image, if one does not already exist (within else)
                // Wed May 23 16:25:23 PDT 2012 JTG
                $imageSrc = (string) $imageSrc; // was getting 'is array' errors even thoug var dump said it as a sting, so strongly typed it
		$images = array(
			'small'	 => array(
					'pathname' => str_replace('.jpg','_small.jpg',$imageSrc),
					'width' => 150,
					'height' => 169
					),
			'medium' => array(
					'pathname' => str_replace('.jpg','_medium.jpg',$imageSrc),
					'width' => 300,
					'height' => 338
					)

		);
		// sample: /var/www/public_html/images/120523070707-4ccc2e729345440f97540c755d85a3ca_small.jpg              
		$config['image_library'] = 'gd2';
		$config['source_image'] = $imageSrc;
		// $config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		// first pass
		foreach($images as $key => $val)
		{
			// print_r(($val['pathname']));
			if (!file_exists($val['pathname'])) 
			{	
				$config['new_image'] = $val['pathname'];
				$config['width']     = $val['width'];
				$config['height']    = $val['height'];

				$CI->load->library('image_lib');

				$CI->image_lib->clear();
				$CI->image_lib->initialize($config);
				if ( ! $CI->image_lib->resize())
				{
					$CI->upload_error = $CI->image_lib->display_errors();
					$CI->image_lib->clear();
					return false;
				}
			}
			$images[$key]['imgurl'] = str_replace('/var/www/public_html/',base_url(),$val['pathname']);
		}
		return $images;
        }
}
/* End of file Awsimages.php */
