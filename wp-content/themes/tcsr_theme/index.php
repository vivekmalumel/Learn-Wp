<?php
	get_header();
	pageBanner(array(
		'title'	=>	'Welcome to Our Blog',
		'subtitle'	=>'Keep up with our latest post.',
		'photo'		=>  get_field('page_banner_image',8)['sizes']['pageBanner'],
	));
?>
<div class="page_content container">
	<?php
	while(have_posts()){
		the_post();
	?>

	<div class="post_item col-md-12">
		<h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
		<div class="metabox">
			<p>
				Posted by <?php the_author_posts_link()?> on <?php the_time('n-j-y') ?> in <?php echo get_the_category_list(', ') ?>
			</p>
		</div>
		<div class="post_desc"> <?php the_excerpt() ?> </div>
		<div class="read_more">
		<a class="btn btn-continue" href="<?php the_permalink() ?>">Continue Reading &raquo;</a>
		</div>
		<hr>
	</div>
<?php } 

	echo paginate_links();
?>
	</div>


<?php
	get_footer();
?>