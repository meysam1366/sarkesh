<?php
namespace core\control\uploader;
use \core\cls\template as template;
use \core\cls\browser as browser;
class view{
	
	private $raintpl;
	private $page;
	function __construct(){
		
		$this->raintpl = new template\raintpl;
		$this->page = new browser\page;
	}
	
	//this function draw control
	protected function view_draw($config){
		//configure raintpl //
		$this->raintpl->configure('tpl_dir','core/lib/controls/uploader/');
		
		//add headers to page//
		browser\page::add_header('<script src="./core/ect/scripts/events/functions.js"></script>');		
		browser\page::add_header('<script src="./core/lib/controls/uploader/fileinput.min.js"></script>');
		browser\page::add_header('<script src="./core/lib/controls/uploader/ctr_uploader.js"></script>');
		browser\page::add_header('<link rel="stylesheet" type="text/css" href="./core/lib/controls/uploader/fileinput.min.css" />');
		
		if($config['SCRIPT_SRC'] != ''){browser\page::add_header('<script src="' . $config['SCRIPT_SRC'] . '"></script>'); }		
		if($config['CSS_FILE'] != ''){ browser\page::add_header('<link rel="stylesheet" type="text/css" href="' . $config['CSS_FILE']) . '" />';}
		
		//labels
		$this->raintpl->assign( "browse_label", _('Browse ...'));
		$this->raintpl->assign( "upload_label", _('Upload'));
		$this->raintpl->assign( "remove_label", _('Remove'));

		$this->raintpl->assign( "file_system_id", $config['FILE_SYSTEM_ID']);
		$this->raintpl->assign( "file_extensions", $config['FILE_TYPES']);
		
		$this->raintpl->assign( "size", $config['SIZE']);
		$this->raintpl->assign( "msgSizeTooLarge", sprintf(_('File % is too large.max file size is:%s'),'{name}','{maxSize}'));
		$this->raintpl->assign( "msgInvalidFileExtension", sprintf(_('Invalid extension for file "%s". Only "%s" files are supported.'),'{name}','{extensions}'));
		$this->raintpl->assign( "msgLoading", sprintf(_('Loading file %s of %s …'),'{index}','{files}'));
		$this->raintpl->assign( "msgProgress", sprintf(_('Loading file %s of %s - %s - %s %%  completed.'),'{index}','{files}','{name}','{percent}'));

		$this->raintpl->assign( "uploadUrl", 'http://localhost/');
		$this->raintpl->assign( "dropZoneTitle", _('Drag & drop files here …'));
		$this->raintpl->assign( "can_drag", 'false');
		if($config['CAN_DRAG']){
			$this->raintpl->assign( "can_drag", 'true');
		}

		$this->raintpl->assign( "form", $config['FORM']);
		$this->raintpl->assign( "name", $config['NAME']);
		$this->raintpl->assign( "label", $config['LABEL']);
		$this->raintpl->assign( "help", $config['HELP']);
		$this->raintpl->assign( "type", $config['TYPE']);
		$this->raintpl->assign( "txt_file_address", _('File name'));
		$this->raintpl->assign( "txt_upload", _('Upload'));
		$this->raintpl->assign( "txt_select", _('Select'));
		$this->raintpl->assign( "txt_max_size", _('Max Size'));
		$this->raintpl->assign( "txt_max_size_unit", $config['FILE_UNIT']);
		$this->raintpl->assign( "max_size",$config['MAX_FILE_SIZE']);
		$this->raintpl->assign( "max_size_unit",$config['MAX_FILE_SIZE_UNIT']);
		$this->raintpl->assign( "txt_file_types", _('Valid types'));

		$this->raintpl->assign( "preview", $config['PREVIEW']);
	
		//return control
		return $this->raintpl->draw('ctr_uploader',true);
	
	}
	
}
?>
