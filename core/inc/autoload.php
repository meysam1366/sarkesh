<?php

//this function load class, plugins and ...
function __autoload($class_name){
	$Seperated = explode('\\',$class_name);
	if($Seperated[0] == 'core' && $Seperated[1] == 'plugin'){
		
		if(max(array_keys($Seperated)) == 2){
			require_once(AppPath . 'plugins/system/'  . $Seperated[2] . '/controller.php');
		}
		elseif(max(array_keys($Seperated)) == 3){
			
			require_once(AppPath . 'plugins/system/'  . $Seperated[2] . '/' . $Seperated[3] . '.php');
		}
	}
	elseif($Seperated[0] == 'addon' && $Seperated[1] == 'plugin'){
		if(max(array_keys($Seperated)) == 2){
			require_once(AppPath . 'plugins/defined/'  . $Seperated[2] . '/controller.php');
		}
		elseif(max(array_keys($Seperated)) == 3){
			
			require_once(AppPath . 'plugins/defined/'  . $Seperated[2] . '/' . $Seperated[3] . '.php');
		}
	}
	elseif($Seperated[0] == 'core' && $Seperated[1] == 'control'){
		//going to include control
		if(max(array_keys($Seperated)) == 2){
			require_once(AppPath . 'core/lib/controls/'  . $Seperated[2] . '/controller.php');
		}
		elseif(max(array_keys($Seperated)) == 3){
			
			require_once(AppPath . 'core/lib/controls/'  . $Seperated[2] . '/' . $Seperated[3] . '.php');
		}
		
	}
	
	//add theme classes
	if($Seperated[0] == 'theme'){
		require_once(AppPath . 'themes/'  . $Seperated[1] . '/info.php');
	}
	else{
		//going to include some other
		$class_name = str_replace('\\','_',$class_name);
		if(file_exists(AppPath . 'core/lib/cls/' . $class_name . '.php')){
			require_once(AppPath . 'core/lib/cls/' . $class_name . '.php');
		}
	}
}


?>
