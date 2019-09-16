<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Posts API Controller -used to control posts related API tasks extends the core Rest_Controller library.		
 *
 * @category API Controllers
 * @uses	 RestController Library
 * @package  Posts
 * @author   Arefat Hyeredin
 */ 

require APPPATH . 'libraries/REST_Controller.php';

class Posts extends REST_Controller {

/**
 *  Constructor.
 * @category Controllers
 * @uses	 post-model
 * @uses     databse library
 */

 public function __construct() {
       parent::__construct();
       $this->load->model('post_model');
       $this->load->database();

    }

/**
 * Posts GET Method
 * @param   int     post-id
 * @param   mixed   user-id= #
 * @return  array   $data: post row array || result array
 * @return  int     Rest Status Code
 */

	public function index_get($id = 0,$user_id=0)
	{   //Get user-id from url
        $user_id = $this->input->get('user_id');
        //if id given, find the post with that id. 
        if(!empty($id)){
            $data = $this->db->get_where("posts", ['id' => $id])->row_array();
        }
        //if user_id given,find posts with that user id.
        elseif(!empty($user_id)){
            $data = $this->db->get_where("posts", ['user_id' => $user_id])->result();
        }
        //if no parameters given, get all posts
        else{
            $data = $this->db->get("posts")->result();
        }
        $this->response($data, REST_Controller::HTTP_OK);
	}


/**
 * Posts POST Method
 * @param   array   url-encoded form-data: post attribute key,value pairs
 * @return  array   $data: post created
 * @return  int     Rest Status Code
 */ 
    

    public function index_post()
    {  
        //retrieve json input key-value from post call
        $input = $this->input->post();
        //set the incoming data
        $this->db->set($input);
        //insert post data to database
        $this->db->insert('posts',$input);

        $this->response(['Post created successfully.'], REST_Controller::HTTP_OK);

    }

/**
 * Posts PUT Method
 * @param   int     post-id
 * @param   array   json: post attribute key,value pairs
 * @return  array   $data: post updated
 * @return  int     Rest Status Code
 */

    public function index_put($id){
        //update the datbase with incoming data for the indicated post id
        $input = $this->put();
        $this->db->update('posts', $input, array('id'=>$id));
        $this->response(['Post updated successfully.'], REST_Controller::HTTP_OK);

    }

/**
 * Posts DELETE Method
 * @param   int     post-id
 * @return  array   $data: post deleted
 * @return  int     Rest Status Code
 */
  
    public function index_delete($id)     
    {   //Delete associated post with given id
        $this->db->delete('posts', array('id'=>$id));
        $this->response(['Post Deleted successfully.'], REST_Controller::HTTP_OK);
    }

}