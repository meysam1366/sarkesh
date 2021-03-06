<?php
namespace core\plugin\users;
use \core\cls\core as core;
use \core\cls\db as db;
use \core\cls\network as network;
use \core\cls\browser as browser;
use \core\plugin as plugin;

class module extends view{
	
	private $registry;
	private $settings;
	private $validator;
	
	function __construct(){
		
		$this->registry = core\registry::singleton();
		$this->settings = $this->registry->get_plugin('users');
		$this->validator = new network\validator;
		parent::__construct($this->settings);

	}
	/*
	 * this function show login form for input username and password
	 * if user was logedin before return user profile
	 * form
	 */
	protected function module_login_block($pos){
		//checking for that is logedin before
		if($this->module_is_logedin()){
			//show user profile
			//get user information
			$user=$this->module_get_info();
			return $this->view_profile_block($user, $this->module_has_permission('administrator_admin_panel'));
		}
		else{
			//show login form in block mode
			return $this->view_login_block($pos);
		}
		
	}
	
	/*
	 * OUTPUT:HTML ELEMENTS
	 * Tis function show register form 
	 */
	 protected function module_register(){
		 if($this->module_is_logedin()){
			 header("Location:" . core\general::create_url(array('plugin','users','action','profile')));
		 }
		 elseif($this->settings['register'] == '0'){
			 //new register was closed
			 $msg = new msg;
			 return $msg->msg('Warrning!','Register new user was closed by Administrator.','danger');
			 
		 }
		 return $this->view_register();		 
	 }
	//this function check user login data and do login proccess
	protected function module_btn_login_onclick($e){
		
		$count = db\orm::count('users',"username = ? or email=? and password = ?", array($e['txt_username']['VALUE'],$e['txt_username']['VALUE'],md5($e['txt_password']['VALUE'])));
		if($count != 0){
			//login data is cerrect
			//set validator
			if($e['ckb_remember']['CHECKED'] == 1){
						
				$valid_id = $this->validator->set('USERS_LOGIN',true,true);
							
			}
			else{
				$valid_id = $this->validator->set('USERS_LOGIN',false,true);
							
			}
			//INSERT VALID ID IN USER ROW
			$user = db\orm::load('users',$this->get_user_id($e['txt_username']['VALUE']));
			$user->login_key = $valid_id;
			db\orm::store($user);
			
			//now jump or relod page
			if(isset($_GET['jump'])){
				$e['RV']['URL'] = $_GET['jump'];
			}
			else{
				//refresh page
				$e['RV']['URL'] = 'R';
			}
		}
		else{
			//username or password is incerrect
			$e['txt_username']['VALUE'] = '';
			$e['txt_password']['VALUE'] = '';
			$e['RV']['MODAL'] = browser\page::show_block(_('Message'), _('Username or Password is incerrect!'), 'MODAL','type-warning');
		}
		return $e;
	}
	
	/*
	 * this function check user loged in before or not
	 * boolean 
	 */
	 protected function module_is_logedin(){
		 if($this->validator->is_set('USERS_LOGIN')){
				$id = $this->validator->get_id('USERS_LOGIN');
				if(db\orm::count('users','login_key = ?',array($id)) != 0){
					//user is loged in before
					return true;
				}
		 }
		 //user not loged in before
		 return false;
	 }
	 
	 /*
	  * INPUT:STRING > username | NULL > for get logedin user id
	  * this function return user id
	  * it's AI primary key
	  * OUTPUT > integer | FALSE > not found
	  */
	  protected function get_user_id($username){
		  $res = db\orm::findOne('users',"username = ?",array($username));
		  return $res->id;
	  }
	  
	 
	  /*
	  * INPUT: ELEMENTS | NULL
	  * this function do logout proccess
	  * OUTPUT: boolean | ELEMENTS
	  */
	  protected function module_logout($e = ''){
		  $this->validator->delete('USERS_LOGIN');
		  //if this action requested by content mode jump user to home page
		  if($e == 'content'){
				return core\router::jump_page(SiteDomain);
				
		  }
		  else{
			//jump page with events controller 
			$e['RV']['URL'] = SiteDomain;
		  }
		  
		  return $e;
	  }
	  
