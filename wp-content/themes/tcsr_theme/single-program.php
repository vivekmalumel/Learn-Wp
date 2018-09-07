<?php
	get_header();
?>
<?php
	while(have_posts()){
		the_post();
		pageBanner();
?>
<div class="meta_container container">
		<a href="<?php echo get_post_type_archive_link('program') ?>" class="mata_link"><i class="fa fa-home"></i>All Programs</a>
		<span class="mata_main">
			Posted by <?php the_author_posts_link()?> on <?php the_time('n-j-y') ?> in <?php echo get_the_category_list(', ') ?>
			
		</span>
</div>
<div class="page_content container">

	
	<?php the_field('main_body_content') ?>
	<?php
						$relatedProfessors=new Wp_Query(array(
							'post_type' => 'professor',
							'posts_per_page' => -1,
							'orderby'	=>'title',
							'order'		=> 'ASC',
							'meta_query' => array(
									
									array(
										'key' => 'related_programs',
										'compare' => 'LIKE',
										'value' => '"'.get_the_id().'"',
									)
							),


						));
						if($relatedProfessors->have_posts()):
							echo '<hr><h4>'.get_the_title().' Professors</h4>';
							echo '<ul class="list-unstyled list-inline pl-5">';
						while($relatedProfessors->have_posts()){
							$relatedProfessors->the_post();
						?>
						<li class="card prof_card list-inline-item" style="width: 10rem;">
							<a href="<?php the_permalink()?>" style="text-decoration: none ">
							<div style="overflow: hidden;"><img class="card-img-top" style="width: 100%;" src="<?php the_post_thumbnail_url('professorLandscape') ?>" alt="Card image cap"></div>
							<div class="card-footer text-center text-danger p-0"><?php the_title() ?></div>
							
							</a>
						</li>

						<?php 
						}
						echo '</ul>';
						wp_reset_postdata();
					endif;
					?>

	
	<?php
						//wp_reset_postdata();
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
									),
									array(
										'key' => 'related_programs',
										'compare' => 'LIKE',
										'value' => '"'.get_the_id().'"',
									)
							),


						));
						if($homePagePosts->have_posts()):
							echo '<hr><h4>Upcoming '. get_the_title().' Events</h4>';
						while($homePagePosts->have_posts()){
							$homePagePosts->the_post();
							get_template_part('template-parts/content-event');
						}
						wp_reset_postdata();
					endif;
					?>

</div>















<?php
	}
	get_footer();
?>