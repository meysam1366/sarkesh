<?php
namespace core\plugin\users;
use \core\cls\template as template;
use \core\cls\browser as browser;
use \core\cls\core as core;
use \core\plugin as plugin;
use \core\cls\calendar as calendar;
use \core\control as control;
use \core\cls\db as db;
class view{
	private $settings;
	function __construct($settings){
		$this->settings = $settings;
	}
	
	public function view_login_block($pos){
		$username = new control\textbox();
		$username->configure('NAME','txt_username');
		$username->configure('INLINE',TRUE);
		$username->configure('ADDON','U');
		$username->configure('PLACE_HOLDER',_('Username or e-mail address'));
		//$username->configure('HELP',_('Enter your username or email.'));
		
		$password = new control\textbox();
		$password->configure('NAME','txt_password');
		$password->configure('INLINE',TRUE);
		$password->configure('LABEL',_('Password:'));
		$password->configure('ADDON','P');
		$password->configure('PLACE_HOLDER',_('Password'));
		$password->configure('PASSWORD',true);
		//$password->configure('HELP',_('Enter the password that accompanies your username.'));
		
		$remember = new control\checkbox;
		$remember->configure('NAME','ckb_remember');
		$remember->configure('LABEL',_('Remember me!'));
		
		$login = new control\button;
		$login->configure('NAME','btn_login');
		$login->configure('LABEL',_('Sign in'));
		$login->configure('P_ONCLICK_PLUGIN','users');
		$login->configure('P_ONCLICK_FUNCTION','btn_login_onclick');
		$login->configure('TYPE','primary');
		
		$forget = new control\button;
		$forget->configure('NAME','btn_reset_password');
		$forget->configure('LABEL', _('Reset Password'));
		$forget->configure('HREF',core\general::create_url(array('plugin','users','action','reset_password')));
		$forget->configure('TYPE','link');
		
		$r = new control\row;
		$r->add($login,3);
		$r->add($forget,9);
		
		$form = new control\form;
		
		if($pos == 'block'){
			$form->configure('NAME','users_login_block');
		}
		else{
			$form->configure('NAME','users_login');
		}
		$form->add_array(array($username,$password,$remember,$r));
		
		//users can register?
		if($this->settings['register'] == '1'){
			$form->add_spc();
			$lbl = new control\label(_("Don't have account?"));
			$register = new control\button;
			$register->configure('NAME','btn_register');
			$register->configure('LABEL', _('Sign up'));
			$register->configure('HREF',core\general::create_url(array('plugin','users','action','register')));
			$register->configure('TYPE','success');
			$r1 = new control\row;
			$r1->add($lbl,7);
			$r1->add($register,5);
			$form->add($r1);
		}
		
		return array(_('Sign in'),$form->draw());
	}
	
	/*
	 * INPUT: Object >redbeanphp user info
	 * INPUT: boolean > Admin permission
	 * 
	 * This function show user profile in block mode and content mode
	 * block mode draw with small information about user
	 * content mode draw all information about user
	 * OUTPUT:form
	 */
	 protected function view_profile_block($user,$admin){
		 $form = new control\form('USERS_PROFILE_BLOCK');
		 $row = new control\row;
		 $row->configure('IN_TABLE',FALSE);
		 $avatar = new control\image;
		 if($user->photo != 0){
			  $files = new plugin\files;
			  $adr = $files->get_adr($user->photo);
			  $photo = new control\image('USERS_PHOTO');
			  $photo->configure('SIZE',4);
			  $photo->configure('SRC',$adr);
			 $photo->configure('LABEL',_('Hello') . ' ' . $user->username);
		 }
		 $row->add($photo,6);
		 
		 $row1 = new control\row;
		 $btn_logout = new control\button;
		 $btn_logout->configure('NAME','btn_logout');
		 $btn_logout->configure('LABEL',_('Sign Out!'));
		 $btn_logout->configure('TYPE','info');
		 $btn_logout->configure('P_ONCLICK_PLUGIN','users');
		 $btn_logout->configure('P_ONCLICK_FUNCTION','btn_logout_onclick');
		 $row1->add($btn_logout,6);
		 
		 if($admin){
			$btn_admin = new control\button;
			$btn_admin->configure('NAME','JUMP_ADMIN');
			$btn_admin->configure('LABEL',_('Admin panel'));
			$btn_admin->configure('HREF',core\general::create_url(array('service','1','plugin','administrator','action','main','p','administrator','a','dashboard')));
			$row1->add($btn_admin,6);
		 }
		 
		 $form->add_array(array($row,$row1));
		 return array(_('User Profile'),$form->draw());
	 }
	 
