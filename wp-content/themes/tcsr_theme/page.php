<?php
	get_header();
?>
<?php
	while(have_posts()){
		the_post();
		pageBanner();
?>
	
<!-- <div class="page_banner">
	<div class="container">
		<div class="page_banner_title"> <?php the_title()?></div>
		<div class="page_banner_intro">
"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..."
		</div>
	</div>
</div> -->
	<?php
		$parent=wp_get_post_parent_id(get_the_ID());
		if($parent):
	?>
	<div class="meta_container container">
		<a href="<?php echo get_the_permalink($parent)?>" class="mata_link"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back to <?php echo get_the_title($parent)?></a>
		<span class="mata_main"><?php the_title() ?></span>
	</div>
	<?php
	endif;
	?>

<div class="page_content container">

	<?php 
		$testArray=get_pages(array(
			'child_of' => get_the_ID()
		));
		if($parent or $testArray){	//check if parent or child exist

	?>
	<div class="page_right_block page_links col-md-6 col-lg-4">
		<div class="page_link_title">
			<a href="<?php echo get_the_permalink($parent)?>"><?php echo get_the_title($parent)?></a></div>
		<?php
			if($parent)					//if parent exist display all childsof it
				$findChildOf=$parent;
			else 						//if parent does not exist display all childsof current page
				$findChildOf=get_the_ID();
		?>
		<ul class="min_list">
			<?php 
				echo wp_list_pages(array(
					'title_li' => NULL,
					'child_of' => $findChildOf,
					'sort_order' => 'menu_order'
				));
			?>
		</ul>
	</div>

	<?php
		}
	 the_content() ?>

</div>















<?php
	}
	get_footer();
?>