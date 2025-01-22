<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Galeria extends CI_Controller {

	public function show($gallery_id, $auth_code)
	{
		
		$this->load->database();
		$query = $this->db->query("SELECT * FROM galeria WHERE id = {$gallery_id} AND auth_code = '{$auth_code}'");
		if($query->num_rows() == 0){
			echo "<p style='padding:50px; text-align:center'>Galer&iacute;a no encontrada</p>";
			exit;
		}
		
		$data = array(
        'dir' => array(
            'original' => './uploads/gallery/'.$gallery_id.'/orginal/',
            'thumb' => './uploads/gallery/'.$gallery_id.'/thumbs/'
        ),
        'images' => array()
    	);
		
		
		if (is_dir($data['dir']['thumb']))
        {
            $i = 0;
			
            if ($dh = opendir($data['dir']['thumb'])) {
            
			while (($file = readdir($dh)) !== false) {
            	if($file != '.' && $file != '..')
					{
						// get file extension
                    
						$ar_file = explode(".",$file);
						$ext = end($ar_file);
					//$ext = strrev(strstr(strrev($file), ".", TRUE));
                    if ($ext == 'jpg' || $ext == 'JPG' || $ext == 'jpeg') {
                            $data['images'][$i]['thumb'] = $file;
                            $data['images'][$i]['original'] = str_replace('thumb_', '', $file);
                            $i++;
                       
					}
                    } 
                }
                closedir($dh);
            }
        }
		$this->load->view('cliente/full_gallery', $data);
	}
	
}