	 /*
	 * OUTPUT:HTML ELEMENTS
	 * Tis function show register form 
	 */
	 protected function view_register(){
		 $form = new control\form('USERS_REGISTER');
		 $form->configure('LABEL',_('Register'));
		 
		 $username = new control\textbox;
		 $username->configure('NAME','txt_username');
		 $username->configure('LABEL',_('Username:'));
		 $username->configure('ADDON',_('*'));
		 $username->configure('PLACE_HOLDER',_('Username'));
		 $username->configure('HELP',_('Spaces are allowed; punctuation is not allowed except for periods, hyphens, apostrophes, and underscores.'));
		 $username->configure('SIZE',4);
		 
		 $email = new control\textbox;
		 $email->configure('NAME','txt_email');
		 $email->configure('LABEL',_('Email:'));
		 $email->configure('ADDON',_('*'));
		 $email->configure('PLACE_HOLDER',_('Email'));
		 $email->configure('HELP',_('A valid e-mail address. All e-mails from the system will be sent to this address. The e-mail address is not made public and will only be used if you wish to receive a new password or wish to receive certain news or notifications by e-mail.'));
		 $email->configure('SIZE',6);
		 
		 $form->add_array(array($username,$email));
		 
		 $password = new control\textbox;
		 $password->configure('NAME','txt_password');
		 $password->configure('LABEL',_('Password:'));
		 $password->configure('ADDON',_('*'));
		 $password->configure('PLACE_HOLDER',_('Password'));
		 $password->configure('PASSWORD',true);
		 $password->configure('SIZE',4);
		 
		 $repassword = new control\textbox;
		 $repassword->configure('NAME','txt_repassword');
		 $repassword->configure('LABEL',_('Confirm password :'));
		 $repassword->configure('ADDON',_('*'));
		 $repassword->configure('PLACE_HOLDER',_('Password'));
		 $repassword->configure('PASSWORD',true);
		 $repassword->configure('SIZE',4);
		 
		 $signup = new control\button;
		 $signup->configure('NAME','btn_signup');
		 $signup->configure('TYPE','primary');
		 $signup->configure('LABEL',_('Create new account'));
		 $signup->configure('P_ONCLICK_PLUGIN','users');
		 $signup->configure('P_ONCLICK_FUNCTION','btn_signup_onclick');
		 
		 $cancel = new control\button;
		 $cancel->configure('NAME','btn_cancel');
		 $cancel->configure('TYPE','warning');
		 $cancel->configure('LABEL',_('Cancel'));
		 $cancel->configure('HREF','?');
		 
		 $row = new control\row();
		 $row->add($signup,3);
		 $row->add($cancel,2);
		 
		 $form->add_array(array($password,$repassword));
		 $form->add_spc();
		 $form->add($row);
		 
		 return array(_('Sign up'),$form->draw());
	 }
	 
