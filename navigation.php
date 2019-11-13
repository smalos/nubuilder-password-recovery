<!-- navbar -->
<div class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container-fluid">
 
        <div class="navbar-header">
            <!-- to enable navigation dropdown when viewed in mobile device -->
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
 
        <!-- display the site name(in config.php)-->
            <a class="navbar-brand" href="<?php echo $login_url; ?>"><?php echo $site_name; ?></a>
        </div>
 
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <!-- link to the "Cart" page, highlight if current page is cart.php -->
                <li <?php echo $page_title=="Index" ? "class='active'" : ""; ?>>
                    <a href="<?php echo $login_url; ?>">Home</a>
                </li>
            </ul>
             
        </div><!--/.nav-collapse -->
 
    </div>
</div>
<!-- /navbar -->