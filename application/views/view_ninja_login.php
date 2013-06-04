<div class="row-fluid">
<div class="span4">
	<h4>Ninjas welcome</h4>
	<?php 
		echo form_open('ninja/login');
		echo validation_errors();

		$options = array(
			'name'		=>	'email',
			'id'		=>	'email',
			'placeholder'	=>	'Email'
		);
		echo form_input($options);

		echo '<br>';

		$options = array(
			'name'		=>	'password',
			'id'		=>	'password',
			'placeholder'	=>	'Password'
		);
		echo form_password($options);

		echo '<br><button type="submit" class="btn btn-primary"><i class="icon-lock icon-white"></i> Enter</button>';	

		echo form_close();
	?>
</div>
<div class="span8">
	<img src="<?php echo base_url(); ?>includes/img/ninja_banner.jpg" class="img-polaroid">
</div>
</div>
