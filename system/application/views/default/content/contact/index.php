<div id="leftb" >
	<div id="page" >
<div style="width:98%;  float:left" >
<?= !empty( $this->validation->error_string ) ? flash_message( $this->validation->error_string, 'red', TRUE ) : '' ?>
<?= !empty( $flash_message ) ? flash_message( $flash_message,'green' ) : '' ?>
		<div style=" width:100% ; float:left ; " >
		<form method="post" action="<?= site_url( "contact/send" ) ?>" id="form_section">
		<fieldset class="fld5"  >
		<legend>Contact Us (* required information )</legend>
		
		<div><label>Name *</label><br />
		<input type="text" name="name" class="text ab" /></div>
		<div class="clear"></div>
		
		<div><label>Email *</label><br />
		<input type="text" name="email" class="text ab" /></div>
		<div class="clear"></div>

		<div><label>Inquiry regarding *</label><br />
		<select name="inquirytype" >
		<option value="1" >Advertise</option>
		<option value="2" >Dispute over project</option>
		<option value="3" >Dispute with other members</option>		
		<option value="4" >Errors/Bugs</option>
		<option value="5" >Feedback</option>
		<option value="6" >Others</option>		
		</select>
		</div><br />
		
		<div class="clear"></div>
		<div><label>Message *</label><br />
		<textarea class="text" rows="10" cols="10" name="message" ></textarea></div><br />
		
		<div class="clear"></div>
		<label>Verification code</label><br />
		<div id="captchas"><?= $captcha_img ; ?></div>
		<a href="javascript:void(0)" onclick="$.post('<?= site_url('contact/generate_form_captcha')?>', function(data) { $('#captchas').replaceWith('<div id=captchas >' + data + '</div>') } )" >Cannot read? Generate a new one.</a><br />
		<label>Enter the characters shown in the image above.</label><br />
		<input type="text" name="seccode" class="text ab" /><br />
		
		<div class="clear"></div>
		<input type="submit" name="submit" value="Submit"  class="button" />
		</fieldset>
		</form>
		</div>
</div>

	
	</div>
</div>