	 /*
	  * This function draw reset password form and return back that
	  * OUTPUT: elements
	  */
	  protected function view_reset_password(){
		  $frm_reset_password_email = new control\form('USERS_EMAIL_RESET_PASSWORD');
		  $frm_reset_password_email->configure('LABEL', _('Request reset password'));
		  
		  //create textbox for enter email or username
		  $txt_email = new control\textbox;
		  $txt_email->configure('NAME','txt_email');
		  $txt_email->configure('LABEL',_('Username or e-mail address'));
		  $txt_email->configure('HELP',_('Enter your Alternate Email Address or username'));
		  $txt_email->configure('PLACE_HOLDER',_('Username or e-mail address'));
		  $txt_email->configure('ADDON',_('*'));
		  $txt_email->configure('SIZE',10);
		  
		  $btn_send_email = new control\button('btn_email_reset_password');
		  $btn_send_email->configure('NAME','btn_send_email');
		  $btn_send_email->configure('LABEL',_('Send password reset code'));
		  $btn_send_email->configure('P_ONCLICK_PLUGIN','users');
		  $btn_send_email->configure('P_ONCLICK_FUNCTION','btn_reset_password_email_onclick');
		  $btn_send_email->configure('TYPE','primary');		  
		  $frm_reset_password_email->add_array(array($txt_email, $btn_send_email));
		  
		  //THIS PARD IS FOR DRAW ENTER RESET CODE
		  $frm_reset_password = new control\form('USERS_RESET_CODE');
		  $frm_reset_password->configure('LABEL', _('Enter reset code'));
		  //create textbox for enter email or username
		  $txt_code = new control\textbox;
		  $txt_code->configure('NAME','txt_code');
		  $txt_code->configure('LABEL',_('Reset code'));
		  $txt_code->configure('HELP',_('Enter your code that you get in your email'));
		  $txt_code->configure('PLACE_HOLDER',_('Code'));
		  $txt_code->configure('ADDON',_('*'));
		  $txt_code->configure('SIZE',8);
		  
		  $btn_reset_password = new control\button('USERS_BTN_RESET_PASSWORD');
		  $btn_reset_password->configure('NAME','btn_reset_password');
		  $btn_reset_password->configure('LABEL',_('Reset password'));
		  $btn_reset_password->configure('P_ONCLICK_PLUGIN','users');
		  $btn_reset_password->configure('P_ONCLICK_FUNCTION','btn_reset_password_onclick');
		  $btn_reset_password->configure('TYPE','primary');		  
		  
		  $frm_reset_password->add_array(array($txt_code, $btn_reset_password));
		  
		  $tabbar = new control\tabbar;
		  $tabbar->add($frm_reset_password_email);
		  $tabbar->add($frm_reset_password);
		  return array(_('Change password'),$tabbar->draw());
		  
	  }
	  
	  /*
	   * This function is for show active acount page to user
	   */
	  protected function view_ActiveAccount($msg){
		$tile = new control\tile;
		if($msg != ''){
			$tile->add($msg);
		}
		
		$txt_code = new control\textbox('txt_code');
		$txt_code->configure('LABEL', _('Activation code') );
		$txt_code->configure('ADDON',_('*'));
		$txt_code->configure('PLACE_HOLDER',_('Your code in here!'));
		$txt_code->configure('HELP',_('Enter code that you got it in your email in box below for active your account.'));
		$txt_code->configure('SIZE',6);
		
		$btn_active = new control\button('btn_active');
		$btn_active->configure('P_ONCLICK_PLUGIN','users');
		$btn_active->configure('P_ONCLICK_FUNCTION','btn_active_account');
		$btn_active->configure('LABEL', _('Active account') );
		
		$form = new control\form('USERS_ACTIVE_ACCOUNT');
		$form->add_array(array($txt_code,$btn_active));
		$tile->add($form->draw());
		return array( _('Active account') ,$tile->draw());
	  }
	  
