<?php

/**
 * User Model
 *		used to support with tasks related to the users table.
 * 		tbl-name: users
 *		extends the core CI_Model library		
 *
 * @category Models
 * @package  Users
 * @author   Arefat Hyeredin
 */

	class User_model extends CI_Model{

	/**
     * Check if the username is taken or not by reading the database.
     *  @param 	string 	username 
     *	@return boolean	
     */

		// Check username exists
		public function check_username_exists($username){
			$query = $this->db->get_where('users', array('username' => $username));
			if(empty($query->row_array())){
				return true;
			} else {
				return false;
			}
		}

	/**
     * Check if the email address is taken or not by reading the database.
     *  @param 	string 	email address
     *	@return boolean	
     */

		// Check email exists
		public function check_email_exists($email){
			$query = $this->db->get_where('users', array('email' => $email));
			if(empty($query->row_array())){
				return true;
			} else {
				return false;
			}
		}

	/**
	 *	Fetch the time a password reset is requestes at:
	 *		:used to impleement the 24 hour window expiry checking.
	 *	@param 	string	$email 	the email associated with request.
	 */

		function fetch_time($email){
			$this->db->select('resetreqat');
			//$this->db->from('users');
			$this->db->where('email',$email);
			return $this->db->get('users');
		}

	/**
     * Insert a new user into the database.
     * @param 	string 		name 	from the field input. 	
     * @param 	string 		email	from the input field.
     * @param 	string 		username 	from the textarea input. 	
     * @param 	string 		password	encrypted in user controller. 	
     * @param 	string 	 	status 		:default = Inactive till activated via email.
     * @return  boolean		data inserted or not.
     */

		public function register($enc_password){
			// User data array
			$data = array(
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
                'username' => $this->input->post('username'),
				'password' => $enc_password,
				'status' => 'Inactive'
			);

			// Insert user
			return $this->db->insert('users', $data);
		}

	/**
     * Register new user using API.
     * @param 	string 		name 	from the field input. 	
     * @param 	string 		email	from the input field.
     * @param 	string 		username 	from the textarea input. 	
     * @param 	string 		password	encrypted in user controller. 	
     * @param 	string 	 	status 		:default = Inactive till activated via email.
     * @return  boolean		API message: pass || fail.
     */


			public function api_register($name, $username, $email, $password){
				// User data array
				if( $this->check_username_exists($username) && $this->check_email_exists($email)){
					$enc_password = md5($password);
				//if all parameters are set
					if(!empty($name) && !empty($username) && !empty($email) && !empty($password) ){
				//insert into database
						$check = "INSERT INTO users (name,username,email,password) VALUES ('$name', '$username', '$email', '$enc_password')";
						$query = $this->db->query($check);
						if($this->db->affected_rows() > 0) {
							return "pass";
						} else {
							return "fail";
						}
					}
				}
			}	
					
	/**
     * Check User account information for login or authentication.
     * @param 	string 		username 	from the textarea input. 	
     * @param 	string 		password	encrypted in user controller. 	
     * @param 	string 	 	status 		check if account is active or not.
     * @return  boolean		if user account found: send user-id
     */

		// Log user in
		public function login($username, $password){
			// Validate Info
			$this->db->where('username', $username);
			$this->db->where('password', $password);
			$this->db->where('status','Active');

			$result = $this->db->get('users');

			if($result->num_rows() == 1){
				return $result->row(0)->id;
			} else {
				return false;
			}
		}

		
	}