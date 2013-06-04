<br>
<div class="row-fluid">
	<div class="span3">
		<div class="row-fluid">
			<div class="span4">
				<?php echo '<img src="' . $this->session->userdata('profile_picture_64') . '" class="img-rounded">'; ?>
			</div>
			<div class="span8">
				<?php echo '<h5 class="blue-text">' . $this->session->userdata('fname') . ' ' . $this->session->userdata('lname') . '</h5>'; ?>
			</div>
		</div>
		<br>
		<ul class="nav nav-tabs nav-stacked">
			<li <?php if(isset($nav)){if($nav == 1) {echo 'class="active"';}} ?>><a href="<?php echo base_url(); ?>feed"><i class="icon-th-list"></i> Feed</a></li>
			<li <?php if(isset($nav)){if($nav == 2){echo 'class="active"';}} ?>><a href="<?php echo base_url(); ?>questions"><i class="icon-question-sign"></i> Questions</a></li>
			<li <?php if(isset($nav)){if($nav == 3){echo 'class="active"';}} ?>><a href="<?php echo base_url(); ?>friends"><i class="icon-user"></i> Friends</a></li>
		</ul>
	</div>
	<div class="span9">