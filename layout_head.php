<!DOCTYPE html>
<html lang="en">
<head>
 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
    <!-- set the page title, for seo purposes too -->
    <title><?php echo isset($page_title) ? strip_tags($page_title) : "$site_name"; ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" media="screen" />
 
    <!-- Custom CSS -->
    <link href="<?php echo $home_url . "style.css" ?>" rel="stylesheet" />
 
</head>
<body>
 
    <!-- include the navigation bar -->
    <?php include_once 'navigation.php'; ?>
 
    <!-- container -->
    <div class="container">
 
 
<!-- display the title -->
<div class='col-md-12'>
	<div class="page-header">
		<h2><center><?php echo isset($page_title) ? $page_title : "nuBuilder"; ?></center></h2>
	</div>
</div>



