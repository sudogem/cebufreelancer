<div style="width:98%;  float:left" id="form_section" >
<style type="text/css" >
#form_section label {
color:#222222;
cursor:pointer;
clear:both;
float:left;
font:bold 15px arial, Georgia,serif;
margin:1px 11px 0 0;
padding-top:4px;
text-align:right;
}

</style>

<?= !empty( $flash_message ) ? flash_message( $flash_message,'red' ) : '' ?>

		<form method="post" action="<?= site_url( 'login/check' ) ?>" >
		
		<fieldset class="fld5"  >
		<legend>Login</legend>
<table>
			<tr>
				<td><label>Username</label> </td>
				<td><input type="text" name="username" class="text ab" /></td>
			</tr>

			<tr>
				<td><label>Password</label> </td>
				<td><input type="password" name="password" class="text ab" /></td>
			</tr>

			<tr>
				<td></td>
				<td>
				<input type="submit" name="login" value="Sign in" class="button" />
				<label for="remember" style="float:none"  >&nbsp;&nbsp;Remember me? <input type="checkbox" name="remember" id="remember" /></label>
				</td>
			</tr>
			
			<tr>
				<td></td>
				<td><a href="<?= site_url( '/lostpassword' ) ?>" >Forgot your password?</a></td>
			</tr>
			
		</table>
		
		
		<p style="padding-top:15px">Don't have an account? <a href="<?= site_url( 'signup/' )?>" >Sign up here</a> <em>It's FREE!</em></p>
				 
		</fieldset>
		</form>
</div>
