<?php

	require get_theme_file_path('/inc/search-route.php');
	require get_theme_file_path('/inc/like-route.php');

	function pageBanner($args=NULL){
		if(!$args['title']){
			$args['title']=get_the_title();
		}
		if(!$args['subtitle']){
			$args['subtitle']=get_field('page_banner_subtitle');
		}
		if(!$args['photo']){
			if(get_field('page_banner_image'))
				$args['photo']=get_field('page_banner_image')['sizes']['pageBanner'];
		}
?>
	<?php $bannerImage=get_field('page_banner_image')?>
	<div class="page_banner" <?php if($args['photo']):?> style="background: url(<?php echo $args['photo'] ?>); background-size: cover;" <?php endif;?>>
		<div class="container">
			<div class="page_banner_title"> <?php echo $args['title']?></div>
			<div class="page_banner_intro pl-2">
			<?php echo $args['subtitle'] ?>
			</div>
		</div>
	</div>

<?php
	}



	function tcsr_files(){

		wp_enqueue_script('tcsr_script',get_theme_file_uri('/js/scripts.js'),array( 'tcsr_jquery_js' ),1.0,true);
		wp_enqueue_script('tcsr_myNote_script',get_theme_file_uri('/js/myNotes.js'),array( 'tcsr_jquery_js' ),1.0,true);
		wp_enqueue_script('tcsr_like_script',get_theme_file_uri('/js/like.js'),array( 'tcsr_jquery_js' ),1.0,true);
		wp_enqueue_script('toaster_script',get_theme_file_uri('/js/toastr.min.js'),array( 'tcsr_jquery_js' ),1.0,true);
		wp_enqueue_script('tcsr_jquery_js',get_theme_file_uri('/js/jquery-3.3.1.min.js'),NULL,3.3,true);
		wp_enqueue_script('tcsr_popper_js',get_theme_file_uri('/js/popper.min.js'),NULL,1.0,true);
		wp_enqueue_script('tcsr_bootstrap_js',get_theme_file_uri('/js/bootstrap.min.js'),NULL,4.1,true);
		wp_enqueue_script('tcsr_custom_script',get_theme_file_uri('/js/custom.js'),NULL,1.0,true);
		wp_enqueue_style('meterial_icons',get_theme_file_uri('/css/materialicons/material-icons.css'));
		wp_enqueue_style('tcsr_main_styles',get_stylesheet_uri());
		wp_enqueue_style('toaster_styles',get_theme_file_uri('/css/toastr.min.css'));
		wp_enqueue_style('tcsr_custom_styles',get_theme_file_uri('/css/custom.css'));
		wp_enqueue_style('tcsr_animate_styles',get_theme_file_uri('/css/animate.min.css'));
		wp_localize_script('tcsr_script','tcsrData',array(
			'root_url' => esc_url(get_site_url()),
			'nonce'	=> wp_create_nonce('wp_rest')
		));
	}
	add_action('wp_enqueue_scripts','tcsr_files');






	function tcsr_features()
	{
		register_nav_menu('headerMenuLocation','Header Menu Location');
		add_theme_support('title-tag');
		add_theme_support('post-thumbnails');
		add_image_size('professorLandscape',400,260,true);
		add_image_size('professorPortrait',300,450,true);
		add_image_size('pageBanner',1500,350,true);
	}
	add_action('after_setup_theme','tcsr_features');

	function add_classes_on_li($classes, $item, $args) {
  		$classes[] = 'nav-item';
  		return $classes;
	}
	add_filter('nav_menu_css_class','add_classes_on_li',1,3);

	function tcsr_event_queries($query){

		if(!is_admin() AND is_post_type_archive('program') AND $query->is_main_query()){
			$query->set('orderby','title');
			$query->set('order','ASC');
			$query->set('posts_per_page',-1);
		}

		$today=date('Ymd');
		if(!is_admin() AND is_post_type_archive('event') AND $query->is_main_query())
		{
			$query->set('meta_key', 'event_date');
			$query->set('orderby', 'meta_value_num');
			$query->set('order', 'ASC');
			$query->set('meta_query', array(
									array(
										'key' => 'event_date',
										'compare' => '>=',
										'value'	=> $today,
										'type'	=>'numeric'
									)
							)
						);

		}
	}
	add_action('pre_get_posts','tcsr_event_queries');


	function tcsr_mapKey($api){
		$api['key']='AIzaSyCIl8dqG-e2SpKMxeqKU8TbwZMwKrJRO0g';
		return $api;
	}
	add_filter('acf/fields/google_map/api','tcsr_mapKey');

	function tcsr_custom_rest(){
		register_rest_field('post','authorName',array(//get author name for post_type post
			'get_callback' =>function(){
				return get_the_author();
			}
		));

		register_rest_field('note','noteCount',array(//customize rest to get current user note count
			'get_callback' =>function(){
				return count_user_posts(get_current_user_id(),'note');
			}
		));
	}
	add_action('rest_api_init','tcsr_custom_rest');

//Redirect Subscriber out of admin and onto home page
	function redirectSubsToFrontend(){
		$curUser=wp_get_current_user();
		if(count($curUser->roles())==1 AND $curUser->roles[0]=='subscriber'){
			wp_redirect(site_url('/'));
			exit;
		}

	}
	add_action('admin_init','redirectSubsToFrontend');

//Remove adminbar for subscribers

		function noSubsAdminbar(){
		$curUser=wp_get_current_user();
		if(count($curUser->roles())==1 AND $curUser->roles[0]=='subscriber'){
			show_admin_bar(false);
		}

	}
	add_action('wp_loaded','noSubsAdminbar');

//customize Login Screen image url
	add_filter('login_headerurl','ourHeaderUrl');
	function ourHeaderUrl(){
		return site_url('/');
	}

//customize Login Screen image title
	add_filter('login_headertitle','ourHeaderTitle');
	function ourHeaderTitle(){
		return get_bloginfo('name');
	}

//Admin css linking
	add_action('login_enqueue_scripts','ourLoginCss');
	function ourLoginCss(){
		wp_enqueue_style('tcsr_admin_custom_styles',get_theme_file_uri('/css/admin.css'));

	}
//Force note post to be private
	add_filter('wp_insert_post_data','makeNotePrivate',10,2);
	function makeNotePrivate($data,$postArr){  

		if($data['post_type']=='note'){
			if(count_user_posts(get_current_user_id(),'note')>5 AND !$postArr['ID']){//set user post limit
				die("You have reached your note limit");
			}

			$data['post_content']=sanitize_textarea_field($data['post_content']);//to remove any htmlor malicious code
			$data['post_title']=sanitize_text_field($data['post_title']);
		}


		if($data['post_type']=="note" AND $data['post_status']!='trash' )
		{
			$data['post_status']="private";//to make note post type private
		}
			return $data;
	}
?>