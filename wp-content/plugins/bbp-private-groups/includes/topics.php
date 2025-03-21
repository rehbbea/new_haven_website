<?php
//version 1.9.2 fixed private groups forums for subscriptions //version 3.9.7 fixed private groups topics for subscriptions

add_filter ('bbp_before_has_topics_parse_args', 'pg_has_topics') ;

function pg_has_topics( $args = '' ) {
	//for forums, check if being called by subscriptions and if so skip filtering (as you can only subscribe to forums you can already see)		if(isset($args['post__in']) ){	return $args ;	}		/*then fix for topic subscriptions - logic here is that if a user has subscribed to a topic, then he is allowed to view that topic, so we 	don't need to filter.  So in \bbpress\includes\users\engagements.php we have the function bbp_get_user_topic_subscriptions whch is used in	\bbpress\bbpress\templates\default\bbpress\user-subscriptions.php to get the topic subscriptions.  This sets up the $args for bbp_has_topics	which includes the meta args below, so we test for this, and then we know we are in a subscription call.	*/	
	if(isset($args['meta_query'][0]['key'] )){			if ($args['meta_query'][0]['key']  == '_bbp_subscription')			return $args ;	}		
	$user_id2 = false;
    if (isset($args['author'])) {
        $user_id2 = bbp_get_user_id($args['author']);
    } elseif (isset($args['meta_query'][0]['value'])) {
        $user_id2 = bbp_get_user_id($args['meta_query'][0]['value']);
    }

	$default_post_parent   = bbp_is_single_forum() ? bbp_get_forum_id() : 'any';
	
	if ($default_post_parent == 'any') {
		if ( bbp_is_user_keymaster()) return $args; 
		$user_id = wp_get_current_user()->ID;
		
		if (user_can( $user_id, 'moderate' ) ) {
		$check=get_user_meta( $user_id, 'private_group',true);
		if ($check=='') return $args;
		}
	
	
	global $wpdb;
	$topic=bbp_get_topic_post_type() ;
	if (empty($user_id2)) {
		$post_ids=$wpdb->get_col("select ID from $wpdb->posts where post_type = '$topic'") ;
	} else {
		$post_ids=$wpdb->get_col("select ID from $wpdb->posts where post_type = '$topic' and post_author = '$user_id2'") ;
	}
	//check this list against those the user is allowed to see, and create a list of valid ones for the wp_query in bbp_has_topics
	$allowed_posts = check_private_groups_topic_ids($post_ids) ;
	if (empty ($allowed_posts))  $allowed_posts[] = -1 ;
    $args['post__in'] = $allowed_posts;	
}
return $args;
}


//the function to check the above !
function check_private_groups_topic_ids($post_ids) {
    
    //Init the Array which will hold our list of allowed posts
    $allowed_posts = array();
    

    //Loop through all the posts
	foreach ( $post_ids as $post_id ) {
		//Get the Forum ID based on Post Type Topic
		$topic=bbp_get_topic_post_type() ;
        $forum_id = private_groups_get_forum_id_from_post_id($post_id, $topic);
		//Check if User has permissions to view this Post ID
		//by calling the function that checks if the user can view this forum, and hence this post
        if (private_groups_can_user_view_post_id($forum_id)  && topic_permissions_check ($post_id)) {
		
            //User can view this post - add it to the allowed array
            array_push($allowed_posts, $post_id);
        }
}
   
    //Return the list		
    return $allowed_posts;
}

