<?php
class CP_Option_Process{
	/**
	 * Constructor
	 */
	/** All option pages, require frst than make class */
	var $options;

	const PAGE_TITLE="CleanerPress";
	const MENU_TITLE="CleanerPress";
	const MENU_SLUG="cleaner-press-options";
	

	function __construct(){
		if (isset($_GET['page'])) {
		add_action( 'admin_enqueue_scripts',array(&$this,'adm_init') );
		}
		add_action('admin_menu',array(&$this,'add_pages'));


	}

	function add_pages(){
		global $cpr_options;
		add_menu_page( self::PAGE_TITLE, self::MENU_TITLE, 'administrator', self::MENU_SLUG,array(&$this,'do_top_level_menu'));
		add_submenu_page(self::MENU_SLUG, "General Settings", "General Settings", 'administrator', self::MENU_SLUG . '-settings', array(&$cpr_options,'generate_form') );

	}

	/** param $val1 the value to be checked
	  * param $val2 the value to be checked too;
	  * $val1 can be null, $val2 cant be null
	  */
	public function is_checked($val1,$val2,$nullishit=false){
		if ($nullishit && empty($val1)){
			return 'checked="checked"';
		} else {
			return (!empty($val1) && !empty($val2) && $val2==$val1) ? 'checked="checked"' : '';
		}
	} 


	function adm_init() {
		if (!empty($_GET['page']) && $_GET['page']=="cleaner-press-options-settings"){
		wp_enqueue_script( 'adm_form_val', plugins_url('/admin/form_validate.js', __FILE__) );
		wp_enqueue_script( 'jsqueries', plugins_url('/admin/queries.js', __FILE__) );
		wp_enqueue_script( 'sltab', plugins_url('/admin/tabs.js', __FILE__) );
		wp_enqueue_style( 'sltab_cc', plugins_url('/admin/tab.css', __FILE__) );
	}
	}
	function do_top_level_menu(){?>
<div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div><h2>Arevico CleanerPress Resources</h2>
			<ul style="list-style-type:decimal;padding-left: 5px;margin-left: 50px;">
				<li><a href="http://arevico.com/main-support/" />Contact us for feedback/support:</a></li><br />			
				<li><a href="http://arevico.com/f-a-q-cleaner-press/" />Frequently Asked Questions:</a></li><br />
				<li><a href="http://facebook.com/Arevico" />Share / Find us on Facebook:</a></li><br />		
			</ul>
			<div style="background-color:#F7F7FF;border: 1px solid #DDDDDD;padding: 10px;"><b>Note:</b> do not use in conjunction with other minification plugins (caching like hyper cache or super cache <b>is fine!</b>.</div>
	</div>
	<?php }
}

?>