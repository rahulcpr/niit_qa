/* accordion.js */

function getAccordion(element_id,screen) 
{
    if ($(window).width() < screen) 
	{
		var concat = '';
		obj_tabs = $( element_id + " li a" ).toArray();
		obj_cont = $( "#quicktabs-container-ifbi-team .quicktabs-tabpage").toArray();
		jQuery.each( obj_tabs, function( n, val ) 
		{
			concat += '<div id="' + n + '" class="panel panel-default">';
			concat += '<div class="panel-heading" role="tab" id="heading' + n + '">';
			concat += '<h4 class="panel-title"><a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse' + n + '" aria-expanded="false" aria-controls="collapse' + n + '">' + val.innerHTML + '</a></h4>';
			concat += '</div>';
			concat += '<div id="collapse' + n + '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading' + n + '">';
			concat += '<div class="panel-body">' + obj_cont[n].innerHTML + '</div>';
			concat += '</div>';
			concat += '</div>';
		});
		$("#accordion").html(concat);
		$("#accordion").find('.panel-collapse:first').addClass("in");
		$("#accordion").find('.panel-title a:first').attr("aria-expanded","true");
		$(element_id).remove();
		$("#quicktabs-container-ifbi-team").remove();
	}	
}