	  /*
	   * * INPUT:STRING >permation
	   * INPUT: STRING >USERNAME | NULL >for get cerrent user
	   * this function check permission of user
	   * OUTPUT:boolean
	   */
	   protected function module_has_permission($permission,$username=''){
		   
			 if($username == ''){
				//get cerrent user info
				$user = $this->module_get_info();
				if($user == null){
					//user is guest
					//4 = guest primary key
					$id = 4;
				}
				else{
					//get user permission id
					$id = $user['permission'];
				}
				$per = db\orm::findOne('permissions',"id = ?", array($id));
				if($per[$permission] == '1'){return true;}
				return false;
			}
			else{
				//get permission with username
				//check for that user exists
				if(db\orm::count('users',"username = ?",array($username)) != 0){
					//going to find permission
					$res = db\orm::getRow('SELECT * FROM users s INNER JOIN permissions p ON s.permission=p.id where s.username=?',array($username));
					//checking for that permission is exist
					if(array_key_exists($permission,$res)){
					if($res[$permission] == '1'){
						return true;
					}
				}
			}
			//user not found return false
			return false;
			}
	   }
	   
	   /*
	    * This function return reset password form
	    * OUTPUT:elements
	    */
	    protected function module_reset_password(){
			return $this->view_reset_password();
		}
		
		/*
	    * INPUT:ELEMENTS
	    * This function run with botton that's in reset password form
	    * OUTPUT:ELEMENTS
	    */
	    protected function module_btn_reset_password_email_onclick($e){
			
			if( db\orm::count('users','username=? or email=?',array($e['txt_email']['VALUE'],$e['txt_email']['VALUE'])	) != 0){
				//going to send reset code
				$user = db\orm::findOne('users','username=? or email=?',array($e['txt_email']['VALUE'],$e['txt_email']['VALUE'])	);
				
				//create random password
				$user->forget = core\general::random_string(10,'NC');
				db\orm::store($user);
				
				//send email to user
				$header = _('Reset password');
				$body = sprintf(_('Your reset password code is:%s'),$user->code) . _('first go to this link and enter your reset password code.') . '</br> ' . core\general::create_url(array('plugin','users','action','reset_password')) ;
				
				$mail = new network\mail;
				if($mail->simple_send($user->username,$user->email,$header,$body)){
					//show successfull message to user
					$e['RV']['MODAL'] = browser\page::show_block(_('Message'), _('We send an email to you.please go to your inbox for more information about reset your password.'),'MODAL','type-success');
				}
				else{
					//error in sending email
					
				}
			}
			else{
				//email or username is not found
				$e['RV']['MODAL'] = browser\page::show_block(_('Message'),_('Your entered username/email not found.'),'MODAL','type-warning');
			}
			return $e;
		}
		
		//this function return back user information
		protected function module_get_info($username = ''){
		
			//first check for that what type of user info you want
			if($username == ''){
				//you want user information that now in loged in
				if($this->is_logedin()){
					$id = $this->validator->get_id('USERS_LOGIN');
					if(db\orm::count('users','login_key = ?',array($id)) != 0){
						return db\orm::findOne('users','login_key = ?', array($id));
					}
				}
				else{
					//user is guest
					return null;
				}
			}
			else{
				//check for username and return back information if exists
				if(db\orm::count('users','username = ?',array($username)) != 0){
						return db\orm::findOne('users','login_key = ?', array($username));
				}
				else{
					//username not found
					return 0;
				}
			}
		}
		
