<?php
	get_header();
	pageBanner(array(
		'title' => 'All Programs',
		'subtitle' => 'There is something for everyone. Have a look around.'
	));
?>

<div class="page_content container">
	<ul class="list-group">
	<?php
	while(have_posts()){
		the_post();
	?>

	<li class="list-group-item list-group-item-info"><a class="text-danger" href="<?php the_permalink()?>"><?php the_title() ?></a></li>

<?php } 

	echo paginate_links();
?>
	</ul>
	</div>


<?php
	get_footer();
?>