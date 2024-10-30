<?php
class CPRMetaBoxes{

	function __construct(){
		add_action('add_meta_boxes', array($this,'mb_load'), 10, 1);
		add_action( 'save_post', array(&$this,'mb_save') ); 
	}

	function mb_load() {
     /* add_meta_box( $id, $title, $callback, $page, $context, $priority, $callback_args );  */
		add_meta_box( 'arevico-mb-cprpress-1', "Load Plugins?", array(&$this,'render_mb'),'post', 'normal', 'high'  ); 
		add_meta_box( 'arevico-mb-cprpress-1', "Load Plugins?", array(&$this,'render_mb'),'page', 'normal', 'high'  ); 
	
	}

	function render_mb($post ){
		
		$values = get_post_meta( $post->ID ,'cpr_mtb_plg',true);  
	    wp_nonce_field( 'arevico-mb-cprpress-1', 'arevico-mb-cprpress-1' ); 
	    $plgs=get_plugins();
		foreach ( $plgs as $key => $plg) {
				$ka=preg_replace('/\/.*/im', '', $key);				
				$base=preg_replace('/\/.*/im', '',plugin_basename(__FILE__));
			if (is_plugin_active($key) && $ka !=$base){
				echo(sprintf('<strong>%1$s</strong><br /><input type="radio" name="cpr_mtb_plg[%2$s]" value="1" %3$s /> Default <input type="radio" value="2" name="cpr_mtb_plg[%2$s]" %4$s /> Never <input type="radio" name="cpr_mtb_plg[%2$s]" value="3" %5$s /> Always <br /><br />',$plg['Name'],$ka,
					CP_Option_Process::is_checked($values[$ka],'1',true),
					CP_Option_Process::is_checked($values[$ka],'2',false),
					CP_Option_Process::is_checked($values[$ka],'3',false)
					));
			}

		}
	
	}  
	
	function mb_save($post_id){

		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
    // if our nonce isn't there, or we can't verify it, bail 
	    if( !isset( $_POST['arevico-mb-cprpress-1'] ) || !wp_verify_nonce( $_POST['arevico-mb-cprpress-1'], 'arevico-mb-cprpress-1' ) ) return; 
    // if our current user can't edit this post, bail  
    if( !current_user_can( 'edit_post' ) && !current_user_can( 'edit_page' )) return;  
		

	    if( isset( $_POST['cpr_mtb_plg'] ) ){
	    	update_post_meta( $post_id, 'cpr_mtb_plg',  $_POST['cpr_mtb_plg'] );  
		}
    }



}




?>