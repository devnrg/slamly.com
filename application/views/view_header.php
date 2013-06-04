<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo $title; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="google-site-verification" content="nE-k0hlWX1r5G_WuVXM6-1v7G5fHtFCJZIReRGqTdZs" />
		<meta name="description" content="Slamly lets you create free online slambooks for your friends to fill." />
		<meta name="keywords" content="slambook, friends, community, sign, communicate, india, online slambook, slambook India" />
		<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,700' rel='stylesheet' type='text/css'>
		<link href="<?php echo base_url(); ?>includes/css/bootstrap.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>includes/stylesheet.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>includes/css/bootstrap-responsive.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>includes/jqueryui/jqueryui.min.css" rel="stylesheet">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-41097656-1', 'slamly.com');
			ga('send', 'pageview');
		</script>
	</head>
	<body>
		<div id="fb-root"></div>
			<script>(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=154751491370433";
				fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
			</script>
			<div id="wrap">
		<div class="navbar navbar-fixed-top navbar-inverse">
			<div class="navbar-inner">
				<div class="container">
					<a class="brand" href="<?php echo base_url(); ?>">Slamly</a>
					<?php
						if($this->session->userdata('loggedIn'))
						{
							echo '<ul class="nav pull-right">';
							echo '<li><img src="' . $this->session->userdata('profile_picture_32') . '" class="img-circle" style="margin-top: 5px;"></li>';
							echo '<li class="dropdown">';
							echo '<a href="#" class="dropdown-toggle name-caret" data-toggle="dropdown">' . $this->session->userdata('fname') . ' ' . $this->session->userdata('lname') . ' <b class="caret"></b></a>';
							echo '<ul class="dropdown-menu">';
							echo '<li><a href="' . base_url() . 'account"><i class="icon-cog"></i> Settings</a></li>';
							echo '<li><a href="' . base_url() . 'account/logout"><i class="icon-off"></i> Logout</a></li>';
						}
					?>
				</div>
			</div>
		</div>
	<div class="container">
