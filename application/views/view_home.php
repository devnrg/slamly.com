<br>
<div class="row-fluid">
	<div class="span9">
		<h3>Slamly lets you create an online slambook.</h3>
		<h4 class="blue-text">Take your memories with you. For free.</h4>
		<br><br>
		<img src="<?php echo base_url(); ?>includes/img/slamly.png" title="Slamly | Create your free online slambook" class="img-polaroid">
		<br><br>
		<div class="fb-like-box" data-href="https://www.facebook.com/pages/Slamly/399559170159824" data-width="292" data-show-faces="false" data-stream="false" data-show-border="true" data-header="true"></div>
	</div>
	<div class="span3">
		<h4>Login</h4>
		<?php 
			echo form_open('account/login');
			if($this->input->post('formType') == 'login')
				echo validation_errors();

			echo form_hidden('formType','login');

			$options = array(
				'name'			=>	'email',
				'id'			=>	'email',
				'placeholder'	=>	'Email address',
				'class'			=>	'input-block-level',
				'autocomplete'	=>	'off'
			);
			echo form_input($options);

			$options = array(
				'name'			=>	'password',
				'id'			=>	'password',
				'placeholder'	=>	'Password',
				'class'			=>	'input-block-level',
				'autocomplete'	=>	'off'
			);
			echo form_password($options);

			echo '<button type="submit" class="btn btn-success btn-block">Login</button>';
			echo form_close();
		?>
		<br><br>
		<h4>Or sign up <small>(it's easy)</small></h4>
		<?php 
			echo form_open('account/signup');
			if($this->input->post('formType') == 'signup')
				echo validation_errors();

			echo form_hidden('formType','signup');
			echo '<div class="controls controls-row">';
			$options = array(
				'name'			=>	'fname',
				'id'			=>	'fname',
				'placeholder'	=>	'First name',
				'class'			=>	'span6',
				'value'			=>	set_value('fname'),
				'autocomplete'	=>	'off'
			);
			echo form_input($options);

			$options = array(
				'name'			=>	'lname',
				'id'			=>	'lname',
				'placeholder'	=>	'Last name',
				'class'			=>	'span6',
				'value'			=>	set_value('lname'),
				'autocomplete'	=>	'off'
			);
			echo form_input($options);
			echo '</div>';

			$options = array(
				'name'			=>	'email',
				'id'			=>	'email',
				'placeholder'	=>	'Email address',
				'class'			=>	'input-block-level',
				'value'			=>	set_value('email'),
				'autocomplete'	=>	'off'
			);
			echo form_input($options);

			$options = array(
				'name'			=>	'password',
				'id'			=>	'password',
				'placeholder'	=>	'Password',
				'class'			=>	'input-block-level',
				'value'			=>	set_value('password'),
				'autocomplete'	=>	'off'
			);
			echo form_password($options);

			$options = array(
				'name'			=>	'cpassword',
				'id'			=>	'cpassword',
				'placeholder'	=>	'Confirm Password',
				'class'			=>	'input-block-level',
				'value'			=>	set_value('cpassword'),
				'autocomplete'	=>	'off'
			);
			echo form_password($options);

			$options = array(
				'male'		=>	'Male',
				'female'	=>	'Female'
			);
			echo form_dropdown('sex',$options,set_value('sex'),'class="span12"');

			$options = array(
				'name'			=>	'dob',
				'id'			=>	'dob',
				'placeholder'	=>	'Your birthday',
				'class'			=>	'input-block-level',
				'value'			=>	set_value('dob'),
				'autocomplete'	=>	'off'
			);
			echo form_input($options);

			echo '<button type="submit" class="btn btn-info btn-block">Signup</button>';
			echo form_close();
		?>
	</div>
</div>