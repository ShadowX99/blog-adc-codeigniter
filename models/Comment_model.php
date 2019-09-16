<?php

/**
 * Comment Model
 *		used to support with tasks related to the comments table.
 * 		tbl-name: comments
 *		extends the core CI_Model library		
 *
 * @category Models
 * @package  Categories
 * @author   Arefat Hyeredin
 */

	class Comment_model extends CI_Model{

	/**
     * Constructor loads the database associated with the project.
     */
		public function __construct(){
			$this->load->database();
		}

	/**
     * Insert a new comment into the database.
     * @param 	string 		name 		from the field input.
     * @param 	string 		email 		from the field input.
     * @param 	string 		body 		from the field input. 	
     * @param 	int 		post_id		of the associated post.
     * @return  boolean		data inserted or not.
     */

		public function create_comment($post_id){
			$data = array(
				'post_id' => $post_id,
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'body' => $this->input->post('body')
			);

			return $this->db->insert('comments', $data);
		}

	/**
     * Get the comments from the database.
     * 	@param 	int 	post-id associated to the comment.
     *	@return the result array of the comment content.
     */

		public function get_comments($post_id){
			$query = $this->db->get_where('comments', array('post_id' => $post_id));
			return $query->result_array();
		}

	/**
     * Delete comment
     * @param 	int 		comment-id.
     * @return  boolean		deleted or not.
     */

		public function delete_comment($id){
			$this->db->where('id', $id);
			$this->db->delete('comments');
			return true;
		}
	}