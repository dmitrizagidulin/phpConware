<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Readercon</title>
<link rel="shortcut icon" href="http://readercon.org/favicon.ico" />
<link rel="icon" href="http://readercon.org/favicon.png" type="image/png" />
<link href="/pro_signup/css/rcon.css" rel="stylesheet" type="text/css" />

<?php 
echo $this->Html->css('cake.generic');
echo $scripts_for_layout; 
echo $this->Html->script(array('jquery-1.6.1.min','jquery.progressbar.min','jquery.progressbar'));
?>
</head>
<body>
<div id="container">
		<div id="header">
		<img src="http://readercon.org/images/logo.gif" alt="Readercon" width="334" height="75" border="0" />
		<h1>The conference on imaginative literature, twenty-second edition.</h1>
		</div>
		<div id="tabs">
				<ul>
						<li><a href="/index.htm" title="Home"><span>Home</span></a></li>
						<li><a href="/hotel.htm" title="Hotel"><span>Hotel</span></a></li>
						<li><a href="/registration.htm" title="Register"><span>Register</span></a></li>
						<li><a href="/guests.htm" title="Guests"><span>Guests</span></a></li>
						<li><a href="/program.htm" title="Program"><span>Program</span></a></li>
						<li><a href="/bookshop.htm" title="Bookshop"><span>Bookshop</span></a></li>
						<li><a href="/information.htm" title="More Info"><span>More Info</span></a></li>
						<li><a href="/about.htm" title="Us"><span>Us</span></a></li>
						<li><a href="/community.htm" title="Community"><span>Community</span></a></li>
				</ul>
		</div>
		<div id="wrapper">
				<div id="content_admin">
				<div id="user-nav">
					<?php if($logged_in): ?>
						[<a href="/pro_signup/dashboards/index/">Panelist Dashboard</a>]
						Welcome, <?php echo $user_email; ?>. <?php echo $html->link('Logout', array('controller'=>'users', 'action'=>'logout')); ?>
					<?php endif; ?>
				</div>
				
				<?php echo $this->Session->flash(); ?>
				<?php echo $content_for_layout; ?>

				</div>
		</div>
		<div id="clearer"></div>
		<div id="footer">
				<p>Copyright &copy; 2010 Readercon, Inc.</p>
		</div>
</div>
</body>
</html>
