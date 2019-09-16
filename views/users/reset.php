<?php echo form_open('users/reset'); 

/**
 * 	Password Reset View.
 * 
 * 		This option provides a field to recieve an email address for the
 * 		associated account in which a password is to be changed.
 */

?>
	<div class="row">
		<br><br><br><br>
	<div class="col-md-4">
		<br><br><br><br><br>
	</div>
		<div class="col-md-4 col-md-offset-4">
			<br><br><br><br><br><br>
	
			<h1 class="text-center"><?php echo $title; ?></h1>
			<div class="form-group">
				<input type="text" name="email" class="form-control" placeholder="Enter Email Address" required autofocus>
			</div>
			<button type="submit" class="btn btn-primary btn-block">Send Reset Link</button>
		</div>
		<div class="col-md-4">

	</div>
	</div>
			<br><br><br><br><br><br>
			<br><br><br>

<?php echo form_close(); ?>