<?php echo form_open('users/login'); 

/**
* Login View- This is the login view which opens the form from users controller, invoking the login function.
*
*	It carries out the field values of username and password
*	for authentication, and also provide the password reseting option. 
*/

?>
	<div class="row">
		<br><br><br><br>
	<div class="col-md-4">
		<br><br><br><br>
	</div>
	<div class="col-md-4 col-md-offset-4">
		<br><br><br><br><br>
	
			<h1 class="text-center"><?php echo $title; ?></h1>
			<div class="form-group">
				<input type="text" name="username" class="form-control" placeholder="Enter Username" required autofocus>
			</div>
			<div class="form-group">
				<input type="password" name="password" class="form-control" placeholder="Enter Password" required autofocus>
			</div>
			<button type="submit" class="btn btn-primary btn-block">Login</button>
			<a href="<?php base_url();?>reset">Forgot Password ?</a>
			
	</div>
	<div class="col-md-4">
	</div>
	</div>

		<br><br><br><br><br><br><br>

<?php echo form_close(); ?>