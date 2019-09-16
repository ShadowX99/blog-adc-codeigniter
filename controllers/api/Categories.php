<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Categories API Controller - used to control CATEGORIES related API tasks extends the core Rest_Controller library.		
 *
 * @category API Controllers
 * @uses	 RestController Library
 * @package  Categories
 * @author   Arefat Hyeredin
 */
   
require APPPATH . 'libraries/REST_Controller.php';

class Categories extends REST_Controller {

/**
 *  Constructor.
 * 
 * @category Controllers
 * @uses	 category-model
 * @uses     databse library
 */
    public function __construct() {

       parent::__construct();
       $this->load->model('category_model');
       $this->load->database();

    }

/**
 * Categories GET Method
 * @param   int     category-id
 * @return  array   $data: category row array || result array
 * @return  int     Rest Status Code
 */

	public function index_get($id = 0)
	{
        //If id given, GET that specific category data
        if(!empty($id)){
            $data = $this->db->get_where("categories", ['id' => $id])->row_array();
        }else{
        //If no id given, GET all categories data    
            $data = $this->db->get("categories")->result();
        }
        $this->response($data, REST_Controller::HTTP_OK);
	}

/**
 * Categories POST Method
 * @param   array   url-encoded form-data: category attribute key,value pairs
 * @return  array   $data: category created
 * @return  int     Rest Status Code
 */ 

    public function index_post()
    {   // Get the json posted data
        $input = $this->input->post();
        //Set the recieved data for entry
        $this->db->set($input);
        //Insert into database
        $this->db->insert('categories',$input);

        $this->response(['Category created successfully.'], REST_Controller::HTTP_OK);

    }

/**
 * Categories PUT Method
 * @param   int     category-id
 * @param   array   json: category attribute key,value pairs
 * @return  array   $data: category updated
 * @return  int     Rest Status Code
 */

    public function index_put($id){
        //Update content of indicated category
        $input = $this->put();
        $this->db->update('categories', $input, array('id'=>$id));
        $this->response(['Category updated successfully.'], REST_Controller::HTTP_OK);

    }

/**
 * Categories DELETE Method
 * @param   int     category-id
 * @return  array   $data: category deleted
 * @return  int     Rest Status Code
 */


    public function index_delete($id)
    {   //Delete indicated category from database
        $this->db->delete('categories', array('id'=>$id));
        $this->response(['Category Deleted successfully.'], REST_Controller::HTTP_OK);
    }

}