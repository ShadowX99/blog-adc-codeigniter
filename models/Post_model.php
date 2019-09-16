<?php

/**
 * Post Model
 *		used to support with tasks related to the posts table.
 * 		tbl-name: posts
 *		extends the core CI_Model library		
 *
 * @category Models
 * @package  Posts
 * @author   Arefat Hyeredin
 */

	class Post_model extends CI_Model{

	/**
     * Constructor loads the database associated with the project.
     */
		public function __construct(){
			$this->load->database();
		}

	/**
     * Get the posts data from the database.
     * 		:ordered in descending post_id
     *		:joined with categories table; category-id 
     *  @param 	string 	slug 	posts's 
     *  @param 	int 	limit 	min limit
     *  @param 	int 	offset 	max limit
     *	@return the result array of posts || the row array of a particular post
     */

		public function get_posts($slug = FALSE, $limit = FALSE, $offset = FALSE){
			if($limit){
				$this->db->limit($limit, $offset);
			}
			if($slug === FALSE){
				$this->db->order_by('posts.id', 'DESC');
				$this->db->join('categories', 'categories.id = posts.category_id');
				$query = $this->db->get('posts');
				return $query->result_array();
			}

			$query = $this->db->get_where('posts', array('slug' => $slug));
			return $query->row_array();
		}


	/**
     * Insert a new post into the database.
     * @param 	string 		title 	from the field input. 	
     * @param 	string 		slug	same as title.
     * @param 	string 		body 	from the textarea input. 	
     * @param 	int 		category selected category.
     * @param 	string 		post_image	from the field input. 	
     * @param 	id 	 		user_id	from the logged in session.
     * @return  boolean		data inserted or not.
     */
		
		public function create_post($post_image){
			$slug = url_title($this->input->post('title'));

			$data = array(
				'title' => $this->input->post('title'),
				'slug' => $slug,
				'body' => $this->input->post('body'),
				'category_id' => $this->input->post('category_id'),
				'user_id' => $this->session->userdata('user_id'),
				'post_image' => $post_image
			);

			return $this->db->insert('posts', $data);
		}


						        public function create2_post($title, $body, $slug, $post_image){
									
						if(!empty($title) && !empty($body) && !empty($slug) && !empty($post_image) ){
									$check = "INSERT INTO posts (title,body,slug,post_image) VALUES ('$title', '$body', '$slug', '$post_image')";
						    		$query = $this->db->query($check);
						   			 if($this->db->affected_rows() > 0) {
						        		return "pass";
						    		} else {
						       			 return "fail";
									}
								} 
								}

	/**
     * Delete post
     * @param 	int 		post-id.
     *		:also unlink associated image with psot.
     * @return  boolean		deleted or not.
     */

		public function delete_post($id){
			$image_file_name = $this->db->select('post_image')->get_where('posts', array('id' => $id))->row()->post_image;
			$cwd = getcwd(); // save the current working directory
			$image_file_path = $cwd."\\assets\\images\\posts\\";
            chdir($image_file_path);
			unlink($image_file_name);
			chdir($cwd); // Restore the previous working directory
			$this->db->where('id', $id);
			$this->db->delete('posts');
			return true;
		}


	/**
     * Update an existing post.
     * @param 	string 		title 	from the field input. 	
     * @param 	string 		slug	same as title.
     * @param 	string 		body 	from the textarea input. 	
     * @param 	int 		category selected category.
     * @return  boolean		data updated or not.
     */

			public function update_post(){
				$slug = url_title($this->input->post('title'));

				$data = array(
					'title' => $this->input->post('title'),
					'slug' => $slug,
					'body' => $this->input->post('body'),
					'category_id' => $this->input->post('category_id')
				);

				$this->db->where('id', $this->input->post('id'));
				return $this->db->update('posts', $data);
			}

	/**
     * Get the categories name from the database.
     * in alphabetical order.
     * 
     *	@return the result array of the categories names
     */

			public function get_categories(){
				$this->db->order_by('name');
				$query = $this->db->get('categories');
				return $query->result_array();
			}

	/**
     * Get posts with associated categories from the database.
     * 	@param 	int 	category-id
     *	@return array	result array of the posts data
     */

			public function get_posts_by_category($category_id){
				$this->db->order_by('posts.id', 'DESC');
				$this->db->join('categories', 'categories.id = posts.category_id');
					$query = $this->db->get_where('posts', array('category_id' => $category_id));
				return $query->result_array();
			}

	}