<?php
class ctr_form_module extends ctr_form_view{
	
	function __construct(){
		parent::__construct();
	}
	protected function module_draw($e){
		return $this->view_draw($e);
	}
}
?>
