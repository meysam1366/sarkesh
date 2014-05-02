<?php
class core_view{
	private $raintpl;
	
	function __construct(){
		//create an object from raintpl class//
		$this->raintpl = new cls_raintpl;
		
	}
	public function show_core_page($plugins_menu,$content){
		//atteche headers to page//
		$this->raintpl->configure("tpl_dir", "plugins/core/tpl/" );
		$this->raintpl->assign( "page_headers", cls_page::load_headers(false));
		$this->raintpl->assign( "plugins_menu", $plugins_menu);
		$this->raintpl->assign( "main_menu", _('Main Menu'));
		$this->raintpl->assign( "content", $content[1]);
		//set_page_tittle//
		cls_page::set_page_tittle($content[0]);
		cls_page::show_block(true,  'title not show' , $this->raintpl->draw( 'panel', true ), 'NONE');
	
	}
	public function core_menu(){
		$this->raintpl->configure("tpl_dir", "plugins/core/tpl/" );
		$this->cache = $this->raintpl->cache('core_menu', 60);
		if($this->cache){
			return $this->cache;
		}
		else{
			$this->raintpl->assign( "url", cls_general::create_url(array('panel','admin','plugin','core','action','default_core_page')));
			$this->raintpl->assign( "core_menu_label", _('Core Settings') );
			return cls_page::show_block(false,  '' , $this->raintpl->draw( 'core_menu', true), 'NONE');
		}	
	}
	public function show_default_page($view){
		$this->raintpl->configure("tpl_dir", "plugins/core/tpl/" );
		$this->cache = $this->raintpl->cache('main_page', 60);
		if($this->cache){
			return array(_('Default Core Page'), $this->cache);
		}
		else{
			$this->raintpl->assign( "url_regional", cls_general::create_url(array('panel','admin','plugin','language','action','default_core_page')));
			$this->raintpl->assign( "RegionalandLanguages", _('Regional and Languages'));
			
			$this->raintpl->assign( "url_appearance", cls_general::create_url(array('panel','admin','plugin','core','action','appearance')));
			$this->raintpl->assign( "Appearance", _('Appearance'));
			
			$this->raintpl->assign( "url_plugins", cls_general::create_url(array('panel','admin','plugin','core','action','plugins_list')));
			$this->raintpl->assign( "Plugins", _('Plugins'));
			
			$this->raintpl->assign( "url_blocks", cls_general::create_url(array('panel','admin','plugin','block','action','default_core_page')));
			$this->raintpl->assign( "Blocks", _('Blocks'));
			
			$this->raintpl->assign( "url_uap", cls_general::create_url(array('panel','admin','plugin','users','action','default_core_page')));
			$this->raintpl->assign( "Usersandpermissions", _('Users and permissions'));
			
			$this->raintpl->assign( "url_basic", cls_general::create_url(array('panel','admin','plugin','core','action','basic_settings')));
			$this->raintpl->assign( "BasicSettings", _('Basic Settings'));
			return array(_('Default Core Page'), cls_page::show_block(false,  'tittle not show' , $this->raintpl->draw( 'main_page', true), 'NONE'));
		}
	}
	//this function show single content on page without any menus and ect and just show $content that send for this//
	public function show_single_page($content){
		$this->raintpl->configure("tpl_dir", "plugins/core/tpl/" );
		$this->raintpl->assign( "content", $content[1]);
		$this->raintpl->assign( "page_headers", cls_page::load_headers(false));
		return array($content[0], cls_page::show_block(true,  '' , $this->raintpl->draw( 'core_single_page', true), 'NONE'));

	
	}
	//this function show list of plugins//
	public function show_plugins_list($plugins, $view, $show){
		$this->raintpl->configure("tpl_dir", "plugins/core/tpl/" );
		$this->raintpl->assign( "plugins", $plugins);
		$this->raintpl->assign( "label_options", _('Options'));
		$this->raintpl->assign( "label_name", _('Name'));
		$this->raintpl->assign( "label_description", _('Description'));		
		$this->raintpl->assign( "label_version", _('Version'));
		$this->raintpl->assign( "label_author", _('Author'));
		$this->raintpl->assign( "label_Edite", _('Disable'));
		$this->raintpl->assign( "label_Edite_disabled", _('Disable'));
		$this->raintpl->assign( "label_Edite_enable", _('Enable'));
		$this->raintpl->assign( "label_plugins", _('Plugins'));
		$this->raintpl->assign( "label_install", _('Install'));
		return array(_('Plugins'), cls_page::show_block($show,  '' , $this->raintpl->draw( 'core_plugins_list', true), $view));
	
	}
	
	#this function return error message in MODAL VIEW
	public function error_in_operation($show, $e){
		return cls_page::show_block($show,  'Error!' , _('Error occurred in complete your request.<br />reason:' . $e->getMessage()), 'MODAL','danger');
	}
	
	#this function show appearance for select themes and styles
	public function show_appearance($view, $show, $themes){
		$this->raintpl->configure("tpl_dir", "plugins/core/tpl/" );
		$this->raintpl->assign( "label_themes", _('Themes'));
		$this->raintpl->assign( "label_install", _('Install'));
		$this->raintpl->assign( "label_screen", _('Preview'));
		$this->raintpl->assign( "label_name", _('Name'));
		$this->raintpl->assign( "label_author", _('Author'));
		$this->raintpl->assign( "label_options", _('Options'));
		$this->raintpl->assign( "label_enable", _('Enable'));
		$this->raintpl->assign( "label_disable", _('Disable'));
		$this->raintpl->assign( "theme_count", $themes[0]['count']);
		$this->raintpl->assign( "themes", $themes);
		return array(_('Appearcance'), cls_page::show_block($show,  '' , $this->raintpl->draw( 'core_appearance', true), $view));
	}
}
?>