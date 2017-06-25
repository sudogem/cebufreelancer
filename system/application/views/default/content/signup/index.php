<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
		<div style="margin:10px 0 0 10px ; width:905px ; min-width:800px ; " >
		<?= !empty( $this->validation->error_string ) ? flash_message( $this->validation->error_string, 'red', TRUE ) : '' ?>				

		<div class="features" >
		<h1 class="h2">Do you want to be a freelancer ?</h1>
		<p>Become a freelance web designer, cebu flash developer, drupal developer, ruby on rails developer or  iphone developer here in Cebu, Philippines. <br />
		Sign up now and its free. </p>
					<ul style="list-style-position:inside">
					<li>Registration is FREE.</li>
					<li>Create your profile easily and showcase your field of expertise. </li>					
					<li>Find latest project postings and  bid on the project that interest you.</li>
					<li>Complete the projects that you've been awarded.</li>
					<li>Tell your friends and officemates about this site.</li>
					</ul>		
		</div>
		
		<div class="features2" >
		<h1 class="h2">You got a project and you need a freelancer to work with your project ?</h1>
		<p>You need a programming and related services such as a website design, e-commerce development, drupal programming,  ruby on rails development, etc., but do not know how to find professionals who can do quality work at an affordable price. Just simply register on our site, create your account, post your project details, requirements, budget, etc., Registered freelancers will just respond or place a bid to your project request. 		
	    <br />
	    So sign up now and its free. </p>
					<ul style="list-style-position:inside">
					<li>Registration is FREE.</li>
					<li>Post as many projects as you want.</li>
					<li>Choose the best quote and find  the qualified professionals. </li>
					</ul>		
		</div>
		<div class="clear" ></div>
		
		<div id="begin" style="margin:0 0 0 8px ; "  >
		<form action="<?= site_url( 'signup/do_signup' ) ?>" method="post" id="form_section" name="form1" >
		<fieldset class="fld5" >
			<legend>Sign up (* required information )</legend>
			<p style="margin:0;"></p>
			<div><label>Full Name *</label> 			
			<div class="clear"></div>
			<input type="text" name="fullname" class="text ab" value="<?= !empty( $this->validation->fullname ) ? $this->validation->fullname : '' ; ?>" /></div> 			
			<div class="clear"></div>
			<div><label>Email *</label> 
			<div class="clear"></div>
			<input type="text" name="email" class="text ab" value="<?= !empty( $this->validation->email ) ? $this->validation->email : '' ; ?>" /></div>			
			<div class="clear"></div>
			<div class="b" ><label>Username*</label> 
			<div class="clear"></div>
			<em>can only use alpha-numeric characters.</em><br />
			<input type="text" name="username" class="text ab" value="<?= !empty( $this->validation->username ) ? $this->validation->username : '' ; ?>" /></div> 			
			<div class="clear"></div>
			<div><label>Password *</label> 
			<br /><em>can only use alpha-numeric characters.</em><br />
			<input type="password" name="password" class="text ab" value="<?= !empty( $this->validation->password ) ? $this->validation->password : '' ; ?>" />
			</div>
			<div class="clear"></div>
			<div class="b" ><label>Retype Password *</label> 
			<br />
			<input type="password" name="password2" class="text ab" value="<?= !empty( $this->validation->password ) ? $this->validation->password : '' ; ?>" /></div> 
			<div class="clear"></div>
			<div class="b" ><label>Verification code *</label>
			<br />
			<div id="captchas"><?= $captcha_img ; ?></div>
			<a href="javascript:void(0)" onclick="$.post('<?= site_url('signup/generate_form_captcha')?>', function(data) { $('#captchas').replaceWith('<div id=captchas >' + data + '</div>') } )" >Cannot read? Generate a new one.</a><br />
			<label>Enter the characters shown in the image above.</label><br />
			<input type="text" name="seccode" class="text ab" /></div>
			<div class="clear"></div>			
			<input name="agreement" id="agreement" type="checkbox" >
			&nbsp;<em>I have read and agree to the <a href="<?= site_url( '/tos' ) ?>" >Terms of Service</a> and <a href="<?= site_url( '/privacy' ) ?>" >Privacy</a> statement</em><br /> 
			<input type="submit" name="signup" value="Sign up"  class="button" />  
			<input type="hidden" name="agree" id="agree"  />
		</fieldset>
		</form>		
		</div>
		</div>

