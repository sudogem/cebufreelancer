<div id="leftb" ><!-- start left block -->	

<form action="<?= site_url( 'settings/projects/save_project' ) ?>" method="post" >
<fieldset>
	<legend>Post a new project</legend>
<div class="note1" >NOTE:<br /> 
  You're not allowed to post any contact information on CebuFreelancer.com according to our Terms of Service.</div>	
	<div><label>Project Title</label><br /><em>Name of your project.</em><br />
	<input type="text" name="title" class="text ad" /></div> 	
	<div><label>Description</label><br />
	<em>Describe the project in detail.  Add as much information as possible about your project.</em><br />
	
	<textarea name="description" class="text ad" rows="15"></textarea></div>
	
	<div><label>Budget </label><br /><em>Input the budget range for the project. </em>
	<br />
	<input type="text" name="budget" class="text ad" /></div> 
	<div>
	  <label>Deadline </label>
	  <br />
	  <em>Sample deadline: 1-2 months, 1 week, ASAP, No Deadline(ND), 6 month contract work@home, etc...</em>
	<br />
	<input type="text" name="duration" class="text ad" /></div>	
	<div><label>How many days the project should stay in the project listing.</label><br />
	<label><input type="radio" name="numofdays" value="1" />7 days</label><br />
	<label><input type="radio" name="numofdays" value="2" />15 days</label><br />
	<label><input type="radio" name="numofdays" value="3" />30 days</label><br />
	</div>
	
	<div align="center" class="submit1" ><input type="submit" name="preview" value="Preview Project &raquo;"  class="button" /></div>
</fieldset>
</form>

</div><!-- end left block -->	