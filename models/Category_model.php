<?php

/**
 * Categories Model
 *		used to support with tasks related to the categories table.
 * 		tbl-name: categories
 *		extends the core CI_Model library		
 *
 * @category Models
 * @package  Categories
 * @author   Arefat Hyeredin
 */

	class Category_model extends CI_Model{

	/**
     * Constructor loads the database associated with the project.
     */

		public function __construct(){
			$this->load->database();
		}

	/**
     * Get the categories name from the database
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
     * Insert a new category into the database
     * @param 	string 		name 	from the field input. 	
     * @param 	int 		user_id	from the logged in session.
     * @return  boolean		data inserted or not.
     */

		public function create_category(){
			$data = array(
				'name' => $this->input->post('name'),
				'user_id' => $this->session->userdata('user_id')
			);

			return $this->db->insert('categories', $data);
		}


	/**
     * Get category by id
     * @param 	int 		category-id.
     * @return  row	data	of the obtained category.
     */

		public function get_category($id){
			$query = $this->db->get_where('categories', array('id' => $id));
			return $query->row();
		}


	/**
     * Delete category
     * @param 	int 		category-id.
     * @return  boolean		deleted or not.
     */

		public function delete_category($id){
			$this->db->where('id', $id);
			$this->db->delete('categories');
			return true;
		}
	}