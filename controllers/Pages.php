<?php

/**
 * Pages Controller-
 *		used to control page related tasks extends the core CI_Controller library.		
 *
 * @category Controllers
 * @package  Pages
 * @author   Arefat Hyeredin
 */

	class Pages extends CI_Controller{


	/**
     * Page viewing controller.
	 * 
     * @param 	string					page-name
	 * @throws	PageException			404-Error Page 					
     * @return  array					Page Data.
     */

		public function view($page = 'home'){
		if(!file_exists(APPPATH.'views/pages/'.$page.'.php')){
				show_404();
			}
            
            $data['title'] = ucfirst($page);

			$this->load->view('templates/header');
			$this->load->view('pages/'.$page, $data);
		    $this->load->view('templates/footer');
		}
	}