		//this function get user id and send back user information in bean format
		protected function module_get_info_with_id($id){
			if(db\orm::count('users','id=?',[$id]) != 0){
				return db\orm::findOne('users','id=?',[$id]);
			}
			else{
				//user not found
				return false;
			}
			
		}
		//this function is for do user registeration
		//INPUT:ELEMENTS
		protected function module_btn_signup_onclick($e){
			//this variable is for store errors
			$error = array(null);
			//first checking for input informations
			//check for that username is exist before
			if(strlen($e['txt_username']['VALUE']) > 4){
				if(max(array_keys(explode(' ',$e['txt_username']['VALUE'])	)	)	!= 0){
					array_push($error,browser\page::show_block(_('Message'),_('Format of username is not cerrect.'), 'NONE'));
				}
				else{
					//check username for that exists or not
					if($this->module_is_exists($e['txt_username']['VALUE'],'USERNAME')){
						array_push($error,browser\page::show_block(_('Message'),_('The username you entered is already taken by another user.'), 'NONE'));
					}
					//check email for that exists or not
					if($this->module_is_exists($e['txt_email']['VALUE'],'EMAIL')){
						array_push($error,browser\page::show_block(_('Message'),_('Email is already taken by another user.'), 'NONE'));
					}
				}	
			}
			else{
				array_push($error,browser\page::show_block(_('Message'),_('Your usernameis too short.'), 'NONE'));
			}
			
			//Check passwords length and match.
			if(strlen($e['txt_password']['VALUE']) > 5){
				if($e['txt_password']['VALUE'] != $e['txt_repassword']['VALUE']){
					//input passwords are not match
					array_push($error,browser\page::show_block(_('Message'),_('The new passwords you entered do not match.'), 'NONE'));
				}
			}
			else{
				array_push($error,browser\page::show_block(_('Message'),_('Your password is to short.'), 'NONE'));
			} 

			
			//check for that entered email is cerrect.
			//for more info about filter_var visit http://php.net/manual/en/function.filter-var.php
			if(!filter_var($e['txt_email']['VALUE'] , FILTER_VALIDATE_EMAIL)){
				array_push($error,browser\page::show_block(_('Message'),_('Your email is not cerrect.'), 'NONE'));
			}
			
			//check for that error is exist
			if(max(array_keys($error)) != 0){
				$msg_modal = '';
				foreach($error as $msg){
					$msg_modal = $msg_modal . '   ' . $msg;
				}
				$e['RV']['MODAL'] = browser\page::show_block(_('Message'),$msg_modal , 'MODAL','type-warning');
				
			}
			else{
					//going to register user.
					$user = db\orm::dispense('users');
					$user->username = $e['txt_username']['VALUE'];
					$user->password = md5($e['txt_password']['VALUE']);
					$user->email = $e['txt_email']['VALUE'];
					//save register date
					$ObjDateTime = new \DateTime;
					$user->register_date = $ObjDateTime->getTimestamp();
					//set default permation
					$user->permation = $this->settings['default_permation'];
					
					/*
					 * check for that administrator want to validate users with email or not
					 * all states is E=>enabled B=>baned D=>Disabled NA=>not activated
					 */
					 
					 //perpare email class for send email
					$mail = new network\mail;
					
					if($this->settings['active_from_email'] == 1){
						//active with email
						$user->state = 'NA';
						
						//send active code to email
						//create random code
						$user->code = core\general::random_string(10,'NC');
						
						$email_title = _('Active account');
						$email_body = sprintf(_('Your activation code is:%s'),$user->code) . _(' first go to link that comes below and enter your activation code.') . '</br>' . core\general::create_url(SiteDomain . '/?plugin=users&action=ActiveAccount',false);
						
						//save in database
						$UserId = db\orm::store($user);
						
						if($mail->simple_send($e['txt_username']['VALUE'],$e['txt_email']['VALUE'],$email_title,$email_body)){
							//user activated
							$e['RV']['URL'] = core\general::create_url(array('plugin','users','action','ActiveAccount','new','1'),true);
						}
						else{
							//error in sending email
							$e['RV']['MODAL'] = browser\page::show_block('Error','Error in sending activation code to your email.please tell administrator!','MODAL','type-danger');
							
							//remove user from database
							$usr = db\orm::load('users',$UserId);
							db\orm::trash($usr);
						}
						
						
					}
					else{
						//user active now
						$user->state = 'E';
						
						//save user in database
						db\orm::store($user);
						
						//get site name
						$obj_localize = new core\localize;
						$local = $obj_localize->get_localize();
						
						//send register information to email
						$email_title = _('Registration complete');
						$email_body = sprintf(_('Your registration in %s was completed.'),[$local['name']]);
						if(!$mail->simple_send($e['txt_username']['VALUE'],$e['txt_email']['VALUE'],$email_title,$email_body)){
							//user activated
							//show register successful message for registeration in sarkesh
							$header = _('Active account');
							$body = _('We sent an email with an activation code to activate your account, check your email for more information.');
							$type = 'info';
							$e['RV']['MODAL'] = browser\page::show_block($header,$body,'MODAL','type-success');
							$e['RV']['JUMP_AFTER_MODAL'] = core\general::create_url(array('plugin','users','action','ActiveAcount'),true);
						}
						else{
							//error in sending email
							$e['RV']['MODAL'] = browser\page::show_block('Warrning','Error in sending your information to your email but your account was activated. you can now log in with your information','MODAL','type-warrning');
						}
						
					}
					
					
			}
			return $e;
		}
		
		//this function check for that username is exist before or not
		protected function module_is_exists($parameter , $type){
			if($type == 'username' || $type == 'USERNAME'){
				$UserNum = db\orm::count('users','username=?',array($parameter));
				if($UserNum != 0){	return true;}
				return false;
			}
			elseif($type == 'email' || $type == 'EMAIL'){
				$EmailNUM = db\orm::count('users','email=?',array($parameter));
				if($EmailNUM != 0){	return true;}
				return false;
			}
			
		}
		
		/*
		 * This function is for show active acount page to user
		 */
		protected function module_ActiveAccount(){
			//check for that user is loged in
			if($this->module_is_logedin()){
			 header("Location:" . SiteDomain);
			 exit();
			}
			
			$msg = '';
			if(isset($_GET['new'])){
				$msg = $this->module_show_msg('register_active',true);
			}
			return $this->view_ActiveAccount($msg);
		}
		
