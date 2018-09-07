<?php
	add_action('rest_api_init','tcsrLikeRoutes');
	function tcsrLikeRoutes(){
		register_rest_route('tcsr/v1','manageLike',array(
			'methods'	=>  POST,
			'callback'	=>  'createLike'
		));
		register_rest_route('tcsr/v1','manageLike',array(
			'methods'	=>  DELETE,
			'callback'	=>  'deleteLike'
		));

	}
	function createLike($data){
		$professor=sanitize_text_field($data['professorID']);
		if(is_user_logged_in()){
			$existQuery=new Wp_Query(array(
						'author' => get_current_user_id(),
						'post_type' => 'like',
						'meta_query'=>array(
							array(
								'key'=>'liked_professor_id',
								'compare'=>'=',
								'value'=>$professor,
							)
						),
					));
			if($existQuery->found_posts==0 AND get_post_type($professor)=="professor"){
				return wp_insert_post(array(
					'post_type' => 'like',
					'post_status' => 'publish',
					'meta_input'=>array(
						'liked_professor_id'=>$professor,
					),
				));
			}
			else{//when useralredy liked a post and press like again
				die("invalid Professor Id");
			}
		}
		else
			die("guest");
	}
	function deleteLike($data){
		$likeID=sanitize_text_field($data['like']);
		//return get_post_type($likeID);
		if(get_current_user_id()==get_post_field('post_author',$likeID) AND get_post_type($likeID)=='like'){
			wp_delete_post($likeID,true);
			return "congrats Like Deleted.";
		}
		else{
			die("You don't have permission.");
		}
	}
?>