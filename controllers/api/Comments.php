<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Comments API Controller - used to control comments related API tasks extends the core Rest_Controller library.		
 *
 * @category API Controllers
 * @uses	 RestController Library
 * @package  Comments
 * @author   Arefat Hyeredin
 */   

require APPPATH . 'libraries/REST_Controller.php';

class Comments extends REST_Controller {

/**
 *  Constructor.
 * @category Controllers
 * @uses	 comment-model
 * @uses     databse library
 */

    public function __construct() {

       parent::__construct();
       $this->load->model('comment_model');
       $this->load->database();

    }

/**
 * Comments GET Method
 * @param   int     comment-id
 * @param   mixed   post-id= #
 * @return  array   $data: category row array || result array
 * @return  int     Rest Status Code
 */

	public function index_get($id = 0,$post_id = 0)
	{   //recieve if post_id given
        $post_id = $this->input->get('post_id');
        //if comment_id is given, get that comment
        if(!empty($id)){
            $data = $this->db->get_where("comments", ['id' => $id])->row_array();
        }
        //if post id is given, get comments with that post_id 
        elseif(!empty($post_id)){
            $data = $this->db->get_where("comments", ['post_id' => $post_id])->result();
        }
        //if no parameters given, get all comments
        else{
            $data = $this->db->get("comments")->result();
        }
        $this->response($data, REST_Controller::HTTP_OK);

	}

/**
 * Comments POST Method
 * @param   array   url-encoded form-data: comment attribute key,value pairs
 * @return  array   $data: comment created
 * @return  int     Rest Status Code
 */ 

    public function index_post()
    {   //get posted data
        $input = $this->input->post();
        //set the incoming data
        $this->db->set($input);
        //insert into comments table
        $this->db->insert('comments',$input);

        $this->response(['Comment created successfully.'], REST_Controller::HTTP_OK);
    } 

/**
 * Comments PUT Method
 * @param   int     comment-id
 * @param   array   json: comment attribute key,value pairs
 * @return  array   $data: comment updated
 * @return  int     Rest Status Code
 */

    public function index_put($id){
        //Set the incoming data, update database table
        $input = $this->put();
        $this->db->update('comments', $input, array('id'=>$id));
        $this->response(['Comment updated successfully.'], REST_Controller::HTTP_OK);

    }

/**
 * Comments DELETE Method
 * @param   int     comment-id
 * @return  array   $data: comment deleted
 * @return  int     Rest Status Code
 */
    public function index_delete($id)
    {   //Delete the comment with indicated id.
        $this->db->delete('comments', array('id'=>$id));
        $this->response(['Comment Deleted successfully.'], REST_Controller::HTTP_OK);
    }

}