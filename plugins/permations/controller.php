<?php
class permations_controller{
	private $view;
	private $madule;
	
	function __construct($madule, $view){
		$this->view = $view;
		$this->madule = $madule;
	}
	
	public function action($action_name, $view){
		$obj_page= new cls_page;
		$obj_page->show_block(_('Banner') , "<script>tinymce.init({directionality : 'rtl',selector:'textarea'});</script>" , $view);
	}


}
?>