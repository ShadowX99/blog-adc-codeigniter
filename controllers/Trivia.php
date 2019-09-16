<?php

/**
 * Trivia Controller.
 * 
 *		used to control trivia related tasks extends the core CI_Controller library.		
 *
 * @category Controllers
 * @package  Trivia
 * @author   Arefat Hyeredin
 */

	class Trivia extends CI_Controller{

	/**
     * Trivia viewing controller.
	 * 
     * @param 	string		page-name
	 * @throws	PageException	404-Error Page
     * @return  array		Trivia Data.
     */

        public function index(){

			$data['title'] = 'Trivia';

			$this->load->view('templates/header');
			$this->load->view('trivia/index', $data);
			$this->load->view('templates/footer');
		}
		
		public function view($page = 'index'){
		if(!file_exists(APPPATH.'views/trivia/'.$page.'.php')){
				show_404();
			}
            
            $data['title'] = ucfirst($page);

			$this->load->view('templates/header');
			$this->load->view('pages/'.$page, $data);
		    $this->load->view('templates/footer');
		}
	}