	//num 0 = is registered messeage
	//num 1 = is cerect email
	register_form_msg = new Array();


function users_login(){
	//first check for that user name or password not empty
	var username = $("div.users_login input#users_username").val();
	var password = $("div.users_login input#users_password").val();
	var url;
	if(username && password){
	
		 //username and password is filled
		 if ($('div.users_login input#users_remember').is(":checked")){
			//remember is checked
			url = "?service=1&plugin=users&action=login&username=" + username + "&password=" + password + "&remember=yes";
		 }
		 else{
			url = "?service=1&plugin=users&action=login&username=" + username + "&password=" + password;
		 }
		$.get(url ,
			function(data){
				if(data == '1'){
					//login successfull going to refresh page
					location.reload();
				}
				else{
					 //username or password is incerrect or user loged in before
					 //we get message from server for show in localize matched
					  xmlDoc = $.parseXML( data ),
					  $xml = $( xmlDoc ),
					  $header = $xml.find( "header" );
					  $content = $xml.find( "content" );
					  $btnback = $xml.find( "btn-back" );
					  BootstrapDialog.show({
					  type: BootstrapDialog.TYPE_WARNING,
					  title: $header.text(),
					  message: $content.text(),
					  onshow: function(){
						$("div.users_login input#users_username").val("");
						$("div.users_login input#users_password").val("");
					  },
					  buttons: [{
					      label: $btnback.text(),	       
					      action: function(dialogItself){dialogItself.close(); }		       
					      }]
					  });     



				}
			}
		); 
		
	}
	else{
	    //username or password not filled
	    //add warrning class to textboxes
	
	  
	}
	


}

function users_logout(){
	var url = url = "?service=1&plugin=users&action=logout";
	$.get(url ,
		function(data){
			//if recive 1 that mean log out successfull else show msg
			if(data == '1'){
				//logout successfull going to refresh page
				location.reload();
			}
			else{
				//problem in logout
				 xmlDoc = $.parseXML( data ),
				$xml = $( xmlDoc ),
				$header = $xml.find( "header" );
				$content = $xml.find( "content" );
				$btnback = $xml.find( "btn-back" );
				BootstrapDialog.show({
				type: BootstrapDialog.TYPE_WARNING,
				title: $header.text(),
				message: $content.text(),

				buttons: [{
					  label: $btnback.text(),	       
					  action: function(dialogItself){dialogItself.close(); }		       
				}]
				});   	 
			}
		}
	); 
}

//this function check user forget password and show result
function users_forget_password(){
  var email = $("div.users_forget input#users_email").val();
  if(email){
	  var url = url = "?service=1&plugin=users&action=send_forget_email&email=" + email;
		$.get(url ,
			function(data){
					//problem in logout
					xmlDoc = $.parseXML( data ),
					$xml = $( xmlDoc ),
					$type = $xml.find( "type" );
					$header = $xml.find( "header" );
					$content = $xml.find( "content" );
					$btnback = $xml.find( "btn-back" );
					BootstrapDialog.show({
					type: $type.text(),
					title: $header.text(),
					message: $content.text(),
					onhide: function(){ $('div.users_forget input#users_email').val('');},
					buttons: [{
						  label: $btnback.text(),	       
						  action: function(dialogItself){dialogItself.close(); }		       
					}]
					});   	 
				
			}
		); 
  }
}

function users_reset_password(){
	//get value of code
	var code = $('div.users_reset input#users_reset_code').val();
	if(code){
		var url = url = "?service=1&plugin=users&action=reset_password&USERS_FORGET=" + code;
		$.get(url ,
			function(data){
					//problem in logout
					xmlDoc = $.parseXML( data ),
					$xml = $( xmlDoc ),
					$type = $xml.find( "type" );
					$header = $xml.find( "header" );
					$content = $xml.find( "content" );
					$btnback = $xml.find( "btn-back" );
					BootstrapDialog.show({
					type: $type.text(),
					title: $header.text(),
					message: $content.text(),
					onhide: function(){ $('div.users_reset input#users_reset_code').val('');},
					buttons: [{
						  label: $btnback.text(),	       
						  action: function(dialogItself){dialogItself.close(); }		       
					}]
					});   	 
				
			}
		); 
	  
	}
  
}

//this function check username
function is_registered(){
	var username = $('div.users_register input#users_username').val();
	if(username){
		var url = url = "?service=1&plugin=users&action=is_user_registered&username=" + username;
		$.get(url ,
			function(data){
				if(data != '1'){
				  window.register_form_msg[0] = data;
				  show_message('register_form',0);				  
				}
				else{
				  window.register_form_msg[0] = 'null';
				  hide_message('register_form',0);
				}
				
			}
		); 
	  
	}
}

function users_register(){
  alert(); 
}
function users_cancel_register(){
window.location.href = "../";
}
function show_message(action, index){
  if(action == 'register_form'){
    $("#msg.users_register_msg").html(window.register_form_msg[index]);
  }
}
function hide_message(action, index){
  if(action == 'register_form'){
    $("#msg.users_register_msg").html('');
  }
  
}
