<?php
	get_header();
	pageBanner(array(
		'title'	=> 'All Events',
		'subtitle' => 'See what is going on in our world.'
	));
?>

<div class="page_content container">
	<?php
	while(have_posts()){
		the_post();
		get_template_part('template-parts/content-event');
 } 

	echo paginate_links();
?>
	</div>


<?php
	get_footer();
?>