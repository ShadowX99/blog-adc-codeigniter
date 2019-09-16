<?php

/**
 * Users Controller.
 *		used to control user account related tasks.
 *		extends the core CI_Controller library		
 *
 * @category Controllers
 * @uses	 RestController Library
 * @package  Users
 * @author   Arefat Hyeredin
 */

require APPPATH . 'libraries/REST_Controller.php';
	class Users extends CI_Controller{

	/**
     * User Registration Controller.
	 * 
     * @param 	string 		name 	from the field input. 	
     * @param 	string 		email	from the input field.
     * @param 	string 		username 	from the textarea input. 	
     * @param 	string 		password	encrypted in user controller. 	
     * @param 	string 	 	status 		:default = Inactive till activated via email.
	 * @uses				Form Validation Library
	 * @uses				Email Library
	 * @uses				user-model
	 * @uses				md5 128-bit hash Encryption
     * @return  void		flashdata: user registered.
     */
		// Register user
		public function register(){
			$data['title'] = 'Sign Up';

			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('username', 'Username', 'required|callback_check_username_exists');
			$this->form_validation->set_rules('email', 'Email', 'required|callback_check_email_exists');
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('password2', 'Confirm Password', 'matches[password]');

			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header');
				$this->load->view('users/register', $data);
				$this->load->view('templates/footer');
			} else {
				/** Encrypt Password */
				$enc_password = md5($this->input->post('password'));

				$this->user_model->register($enc_password);
				$this->session->set_flashdata('user_registered', 'You are now registered and can log in, First Activate your account using Email.');
				
				/** Load Email library */
				$email=$this->input->post('email');
				$this->load->library('email');

				//Email Content and Parameter
				$sender_email = 'someonesemail@gmail.com';
				$user_password = '################';
				$token = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 50);
				$subject = 'Account Activation';
				$message = '';
				$message .= "<h2>You are receiving this message in response to account activation.</h2>"
						. "<p>Follow this link to activate your account <a href='".site_url()."activate?token=$token&email=$email' >Activate Account</a> </p>"
						. "<p>If You did not make this request kindly ignore!</p>"
						. "<P class='pj'><h2>Blogin</h2></p>"
						. "<style>"
						. ".pj{"
						. "color:green;"
						. "}"
						. "</style>"
						. "";

				/** Configure email library*/
					$config['protocol'] = 'smtp';
					$config['smtp_host'] = 'smtp.gmail.com';
					$config['smtp_port'] = 465;
					$config['smtp_crypto'] = 'ssl';
					$config['smtp_timeout'] = '7';
					$config['smtp_user'] = $sender_email;
					$config['smtp_pass'] = $user_password;
					$config['charset']    = 'utf-8';
					$config['newline']    = "\r\n";
					$config['mailtype'] = 'html';

				/** Load Email Configuration */				
	 			$this->email->initialize($config);
				/** Sender email address */
				$this->email->from($sender_email);
				/** Receiver email address */
				$this->email->to($email);
				// Subject of email
				$this->email->subject($subject);
				// Message in email
				$this->email->message($message);
				// Send Email
				$this->email->send();

				redirect('posts');
			}
		}


	/**
     * User Login Controller.
	 * 
     * @param 	string 		username 	from the textarea input. 	
     * @param 	string 		password	encrypted in user controller. 	
     * @param 	string 	 	status 		:default = Inactive till activated via email.
	 * @uses				Form Validation Library
	 * @uses				Email Library
	 * @uses				Session Library
	 * @uses				user-model
	 * @uses				md5 128-bit hash Encryption
     * @return  void		flashdata: Login Success or Failure.
	 * @return	void		Posts page || Login Page
     */

		// Log in user
		public function login(){
			$data['title'] = 'Sign In';

			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header');
				$this->load->view('users/login', $data);
				$this->load->view('templates/footer');
			} else {
				
				// Get username
				$username = $this->input->post('username');
				// Get and encrypt the password
				$password = md5($this->input->post('password'));

				// Login user
				$user_id = $this->user_model->login($username, $password);

				if($user_id){
					// Create session
					$user_data = array(
						'user_id' => $user_id,
						'username' => $username,
						'logged_in' => true
					);
					$this->session->set_userdata($user_data);

					// Set message
					$this->session->set_flashdata('user_loggedin', 'You are now logged in');
					redirect('posts');
				} else {
					// Set message
					$this->session->set_flashdata('login_failed', 'Login is invalid');
					redirect('users/login');
				}		
			}
		}

	/**
     * Password Reset Controller.
	 * 
     * @param 	string 		email	 	from the textarea input. 	
	 * @uses				Form Validation Library
	 * @uses				Email Library
	 * @uses				Session Library
	 * @uses				user-model
	 * @uses				md5 128-bit hash Encryption
     * @return  void		flashdata: Valid Email or Invalid Email.
	 * @return	void		Reset page || Login Page
     */	

		public function reset(){
			$data['title'] = 'Password Reset';

			$this->form_validation->set_rules('email', 'Email', 'required');

			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header');
				$this->load->view('users/reset', $data);
				$this->load->view('templates/footer');
			} else {
				$eMail = $this->input->post('email');

				/** Check user email exists */
		        $this->db->where("email = '$eMail'");
        		$this->db->from("users");
        		$countResult = $this->db->count_all_results();

        				if($countResult >=1){
		  
								$this->load->library('email');
								 
								$this->db->where("email = '$eMail'");
            					$getUserData =$this->db->get("users")->result();
            				 foreach($getUserData as $userD){

             						$data['name'] = $userD->name;
										//Email Content and Parameters
										$sender_email = 'someoneemail@gmail.com';
										$user_password = '*************';
										$token = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 50);
										$subject = 'Password Reset Blogin';
										$message = '';
										$message .= "<h2>You are receiving this message in response to your request for password reset</h2>"
												. "<p>Follow this link to reset your password <a href='".site_url()."recover?token=$token&email=$eMail' >Reset Password</a> </p>"
												. "<p>If You did not make this request kindly ignore!</p>"
												. "<P class='pj'><h2>Blogin</h2></p>"
												. "<style>"
												. ".pj{"
												. "color:green;"
												. "}"
												. "</style>"
												. "";

										// Configure email library
										$config['protocol'] = 'smtp';
										$config['smtp_host'] = 'smtp.gmail.com';
										$config['smtp_port'] = 465;
										$config['smtp_crypto'] = 'ssl';
										$config['smtp_timeout'] = '7';
										$config['smtp_user'] = $sender_email;
										$config['smtp_pass'] = $user_password;
										$config['charset']    = 'utf-8';
										$config['newline']    = "\r\n";
										$config['mailtype'] = 'html';   

										// Load Imail COnfiguration 
										$this->email->initialize($config);
 
										//Sender email address
										$this->email->from($sender_email);
										// Receiver email address
										$this->email->to($eMail);
										// Subject of email
										$this->email->subject($subject);
										// Message in email
										$this->email->message($message);
										//Send the email
										$this->email->send();

										if ($this->email->send()) {

											$this->session->set_flashdata('valid_email', 'Email Sent.Check Email');
											redirect('users/login');

										}else { /** Save the token and request time */
												$insert = array('token' => $token);
												$this->db->set('resetreqat', 'NOW()', FALSE);
												$this->db->where("email = '$eMail'");
												$this->db->update('users', $insert);

										$this->session->set_flashdata('valid_email', 'Email Sent.Check your Email');
										  redirect('users/login');	
										}
										 $this->load->view('users/register', $data);
									}
  								}
        				if($countResult <= 0){
							//If non-existing email is entered
							$this->load->view('templates/header');
							$this->load->view('users/reset', $data);
							$this->load->view('templates/footer');

							$this->session->set_flashdata('invalid_email', 'Email Address not Registered, Try Again.');
							redirect('users/reset');
        				}	
					}
				}

	/**
     * User Logout Controller.
	 * 
	 * @uses				Session Library
	 * @uses				user-model
     * @return  void		flashdata: User Logged Out.
     */

		/** Log user out*/
		public function logout(){
			// Unset user data
			$this->session->unset_userdata('logged_in');
			$this->session->unset_userdata('user_id');
			$this->session->unset_userdata('username');

			// Set message
			$this->session->set_flashdata('user_loggedout', 'You are now logged out');
			redirect('users/login');
		}


	/**
     * Password Recover Controller.
	 * 
     * @param 	string 		$email from the url input. 	
	 * @uses				Form Validation Library
	 * @uses				user-model
	 * @uses				md5 128-bit hash Encryption
     * @return  void		flashdata: Password Change.
	 * @return	void		Login Page
     */	
		public function recover(){

			$email = $this->input->get('email');
			$result=$this->user_model->fetch_time($email)->row();
			$time=$result->resetreqat;
			//Fetch reset request time

			$data['title'] = 'Recover Password';
			$data['time'] = $time;
			//Validate New Password Entry
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('password2', 'Confirm Password', 'matches[password]');

			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header');
				$this->load->view('users/recover', $data);
				$this->load->view('templates/footer');
			} else {
				// Encrypt new password
				$enc_password = md5($this->input->post('password'));
				$email = $this->input->post('email');
				//Empty out token
				$token = '';
				//Update database with new password
				$check ="UPDATE users SET password = '$enc_password',token = '$token' WHERE email = '$email'" ;
				$this->db->query($check);
				
				$this->session->set_flashdata('pass_change', 'You have changed your password.Log In with yur new password.');
				redirect('users/login');
			}	
		}

	/**
     * Check if the username is taken or not by reading the database.
     *  @param 	string 	username 
	 *  @uses			user-model
	 *  @return	void	flashdata: Username Exists
     *	@return boolean	username taken or not
     */

		public function check_username_exists($username){
			$this->form_validation->set_message('check_username_exists', 'That username is taken. Please choose a different one');
			if($this->user_model->check_username_exists($username)){
				return true;
			} else {
				return false;
			}
		}

	/**
     * Check if the email is taken or not by reading the database.
     *  @param 	string 	email-address 
	 *  @uses			user-model
	 *  @return	void	flashdata: Email Exists
     *	@return boolean	email taken or not
     */

	//Email Existence Check
		public function check_email_exists($email){
			$this->form_validation->set_message('check_email_exists', 'That email is taken. Please choose a different one');
			if($this->user_model->check_email_exists($email)){
				return true;
			} else {
				return false;
			}
		}

	
	/**
     * User Account Activation.
     *  @param 	string 	email-address 
	 *  @uses			user-model
	 *  @return	void	flashdata: Account Active
     *	@return void	Login Page
     */

	//Account Activaion
		public function activate(){
			//Get Email
			$email = $this->input->get('email');
			$data['title'] = 'Activate Account';
			//Set Account Status Active
			$check ="UPDATE users SET status = 'Active' WHERE email = '$email'" ;
			$this->db->query($check);
			//View Flashdata
			$this->session->set_flashdata('AccountActive', 'You have activated your account, Sign In and Enjoy.');
			redirect('users/login');
		}

	}