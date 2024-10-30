<?php
class CPRAdminAjax{

function __construct(){
		add_action('wp_ajax_cpr_exec_query', array(&$this,'queries'));
	}

/** Execute clean-up queries, if you have the privilege*/
function queries() {
	global $wpdb; // this is how you get access to the database
	/** Prepare optimize statements*/


				/*= == = = = = = =  Check wchich query to execute = == = = = = = = */
	if (is_admin() && !empty($_POST['cpr_nonce']) && wp_verify_nonce($_POST['cpr_nonce'],"cpr_nonce")>0){
		/** seems valid!, only a priviledged administrator can execute queries.*/
			if (!empty($_POST['query'])){
				/* Normally you should escpae post data, 1 we are 100% sure it is correct and unmodifyable by
				any user other than the admin */
		
				/* _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ */
				if (!isset($_POST['query']) || !is_numeric($_POST['query'])){
				die();
				}	
				switch ($_POST['query']) {
					
					case '1': /* Optimize ? Repair tables */
						/** Set execution time limit, because optimizing CAN take long*/
						set_time_limit(60*60*9); 
						/** Repair all database tables */
						$tables=$wpdb->get_results("SHOW TABLES;",ARRAY_N);
						$lret=$wpdb->num_rows;

						foreach ($tables as $value) {
							$wpdb->query("OPTIMIZE TABLE " . $value[0]. ';');
						}
						die("$lret Tables Repaired and Optimized!");
						break;

					case '2': /** Delete Spam comments*/
					$lret=$wpdb->query("DELETE from " .$wpdb->prefix ."comments WHERE comment_approved = 'spam';");
					die("$lret Spam Comments Cleared!");
					break ;

					case '3':/** Delete Unapproved comments*/
						$lret=$wpdb->query("DELETE from " .$wpdb->prefix ."comments WHERE comment_approved = '0';");
						die("$lret Unapproved Comments Cleared!");
						break ;

					case '4':/** Delete all comments*/
						$lret=$wpdb->query("DELETE from " .$wpdb->prefix ."comments;");
						die("$lret Comments Cleared!");
						break ;

					case '5':/** Delete all revisions*/
						$lret=$wpdb->query("DELETE FROM " .$wpdb->prefix ."posts WHERE post_type = 'revision';");
						die("$lret Post Revisions Cleared!");
						break ;

						case '6' : /** Delete Post Meta data*/
						$lret=$wpdb->query("DELETE pm FROM ".$wpdb->prefix ."postmeta pm LEFT JOIN ".$wpdb->prefix ."posts wp ON wp.ID = pm.post_id WHERE wp.ID IS NULL ");
						die("$lret Pieces of meta data affected!");
						break;

						case '7' :
						$lret=$wpdb->query("DELETE a,c FROM $wpdb->terms AS a LEFT JOIN $wpdb->term_taxonomy AS c ON a.term_id = c.term_id LEFT JOIN $wpdb->term_relationships AS b ON b.term_taxonomy_id = c.term_taxonomy_id WHERE (c.taxonomy = 'post_tag' AND c.count = 0)");
						die("$lret Tags removed!");
						break;

					
				}

		
				if ($lret===false){die( $wpdb->last_error);}
			}
		die();/** Required */
	}
}

}

