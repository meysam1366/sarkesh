<div id="users_login" class="users_login" >
	<script language="javascript" type="text/javascript" src="../plugins/users/scripts/users.js"></script>
	<div id="msg" class="users_login_msg" ></div>
	<form>
		<div class="form-group">
			<label for="username"> Username: </label>
			<input type="text" id="username" class="form-control" name="username" placeholder=" Username">
			<label for="password"> Password: </label>
			<input type="password" id="password" class="form-control" name="password" placeholder="******">
			<div class="checkbox">
				<input type="checkbox" id="remember" class="form-control" name="remember" value="yes">
			<label class="lcb>">Remember me!</label>
			</div>
			<input type="button" class="form-control btn btn-primary" data-loading-text="Loading..." onclick="users_login()" value="Sign in">
			<a href=".?plugin=users&action=forget_password" >Forget your password?</a>
		</div>
	</form>
</div>