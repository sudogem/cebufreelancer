// JavaScript Document

$(document).ready(function(){
 
 	if ( document.getElementById('closeme') )
	{	
		$('.flash')
		.fadeIn(1000)
		.animate({opacity:1.0}, 2000) ;
		$('#closeme').click( function(){
			$('.flash')
			.fadeOut('normal', function(){
			$(this).remove();
			});
		});
	}
	else
	{
		$('.flash')
		.fadeIn(1000)
		.animate({opacity:1.0}, 2000)
		.fadeOut(1000, function() {
			$(this).remove();
		}) ;
	}
	
	var scrollspeed = 10;
	$(function() {
				 $('#scbottom').click(function () {
					 $('html, body').animate({
						 scrollTop: $(document).height()
					 },
					 scrollspeed);
					 return false;
				 });

				 $('#sctop').click(function () {
					 $('html, body').animate({
						 scrollTop: '0px'
					 },
					 scrollspeed);
					 return false;
				 });
			 }); 

	$('#searchcmd').click(function() {
		$('#searchbx').toggle(100);
	});
	
	if (typeof $('.tooltipsy').tipsy == 'function' ) {
		$('.tooltipsy').tipsy({html:true});
	}
	
	$("#btncancelbid").click( function() {
		c = confirm( "Are you sure you want to cancel your bid?" ) ;
		if ( c ) $("#btncancelbid").submit( ) ;
		else return false ;
	});	

	$("#closepbtn").click( function() {
		c = confirm( "Are you sure you want to close the project?" ) ;
		if ( c ) $("#closepbtn").submit( ) ;
		else return false ;
	});


	$(function() {
		$("#cmdreply").click( function(event){
			event.preventDefault( ) ;
			$("#replyb").slideToggle( ) ;
		}) ;
	}) ;

	$(function() {
		$("#bidbutton").click( function(event){
			event.preventDefault( ) ;
			$("#bidme").slideToggle( ) ;
		}) ;
	}) ;

	if ($("#viewproject").height() <= 1000 )
	{
		$('#ads160x600').html("&nbsp;");
	}	
    

    $(".photof").mouseenter(function(){
		id = $(this).attr('id');
		$('.deletephoto_'+id).show();
		$('.deletephoto_'+id).addClass('deletephotoico');

    }).mouseleave(function(){
		id = $(this).attr('id');
		$('.deletephoto_'+id).hide()
    });
	
	if (typeof $("#work").sortable == 'function') {
		$("#work").sortable( { placeholder : '.sortarrow' } );
	}

	if (typeof $("#education").sortable == 'function') {
		$("#education").sortable( { placeholder : '.sortarrow' } );
	}	

	if (typeof $("#references").sortable == 'function') {
		$("#references").sortable( { placeholder : '.sortarrow' } );
	}		
	
});

function gotoURL(url) 
{
	window.location.href = url;
}

function ischecked( ischeck )
{
	if ( ischeck.checked == true )
		document.actionform.boxchecked.value++ ;
	else
		document.actionform.boxchecked.value-- ;
}
	
 
	
function toggles( idx ) {
	$("#"+idx ).slideToggle(100) ;
}

function toggleDetail(id) {
	$("div#proj_"+id+"_detail").slideToggle('fast');
}


//OPEN_IMAGE = 'images/arrowr_18.gif';
//CLOSED_IMAGE = 'images/arrowd_18.gif';
function blocking(nr, d)
{
	is_open = false ;
	if (document.layers)
	{
		current = (document.layers[nr].display == 'none') ? 'block' : 'none';
		document.layers[nr].display = current;
		is_open = (current == 'block') ?  true : false ;		
	}
	else if (document.all)
	{
		current = (document.all[nr].style.display == 'none') ? 'block' : 'none';
		document.all[nr].style.display = current;
		is_open = (current == 'block') ?  true : false ;				
	}
	else if (document.getElementById)
	{
		current = (document.getElementById(nr).style.display == 'none') ? 'block' : 'none';
		document.getElementById(nr).style.display = current;
		is_open = (current == 'block') ?  true : false ;				
	}
	if (is_open==false)	document.getElementById(d).src = OPEN_IMAGE ;
	else {
		document.getElementById(d).src = CLOSED_IMAGE ;
	}
	
}



function submit_action( action )
{
	document.nbox.action.value= action ;
	try {
		document.nbox.onsubmit();
		}
	catch(e){}
	document.nbox.submit();

}

