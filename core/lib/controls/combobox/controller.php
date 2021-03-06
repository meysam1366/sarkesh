<?php
namespace core\control;
use \core\control as control;
/*
	this class is a control for working with buttones toggle buttons
	
*/
class combobox extends control\combobox\module{
	
	#$name use to access this class on the page
	
	private $config;
		
	function __construct($name=''){
		parent::__construct();
		if($name!=''){
			$this->config['NAME'] = $name;
		}
		else{
			$this->config['NAME'] = 'ctr_combobox';
		}
		//this config show abow of element
		$this->config['LABEL'] = 'combobox';
		
		//this config show below of element
		$this->config['HELP'] = '';
		
		//this config is for show width of element and most be between 1 and 12
		$this->config['SIZE'] = '6';
		
		//this config use for show 1d array
		$this->config['SOURCE'] = [];
		
		//this config for set table for show
		//table is 2d array
		$this->config['TABLE'] = '';
		
		//This config set coloum value of table config for bind
		$this->config['COLUMN_VALUES'] = '';
		
		//This config set coloum name of table config for bind
		$this->config['COLUMN_LABELS'] = '';
		
		//if enable this config control perpare for showing in inline mode
		$this->config['INLINE'] = false;
		
		$this->config['FORM'] = 'DEFAULT_FORM_NAME';
		//this config is for set value for element
		
		$this->config['BS_CONTROL'] = TRUE;
		//this config is for set value for element
		
		$this->config['VALUE'] = '';
		
		$this->config['DISABLE'] = FALSE;
		//this config use for attech javascript(js) file to header of page
		
		$this->config['SCRIPT_SRC'] = '';
		
		//This config for use add css classes to control//
		$this->config['CLASS'] = '';
		
		//THIS config set css file for paste to headet of page
		$this->config['CSS_FILE'] = '';
		
		//this config add inline css style to html element
		$this->config['STYLE'] = '';
		
		//------------------------------------------------------
		//this configs set php plugin and function that should run with ONCHANGE event//
		
		$this->config['P_ONCHANGE_PLUGIN'] = '0';
		$this->config['P_ONCHANGE_FUNCTION'] = '0';
		//This configs set javascript function and src for run with ONCHANGE event//
		
		$this->config['J_ONCHANGE'] = '0';
		//it's can get all data from returned from php Argoman $arg['RV']['value']
		$this->config['J_AFTER_ONCHANGE'] = '0';
		
		//with this config you can select index by default in combobox
		$this->config['SELECTED_INDEX'] = 0;
	}
	
	//this function configure control//
	public function configure($key, $value){
		// checking for that key is exists//
		if(key_exists($key, $this->config)){		
			$this->config[$key] = $value;
			return TRUE;
		}
		//key not exists//
		return FALSE;
	}
	public function draw($show = false){
		return $this->module_draw($this->config, $show);
	}
	
	public function get($key){
		if(key_exists($key, $this->config)){
			return $this->config[$key];
		}
		die('Index is out of range');
	}
}
?>
