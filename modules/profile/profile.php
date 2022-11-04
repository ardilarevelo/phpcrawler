<?php

// No direct access
defined('_DIACCESS') or die;

$site["title"] = "Profile - Daniel Ardila";

// load the header
require_once (BASE_PATH."header-admin.php");
?>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?php echo $site["title"]; ?></h1>
	</div>
	<!-- /.col-lg-12 --> 
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<p>
			Full-stack engineer with huge experience in Software Development and Data Analytics. Highly experienced in digital transformation processes to improve the flow of information, user experience and business agility.
		</p>
		<p>
			Experience of 13+ years in IT projects including websites and eCommerce development, optimizations to digital marketing campaigns, business process automation, development and integration of software using services and microservices, creating data solutions for datamart or data warehouse, and migrations of platforms. Experience in different business lines like banks, insurance, press, social media, and online payments. Skilled at high-traffic websites, backend, frontend, cloud solutions, data modelling, web services, APIs, reports, and big data processing.
		</p>
		<p>
			Specialized in PHP, Javascript, HTML, CSS, VueJS, React, NodeJS, Angular, Java; databases such as SQL Server, Sybase, MySQL, Teradata and MongoDB; process modelling using BPMN; cloud platforms like Azure, AWS and Google; data analytics, ETLs and PowerBI reports. Proficient with Scrum, DevOps, CI/CD, design patterns, Model View Controller (MVC) and MVP.
		</p>
		<p>
			Interested in new technologies, adaptable person, problem-solver, quick learner and enjoys working in a team.
		</p>
		<p>
			<a href="tel:+16132631735">
				<div> <i class="fa fa-phone fa-fw"></i> Phone number: +1 613-263-1735 </div>
			</a>
		</p>
		<p>
			<a href="mailto:dardila.ar@gmail.com">
				<div> <i class="fa fa-envelope fa-fw"></i> Email: dardila.ar@gmail.com </div>
			</a>
		</p>
		<p>
			<a href="https://www.linkedin.com/in/danielardila/?locale=en_US" target="_blank">
				<div> <i class="fa fa-linkedin fa-fw"></i> Linkedin </div>
			</a>
		</p>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<?php
    // load the footer
    require_once(BASE_PATH."footer-admin.php");
?>