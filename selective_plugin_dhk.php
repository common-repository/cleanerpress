<?php
/**
  * This class makes sure that all plugins are loaded as defined in the options
  */
class CleanerPressPLGRem{

 function __construct(){
 		add_action('init', array(&$this,'dehook'),-99999);
 }

	public function dehook(){
			global $cpr_arev_opt,$wp_filter,$wp_query;
		    $url = ( (empty($_SERVER['HTTPS'])) ? "http://" : 'https://') .$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

			$mid = url_to_postid( $url );
			 $md = get_post_meta( $mid ,'cpr_mtb_plg',true);  
		
			$toberemoved=array();
			if (empty($cpr_arev_opt['dhk'])){return;}

			require_once('browser_detect.php');
			$browser_detect=new CCPRDDetectMobile();
			/** Check which plugins should be dehooked: */

			foreach ($cpr_arev_opt['dhk'] as $key=>$plg){
				/*
				 * Remove if plugin data matches the page its on
				*/
				if ($browser_detect->BrowserCheck() && (!empty($plg['mobile']) ))
				{
					array_push($toberemoved, $key);
		
				} else if ( (!empty($plg['c']) && $plg['c']=='2' ) && $this->array_match(preg_split('/(\\r|\\n)/mi', $plg['val']),$url)) {
					/* don't remove */

				} else if (empty($plg['c']) || $plg['c']=='1'){
					/* don't remove */	
				} else if ( 
				((is_home() || is_front_page()) && !empty($plg['homepage'])) ||
				(is_archive() && !empty($plg['Archives'])) ||
				(is_single() && !empty($plg['Posts'])) ||
				(is_404() && !empty($plg['404'])) ||
				(is_search() && !empty($plg['search'])) ||
				(is_feed() && !empty($plg['feed']))
				)
				{ 
					array_push($toberemoved, $key);

				} else {
					/* remove */
					array_push($toberemoved, $key);
				}
			}
			$browser_detect=null;
			/** Remove Hooks*/

			
		/** check the meta data to modify the array*/

		$meta_rem=array();

		if (!empty($md) && is_array($md)){
			/*  */
			foreach ($md as $key => $value) {
				
				if ($value=='2'){
					array_push($toberemoved,$key);					
				}
				if ($value=='3'){
					array_push($meta_rem,$key);
				}
			}
	
		}
		/*____________________________________*/

		foreach ($wp_filter as $k1=>$f){
			foreach ($f as $k2=>$prio){
				foreach ($prio as $k3=>$hook){
					//var_dump($hook);
					$l=$this->get_base($hook['function']);
						if ($l!=null && in_array($l,array_values($toberemoved))){
							unset($wp_filter[$k1][$k2][$k3]);
						}
					}

			}
	}
	}

	/**
	 * Matches a string against multiple items.
	 * Return true if one ore more items in the array are matched.
	 *
	 */
	function array_match($arr_needles,$str){
		$str=strtolower($str);
		if (empty($arr_needles) || empty ($str) || !is_array($arr_needles)){return false;}
		foreach ($arr_needles as &$ndl) {
			if ((!empty($ndl) )  && strpos($str, $ndl)>-1){return true;}
		}
		return false;
	}


	/**
	  * Return base dir of all wordpress functions encountered
	  */
	private function get_base($path){
		$lret=null;
		$repcount=0;

	try {
			$refFunction = (is_string($path)) ? new \ReflectionFunction($path) : new \ReflectionClass($path[0]) ;
			$lret=preg_replace('/.*wp-content[\\\|\\/]plugins[\\\|\\/]/i','',$refFunction->getFilename(),1,$repcount);
		} catch (Exception $e){
			return null;
		}
	
	if ($repcount<=0){return null;}
		$lret=preg_replace('/[\\\|\\/].*/i','',$lret);
		return $lret;
 	}


} /* END CLASS */
?>