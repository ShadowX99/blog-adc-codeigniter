<?php

/**
 * Categories Controller - used to control categories related tasks extends the core CI_Controller library.		
 *
 * @category Controllers
 * @package  Categories
 * @author   Arefat Hyeredin
 */

	class Categories extends CI_Controller{

	/**
     * Categories creating controller.
	 * 
     * @param 	boolean		is user logged in. 			
     * @uses				category_model		
     * @return  void		flashdata: Category Created.
     */
		
		public function create(){
			// Check login
			if(!$this->session->userdata('logged_in')){
				redirect('users/login');
			}
				
			$this->category_model->create_category();

			// Set message
			$this->session->set_flashdata('category_created', 'Your category has been created');

				redirect('posts');
			}
	
	/**
     * Posts related to certain category.
	 * 
     * @param 	int			category-id. 			
     * @uses				category_model
	 * @uses				post_model		
     * @return  array		Posts data belonging to certain category.
     */

		public function posts($id){

			$data['title'] = $this->category_model->get_category($id)->name;

			$data['categories'] = $this->category_model->get_categories();

			$data['posts'] = $this->post_model->get_posts_by_category($id);

			$this->load->view('templates/header');
			$this->load->view('posts/index', $data);
			$this->load->view('templates/footer');
		}

	/**
     * Category deleting controller.
	 * 
	 * @param 	boolean		is user logged in.
     * @param 	int 		category-id.
     * @return  void 		flashdata: Category Deleted.
     */

		public function delete($id){
			// Check login
			if(!$this->session->userdata('logged_in')){
				redirect('users/login');
			}

			$this->category_model->delete_category($id);

			// Set message
			$this->session->set_flashdata('category_deleted', 'Your category has been deleted');

			redirect('posts');
		}
	}