	  //this function is for return users profile
	  protected function view_profile($user){
		  
		  $form = new control\form('USERS_VIEW_PROFILE');
		  
		  //USER PROFILE PICTURE
		  //get file address
		  if($user->photo != 0){
			  $files = new plugin\files;
			  $adr = $files->get_adr($user->photo);
			  $photo = new control\image('USERS_PHOTO');
			  $photo->configure('SIZE',2);
			  $photo->configure('SRC',$adr);
		  }
		 
		  
		  //show username
		  $lbl_username = new control\label('users_lbl_username');
		  $lbl_username->configure('LABEL', _('Username:') . $user->username);
		  
		  //show last login date
		  $calendar = new calendar\calendar;
		  
		  $lbl_last_login = new control\label('users_lbl_last_login');
		  $lbl_last_login->configure('LABEL', _('Last login:') .  'NOT DEVELOPED YET');
		  
		  //show register date
		  $lbl_register_date = new control\label('users_lbl_register_date');
		  $lbl_register_date->configure('LABEL', _('Register date:') . $calendar->cdate($this->settings['register_date_format'],$user->register_date ) );
		  
		  //add edite button
		  $btn_edite = new control\button('btn_edite');
		  $btn_edite->configure('LABEL',_('Edite Profile'));
		  $btn_edite->configure('HREF',core\general::create_url(array('plugin','users','action','edite_profile','id',$user->id) ) );
		
		  
		  $form->add_array([$photo,$lbl_username, $lbl_last_login, $lbl_register_date,$btn_edite]);
		  
		  return [sprintf( _('%s\'s profile'),$user->username), $form->draw(),true];
		  
	  }
      
      //this function show list of users
      protected function view_list_people($users,$groups){
        
        $form = new control\form("users_list_people");
		$form->configure('LABEL',_('People'));
		
		$table = new control\table;
		
		foreach($users as $key=>$user){
			$row = new control\row;
			
			//add id to table for count rows
			$lbl_id = new control\label($key+1);
			$row->add($lbl_id,1);
			
			//add user name
			$lbl_user_name = new control\label($user->username);
			$row->add($lbl_user_name,2);
            
            //add user group
            foreach($groups as $group){
                if($group->id == $user->permission){
                    $lbl_user_group = new control\label($group->name);
                }
            }
			
			$row->add($lbl_user_group,2);
			
			//add register date
            //show last login date
            $calendar = new calendar\calendar;
		   	$lbl_register = new control\label($calendar->cdate($this->settings['register_date_format'],$user->register_date ));
			$row->add($lbl_register,2);
			
			//add edite button
            $btn_active = new control\button;
            $btn_active->configure('LABEL',_('Edite'));
            $btn_active->configure('TYPE','success');
            $btn_active->configure('VALUE',$user->id);
			$btn_active->configure('P_ONCLICK_PLUGIN','users');
			$btn_active->configure('P_ONCLICK_FUNCTION','btn_edite_user');
			$row->add($btn_active,1);
			
			$table->add_row($row);
			
		}
		
		//add headers to table
		$table->configure('HEADERS',array(_('ID'),_('Username'),_('Group'),_('Register Date'),_('Options')));
		$table->configure('HEADERS_WIDTH',[1,5,2,2,2]);
		$table->configure('ALIGN_CENTER',[TRUE,FALSE,FALSE,TRUE,TRUE]);
		$table->configure('BORDER',true);
		$form->add($table);
		
		return array(_('People'),$form->draw());
      }
      
