<br>
<div class="row-fluid">
	<h3 class="blue-text">Thank you for signing up. Your account has been created.</h3>
	<h4>Login</h4>
	<?php 
		echo form_open('account/login');
		echo validation_errors();
		$options = array(
			'name'			=>	'email',
			'id'			=>	'email',
			'placeholder'	=>	'Email address'
		);
		echo form_input($options);
		echo '<br>';
		$options = array(
			'name'			=>	'password',
			'id'			=>	'password',
			'placeholder'	=>	'Password'
		);
		echo form_password($options);
		echo '<br>';
		echo '<button type="submit" class="btn btn-success">Login</button>';
		echo form_close();
	?>
</div>