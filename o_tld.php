<?php
class CPOptions{

	private $opt_defaults;
	
	

	function __construct(){
			add_action('admin_init', array(&$this,'option_init'));
	}

	function option_init(){
		register_setting( CleanerPressCNSTD::OPTION_GROUP, CleanerPressCNSTD::OPTION_NAME,array(&$this,'options_val'));
	}

function options_val($input) {
	return $input;
}

// AV are the array values, since we are going to use this so often, i'l; abbreviate them to av.
function generate_form(){	
	
?>
	<div class="wrap">
		<style>
		#setting-error-settings_updated{display:none;}
		</style>
		<div style="background-color: #F7F7FF;border: 1px solid #DDDDDD;padding: 10px;">
			 <strong>Receive Free WordPress Plugin Recommendations and Business Tips:</strong><br />
			<form method="post" target="_blank" action="http://arevico.us2.list-manage1.com/subscribe/post?u=e23c318ca9665b7616c745ccb&id=b621dd3a4d" style="padding-top:5px;" id="arvsubsribe"><input name="EMAIL" type="text" value="<?php echo(get_bloginfo('admin_email')); ?>"><input type="submit" value="subscribe">
				</form>
			you can unsubcribe whenever you wish, we dont rent or sell your information.
    <div style="clear:both;"></div>
</div>

			<div id="icon-options-general" class="icon32"><br /></div><h2>General Settings</h2>
			<?php if (isset($_GET['settings-updated'])){
				print_r('<div style="background: #F2F3F6;border: 1px solid #7E8AA2; margin: 0;
    padding: 5px;">Settings Updated!</div>');
			} elseif (isset($_GET['clearcsscache'])) {

			$lp=realpath($lp[1]) . DIRECTORY_SEPARATOR . 'wp-content' .DIRECTORY_SEPARATOR  ;
		if (!file_exists($lp. 'arevico-css-cache' .DIRECTORY_SEPARATOR)){
				$files = glob($lp. 'arevico-css-cache' .DIRECTORY_SEPARATOR . '*'); // get all file names
				foreach($files as $file){ // iterate files
				  if(is_file($file))
			    unlink($file); // delete file
				}

		}

					print_r('<div style="background: #F2F3F6;border: 1px solid #7E8AA2; margin: 0;
    padding: 5px;">CSS Cache Cleared! Don\'t forget to clear any other caching plugin you may use, to clear references to the static css files.</div>');
			}



			?>
			<br />
	<form method="POST" action="options.php">
		<?php 
		/** Abreviate option name to $on, as we are going to use it A LOT!*/

		$on=(CleanerPressCNSTD::OPTION_NAME);
		$o=get_option($on,array());


		settings_fields(CleanerPressCNSTD::OPTION_GROUP); ?>
	<div class="tabbed">
		<div class="slheadcontainer"><a class="sltabhead">1: Headers</a> <a class="sltabhead">2: Scripts</a> <a class="sltabhead">3: Plugins</a> <a class="sltabhead">4: Extra</a>
		</div>

	<div class="sltab">

		<span class="lblwide ilb"><b>Feeds</b></span>
		<span class="lblmiddle ilb">
			<input type="checkbox" value="1" name="<?php echo($on); ?>[feed_links_extra]" <?php echo( (empty($o['feed_links_extra']) ? '' : 'checked="checked" ')); ?>/> Removes links to extra feeds such as category feeds.<br />
			<input type="checkbox" value="1" name="<?php echo($on); ?>[feed_links]" <?php echo( (empty($o['feed_links']) ? '' : 'checked="checked" '));?>/> Removes links to the general feeds.<br />
			<input type="checkbox" value="1" name="<?php echo($on); ?>[rsd_link]" <?php echo( (empty($o['rsd_link']) ? '' : 'checked="checked" '));?>/> Removes links to Really Simple Discovery service endpoint.<br />
		</span><br /><br />
		<span class="lblwide ilb"><b>Admin Bar</b></span>
		<span class="lblmiddle ilb">
			<input type="checkbox" value="1" name="<?php echo($on); ?>[adminbar]" <?php echo( (empty($o['adminbar']) ? '' : 'checked="checked" ')); ?>/> Disable admin bar.<br />

		</span>

		<br /><br />
		<span class="lblwide ilb"><b>Links</b></span>
		<span class="lblmiddle ilb">
			<input type="checkbox" value="1" name="<?php echo($on); ?>[wlwmanifest_link]" <?php echo( (empty($o['wlwmanifest_link']) ? '' : 'checked="checked" '));?>/> Remove link to Windows Live Writer.<br />
			<input type="checkbox" value="1" name="<?php echo($on); ?>[index_rel_link]" <?php echo( (empty($o['index_rel_link']) ? '' : 'checked="checked" '));?>/> Remove the index link.<br />
			<input type="checkbox" value="1" name="<?php echo($on); ?>[parent_post_rel_link_wp_head]" <?php echo( (empty($o['parent_post_rel_link_wp_head']) ? '' : 'checked="checked" '));?>/> Removes the prev link<br />
			<input type="checkbox" value="1" name="<?php echo($on); ?>[adjacent_posts_rel_link_wp_head]" <?php echo( (empty($o['adjacent_posts_rel_link_wp_head']) ? '' : 'checked="checked" '));?>/> Removes the relational links for the posts adjacent to the current post.<br />
			<input type="checkbox" value="1" name="<?php echo($on); ?>[wp_generator]" <?php echo( (empty($o['wp_generator']) ? '' : 'checked="checked" '));?>/> Removes the WordPress Version Information.<br />

		</span>
<br /><br />
			<span class="lblwide ilb"><b>Shortlink</b></span>
		<span class="lblmiddle ilb">
			<input type="checkbox" value="1" name="<?php echo($on); ?>[wp_shortlink_wp_head]" <?php echo( (empty($o['wp_shortlink_wp_head']) ? '' : 'checked="checked" '));?>/> Disable Wordpress Shortlink.<br />
		</span>
		<br />


		</div>

	<div class="sltab">

		<span class="lblwide ilb"><b>CDN</b></span>
		<span class="lblmiddle ilb">
			<input type="checkbox" name="<?php echo($on); ?>[cdn]" <?php echo( (empty($o['cdn']) ? '' : 'checked="checked" '));?>/> Load jQuery from Google CDN.<br />
		</span><br /> <br />

	<span class="lblwide ilb"><b>Head.js</b></span>
			<span class="lblmiddle ilb">
			<input type="checkbox" value="1" name="<?php echo($on); ?>[headjs]"  <?php echo( (empty($o['headjs']) ? '' : 'checked="checked" '));?>/> Load scripts non-blocking with head.js (breaks inline scripts)	.<br />
			<input type="checkbox" value="1" name="<?php echo($on); ?>[headjs_jq]"  <?php echo( (empty($o['headjs_jq']) ? '' : 'checked="checked" '));?>/> Exclude jQuery from headjs.<br />
		</span>
		<br />

		<span class="lblwide ilb"><b>CSS</b></span>
			<span class="lblmiddle ilb">
			<input type="checkbox" value="1" name="<?php echo($on); ?>[style_comb]"  <?php echo( (empty($o['style_comb']) ? '' : 'checked="checked" '));?>/> Enable Combining and Caching Stylesheets.<br />
				
			</span>

	</div>
	
<div class="sltab">

		<?php
		   global $wpdb,$wp_query;
	      $dbpref = $wpdb->prefix;
	      $nonce=wp_create_nonce('cpr_nonce'); 
		$plgs=get_plugins();

			foreach ( $plgs as $key => $plg) {
				$ka=preg_replace('/\/.*/im', '', $key);				
				$base=preg_replace('/\/.*/im', '',plugin_basename(__FILE__));
			if (is_plugin_active($key) && $ka !=$base){
				/** KA is the adjusted key. the dir rootname of the plugin */
				echo(sprintf('<span class="lblwide ilb"><b>%s</b></span><span class="lblmiddle ilb">%s</span><br /><br />',$plg['Name'],
					
					'<input type="radio" name="' .$on .'[dhk][' . $ka.'][c]" value="1" '. CP_Option_Process::is_checked($o['dhk'][$ka]['c'],'1',true) . ' /> Load Always 
					 <input type="radio" name="' .$on .'[dhk]['. $ka.'][c]" value="2" '. CP_Option_Process::is_checked($o['dhk'][$ka]['c'],'2') . '/> Only on urls containing (one per line)
					 <br />
					 <textarea name="' . $on .'[dhk][' . $ka.'][val]">'.htmlentities( (!empty($o['dhk'][$ka]['val']))  ? $o['dhk'][$ka]['val'] : '') . '</textarea><br />
					 <strong>Disable on the following items</strong><br />
					<input type="checkbox" name="' .$on .'[dhk]['. $ka.'][mobile]" value="1" '. CP_Option_Process::is_checked($o['dhk'][$ka]['mobile'],'1') . '/>Mobile Devices 
						 <input type="checkbox" name="' .$on .'[dhk]['. $ka.'][homepage]" value="1" '. CP_Option_Process::is_checked($o['dhk'][$ka]['homepage'],'1') . '/>Homepage
					<input type="checkbox" name="' .$on .'[dhk]['. $ka.'][Archives]" value="1" '. CP_Option_Process::is_checked($o['dhk'][$ka]['Archives'],'1') . '/>Archives				
					<input type="checkbox" name="' .$on .'[dhk]['. $ka.'][Posts]" value="1" '. CP_Option_Process::is_checked($o['dhk'][$ka]['Posts'],'1') . '/>Posts
					<input type="checkbox" name="' .$on .'[dhk]['. $ka.'][Pages]" value="1" '. CP_Option_Process::is_checked($o['dhk'][$ka]['Pages'],'1') . '/>Pages<br />
					

					<input type="checkbox" name="' .$on .'[dhk]['. $ka.'][404]" value="1" '. CP_Option_Process::is_checked($o['dhk'][$ka]['404'],'1') . '/> 404

					<input type="checkbox" name="' .$on .'[dhk]['. $ka.'][search]" value="1" '. CP_Option_Process::is_checked($o['dhk'][$ka]['search'],'1') . '/> search

					<input type="checkbox" name="' .$on .'[dhk]['. $ka.'][search]" value="1" '. CP_Option_Process::is_checked($o['dhk'][$ka]['feed'],'1') . '/> Feed


					 <br />
					' ) 
					);
			}
			}

		?>

</div>

<div class="sltab">
		<span class="lblwide ilb"><b>Static Resource</b></span>
			<span class="lblmiddle ilb">
			<input type="checkbox" value="1" name="<?php echo($on); ?>[stcres]"  <?php echo( (empty($o['stcres']) ? '' : 'checked="checked" '));?>/> Remove Query String.<br />
			</span><br />
			<span class="lblwide ilb"><b> Updates</b></span>
			<span class="lblmiddle ilb">
			<input type="checkbox" value="1" name="<?php echo($on); ?>[nopdate]"  <?php echo( (empty($o['nopdate']) ? '' : 'checked="checked" '));?>/> Don't check for updates.<br />
			</span>
<br /></br />
			<span class="lblwide ilb"><b>Queries</b></span>
			<span class="lblmiddle ilb aalig"><b>NOTE: The following actions interact with the wordpress database directly.<br /> 
				It's adviseable to make a backup before starting.</b> <br />
				<br/>

				<a href="#" onclick='exec_queries("1","<?php echo($nonce); ?>");return false;'>Repair and Optimize Tables</a><br /><br />
				<a href="#" onclick='exec_queries("2","<?php echo($nonce); ?>");return false;'>Deleting All Spam Comments</a><br />
				<a href="#" onclick='exec_queries("3","<?php echo($nonce); ?>");return false;'>Deleting All Unapproved Comments</a><br />
				<a href="#" onclick='exec_queries("4","<?php echo($nonce); ?>");return false;'>Delete All Comments</a><br /><br />

				<a href="#" onclick='exec_queries("5","<?php echo($nonce); ?>");return false;'>Delete All Post Revisions</a><br />
				<a href="#" onclick='exec_queries("6","<?php echo($nonce); ?>");return false;'>Delete Redundant / Orphaned Post Meta Data</a><br />
				<a href="#" onclick='exec_queries("7","<?php echo($nonce); ?>");return false;'>Delete Redundant Tags</a><br />
	
			</span>
									
</div>
<div class="slheadcontainer"></div>
&nbsp;
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" style="width:70px;margin-left:380px;" />
</form>

</div>

</div>
<?php }

}//END OF CLASS
?>