      //this function show list of froups
      protected function view_list_groups($groups){
        
        $form = new control\form("users_list_people");
		$form->configure('LABEL',_('User Groups'));
		
		$table = new control\table;
		
		foreach($groups as $key=>$group){
			$row = new control\row;
			
			//add id to table for count rows
			$lbl_id = new control\label($key+1);
			$row->add($lbl_id,1);
			
			//add group name
			$lbl_group_name = new control\label($group->name);
			$row->add($lbl_group_name,2);
            
            $user_number = new control\label(db\orm::count('users','permission=?',[$group->id]));
			
			$row->add($user_number,2);
			
			
			//add edite button
            $btn_active = new control\button;
            $btn_active->configure('LABEL',_('Edite'));
            $btn_active->configure('TYPE','success');
			$btn_active->configure('HREF',core\general::create_url(['service','1','plugin','administrator','action','main','p','users','a','edite_group','id',$group->id]));
			$row->add($btn_active,1);
			$table->add_row($row);
			
		}
		
		//add headers to table
		$table->configure('HEADERS',array(_('ID'),_('Name'),_('Count'),_('Options')));
		$table->configure('HEADERS_WIDTH',[1,7,2,2]);
		$table->configure('ALIGN_CENTER',[TRUE,FALSE,TRUE,TRUE]);
		$table->configure('BORDER',true);
		$form->add($table);
		
		$btn_insert_group = new control\button('btn_insert_group');
		$btn_insert_group->configure('LABEL',_('New Group'));
		$btn_insert_group->configure('TYPE','primary');
		$btn_insert_group->configure('HREF',core\general::create_url(['service','1','plugin','administrator','action','main','p','users','a','new_group']));
		
		$btn_cancel = new control\button('btn_cancel');
		$btn_cancel->configure('LABEL',_('Cancel'));
		$btn_cancel->configure('HREF',core\general::create_url(['service','1','plugin','administrator','action','main','p','administrator','a','dashboard']));
		
		$row = new control\row;
		$row->configure('IN_TABLE',false);
		
		$row->add($btn_insert_group,3);
		$row->add($btn_cancel,3);
		$form->add($row);
		return array(_('Groups'),$form->draw());
      }

