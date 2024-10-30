function wpf($posts){
global $shortcode_tags,$wp_filter,$wp_action,$plugins_loaded;
	$sc_paths=array();
	
	foreach ($shortcode_tags as $k=>$sc){
	$sd=get_base($sc);

	if ($sd!=null && (!in_array($sd,$sc_paths))){
		$sc_paths[$k]=$sd;
		}
	}
	check_for_shortcode($sc_paths,$posts);



	foreach ($wp_filter as $k1=>&$f){
		foreach ($f as $k2=>&$prio){
				foreach ($prio as $k3=>&$hook){
					//var_dump($hook);
					$l=get_base($hook['function']);
						if (in_array($l,array_values($sc_paths))){
							unset($wp_filter[$k1][$k2][$k3]);
						}
					}

		}
	}

	
	return $posts;	
	}

 function get_base($thing){
	$lret=null;
	$repcount=0;
	try {
	$refFunction = (is_string($thing)) ? new \ReflectionFunction($thing) : new \ReflectionClass($thing[0]) ;
	$lret=preg_replace('/.*wp-content[\\\|\\/]plugins[\\\|\\/]/i','',$refFunction->getFilename(),1,$repcount);
	} catch (Exception $e){
		return null;
	}
	if ($repcount<=0){return null;}
	$lret=preg_replace('/[\\\|\\/].*/i','',$lret);
	return $lret;
 }


function check_for_shortcode(&$shorts,&$posts) {
    if ( empty($posts) )
        return;
    foreach ($posts as &$ps) {			
			foreach ($shorts as $key=>$s){
			if (stripos($ps->post_content , '[' . $key)>0){
				unset($shorts[$key]);print_r('>11');
			}
		}
	}
 } 