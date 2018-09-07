<?php 
	if(!is_user_logged_in()){
		wp_redirect(esc_url(site_url('/')));
		exit;
	}
	get_header();
	while(have_posts()){
		the_post();
		pageBanner();
?>
<div class="page_content container">
	<div class="card bg-light">
		<div class="card-header"><h2>Create New Note</h2></div>
		<div class="card-body">
			<div class="form-group">
				<input type="text" placeholder="Enter the Title" class="form-control" id="new-note-title">
			</div>
			<div class="form-group">
				<textarea placeholder="Enter Content Here.." class="form-control" id="new-note-body"></textarea>
			</div>
		</div>
		<div class="card-footer">
			<a class="btn btn-success text-white" id="save-note">Save Note</a>
			<br>
			<span id="note_msg" class="text-danger"></span>
		</div>
	</div>
	<ul class="list-unstyled py-5" id="my-notes">
		<?php
			$userNotes=new Wp_Query(array(
				'post_type'=> 'note',
				'posts_per_page' => -1,
				'author' => get_current_user_id()
			));
			while($userNotes->have_posts()){
				$userNotes->the_post();?>
			<li data-id="<?php the_ID()?>">
				<div class="row">
				<div class="col-8">
				<input type="text" class="note-title form-control form-control-lg lead d-none" value="<?php echo str_replace('Private: ', '', esc_attr(get_the_title())) ?>">
				<h2 class="note-title-head "><?php echo str_replace('Private: ', '', esc_attr(get_the_title())) ?>
				</h2>
				</div>
				<div class="note-btn col-4">
				<span class="btn btn-info edit-note "><i class="fas fa-pencil-alt" aria-hidden="true"></i> Edit</span>
				<span class="btn btn-danger delete-note "><i class="fas fa-trash-alt" aria-hidden="true"></i> Delete</span>
				</div>
				</div>
				<textarea class="form-control note-body d-none bg-white" ><?php echo esc_textarea(get_the_content())?></textarea>
				<div class="note-body-div">
					<?php echo esc_html(get_the_content())?>
				</div>
				<span class="btn btn-primary update-note d-none ">Save</span>
				<hr>
			</li>
		<?php
			}
		?>

	</ul>
</div>


<?php 
	}
	get_footer();
?>