       //This function show settings for control user register/login/view and ...
		  public function view_settings($settings){
		  	$tab = new control\tabbar;

		  	//---------------------- FORM FOR CONTROL REGISTER AND ECT ----------------------
		  	$frm_reg_settings = new control\form('frm_reg_settings');
		  	$frm_reg_settings->configure('LABEL',_('Registration and cancellation'));

		  	$rad_bot = new control\radiobuttons('rad_show_option');
			$rad_bot->configure('LABEL',_('Who can register accounts? '));
			$radit_admin_only = new control\radioitem('rad_it_adminonly');
			$radit_admin_only->configure('LABEL',_('Administrators only'));
			if($settings['register'] == 0){
				$radit_admin_only->configure('CHECKED',TRUE);
			}
			$rad_bot->add($radit_admin_only);
			
			$radit_visitors  = new control\radioitem('rad_it_visitors');
			$radit_visitors->configure('LABEL',_('Visitors'));
			if($settings['register'] == 1){
				$radit_visitors->configure('CHECKED',TRUE);
			}
			$rad_bot->add($radit_visitors);

			$radit_admin_req  = new control\radioitem('rad_it_visitors_req_admin');
			$radit_admin_req->configure('LABEL',_('Visitors, but administrator approval is required'));
			if($settings['register'] == 2){
				$radit_admin_req->configure('CHECKED',TRUE);
			}
			$rad_bot->add($radit_admin_req);

			$frm_reg_settings->add($rad_bot);

			//veriflication settings
			$ckb_verification = new control\checkbox('ckb_verification');
			$ckb_verification->configure('LABEL',_('Require e-mail verification when a visitor creates an account.') );
			$ckb_verification->configure('HELP',_('New users will be required to validate their e-mail address prior to logging into the site, and will be assigned a system-generated password. With this setting disabled, users will be logged in immediately upon registering, and may select their own passwords during registration.'));
			if($settings['active_from_email'] == 1){
				$ckb_verification->configure('CHECKED',TRUE);
			}
			$frm_reg_settings->add($ckb_verification);

		  	//update and cancel buttons
			$btn_update = new control\button('btn_update');
			$btn_update->configure('LABEL',_('Update'));
			$btn_update->configure('P_ONCLICK_PLUGIN','users');
			$btn_update->configure('P_ONCLICK_FUNCTION','btn_onclick_register_settings');
			$btn_update->configure('TYPE','primary');
			
			$btn_cancel = new control\button('btn_cancel');
			$btn_cancel->configure('LABEL',_('Cancel'));
			$btn_cancel->configure('HREF',core\general::create_url(['service','1','plugin','administrator','action','main','p','administrator','a','blocks']));
			
			$row = new control\row;
			$row->configure('IN_TABLE',false);
			$row->add($btn_update,3);
			$row->add($btn_cancel,3);
			$frm_reg_settings->add($row);

			$tab->add($frm_reg_settings);
		  	//-------------------------------------------------------------------------------
		  	$frm_personal_settings = new control\form('frm_personal_settings');
		  	$frm_personal_settings->configure('LABEL',_('Personalization'));

		  	//enable sign
			$ckb_signatures = new control\checkbox('ckb_signatures');
			$ckb_signatures->configure('LABEL',_('Enable signatures.'));
			$ckb_signatures->configure('HELP',_('With enable this option user signature show in content that published by user.'));
			if($settings['signatures'] == 1){
				$ckb_signatures->configure('CHECKED',TRUE);
			}
			$frm_personal_settings->add($ckb_signatures);

			//enable user picture
			$ckb_user_pic = new control\checkbox('ckb_user_pic');
			$ckb_user_pic->configure('LABEL',_('Enable user pictures. ') );
			$ckb_user_pic->configure('HELP',_('With this option,site users can upload personal avatars.'));
			if($settings['user_can_upload_avatar'] == 1){
				$ckb_user_pic->configure('CHECKED',TRUE);
			}
			$frm_personal_settings->add($ckb_user_pic);
		  	
		  	//max_file_size
		  	$txt_max_file_size = new control\textbox('txt_max_file_size');
		  	$txt_max_file_size->configure('LABEL',_('Picture upload max file size'));
		  	$txt_max_file_size->configure('ADDON',_('KiloByte'));
		  	$txt_max_file_size->configure('VALUE',$settings['max_file_size']);
		  	$txt_max_file_size->configure('SIZE',3);
			$txt_max_file_size->configure('HELP',_('Maximum allowed file size for uploaded pictures. Upload size is normally limited only by the PHP maximum post and file upload settings, and images are automatically scaled down to the dimensions specified above.'));
			$frm_personal_settings->add($txt_max_file_size);

			//avatar Picture guidelines
			$txt_picture_guidlines = new control\textarea('txt_picture_guidlines');
			$txt_picture_guidlines->configure('LABEL',_('Picture guidelines'));
			$txt_picture_guidlines->configure('VALUE',$settings['avatar_guidline']);
			$txt_picture_guidlines->configure('EDITOR',FALSE);
			$txt_picture_guidlines->configure('ROWS',5);
			$txt_picture_guidlines->configure('HELP',_("This text is displayed at the picture upload form in addition to the default guidelines. It's useful for helping or instructing your users."));
			$frm_personal_settings->add($txt_picture_guidlines);

		  	//update and cancel buttons
			$btn_update = new control\button('btn_update');
			$btn_update->configure('LABEL',_('Update'));
			$btn_update->configure('P_ONCLICK_PLUGIN','users');
			$btn_update->configure('P_ONCLICK_FUNCTION','btn_onclick_register_personal');
			$btn_update->configure('TYPE','primary');
			
			$btn_cancel = new control\button('btn_cancel');
			$btn_cancel->configure('LABEL',_('Cancel'));
			$btn_cancel->configure('HREF',core\general::create_url(['service','1','plugin','administrator','action','main','p','administrator','a','blocks']));
			
			$row = new control\row;
			$row->configure('IN_TABLE',false);
			$row->add($btn_update,3);
			$row->add($btn_cancel,3);
			$frm_personal_settings->add($row);
		  	$tab->add($frm_personal_settings);
		  	//-------------------------------------------------------------------------------
		  	$frm_email_settings = new control\form('frm_email_settings');
		  	$frm_email_settings->configure('LABEL',_('Emails'));

		  	$txt  = new control\textbox('ff');
		  	$frm_email_settings->add($txt);
		  	$tab->add($frm_email_settings);
		  	return [_('Account settings'),$tab->draw()];
		  }