		//this function is for check activation code and active user account
		protected function module_btn_active_account($e){
			//check for that code is exist
			if( db\orm::count('users','code=?',[$e['txt_code']['VALUE']]	)	!= 0){
					
					//get user
					$user = db\orm::findOne('users','code=?',[$e['txt_code']['VALUE']]);
					// E => Enabled
					$user->state = 'E';
					db\orm::store($user);
					$e['RV']['MODAL'] = browser\page::show_block('Registration completed','your account activated successfully. Now click on OK to jump to home page.','MODAL','type-success');
					$e['RV']['JUMP_AFTER_MODAL'] = SiteDomain;
			}
			else{
				//active code not found
				$e['RV']['MODAL'] = browser\page::show_block('Error','Activation Code Invalid','MODAL','type-danger');
			}
			return $e;
		}
		
		//this function show meesage
		protected function module_show_msg($id,$just_body = false){
			
			//create object from msg plugin
			$msg = new plugin\msg;
			
			$header = '';
			$body = '';
			$type='';
			
			if($id == 'register_successful'){
				//show register successful message for registeration in sarkesh
				$header = _('Registration completed!');
				$body = _('Your registration was successful.now you can login to system with your login information that you entered');
				$type = 'success';
			}
			elseif($id == 'register_active'){
				//show register successful message for registeration in sarkesh
				$header = _('Active account');
				$body = _('We sent an email with an activation code to activate your account, check your email for more information and enter your activation code in box below.');
				$type = 'info';
			}
			
			//return back message
			$result = $msg->msg($header,$body,$type);
			if($just_body){
				return $result[1];
			}
			return $result;
		}
		
		/*
		 * Function for reset user password and send that to user
		 */
		 protected function module_btn_reset_password_onclick($e){
			 
			 //check for that count is cerrect
			 if(db\orm::count('users','forget=?',array($e['txt_code']['VALUE'])) != 0){
				 //code is cerrect
				 $password = core\general::random_string(5,'NC');
				 $user = db\orm::findOne('users','forget=?',array($e['txt_code']['VALUE']));
				 $user->password = md5($password);
				 $user->forget = '';
				 db\orm::store($user);
				 
				 //now send password to user email
				 $header = _('New password');
				 $body = sprintf(_('Your new password is: %s'),$password) . _('Please after login to portal change your password');
				 
				 $mail = new network\mail;
				 if($mail->simple_send($user->username,$user->email,$header, $body)	){
					 //show successfull mesage to user
					 $e['RV']['MODAL'] = browser\page::show_block(_('Password changed'),_('Your new password was send to your email. check your email for get that.'),'MODAL','danger');

				 }
				 else{
					 //error in sending email
					 $e['RV']['MODAL'] = browser\page::show_block(_('Error'),_('Error in sending new password to your email. please tell with administrator'),'MODAL','type-danger');
				 }
				 
				 return $e;
			 }
			 else{
				 //show message about invalid code
				 $e['RV']['MODAL'] = browser\page::show_block(_('Warning'),_('Code that you entered is invalid.please enter code that you got from your email.'),'MODAL','type-warning');
				 return $e;
			 }
		 }
		 
		 //this function is for show profile
		 protected function module_profile(){
			//going to show profile to user
			$user_info = $this->module_get_info('');
					 
			if($user_info != false){
				$user = db\orm::findOne('users','id = ?',array($user_info->id));
				return $this->view_profile($user);
			}
			else{
				//user is guest, jump to login page
				return core\router::jump_page(array('plugin','users','action','login'));
						 
			}
 
		 }
         protected function module_no_permission(){
    		core\router::jump_page(404);
            return [0,0];
    	}
         //this function show list of users in admin panel
          protected function module_list_people(){
            //check for permission to admin area
            if($this->module_has_permission('users_admin')){
                //get list of users
                $users = db\orm::find('users');
                $groups = db\orm::find('permissions');
                return $this->view_list_people($users,$groups);
            }
            //show access denied message
            return $this->module_no_permission();
            
          }
          
          //this function show list of users in admin panel
          protected function module_list_groups(){
            //check for permission to admin area
            if($this->module_has_permission('users_admin')){
                //get list of permissions
                $groups = db\orm::find('permissions',"name !='Guest'");
                return $this->view_list_groups($groups);
            }
            //show access denied message
            return $this->module_no_permission();
            
          }

