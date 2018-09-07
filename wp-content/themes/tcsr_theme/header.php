<!DOCTYPE html>
<html <?php language_attributes()?>>
<head>
	<meta charset="<?php bloginfo('charset')?>">
	<meta  name="viewport" content="width=device-width,initial-scale=1">
	<?php wp_head()?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body <?php body_class()?>>


  	<header class="main_menu_area bg-light">
  		<div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#"><h2>TCSR</h2><!-- <img src="img/logo.png" alt=""> --></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                	<i class="fas fa-align-justify open"></i>
                	<i class="fas fa-times close hidden"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                		<?php wp_nav_menu(array(
                		'menu' => 2,
                		'menu_class'	 => 'navbar-nav ml-auto'
                	))?>
<!--                     <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="<?php echo home_url() ?>">Home</a></li>
                        <li class="nav-item"><a class="nav-link " href="about">About Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="service">Services</a></li>
                        <li class="nav-item "><a class="nav-link" href="portfolio">Portfolio</a></li>
                        <li class="nav-item dropdown submenu">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Blog
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li class="nav-item"><a class="nav-link" href="blog">Blog</a></li>
                                <li class="nav-item"><a class="nav-link" href="single_blog">Blog Details</a></li>
                                <li class="nav-item"><a class="nav-link" href="elements">Elements</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="contact">Contact</a></li>
                    </ul> -->
                </div>
                <div class="top_bar_btn" >
                	<?php if(!is_user_logged_in()):?>
  					<a href="<?php echo wp_login_url() ?>">Login</a>
  					<a href="<?php echo wp_registration_url() ?>">Register</a>
  					<?php else:?>
  					<a class="mr-1" href="<?php echo wp_logout_url(get_permalink())?>"><span class="logout_avatar"><?php echo get_avatar(get_current_user_id(),30) ?></span>
                        <span>Logout</span>
                    </a>
  				<?php endif; ?>
                    <a href="<?php echo esc_url(site_url('/search')) ?>" class="material-icons js-search-trigger">search</a>
  				</div>
            </nav>
            </div>

        </header>
        <!-- Header End -->

