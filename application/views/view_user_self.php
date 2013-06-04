	<div class="row-fluid">
		<div class="span4">
			<?php
				echo '<a href="#" title="Click to change"><img src="' . $this->session->userdata('profile_picture_256') . '" class="img-polaroid"></a>';
			?>
		</div>
		<div class="span1"></div>
		<div class="span7">
			<?php
				$timestamp = new DateTime($user->timestamp);
				echo '<h1 class="blue-text">' . $this->session->userdata('fname') . '<br>' . $this->session->userdata('lname') . '</h1>';
				if($profile->designation != null)
					echo '<h5>Works as ' . $profile->designation . ' at ' . $profile->organization . '</h5>';
				echo 'Member since ' . $timestamp->format('F Y');
			?>
		</div>
	</div>
	</div>
</div>