		  //rhis function show blocked ip list
		  protected function view_ip_block($ips){
		  	 	$form = new control\form("users_list_ip_blocked");
				$form->configure('LABEL',_('Blocked IPs'));
				
				$table = new control\table;
				$key=1;
				foreach($ips as $key=>$ip){
					$row = new control\row;
					
					//add id to table for count rows
					$lbl_id = new control\label($key);
					$key++;
					$row->add($lbl_id,1);
					
					//add ip
					$lbl_ip = new control\label(long2ip($ip->ip));
					$row->add($lbl_ip,2);
		            

					//add edite button
		            $btn_remove = new control\button;
		            $btn_remove->configure('LABEL',_('Delete'));
		            $btn_remove->configure('TYPE','info');
		            $btn_remove->configure('VALUE',$ip->id);
					$btn_remove->configure('P_ONCLICK_PLUGIN','users');
					$btn_remove->configure('P_ONCLICK_FUNCTION','btn_onclick_ip_block_delete');
					$row->add($btn_remove,1);
					$table->add_row($row);
					
				}
				
				//add headers to table
				$table->configure('HEADERS',array(_('ID'),_('IP number'),_('Options')));
				$table->configure('HEADERS_WIDTH',[1,5,2]);
				$table->configure('ALIGN_CENTER',[TRUE,FALSE,TRUE]);
				$table->configure('BORDER',true);
				$form->add($table);

				//update and cancel buttons
				$btn_update = new control\button('btn_add_new');
				$btn_update->configure('LABEL',_('Add IP'));
				$btn_update->configure('HREF',core\general::create_url(['service','1','plugin','administrator','action','main','p','users','a','ip_block_new']));
				$btn_update->configure('TYPE','primary');
				
				$btn_cancel = new control\button('btn_cancel');
				$btn_cancel->configure('LABEL',_('Cancel'));
				$btn_cancel->configure('HREF',core\general::create_url(['service','1','plugin','administrator','action','main','p','administrator','a','dashboard']));
				
				$row = new control\row;
				$row->configure('IN_TABLE',false);
				$row->add($btn_update,1);
				$row->add($btn_cancel,11);
				$form->add($row);
				return [_('Blocked IPs'),$form->draw()];
		  }

		  //this function is for add new ip to block list
		  protected function view_ip_block_new(){

		  	$form = new control\form('frm_new_ip_block');
		  	$txt_ip = new control\textbox('txt_ip');
		  	$txt_ip->configure('LABEL',_('IP Address'));
		  	$txt_ip->configure('ADDON',_('*'));
		  	$txt_ip->configure('SIZE',4);
			$txt_ip->configure('HELP',_('Enter ip that you want will be blocked by system. '));
			$form->add($txt_ip);
			//update and cancel buttons
			$btn_update = new control\button('btn_add');
			$btn_update->configure('LABEL',_('Add'));
			$btn_update->configure('P_ONCLICK_PLUGIN','users');
			$btn_update->configure('P_ONCLICK_FUNCTION','btn_onclick_add_new_ip_blocklist');
			$btn_update->configure('TYPE','primary');
			
			$btn_cancel = new control\button('btn_cancel');
			$btn_cancel->configure('LABEL',_('Cancel'));
			$btn_cancel->configure('HREF',core\general::create_url(['service','1','plugin','administrator','action','main','p','users','a','ip_block']));
			
			$row = new control\row;
			$row->configure('IN_TABLE',false);
			$row->add($btn_update,1);
			$row->add($btn_cancel,11);
			$form->add($row);
		  	return [_('Block new ip'),$form->draw()];
		  }
}
?>
