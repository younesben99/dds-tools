<?php

include(__DIR__."/../../../wp-load.php");

function duplicate($post_id,$merk,$parentid){
	global $wpdb;
 

	/*
	 * and all the original post data then
	 */
	$post = get_post( $post_id );
 
	/*
	 * if you don't want current user to be the new post author,
	 * then change next couple of lines to this: $new_post_author = $post->post_author;
	 */
	$current_user = wp_get_current_user();
	$new_post_author = $current_user->ID;
 
	/*
	 * if post data exists, create the post duplicate
	 */
	if (isset( $post ) && $post != null) {
 
		/*
		 * new post data array
		 */
		$args = array(
			'comment_status' => $post->comment_status,
			'ping_status'    => $post->ping_status,
			'post_author'    => $new_post_author,
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_name'      => $merk,
			'post_parent'    => $parentid,
			'post_password'  => $post->post_password,
			'post_status'    => 'publish',
			'post_title'     => $post->post_title . " | " . $merk,
			'post_type'      => $post->post_type,
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order,
      'meta_input'        => array( 
        'autoverkopen_merk' => $merk
    )
		);
 
		/*
		 * insert the post by wp_insert_post() function
		 */
		$new_post_id = wp_insert_post( $args );
    
		/*
		 * get all current post terms ad set them to the new post draft
		 */
		$taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
		foreach ($taxonomies as $taxonomy) {
			$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
			wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
		}
 
		/*
		 * duplicate all post meta just in two SQL queries
		 */
		$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
		if (count($post_meta_infos)!=0) {
			$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
			foreach ($post_meta_infos as $meta_info) {
				$meta_key = $meta_info->meta_key;
				$meta_value = addslashes($meta_info->meta_value);
				$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
			}
			$sql_query.= implode(" UNION ALL ", $sql_query_sel);
			$wpdb->query($sql_query);
		}
    
 
	} else {
		wp_die('Post creation failed, could not find original post: ' . $post_id);
	}
}
if(isset($_POST["dds_id"])){

  $merkenjson = file_get_contents(__DIR__."/merken.json");

  $merkenarray = json_decode( $merkenjson, true );
  
  $merken = array();
  
  foreach ($merkenarray as $value) {
    array_push($merken,$value["name"]);
  }
  
  for ($i=0; $i < count($merken); $i++) { 
    
    duplicate($_POST["dds_id"],$merken[$i],$_POST["dds_id"]);
    $args = array(
      'post_type' => 'post',
      'numberposts' => -1
  );
  $all_posts = get_posts($args);
  foreach ($all_posts as $single_post){
      wp_update_post( $single_post );
  }
  }
}

?>
<form method="post" action="">
<input type="text" name="dds_id" />
</form>

<?php

 ?>