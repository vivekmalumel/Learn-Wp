<?php
	get_header();
?>
        <!-- Carosel Start -->
        <div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel">
        	 <ol class="carousel-indicators">
    			<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    			<li data-target="#myCarousel" data-slide-to="1"></li>
    			<li data-target="#myCarousel" data-slide-to="2"></li>
  			</ol>
  <div class="carousel-inner">
    <div class="carousel-item active animated zoomIn  delay-4s">
      <img class="d-block w-100" src="<?php echo get_theme_file_uri()?>/images/Customized-Software .jpg" alt="First slide">
      <div class="carousel-caption">
    		<h3 class="animated rollIn delay-4s">Los Angeles</h3>
    		<p class="animated zoomIn delay-5s">We had such a great time in LA!</p>
  		</div>
    </div>
    <div class="carousel-item animated fadeInUp delay-4s">
      <img class="d-block w-100" src="<?php echo get_theme_file_uri()?>/images/online-applications.jpg" alt="Second slide">
      <div class="carousel-caption">
    		<h3 class="animated rollIn delay-4s">Los Angeles</h3>
    		<p class="animated zoomIn delay-5s">We had such a great time in LA!</p>
  		</div>
    </div>
    <div class="carousel-item animated lightSpeedIn delay-4s">
      <img class="d-block w-100" src="<?php echo get_theme_file_uri()?>/images/software-development.jpg" alt="Third slide">
      <div class="carousel-caption">
    		<h3 class="animated rollIn delay-4s">Los Angeles</h3>
    		<p class="animated zoomIn delay-5s">We had such a great time in LA!</p>
  		</div>
    </div>
  </div>
  <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
	</div>
	<!-- Carosel End -->


	<!-- First Container -->

	<div class="first_block">
		<div class="container">
				<div class="row">
					<div class="col-sm-6 col-md-3 text-center">
						<div class="box-area">
							<div class="img-block animated rollIn delay-4s">
								<i class="fas fa-database"></i>
							</div>
								<p class="img_caption">WEB WITH DATA MINING</p>
						</div>
					</div>
					<div class="col-sm-6 col-md-3 text-center">
						<div class="box-area">
							<div class="img-block animated zoomInDown delay-6s">
								<i class="fas fa-volume-up"></i>
							</div>
								<p class="img_caption">DATA MINING IN MATLAB</p>
						</div>
					</div>
					<div class="col-sm-6 col-md-3 text-center">
						<div class="box-area">
							<div class="img-block animated rollIn delay-8s">
								<i class="fas fa-dna"></i>
							</div>
								<p class="img_caption">BIO INFORMATICS</p>
						</div>
					</div>
					<div class="col-sm-6 col-md-3 text-center">
						<div class="box-area">
							<div class="img-block animated zoomInDown delay-10s">
								<i class="fas fa-images"></i>
							</div>
								<p class="img_caption">IMAGE PROCESSING</p>
						</div>
					</div>
				</div>
		</div>
	</div>

	<div class="second_block">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-6 ">
					<div class="second_left">
					<h2>Upcoming Events</h2>
					<?php
						wp_reset_postdata();
						$today=date('Ymd');
						$homePagePosts=new Wp_Query(array(
							'post_type' => 'event',
							'posts_per_page' => 2,
							'meta_key'	=> 'event_date',
							'orderby'	=>'meta_value_num',
							'order'		=> 'ASC',
							'meta_query' => array(
									array(
										'key' => 'event_date',
										'compare' => '>=',
										'value'	=> $today,
										'type'	=>'numeric'
									)
							),


						));

						while($homePagePosts->have_posts()){
							$homePagePosts->the_post();
							get_template_part('template-parts/content-event');
					?>


<!-- 					<div class="blog_post col-lg-12 col-md-12">
						<div class="row">
							<div class="col-lg-2 col-md-3 col-sm-2 col-2 date_circle" style="padding: 10px;">
								<div class="blog_post_date">
									<?php
										$eventDate=new DateTime(get_field('event_date'));
									?>
									<span class="post_month"><?php echo $eventDate->format('M')?></span>
									<span class="post_day"><?php echo $eventDate->format('d') ?></span>
								</div>
							</div>
							<div class="blog_post_detail col-lg-10 col-md-9 col-sm-10 col-10">
								<div class="blog_post_title">
									<a href="<?php the_permalink()?>">
									<?php the_title()?>
									</a>
								</div>
								<div class="blog_post_desc">
									<?php echo wp_trim_words(get_the_content(),20)?>
									<a href="<?php the_permalink() ?>">Read More</a>
								</div>
							</div>
						</div>
						<hr>
					</div> -->
					<?php
						}
						wp_reset_postdata();
					?>

					<div class="view_all_lnk">
						<a href="<?php echo get_post_type_archive_link('event')?>" class="btn btn-info">View All Events</a>
					</div>




					</div>

				</div>
				<div class="col-lg-6 col-md-6">
					<div class="second_right">
					<h2>From Our Blog</h2>
						<?php
						wp_reset_postdata();
						$homePagePosts=new Wp_Query(array(
							'post_type' => 'post',
							'posts_per_page' => 2,

						));

						while($homePagePosts->have_posts()){
							$homePagePosts->the_post();
					?>


					<div class="blog_post col-lg-12 col-md-12">
						<div class="row">
							<div class="col-lg-2 col-md-3 col-sm-2 col-2 date_circle" style="padding: 10px;">
								<div class="blog_post_date">
									<span class="post_month"><?php the_time('M')?></span>
									<span class="post_day"><?php the_time('d') ?></span>
								</div>
							</div>
							<div class="blog_post_detail col-lg-10 col-md-9 col-sm-10 col-10">
								<div class="blog_post_title">
									<a href="<?php the_permalink()?>">
									<?php the_title()?>
									</a>
								</div>
								<div class="blog_post_desc">
									<?php echo wp_trim_words(get_the_excerpt(),20)?>
									<a href="<?php the_permalink() ?>">Read More</a>
								</div>
							</div>
						</div>
						<hr>
					</div>
					<?php
						}
						wp_reset_postdata();
					?>

					<div class="view_all_lnk">
						<a href="<?php echo site_url('/blog')?>" class="btn btn-info">View All Blog Posts</a>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>

	<!-- End First Container -->
 

<?php
	get_footer();
?>