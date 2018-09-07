<?php
	add_action('rest_api_init','tcsr_register_search');

	function tcsr_register_search(){  //url is: tcsr.com/wp-json//tcsr/v1/search
		register_rest_route('tcsr/v1','search',array(
			'methods'	=>  WP_REST_SERVER::READABLE,
			'callback'	=>  'tcsr_search_results'
		));

	}

	function tcsr_search_results($data){
		$mainQuery=new Wp_Query(array(
			'post_type' => array('post','page','program','event','professor'),
			's'			=> sanitize_text_field($data['term']),//for security
			'posts_per_page' => -1
		));

		$results=array(

			'generalInfo' => array(),
			'professors' => array(),
			'events' => array(),
			'programs' => array()
		);

		
		if(sanitize_text_field($data['term'])=='professor'){
			$subQuery=new Wp_Query(array(
				'post_type' => 'professor',
				'posts_per_page' => -1
			));
			while($subQuery->have_posts()){
				$subQuery->the_post();
				array_push($results['professors'],array(
				'title' => get_the_title(),
				'link'	=> get_the_permalink(),
				'image'	=> get_the_post_thumbnail_url(0,'professorLandscape')
				));
			}
			
		}

		while($mainQuery->have_posts()){
			$mainQuery->the_post();
			if(get_post_type()=='post' || get_post_type()=='page'){
				if(has_excerpt()){
					$description=get_the_excerpt();
				}
				else{
					$description=wp_trim_words(get_the_content(),18);
				}
				array_push($results['generalInfo'],array(
				'title' => get_the_title(),
				'link'	=> get_the_permalink(),
				'authorName'	=> get_the_author(),
				'type'	=>get_post_type(),
				'description' =>$description
				));
			}

			if(get_post_type()=='professor'){
				array_push($results['professors'],array(
				'title' => get_the_title(),
				'link'	=> get_the_permalink(),
				'image'	=> get_the_post_thumbnail_url(0,'professorLandscape')
				));
			}
			if(get_post_type()=='event'){
				$eventDate=new DateTime(get_field('event_date'));
				if(has_excerpt()){
					$description=get_the_excerpt();
				}
				else{
					$description=wp_trim_words(get_the_content(),12);
				}
				array_push($results['events'],array(
				'title' => get_the_title(),
				'link'	=> get_the_permalink(),
				'month'=> $eventDate->format('M'),
				'day'=> $eventDate->format('d'),
				'description' => $description,
				));
			}
			if(get_post_type()=='program'){
				array_push($results['programs'],array(
				'title' => get_the_title(),
				'link'	=> get_the_permalink(),
				'id'	=> get_the_id()
				));
			}
			
		}
		if($results['programs']){
			$programsMetaQuery=array(
				'relation'=> 'OR'
			);
			foreach ($results['programs'] as $item) {
				array_push($programsMetaQuery,array(
					'key'	=> 'related_programs',
					'compare'=> 'LIKE',
					'value'  => '"'.$item['id'].'"'
					)
				);
			}

			$programRelationshipQuery=new Wp_Query(array(
				'post_type' => array('professor','event'),
				'meta_query' => $programsMetaQuery
				)
			);
			while($programRelationshipQuery->have_posts()){
				$programRelationshipQuery->the_post();
				if(get_post_type()=='professor'){
					array_push($results['professors'],array(
					'title' => get_the_title(),
					'link'	=> get_the_permalink(),
					'image'	=> get_the_post_thumbnail_url(0,'professorLandscape')
					));
				}

				if(get_post_type()=='event'){
					$eventDate=new DateTime(get_field('event_date'));
				if(has_excerpt()){
					$description=get_the_excerpt();
				}
				else{
					$description=wp_trim_words(get_the_content(),12);
				}
				array_push($results['events'],array(
					'title' => get_the_title(),
					'link'	=> get_the_permalink(),
					'month'=> $eventDate->format('M'),
					'day'=> $eventDate->format('d'),
					'description' => $description,
					));
				}
			}
			/*	array_unique Removes Duplicate elements from an array */
			$results['professors']=array_values(array_unique($results['professors'],SORT_REGULAR));
			$results['events']=array_values(array_unique($results['events'],SORT_REGULAR));


		}
		
		return $results;
	}


?>