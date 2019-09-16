<?php

/**
 * Posts Controller - used to control post related tasks extends the core CI_Controller library.		
 *
 * @category Controllers
 * @package  Posts
 * @author   Arefat Hyeredin
 */

	class Posts extends CI_Controller{

	/**
     * Posts viewing controller.
	 * 
     * @param 	string		slug
	 * @param	int			offset
	 * @uses 				Pagiantion Library	
	 * @uses				post_model				
	 * @uses				category_model
	 * @uses				comment_model
     * @return  array		Posts Data.
     */
		public function index($offset = 0,$slug=NULL){	
			// Pagination Config	
			$config['base_url'] = base_url() . 'posts/index/';
			$config['total_rows'] = $this->db->count_all('posts');
			$config['per_page'] = 3;
			$config['uri_segment'] = 3;
			$config['attributes'] = array('class' => 'pagination-link');

			// Initialize Pagination Feature
			$this->pagination->initialize($config);

			/**	Load Title, Category, Post Content, Comments */
			$data['title'] = 'Latest Posts';
			$data['categories'] = $this->category_model->get_categories();
			$data['post'] = $this->post_model->get_posts($slug);
			$post_id = $data['post']['id'];
			$data['comments'] = $this->comment_model->get_comments($post_id);
			$data['posts'] = $this->post_model->get_posts(FALSE, $config['per_page'], $offset);

			$this->load->view('templates/header');
			$this->load->view('posts/index', $data);
			$this->load->view('templates/footer');
		}

	/**
     * Post creating controller.
	 * 
     * @param 	string		title
	 * @param	string		body
	 * @param	string		category
	 * @param	string		image name
	 * @uses 				File Upload Library	
	 * @uses				post_model				
     * @return  void		flashdata:Post Created.
     */

		public function create(){
			// Check login
			if(!$this->session->userdata('logged_in')){
				redirect('users/login');
			}

			$data['title'] = 'Create Post';

			$data['categories'] = $this->post_model->get_categories();

			$this->form_validation->set_rules('title', 'Title', 'required');
			$this->form_validation->set_rules('body', 'Body', 'required');

			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header');
				$this->load->view('posts/create', $data);
				$this->load->view('templates/footer');
			} else {
				// Upload Image
				$config['upload_path'] = './assets/images/posts';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size'] = '2048';
				$config['max_width'] = '2000';
				$config['max_height'] = '2000';

				$this->load->library('upload', $config);

				if(!$this->upload->do_upload()){
					$errors = array('error' => $this->upload->display_errors());
					$post_image = 'noimage.png';
				} else {
					$data = array('upload_data' => $this->upload->data());
					$post_image = $_FILES['userfile']['name'];
				}
				$this->post_model->create_post($post_image);

				// Set message
				$this->session->set_flashdata('post_created', 'Your post has been created');

				redirect('posts');
			}
		}

	/**
     * Single Post viewing controller.
	 * 
     * @param 	string		slug
	 * @uses				post_model				
	 * @uses				comment_model
	 * @throws	PageException			404-Error Page, if post doesn't exist.
     * @return  array		Post Data.
     */

		public function view($slug = NULL){
			$data['post'] = $this->post_model->get_posts($slug);
			$post_id = $data['post']['id'];
			$data['comments'] = $this->comment_model->get_comments($post_id);

			if(empty($data['post'])){
				show_404();
			}

			$data['title'] = $data['post']['title'];

			$this->load->view('templates/header');
			$this->load->view('posts/view', $data);
			$this->load->view('templates/footer');
		}

	/**
     * Post deleting controller.
	 * 
     * @param 	boolean		user logged in or not
	 * @param	int			post_id
	 * @uses				post_model				
     * @return  void		flashdata:Post Deleted.
     */	
		
		public function delete($id){
			// Check login
			if(!$this->session->userdata('logged_in')){
				redirect('users/login');
			}

			$this->post_model->delete_post($id);

			// Set message
			$this->session->set_flashdata('post_deleted', 'Your post has been deleted');

			redirect('posts');
		}

	/**
     * Post Editing controller.
	 * 
     * @param 	boolean		user logged in or not
	 * @param	boolean		user is post creator or not.
	 * @uses				post_model		
	 * @uses				category_model	
	 * @throws	PageException			404-Error Page if post doesn't exist					
     * @return  array		Post Data.
     */	

		public function edit($slug){
			// Check login
			if(!$this->session->userdata('logged_in')){
				redirect('users/login');
			}

			$data['post'] = $this->post_model->get_posts($slug);

			// Check user
			if($this->session->userdata('user_id') != $this->post_model->get_posts($slug)['user_id']){
				redirect('posts');

			}

			$data['categories'] = $this->post_model->get_categories();
			if(empty($data['post'])){
				show_404();
			}

			$data['title'] = 'Edit Post';
			$this->load->view('templates/header');
			$this->load->view('posts/edit', $data);
			$this->load->view('templates/footer');
		}

	/**
     * Post Updating controller.
	 * 
     * @param 	boolean		user logged in or not
	 * @uses				post_model		
	 * @uses				post-edit-controller	
	 * @throws	PageException			404-Error Page if post doesn't exist					
     * @return  void		flashdata:Post Updated.
     */

		public function update(){
			// Check login
			if(!$this->session->userdata('logged_in')){
				redirect('users/login');
			}

			$this->post_model->update_post();

			// Set message
			$this->session->set_flashdata('post_updated', 'Your post has been updated');

			redirect('posts');
		}

		
	}