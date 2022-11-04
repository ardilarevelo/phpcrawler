<?php
// No direct access
defined('_DIACCESS') or die;

// Obtain the menu
$admin_menu = menu::get();

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title><?php echo $site["title"]; ?></title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<base href="<?php echo BASE_URL."/"; ?>" />
	
	<!-- Bootstrap Core CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL."/"; ?>template/css-admin/bootstrap.min.css" />
	
	<!-- MetisMenu CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL."/"; ?>template/css-admin/metisMenu.min.css" />
	
	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL."/"; ?>template/css-admin/sb-admin-2.min.css" />
	
	<!-- Custom Fonts -->
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL."/"; ?>template/css-admin/font-awesome.min.css" />
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	<!-- jQuery -->
	<script type="text/javascript" src="<?php echo BASE_URL."/"; ?>template/js-admin/jquery.min.js"></script>
	
	<script type="text/javascript" src="<?php echo BASE_URL."/"; ?>template/js/json.js"></script>
	
	<?php
		if(isset($header_adicional)){
			echo $header_adicional;
		}
	?>
	
</head>
<body>
	
	<div id="wrapper"> 	
		<!-- Navigation -->
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
				<a class="navbar-brand" href="<?php echo BASE_URL; ?>">Tech Challenge: <?php echo $site["title"]; ?></a> </div>
			<!-- /.navbar-header -->
			
			<ul class="nav navbar-top-links navbar-right">
				<li class="dropdown"> <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i> </a>
					<ul class="dropdown-menu dropdown-alerts">
						<li>
							<a href="tel:+16132631735">
								<div> <i class="fa fa-phone fa-fw"></i> Phone number: +1 613-263-1735 </div>
							</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="mailto:dardila.ar@gmail.com">
								<div> <i class="fa fa-envelope fa-fw"></i> Email: dardila.ar@gmail.com </div>
							</a>
						</li>
					</ul>
					<!-- /.dropdown-alerts --> 
				</li>
				<!-- /.dropdown -->
				<li class="dropdown"> <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i> </a>
					<ul class="dropdown-menu dropdown-user">
						<li><a href="/profile"><i class="fa fa-user fa-fw"></i> Profile</a> </li>
						<li><a href="https://www.linkedin.com/in/danielardila/?locale=en_US" target="_blank"><i class="fa fa-linkedin fa-fw"></i> Linkedin</a> </li>
						<li class="divider"></li>
						<li><a href="<?php echo BASE_URL; ?>"><i class="fa fa-sign-out fa-fw"></i> Salir</a> </li>
					</ul>
					<!-- /.dropdown-user --> 
				</li>
				<!-- /.dropdown -->
			</ul>
			<!-- /.navbar-top-links -->
			
			<div class="navbar-default sidebar" role="navigation">
				<div class="sidebar-nav navbar-collapse">
					<ul class="nav" id="side-menu">
						<li>
							<a href="https://agencyanalytics.com/" target="_blank"><i class="fa fa-home fa-fw"></i> Ir a agencyanalytics.com</a>
						</li>
						<li>
							<a href="<?php echo BASE_URL; ?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
						</li>
						<?php
							foreach($admin_menu as $admin_m){
								$submenu_icon = isset($admin_m['submenu']) ? '<span class="fa arrow"></span>' : '';
						?>
						<li>
							<a href="<?php echo isset($admin_m['url']) ? $admin_m['url'] : '#'; ?>"><i class="fa <?php echo $admin_m['class']; ?> fa-fw"></i> <?php echo $admin_m['name']; ?><?php echo $submenu_icon; ?></a>
							<?php if(isset($admin_m['submenu'])){ ?>
							<ul class="nav nav-second-level">
								<?php foreach($admin_m['submenu'] as $admin_s){ ?>
								<li> <a href="<?php echo $admin_s['url']; ?>"><i class="fa <?php echo $admin_s['class']; ?> fa-fw"></i> <?php echo $admin_s['name']; ?></a> </li>
								<?php } ?>
							</ul>
							<?php } ?>
						</li>
						<?php } ?>
					</ul>
				</div>
				<!-- /.sidebar-collapse --> 
			</div>
			<!-- /.navbar-static-side --> 
		</nav>
		
		<!-- Page Content -->
		<div id="page-wrapper">
			<?php site::getSessionMessage(); ?>