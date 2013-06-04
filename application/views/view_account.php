	
		<h4>Settings</h4>
		<ul class="nav nav-tabs">
  			<li class="active"><a href="#account-information" data-toggle="tab"><h5>Account information</h5></a></li>
  			<li><a href="#personal-information" data-toggle="tab"><h5>Personal information</h5></a></li>
  			<li><a href="#profile" data-toggle="tab"><h5>Profile</h5></a></li>
		</ul>
		<div class="tab-content">
  			<div class="tab-pane active" id="account-information">
  				<table class="table table-condensed">
					<tr>
						<td class="blue-text">Email:</td>
						<td><?php echo $email; ?> <span class="muted">(you cannot change your email address)</span></td>
					</tr>
					<tr>
						<td class="blue-text">Password</td>
						<td><a href="<?php echo base_url(); ?>account/password">Change password</a></td>
					</tr>
					<tr>
						<td class="blue-text">Signed up on:</td>
						<td>
							<?php
								$signup = new DateTime($user->timestamp);
								echo $signup->format('d F Y');
							?>
						</td>
					</tr>
					<tr>
						<td class="blue-text">Logged in at:</td>
						<td>
							<?php
								$signup = new DateTime($user->last_login);
								echo $signup->format('d F Y, g:i a');
							?>
						</td>
					</tr>
				</table>
  			</div>
  			<div class="tab-pane" id="personal-information">
  				<div id="edit-result" style="display: none;"></div>
				<div id="edit-form">
				<?php 
					echo form_open('/');
					echo validation_errors();

					echo form_label('First name:','fname');
					$options = array(
						'name'		=>		'fname',
						'id'		=>		'fname',
						'value'		=>		$user->fname,
						'placeholder'	=>	'First name'
					);
					echo form_input($options);
					echo form_label('Last name:','lname');
					$options = array(
						'name'		=>		'lname',
						'id'		=>		'lname',
						'value'		=>		$user->lname,
						'placeholder'	=>	'Last name'
					);
					echo form_input($options);
					echo form_label('Sex:','sex');
					$options = array(
						'male'		=>	'Male',
						'female'	=>	'Female'
					);
					echo form_dropdown('sex',$options,$user->sex,'id="sex"');

					$dob = new DateTime($user->dob);
					echo form_label('Date of birth:','dob');
					$options = array(
						'name'		=>		'dob',
						'id'		=>		'dob',
						'value'		=>		$dob->format('d-m-Y'),
						'placeholder'	=>	'Date of birth'
					);
					echo form_input($options);

					echo '<br><button type="button" onclick="editPersonalInfo()" class="btn btn-primary btn-small"><i class="icon-ok icon-white"></i>&nbsp;&nbsp;&nbsp;Save</button>';

					echo form_close();
				?>
				</div>
  			</div>
  			<div class="tab-pane" id="profile">
				<div class="row-fluid">
					<div class="span6">
						<h5>Profile picture</h5>
						<?php 
							if($profile->profile_picture_256 == 'includes/img/profile_placeholders/male_placeholder_256.jpg' || $profile->profile_picture_256 == 'includes/img/profile_placeholders/female_placeholder_256.jpg')
								echo '<a href="#" title="Click to change"><img src="' . base_url() . $profile->profile_picture_256 . '" class="img-rounded"></a>';
						?>
						<br><br>
						<h5>Work information</h5>
						<div id="work-result" class="display:none"></div>
						<?php 
							echo form_open('/');

							echo form_label('Designation:','designation');
							$options = array(
								'name'			=>	'designation',
								'id'			=>	'designation',
								'placeholder'	=>	'Designation',
								'value'			=>	$profile->designation
							);
							echo form_input($options);

							echo form_label('Organization:','organization');
							$options = array(
								'name'			=>	'organization',
								'id'			=>	'organization',
								'placeholder'	=>	'Organization',
								'value'			=>	$profile->organization
							);
							echo form_input($options);

							echo '<br><button type="button" onclick="editWorkInfo()" class="btn btn-primary btn-small"><i class="icon-ok icon-white"></i>&nbsp;&nbsp;&nbsp;Save</button>';

							echo form_close();
						?>
						<script type="text/javascript">
							function editWorkInfo()
							{
								var designation = $('#designation').val();
								var organization = $('#organization').val();

								$.post("<?php echo base_url(); ?>account/work", { "designation": designation, "organization": organization },function(response){
									if(response.result == "success")
									{
										$('#work-result').fadeOut('slow',function(){});
										$('#work-result').html('<p class="text-success">Changes saved!</p>');
										$('#work-result').fadeIn('slow',function(){});
									}
									else
									{
										if(response.result == "dbError")
										{
											$('#work-result').fadeOut('slow',function(){});
											$('#work-result').html('<p class="text-error">Unknown error, please try later.</p>');
											$('#work-result').fadeIn('slow',function(){});
										}
										else
										{
											$('#work-result').fadeOut('slow',function(){});
											$('#work-result').html('<p class="text-error">Invalid data!</p>');
											$('#work-result').fadeIn('slow',function(){});
										}
									}
								}, "json");
							}
						</script>
					</div>
					<div class="span6">
						<h5>Location</h5>
						<div id="location-result" class="display:none"></div>
						<?php 
							echo form_open('/');

							echo form_label('Phone:','phone');
							$options = array(
								'name'			=>	'phone',
								'id'			=>	'phone',
								'placeholder'	=>	'Phone',
								'value'			=>	$profile->phone
							);
							echo form_input($options);

							echo form_label('Address line 1:','address_1');
							$options = array(
								'name'			=>	'address_1',
								'id'			=>	'address_1',
								'placeholder'	=>	'Address line 1',
								'value'			=>	$profile->address_line_1
							);
							echo form_input($options);

							echo form_label('Address line 2:','address_2');
							$options = array(
								'name'			=>	'address_2',
								'id'			=>	'address_2',
								'placeholder'	=>	'Address line 2',
								'value'			=>	$profile->address_line_2
							);
							echo form_input($options);

							echo form_label('City:','city');
							$options = array(
								'name'			=>	'city',
								'id'			=>	'city',
								'placeholder'	=>	'City',
								'value'			=>	$profile->city
							);
							echo form_input($options);

							echo form_label('State:','state');
							$options = array(
								'name'			=>	'state',
								'id'			=>	'state',
								'placeholder'	=>	'State',
								'value'			=>	$profile->state
							);
							echo form_input($options);

							echo form_label('Zip:','zip');
							$options = array(
								'name'			=>	'zip',
								'id'			=>	'zip',
								'placeholder'	=>	'Zip code',
								'value'			=>	$profile->zip
							);
							echo form_input($options);

							echo form_label('Country:','country');
							$options = array();
							foreach($countries->result() as $country)
							{
								$options[$country->country] = $country->country;
							}
							echo form_dropdown('country',$options,$profile->country,'id="country"');

							echo '<br><button type="button" onclick="editLocationInfo()" class="btn btn-primary btn-small"><i class="icon-ok icon-white"></i>&nbsp;&nbsp;&nbsp;Save</button>';

							echo form_close();
						?>
						<script type="text/javascript">
							function editLocationInfo()
							{
								var phone = $('#phone').val();
								var address_1 = $('#address_1').val();
								var address_2 = $('#address_2').val();
								var city = $('#city').val();
								var state = $('#state').val();
								var zip = $('#zip').val();
								var country = $('#country').val();

								$.post("<?php echo base_url(); ?>account/location", { "phone": phone, "address_1": address_1, "address_2": address_2, "city": city, "state": state, "zip": zip, "country": country },function(response){
									if(response.result == "success")
									{
										$('#location-result').fadeOut('slow',function(){});
										$('#location-result').html('<p class="text-success">Changes saved!</p>');
										$('#location-result').fadeIn('slow',function(){});
									}
									else
									{
										if(response.result == "dbError")
										{
											$('#location-result').fadeOut('slow',function(){});
											$('#location-result').html('<p class="text-error">Unknown error, please try later.</p>');
											$('#location-result').fadeIn('slow',function(){});
										}
										else
										{
											$('#location-result').fadeOut('slow',function(){});
											$('#location-result').html('<p class="text-error">Invalid data!</p>');
											$('#location-result').fadeIn('slow',function(){});
										}
									}
								}, "json");
							}
						</script>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>