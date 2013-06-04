	<div class="row-fluid">
		<div class="span4">
			<?php
				if($profile->profile_picture_256 == 'includes/img/profile_placeholders/male_placeholder_256.jpg' || $profile->profile_picture_256 == 'includes/img/profile_placeholders/female_placeholder_256.jpg')
					$profile_picture_256 = base_url() . $profile->profile_picture_256;
				echo '<img src="' . $profile_picture_256 . '" class="img-polaroid">';
			?>
			<br><br>
			<div class="text-center">
				<?php 
					if($friend)
					{
						echo '<div class="btn-group"><a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">Friends <span class="caret"></span></a><ul class="dropdown-menu"></ul></div>';
					}
					else
					{
						if(isset($request))
						{
							if($request == 'forward')
								echo '<div class="btn-group"><a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-ok icon-white"></i>&nbsp;&nbsp;&nbsp;Friend request sent <span class="caret"></span></a><ul class="dropdown-menu"><li><a href="#cancelRequest" role="button" data-toggle="modal"><i class="icon-remove"></i> Cancel request</a></li></ul></div>';
							elseif($request == 'backward')
								echo '<a class="btn btn-success" href="#respondToRequest" role="button" data-toggle="modal">Respond to friend request</a>';
						}
						else
						{
							echo '<a href="#request" role="button" data-toggle="modal" class="btn btn-primary"><i class="icon-plus icon-white"></i>&nbsp;&nbsp;&nbsp;Add friend</a>';
						}
					}
				?>
			</div>
		</div>
		<div class="span1"></div>
		<div class="span7">
			<?php
				$timestamp = new DateTime($user->timestamp);
				echo '<h1 class="blue-text">' . $user->fname . '<br>' . $user->lname . '</h1>';
				if($profile->designation != null)
					echo '<h5>Works as ' . $profile->designation . ' at ' . $profile->organization . '</h5>';
				else
					echo '<h5>Work information: unkown</h5>';
				echo 'Member since ' . $timestamp->format('F Y');
			?>
		</div>
	</div>
	</div>
	<!-- Friend Request Modal -->
	<div id="request" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="requestLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 class="blue-text" id="requestLabel">Send request</h3>
		</div>
		<div class="modal-body">
			<div id="request-result" style="display: none;"></div>
			<div id="request-form">
			<?php 
				if($profile->profile_picture_32 == 'includes/img/profile_placeholders/male_placeholder_32.jpg' || $profile->profile_picture_32 == 'includes/img/profile_placeholders/female_placeholder_32.jpg')
					$profile_picture_32 = base_url() . $profile->profile_picture_32;
				echo '<h4><span style="font-size: 14px; font-weight: normal;">To:&nbsp;&nbsp;&nbsp;</span><img class = "img-circle" src="' . $profile_picture_32 . '">';
				echo '&nbsp;&nbsp;&nbsp;';
				echo $user->fname . ' ' . $user->lname . '</h4>';
			?>
			<?php
				echo form_open('/');
				echo form_label('Optional message:','requestMessage');
				$options = array(
					'name'		=>	'requestMessage',
					'id'		=>	'requestMessage',
					'placeholder'=>	'(200 characters maximum)',
					'class'		=>	'input-block-level'
				);
				echo form_textarea($options);
			?>
			</div>
		</div>
		<div class="modal-footer">
			<div id="request-button"><button class="btn btn-primary" type="button" onclick="sendRequest()"><i class="icon-envelope icon-white"></i>&nbsp;&nbsp;&nbsp;Send</button></div>
			<?php
				echo form_close();
			?>
		</div>
	</div>

	<div id="cancelRequest" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="cancelRequestLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 class="blue-text" id="cancelRequestLabel">Cancel request</h3>
		</div>
		<div class="modal-body">
			<div id="cancel-request-result" style="display: none;"></div>
			<div id="cancel-request-form">
				Are you sure you want to cancel this request?
			</div>
		</div>
		<div class="modal-footer">
			<div id="cancel-button"><button class="btn btn-primary" type="button" onclick="cancelRequest()">Yes</button></div>
		</div>
	</div>

	<div id="respondToRequest" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="respondToRequestLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 class="blue-text" id="respondToRequestLabel">Respond to friend request</h3>
		</div>
		<div class="modal-body">
			<div id="respond-request-result" style="display: none;"></div>
		</div>
		<div class="modal-footer">
			<button id="accept-request" class="btn btn-primary" type="button" onclick="acceptRequest()">Accept</button>
			<button id="ignore-request" class="btn btn-primary" type="button" onclick="ignoreRequest()">Ignore</button>
		</div>
	</div>
	<script type="text/javascript">
		function sendRequest()
		{
			var uuid = <?php echo "'" . $user->uuid . "';"; ?>
			var message = $('#requestMessage').val();

			$.post("<?php echo base_url(); ?>friends/request", { "uuid": uuid, "message": message },function(response){
				if(response.result == "success")
				{
					$('#request-result').fadeOut('slow',function(){});
					$('#request-form').fadeOut('slow',function(){
						$('#request-button').fadeOut('slow',function(){
							$('#request-result').html('<p class="text-success">Friend request sent!</p>');
							$('#request-result').fadeIn('slow',function(){});
						});
					});
					setTimeout(function(){
						location.reload();
					},3000);
				}
				else
				{
					if(response.result == "dbError")
					{
						$('#request-result').fadeOut('slow',function(){});
						$('#request-form').fadeOut('slow',function(){
							$('#request-button').fadeOut('slow',function(){
								$('#request-result').html('<p class="text-error">Unknown error, please try again</p>');
								$('#request-result').fadeIn('slow',function(){});
							});
						});
						setTimeout(function(){
							location.reload();
						},3000);
					}
					else
					{
						$('#request-result').fadeOut('slow',function(){});
						$('#request-result').html('<p class="text-error">Invalid data!</p>');
						$('#request-result').fadeIn('slow',function(){});
					}
				}
			}, "json");
		}

		function cancelRequest()
		{
			var uuid = <?php echo "'" . $user->uuid . "';"; ?>

			$.post("<?php echo base_url(); ?>friends/cancel_request", { "uuid": uuid },function(response){
				if(response.result == "success")
				{
					$('#cancel-request-result').fadeOut('slow',function(){});
					$('#cancel-request-form').fadeOut('slow',function(){
						$('#cancel-button').fadeOut('slow',function(){
							$('#cancel-request-result').html('<p class="text-success">Friend request cancelled!</p>');
							$('#cancel-request-result').fadeIn('slow',function(){});
						});
					});
					setTimeout(function(){
						location.reload();
					},3000);
				}
				else
				{
					if(response.result == "dbError")
					{
						$('#cancel-request-result').fadeOut('slow',function(){});
						$('#cancel-request-form').fadeOut('slow',function(){
							$('#cancel-button').fadeOut('slow',function(){
								$('#cancel-request-result').html('<p class="text-error">Unknown error, please try again</p>');
								$('#cancel-request-result').fadeIn('slow',function(){});
							});
						});
						setTimeout(function(){
							location.reload();
						},3000);
					}
					else
					{
						$('#cancel-request-result').fadeOut('slow',function(){});
						$('#cancel-request-result').html('<p class="text-error">Invalid data!</p>');
						$('#cancel-request-result').fadeIn('slow',function(){});
					}
				}
			}, "json");
		}

		function acceptRequest()
		{
			var uuid = <?php echo "'" . $user->uuid . "';"; ?>
			var response = 'accept';

			$.post("<?php echo base_url(); ?>friends/cancel_request", { "uuid": uuid, "response": response },function(response){
				if(response.result == "success")
				{
					$('#cancel-request-result').fadeOut('slow',function(){});
					$('#cancel-request-form').fadeOut('slow',function(){
						$('#cancel-button').fadeOut('slow',function(){
							$('#cancel-request-result').html('<p class="text-success">Friend request cancelled!</p>');
							$('#cancel-request-result').fadeIn('slow',function(){});
						});
					});
					setTimeout(function(){
						location.reload();
					},3000);
				}
				else
				{
					if(response.result == "dbError")
					{
						$('#cancel-request-result').fadeOut('slow',function(){});
						$('#cancel-request-form').fadeOut('slow',function(){
							$('#cancel-button').fadeOut('slow',function(){
								$('#cancel-request-result').html('<p class="text-error">Unknown error, please try again</p>');
								$('#cancel-request-result').fadeIn('slow',function(){});
							});
						});
						setTimeout(function(){
							location.reload();
						},3000);
					}
					else
					{
						$('#cancel-request-result').fadeOut('slow',function(){});
						$('#cancel-request-result').html('<p class="text-error">Invalid data!</p>');
						$('#cancel-request-result').fadeIn('slow',function(){});
					}
				}
			}, "json");
		}
	</script>
</div>