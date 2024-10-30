<?php
/*
	Plugin Name: CleanerPress Professional
	Plugin URI: http://arevico.com/
	Description:  Cleanerpress Professional
	Author: Arevico
	Author URI: http://arevico.com/
	Version: 2.0.1
*/

/* option constants*/
class CleanerPressCNSTD{
	const OPTION_GROUP="cpr_press_arevico-123";
	const OPTION_NAME="cpr_press_arevico-grp";
}

require_once('selective_plugin_dhk.php');

/* Don't include anything not needed on the front end! 	*/
$cpr_arev_opt=get_option(CleanerPressCNSTD::OPTION_NAME);


if (is_admin()){/* the back end */
	require('o_tld.php');
	require('p_options.php');
	require('admin_ajax.php');
	require('cpr_meta_boxes.php');
	//init option pages, option handling
	$cpr_options=new CPOptions();
	$cpr_opt_process = new CP_Option_Process();
	$cpr_adminajax=new CPRAdminAjax();	
	$cpr_metaboxes=new CPRMetaBoxes();
	/* No updates */
	if (!empty($cpr_arev_opt['nopdate'])){
		remove_action( 'load-update-core.php', 'wp_update_plugins' );
		add_filter( 'pre_site_transient_update_plugins', create_function( '$a', "return null;" ) );
	}

} else { /* the font end */
	$cpr_plg_do=new clean_press_plugin_do();
	$cpr_opt_dehooker= new CleanerPressPLGRem();
}
class clean_press_plugin_do{
	var $scripts_headjs,$cpr_arev_opt,$scripts_data;

	function __construct(){
		global $scripts_headjs,$cpr_arev_opt;
		$this->remove_headers();

		if (!empty($cpr_arev_opt['headjs'])){
			$scripts_headjs=array();
			add_action('wp_enqueue_scripts', array(&$this,'extract_scripts'),8999);
			add_action('wp_head', array(&$this,'head_jser'),9009); //higher priority get exectued after the scripts are extracted.
		}
		if (!empty($cpr_arev_opt['style_comb'])){		
			add_action( 'wp_print_styles', array(&$this,'style_extract'),90000 );
		}
		
		/** re-queue - jQuery from CDN*/
		if (!empty($cpr_arev_opt['cdn'])){
			add_action('wp_enqueue_scripts', array(&$this,'jq_cdn'),-99999);
		}

		if (!empty($cpr_arev_opt['stcres'])){
		add_filter( 'script_loader_src',array(&$this,'rmv_vers'), 15, 1 );
		add_filter( 'style_loader_src', array(&$this,'rmv_vers'), 15, 1 );
	}
	}

	

	function jq_cdn(){
			wp_dequeue_script('jquery');
    		wp_deregister_script( 'jquery' );
	    	wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js');
    		wp_enqueue_script( 'jquery' );
	}
	function rmv_vers( $src ){
		$parts = explode( '?', $src );
		return $parts[0];
	}


		function style_extract(){

		global $wp_styles;
		if (!is_array($wp_styles->queue)){return ;}
		$hash=sha1(implode($wp_styles->queue, ''));
		$written=false;

		$lp="";
		preg_match('/(.*?)(\/|)wp-content(\/|)/im', dirname( __FILE__),$lp );
		$lp=realpath($lp[1]) . DIRECTORY_SEPARATOR . 'wp-content' .DIRECTORY_SEPARATOR  ;
		
		if (!file_exists($lp. 'arevico-css-cache' .DIRECTORY_SEPARATOR)){
			mkdir($lp. 'arevico-css-cache' .DIRECTORY_SEPARATOR);
		}
	
		foreach ($wp_styles->queue as $key=>$value) {
		
			if (preg_match('/.*?wp-content(?!.*?\?.*?\.css).*?\.css/im', $wp_styles->registered[$value]->src)){
					$comb_url=dirname($wp_styles->registered[$value]->src);
					$comb_url=preg_replace('/(\\|\/)$/im','',$comb_url);


					$path=preg_replace('/(^.*?wp-content(\/|))|(\?.*)/im', '',$wp_styles->registered[$value]->src );
					$path=realpath($lp . $path );
					$write_path=($lp. 'arevico-css-cache' .DIRECTORY_SEPARATOR . $hash . ".css");
				//	die(($write_path));

				if (((!file_exists($write_path)) || $written) && $path !==false) {
					$re = '/url\s{0,}\(\s{0,}("|\'|)(.*?)("|\'|)\s{0,}\)/im';
					$this->processing=$comb_url; //set the processing url
					$str = preg_replace_callback($re, array(&$this,'urlrewriter') , file_get_contents($path));

					file_put_contents($write_path,$str,FILE_APPEND);
					$written=true;
				}
				if ($path!==false){
					wp_dequeue_style($value);
					wp_deregister_style($value);
				}
				unset($wp_styles->queue[$value]);
			}
		}
		wp_register_style('arevico-combines',content_url('arevico-css-cache/' . $hash . ".css"));	
		wp_enqueue_style('arevico-combines');

	}	

