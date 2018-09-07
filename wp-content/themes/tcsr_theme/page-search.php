<?php
	get_header();
?>
<?php
	while(have_posts()){
		the_post();
		pageBanner();
?>

<div class="page_content container text-center">
	<div class="col-6 m-auto bg-secondary py-2 px-5 border border-light rounded">
	<form method="GET" class="search_form" action="<?php echo esc_url(site_url('/'))?>">
		<label for="s" class="text-white"><h2>Perform a new Search</h2></label>
		<input type="search" placeholder="What are you looking for?" class="form-control id="s" name="s">
		<input type="submit" class="btn btn-primary my-2" value="Search">
	</form>
	</div>

</div>



<?php
	}
	get_footer();
?>