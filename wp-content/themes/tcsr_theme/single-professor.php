<?php
	get_header();
?>
<?php
	while(have_posts()){
		the_post();
		pageBanner();
?>
<div class="page_content container">

	<div class="row">
		<div class="col-12 col-sm-3"><?php the_post_thumbnail('professorPortrait2')?></div>
		<div class="col-12 col-sm-9">
			<?php
				$likeCount=new Wp_Query(array(
					'post_type' => 'like',
					'meta_query'=>array(
						array(
							'key'=>'liked_professor_id',
							'compare'=>'=',
							'value'=>get_the_ID(),
						)
					),
				));

				$existStatus="no";
				if(is_user_logged_in()){
					$existQuery=new Wp_Query(array(
						'author' => get_current_user_id(),
						'post_type' => 'like',
						'meta_query'=>array(
							array(
								'key'=>'liked_professor_id',
								'compare'=>'=',
								'value'=>get_the_ID(),
							)
						),
					));
					if($existQuery->found_posts){
						$existStatus="yes";
					}
				}	
			?>
			<div class=" text-right p-0">
				<span id="like-box" data-like="<?php echo $existQuery->posts[0]->ID ?>" data-professor="<?php the_ID() ?>" data-exists="<?php echo $existStatus ?>">
					<i class="far fa-heart"></i>
					<i class="fas fa-heart"></i>
					<span class="like-count"><?php echo $likeCount->found_posts; ?></span>
				</span>
			</div>
			<?php the_content()?>
				
		</div>
	</div>

	<?php
			$relatedPrograms=get_field('related_programs');
			if($relatedPrograms):
	?>
	<hr>
	<div class="related_pgm">
		<h3>Subject(s) Taught</h3>
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