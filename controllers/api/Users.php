<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Users API Controller -used to control user related API tasks extends the core Rest_Controller library.		
 *
 * @category API Controllers
 * @uses	 RestController Library
 * @package  Users
 * @author   Arefat Hyeredin
 */ 

require APPPATH . 'libraries/REST_Controller.php';

class Users extends REST_Controller {

/**
 *  Constructor.
 * @category Controllers
 * @uses	 user-model
 * @uses     databse library
 */

    public function __construct() {

       parent::__construct();
       $this->load->model('user_model');
       $this->load->database();

    }

/**
 * Users GET Method
 * @param   int     user-id
 * @return  array   $data: users row array || result array
 * @return  int     Rest Status Code
 */

	public function index_get($id = 0)
	{   //if id given, get the user info with that id
        if(!empty($id)){
            $data = $this->db->get_where("users", ['id' => $id])->row_array();
        }else{
        //if n id is given, get all users information
            $data = $this->db->get("users")->result();
        }
        $this->response($data, REST_Controller::HTTP_OK);
	}

/**
 * Users POST Method
 * @param   array   url-encoded form-data: users attribute key,value pairs
 * @uses            user-model
 * @return  array   $data: user account created
 * @return  int     Rest Status Code
 */ 

    public function index_post()
    {       //GET - name, username, email, password, role from the posted call data
            $name = $this->post('name');
			$username = $this->post('username');
			$email = $this->post('email');
			$password = $this->post('password');
            $role= $this->post('role');

            //If the role is set and superuser
            if(!empty($role) && $role=="superuser"){
                    //send data to user-model and invoke api_register function
			        $this->load->model('user_model');
                    $msg = $this->user_model->api_register($name, $username, $email, $password);
                if ($msg)
                    {
                        $this->response([
                                'status' => TRUE,
                                'message'=> 'PASS, User Created Successfully'], REST_Controller::HTTP_OK);
                    }
                }
                // Default to fail
                else{
                    $this->response([
                            'status' => FALSE,
                            'message' => 'FAIL'], REST_Controller::HTTP_BAD_REQUEST);

                }
    }
    
/**
 * Users PUT Method
 * @param   int     user-id
 * @param   array   json: post attribute key,value pairs
 * @return  array   $data: users updated
 * @return  int     Rest Status Code
 */

    public function index_put($id){

        $input = $this->put();
        $this->db->update('users', $input, array('id'=>$id));
        $this->response(['User updated successfully.'], REST_Controller::HTTP_OK);

    }

/**
 * Users DELETE Method
 * @param   int     post-id
 * @return  array   $data: user deleted
 * @return  int     Rest Status Code
 */

    public function index_delete($id)
    {   //Delete user with given id
        $this->db->delete('users', array('id'=>$id));
        $this->response(['User Deleted successfully.'], REST_Controller::HTTP_OK);
    }

}