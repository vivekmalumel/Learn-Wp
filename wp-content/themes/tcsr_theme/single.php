<?php
	get_header();
	pageBanner();
?>
<?php
	while(have_posts()){
		the_post();
?>
	
<div class="meta_container container">
		<a href="<?php echo site_url('/blog')?>" class="mata_link"><i class="fa fa-home"></i>Blog Home</a>
		<span class="mata_main">
			Posted by <?php the_author_posts_link()?> on <?php the_time('n-j-y') ?> in <?php echo get_the_category_list(', ') ?>
			
		</span>
		</div>
<div class="page_content container">

	
	<?php the_content() ?>

</div>















<?php
	}
	get_footer();
?>