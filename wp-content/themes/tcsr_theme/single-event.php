<?php
	get_header();
	pageBanner();
?>
<?php
	while(have_posts()){
		the_post();
?>

<div class="meta_container container">
		<a href="<?php echo get_post_type_archive_link('event') ?>" class="mata_link"><i class="fa fa-home"></i>Events Home</a>
		<span class="mata_main">
			<?php the_title() ?>
			
		</span>
</div>


<div class="page_content container">

	
	<?php the_content() ?>

	<?php
			$relatedPrograms=get_field('related_programs');
			if($relatedPrograms):
	?>
	<hr>
	<div class="related_pgm">
		<h3>Related Program(s)</h3>
		<ul class="list-unstyled">
		<?php
			foreach ($relatedPrograms as $program) {?>
				<li><a class="text-danger text-large " href="<?php echo get_the_permalink($program)?>"><?php echo get_the_title($program)?></a></li>
		<?php	}
		?>
		</ul>
	</div>
<?php endif; ?>
</div>


<?php
	}
	get_footer();
?>