           //This function show settings for control user register/login/view and ...
		  protected function module_settings(){
		  	
		  	//check for permission to admin area
            if($this->module_has_permission('users_admin')){
                return $this->view_settings($this->settings);
            }
            //show access denied message
            return $this->module_no_permission();
		  }

		  //this function handle onclick btn_register_settings
		  protected function module_btn_onclick_register_settings($e){
		  	//check for permission to admin area
            if($this->module_has_permission('users_admin')){
            	//save register type
            	$register_type = 0;
                if($e['rad_it_visitors']['CHECKED'] == '1'){
                	$register_type = 1;
                }
                elseif($e['rad_it_visitors_req_admin']['CHECKED'] == '1'){
                	$register_type = 2;
                }
               	$this->registry->set('users','register',$register_type);
            	
            	//save email verification setting
            	$verification_type = 0;
                if($e['ckb_verification']['CHECKED'] == '1'){
                	$verification_type = 1;
                }
                $this->registry->set('users','active_from_email',$verification_type);

               	$e['RV']['MODAL'] = browser\page::show_block(_('successfully updated'),_("Settings was successfully updated."),'MODAL','type-success');
               	return $e;
            }
            //show access denied message
            return $this->no_permission_modal($e);
		  }



		  //this function handel personal settings in users plugin settings
		  protected function module_btn_onclick_register_personal($e){
		  	//check for permission to admin area
            if($this->module_has_permission('users_admin')){
            	//save register type
            	$signatures = 0;
                if($e['ckb_signatures']['CHECKED'] == '1'){
                	$signatures = 1;
                }
               	$this->registry->set('users','signatures',$signatures);
            	
            	//save email verification setting
            	$user_can_upload = 0;
                if($e['ckb_user_pic']['CHECKED'] == '1'){
                	$user_can_upload = 1;
                }
                $this->registry->set('users','user_can_upload_avatar',$user_can_upload);
                $this->registry->set('users','avatar_guidline',$e['txt_picture_guidlines']['VALUE']);
                $this->registry->set('users','max_file_size',$e['txt_max_file_size']['VALUE']);

               	$e['RV']['MODAL'] = browser\page::show_block(_('successfully updated'),_("Settings was successfully updated."),'MODAL','type-success');
               	return $e;
            }
            //show access denied message
            return $this->no_permission_modal($e);
		  }

		  protected function no_permission_modal($e){
		  	$e['RV']['MODAL'] = browser\page::show_block(_('Permission denied'),_("You do't have permission to do this action."),'MODAL','type-danger');
			$e['RV']['JUMP_AFTER_MODAL'] = SiteDomain;
			return $e;
		  }

		  //this function show ipblock list in system
		  public function module_ip_block(){
		  	//check for permission to admin area
            if($this->module_has_permission('users_admin')){
                //get list of ip that blocked
                $ips = db\orm::findAll('ipblock');
                return $this->view_ip_block($ips);
            }
            //show access denied message
            return $this->module_no_permission();
		  }

		  //this function is for add new ip to block list
		  protected function module_ip_block_new(){
		  	//check for permission to admin area
            if($this->module_has_permission('users_admin')){
                return $this->view_ip_block_new();
            }
            //show access denied message
            return $this->module_no_permission();
		  }

		  //this function remove ip from block list
		  protected function module_btn_onclick_ip_block_delete($e){
		  	//check for permission to admin area
            if($this->module_has_permission('users_admin')){
            	if($e['CLICK']['VALUE'] != ''){
			  		$ip = db\orm::load('ipblock',$e['CLICK']['VALUE']);
			  		db\orm::trash($ip);
			  		$e['RV']['MODAL'] = browser\page::show_block(_('Delete IP'),_("Requested IP successfully deleted."),'MODAL','type-success');
					$e['RV']['JUMP_AFTER_MODAL'] = 'R';
					return $e;
		  		}
            }
            //show access denied message
            return $this->no_permission_modal($e);
		  }

		  //this function is for event handel for add new ip to block list
		  protected function module_btn_onclick_add_new_ip_blocklist($e){
		  	//check for permission to admin area
            if($this->module_has_permission('users_admin')){
            	$ip = db\orm::dispense('ipblock');
            	$ip->ip = ip2long(trim($e['txt_ip']['VALUE']));
            	db\orm::store($ip);
            	$e['RV']['MODAL'] = browser\page::show_block(_('Add IP'),_('IP Added to block list successfully.'),'MODAL','type-success');
				$e['RV']['JUMP_AFTER_MODAL'] = core\general::create_url(array('plugin','administrator','action','main','p','users','a','ip_block'),true);
				return $e;

		  	}
		  	else{
		  		return $this->no_permission_modal($e);
		  	}
		  }
}
?>
