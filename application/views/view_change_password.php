	
		<h4>Change your account password</h4>
		<br>
		<?php 
			if($flag == 'change')
			{
				echo form_open('account/change_password');
				echo validation_errors();
				if(isset($captcha))
					echo '<p class="text-error">Invalid captcha!</p>';
				echo form_label('Current password','currentPassword');
				$options = array(
					'name'		=>		'currentPassword',
					'id'		=>		'currentPassword',
					'placeholder'	=>	'Enter your current password'
				);
				echo form_password($options);

				echo form_label('New password','newPassword');
				$options = array(
					'name'		=>		'newPassword',
					'id'		=>		'newPassword',
					'placeholder'	=>	'Enter a new password'
				);
				echo form_password($options);

				echo form_label('Confirm','confirmPassword');
				$options = array(
					'name'		=>		'confirmPassword',
					'id'		=>		'confirmPassword',
					'placeholder'	=>	'Confirm your new password'
				);
				echo form_password($options);

				echo '<br><br>';

				echo form_label("Prove you're not a robot:",'recaptcha_challenge_field');
				echo $recaptcha_html;

				echo '<br><button type="submit" class="btn btn-primary btn-small"><i class="icon-ok icon-white"></i>&nbsp;&nbsp;&nbsp;Save</button>';
				echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="' . base_url() . 'account" class="btn btn-small"><i class="icon-remove"></i>&nbsp;&nbsp;&nbsp;Cancel</a>';
			}
			elseif($flag == 'success')
			{
				echo '<p class="text-success">Password changed</p>';
			}
			else
			{
				echo '<p class="text-error">Unknown error, please try again later.</p>';
			}
		?>
	</div>
</div>