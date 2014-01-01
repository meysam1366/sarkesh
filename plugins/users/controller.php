<?php
class users_controller{
	private $view;
	private $madule;
	//------------------------------------
	private $obj_validator;
	private $db;
	private $io;
	private $service_result;
	function __construct($view, $madule){
		$this->view = $view;
		$this->madule = $madule;
		$this->db = new cls_database;
		$this->obj_validator = new cls_validator;
		$this->io = new cls_io;
	}
	// $view has to value 1- 'block' for show with block header
	// 			2-content for show with orginal state
	public function action($action_name, $view = 'BLOCK'){

		if($action_name == 'login'){
			
			if($this->is_logedin()){
				//show user static
				$this->view->show_user_page($view);

			}
			else{
				//going to show login page
				$this->view->show_login_page($view);
				
			}
			
		}
		elseif($action_name == 'register'){
			if($this->is_logedin()){
				//jump to user profile
				$this->view->show_profile_page();
			}
			else{
				//show register page
				$this->view->show_register_page();
			}
		}
		

	}
	
	//service do not has any user interface
	//it just return text
	public function service($service_name){
		if($service_name == 'login'){
			//checking user entered username and password
			//if cerrect do_login and else return negative 
			//1 ->username and password was cerrect user loged in 
			if($this->is_logedin()){
				//user is logedin before
				$this->service_result = _('You loged in with defferent acount before! first logout.');
			}
			elseif(isset($_GET['username']) && isset($_GET['password'])){
				//start login progress
				$this->db->do_query('SELECT * FROM ' . TablePrefix . 'users WHERE username=? AND password=?;', array($this->io->cin('username', 'get'),md5($this->io->cin('password', 'get'))));
				if($this->db->rows_count() != 0){
					//username is cerrect going to set validator
					if(isset($_GET['remember']) && $_GET['remember'] == 'yes'){
						$valid_id = $this->obj_validator->set('USERS_LOGIN',true);
					}
					else{
						$valid_id = $this->obj_validator->set('USERS_LOGIN',false);
					}
					$this->db->do_query('UPDATE ' . TablePrefix . 'users SET validator=? WHERE username=?;', array($valid_id, $this->io->cin('username', 'get')));
					$this->service_result = 1;
				}
				else{
					//username or password is incerrect
					$this->service_result = _('Username or Password is incerrect!');
				}
			}
			else{
				//what do you want to do ? 
				// you send nothing for me to proccess that. so  i return -1 for you
				$this->service_result = _('Your request can not be prossed! try again later.');
				
			}
		}
		//logout from system
		elseif($service_name == 'logout'){
			if($this->is_logedin()){
				//start logout proccess
				$this->logout();
				$this->service_result = "1";
			}
			else{
				$this->service_result = _('Problem in log out! try again later');
			}
		
		}
		echo $this->service_result;
	
	}
	
	//this function search for that user is loged in before
	//with check validator with USERS_LOGIN source
	public function is_logedin(){
		//first create validator class
		return $this->obj_validator->is_set('USERS_LOGIN');
	}
	
	//this function do users logout proccess
	public function logout(){
		$this->obj_validator->delete('USERS_LOGIN');
	}


}
?>