	function urlrewriter($match){
		   				 $url = $match[2];
						  if(preg_match('/^http(s|):\/\/|^data\:|^\\|^\//im', $url))return $match[0]; // return without change

					  return "url(\"" . $this->processing ."/$url\")";
	}


	/**
	 * Extract all the scripts for head.js, dequeue
	 *
	*/
	function extract_scripts(){
		global $wp_scripts,$scripts_headjs,$cpr_arev_opt,$scripts_data;
	
		foreach ($wp_scripts->queue as $sc){
			if (!empty($cpr_arev_opt['headjs_jq']) && strtolower($sc) =='jquery'){

			} else {

			$src=$wp_scripts->registered[$sc]->src;
	
			if ( !preg_match('|^https?://|', $src) && ! ( $this->content_url && 0 === strpos($src, $this->content_url) ) ) {
				$src = get_bloginfo('url') . $src;
			}
				if (!empty($wp_scripts->registered[$sc]->extra['data'])){
					$scripts_data .= ($wp_scripts->registered[$sc]->extra['data']);

				}
				array_push($scripts_headjs,	$src);
				wp_dequeue_script($sc);
				unset($wp_scripts->queue[$sc]);
			}
		}
	}
	
	/**
	 * Remove all headers specified in the global $cpr_arev_opt
	 */

	function remove_headers(){
		global $cpr_arev_opt;
		if (!empty($cpr_arev_opt['feed_links_extra'])){		remove_action( 'wp_head', 'feed_links_extra', 3 );} 
		if (!empty($cpr_arev_opt['feed_links'])){			remove_action( 'wp_head', 'feed_links', 2 ); }
		if (!empty($cpr_arev_opt['rsd_link'])){				remove_action( 'wp_head', 'rsd_link'); }
		if (!empty($cpr_arev_opt['wlwmanifest_link'])){		remove_action( 'wp_head', 'wlwmanifest_link'); }
		if (!empty($cpr_arev_opt['index_rel_link'])){		remove_action( 'wp_head', 'index_rel_link'); }
		if (!empty($cpr_arev_opt['parent_post_rel_link_wp_head'])){remove_action( 'wp_head', 'parent_post_rel_link_wp_head', 10, 0); }
		if (!empty($cpr_arev_opt['adjacent_posts_rel_link_wp_head'])){remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0); }
		if (!empty($cpr_arev_opt['wp_generator'])){			remove_action( 'wp_head', 'wp_generator'); }
		if (!empty($cpr_arev_opt['wp_shortlink_wp_head'])){	remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 ); }
		if (!empty($cpr_arev_opt['start_post_rel_link'])){	remove_action( 'wp_head', 'start_post_rel_link');}

		if (!empty($cpr_arev_opt['adminbar']) && !is_admin() ){
			wp_deregister_script('admin-bar');
			wp_dequeue_script('admin-bar');
			wp_deregister_style('admin-bar');
			remove_action('wp_footer','wp_admin_bar_render',1000);
		}
	}
	
	/*
	 * Output all the extracted scripts.
	 */
	function head_jser(){
	/**  Normally you cannot do this, but we need to add an inlnine script
	 *   Lowest priority ensures script loads AFTER stylesheets
	*/

	/* we still otuput valid XHTML!*/
		global $scripts_headjs,$scripts_data;
		$combined='"' . implode('","',array_values($scripts_headjs)) . '"'	;
		echo(sprintf("%s<script src='%s' type='text/javascript'></script><script type='text/javascript'><![CDATA[\r\n head.js(%s);\r\n]]></script>"
			,(empty($scripts_data) ? '' : "<script type=\"text/javascript\">//<![CDATA[\r\n".$scripts_data."\r\n//]]></script>"),plugins_url('front/head.min.js',__FILE__),$combined));
	}

}/** End Class*/	

?>