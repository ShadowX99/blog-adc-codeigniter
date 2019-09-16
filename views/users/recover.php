<?php 	
		
/**
 * 	Recover Password -This option would allow users to set a new password.
 * 
 * 		which they could invoke by selecting the forgot password
 * 		option, and being redirected from the email sent to reset their
 * 		passord.
 */
		$token = $this->input->get('token');
		$email = $this->input->get('email');

/**	Get the email and token from the link recieved via email */

		$this->db->select('email');
		$this->db->where('email',$email);
		$this->db->where('token',$token);
		$query = $this->db->get('users');

/**	Check that the token and email exist in the database */

		$past_time = strtotime($time);
		$current_time = time();
		$difference = $past_time - $current_time;
		$difference_minute =  $difference/60;

/**	Calculate if the link has expired or not. If expired deny password recovery using 
 * 	the following if-else condition.
 */

	echo validation_errors(); 

if($query->row_array() > 0 && $difference<86400){ 
/**	Check the link hasn't exceeded 24 hour time period. */	
	
?> 

<?php echo form_open('users/recover'); ?>
	<div class="row"><br>
			<?php echo validation_errors(); ?>
			<br><br><br>
			<div class="col-md-4">
			<br><br><br><br>
	<?php $email = $this->input->get('email'); ?>
	</div>
		<div class="col-md-4 col-md-offset-4">
			<br><br><br><br><br>

			<h1 class="text-center"><?php echo $title; ?></h1>
			<div class="form-group">
				<input type="hidden" name="email" value="<?php echo $email; ?>">
				<input type="password" name="password" class="form-control" placeholder="Enter Password" required autofocus>
			</div>
            <div class="form-group">
				<input type="password" name="password2" class="form-control" placeholder="Confirm Password" required autofocus>
			</div>
				<button type="submit" class="btn btn-primary btn-block">Reset Password</button>
		</div>
	<div class="col-md-4">
	</div>
	</div>
		<br><br><br><br><br><br>

<?php echo form_close(); 
/**	Recieve the new passwords and send to the users controller: recover for further processing */
?>

<?php } ?>