function checkAll ( n , chkname )
{
	if ( !chkname )		
	{
		chkname = 'cb';
	}
	
	var f = document.actionform ;
	var c = f.toggle.checked ;
	var x = 0 ;
	
	for ( i=0 ; i < n ; i++ )
	{
		cb = eval( 'f.' + chkname + '' + i );
		if (cb)
		{
			cb.checked = c ;
			x++ ;
		}
	}
	if ( c )
	{
		f.boxchecked.value = x ;
	}
	else
	{
		f.boxchecked.value = 0 ;	
	}
	
}


function add_references() 
{
	var reference_block = '<table width="100%" class="section addreference" style="display:none" >' +
	    '<tr>' +
        '<td width="18%" class="field">Name&nbsp;</td>' +
        '<td width="82%"><input type="text" name="references[name][]" value="" />' +
		'<a href="javascript:void(0)" style="float:right" class="sortarrow tooltipsy" title="<span class=tt>Drag</span>" ></a>' + 
		'<a href="javascript:void(0)" onclick=hideblock(); class="removeico tooltipsy" title="<span class=tt>Delete</span>" ></a></td>' +
		'</td>' +
        '</tr>' +

        '<tr>' +
        '<td class="field">Position&nbsp;</td>' +
        '<td><input type="text" name="references[title][]" value="" /></td>' +
        '</tr>' +

        '<tr>' +
        '<td class="field">Details&nbsp;</td>' +
        '<td><input type="text" name="references[details][]" value="" /></td>' +
        '</tr>' +
        
 		'<tr>' +
        '<td class="field">Company&nbsp;</td>' +
        '<td><input type="text" name="references[company][]" value="" /></td>' +
        '</tr>' +
     	
        '<tr>' +
        '<td class="field">Department&nbsp;</td>' +
        '<td><input type="text" name="references[department][]" value="" /></td>' +
        '</tr>' +
        
        '<tr>' +
        '<td class="field">Address&nbsp;</td>' +
        '<td><input type="text" name="references[address][]" value="" /></td>' +
        '</tr>' +

        '<tr>' +
        '<td class="field">City&nbsp;</td>' +
        '<td><input type="text" name="references[city][]" value="" /></td>' +
        '</tr>' +

        '<tr>' +
        '<td class="field">State&nbsp;</td>' +
        '<td><input type="text" name="references[state][]" value="" /></td>' +
        '</tr>' +

        '<tr>' + 
        '<td class="field">Postalcode&nbsp;</td>' +
        '<td><input type="text" name="references[postalcode][]" value="" /></td>' +
        '</tr>' +

        '<tr>' +
        '<td class="field">country&nbsp;</td>' +
        '<td><input type="text" name="references[country][]" value="" /></td>' +
        '</tr>' +

        '<tr>' +
        '<td class="field">Contact no&nbsp;</td>' +
        '<td><input type="text" name="references[contactno][]" value="" /></td>' +
        '</tr>' +

        '<tr>' +
        '<td class="field">Email&nbsp;</td>' +
        '<td><input type="text" name="references[email][]" value="" /></td>' +
        '</tr>' +
		
    '</table><input type="hidden" name="references[id][]" value="" />'; 

    	
	$('#references').prepend(reference_block) 
    $('.addreference')
	.fadeIn(1000)
	.animate({opacity:1.0}, 2000) ;
	$('.tooltipsy').tipsy({html:true});	
}


function hideblock() {
	$('.section').bind('click', function(){
		$(this).remove();
		$('.section').unbind();
		$('.tipsy').hide(); // hide the tipsy after removing the div.section
	});
}

function toggleDate(id, m) {
  
  if (m == 0 ) {
    chk = $('#ckcurrent0' + id).is(':checked');
    if (chk) {
      $('.selectenddate0' + id).hide();
      $('.presentdate0' + id).show();
	  $('#workexperience' + id).val('on');
    } else {
      $('.selectenddate0' + id).show();
      $('.presentdate0' + id).hide();        
    }        
  } else {
    chk = $('#ckcurrent' + id).is(':checked');
    if (chk) {
      $('.selectenddate' + id).hide();
      $('.presentdate' + id).show();
	  $('#workexperience' + id).val('on');
    } else {
      $('.selectenddate' + id).show();
      $('.presentdate' + id).hide();
	  $('#workexperience' + id).val('off');
    }        
  }
}

