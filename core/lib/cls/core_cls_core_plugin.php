<?php
	namespace core\cls\core;
	use \core\cls\db as db;
	use core\cls\patterns as patterns;
	//this class controll plugins
	class plugin{
		use patterns\singleton;
		private $db;
		
		function __construct(){
		
			$this->db = db\mysql::singleton();
		}
		
		// if plugin enabled this function return true and else return false
		public function is_enabled($plugin_name){
			$this->db->do_query("SELECT * FROM plugins WHERE enable = '1' and name = ?;" , array($plugin_name));
			if($this->db->rows_count() != 0){
				//plugin is enable
				return true;
				
			}
			// if plugin not enable it mean disabled 
			return false;
		}
		
		//this function install plugin
		// first we get plugin from server (zip) and then uncompress that.
		//step 2 : install sql file
		//step 3 : update plugins table
		public function install($plugin_name){
			
		}
		
		//this function disable plugin from database
		public function disable($plugin_name){
		
			$this->db->do_query("UPDATE SET state = '0' WHERE name = ?" , array($plugin_name));
			
		}
		
		//this function get plugin from server and extract that on plugins folder
		public function download($plugin_name){
		$net = new \network\network;
		$file_adr = $net->download(PluginsCenter . $plugin_name . '/latest.zip');
		$zip = new \archive\zip($file_adr);
		$zip->extract('plugins');
		
		}
	
	}

?>
