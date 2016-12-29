$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#ticketsupport-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});


/*
$('#ticketsupport-affecter').submit( function(eventObj) {
      $('<input />').attr('type', 'hidden')
          .attr('name', 'ids-appended')
          .attr('value', tab)
          .appendTo(this);
      return true;
  });*/
/*$('#ticketsupport-grpEnAttente').click( function(eventObj) {
      $('<input />').attr('type', 'hidden')
          .attr('name', 'ids-appended')
          .attr('value', tab)
          .appendTo(this);
      return true;
  });*/
/*$('#ticketsupport-grpSortirAttente').submit( function(eventObj) {
      $('<input />').attr('type', 'hidden')
          .attr('name', 'ids-appended')
          .attr('value', tab)
          .appendTo(this);
      return true;
  });*/
/*$('#ticketsupport-grpCloturer').submit( function(eventObj) {
      $('<input />').attr('type', 'hidden')
          .attr('name', 'ids-appended')
          .attr('value', tab)
          .appendTo(this);
      return true;
  });
*/

$('input:checkbox').removeAttr('checked');     
$(this).val('check all');


var tab = [];
$('body').delegate('.checkbox-column','change',function(){
	var idcheckbox = $(this).children('input').attr('id');
	var id = $(this).parent().children(':first-child').html();
	var isCheck = $(this).children(':first-child').is(':checked');
	if(idcheckbox=='ticketsupport-grid_c10_all'){
		if(isCheck){
			tab = [];
			$(this).parent().parent().parent().children().eq(1).children().each(function(){
				isCheck = $(this).children(':last-child').children().is(':checked');
				tab.push($(this).children(':first-child').html());
			})		
		}
		else{
			tab=[];
		}

	}
	else{
		$(this).parent().children(':first-child').each(function() { 
			if(isCheck){
				tab.push($(this).html());		
			}
			else{
				var removeItem=$(this).html();
				tab = $.grep(tab, function(value) {
				  return value != removeItem;
				});
			}	
		});	
	}
	
	function sendAction(jsonTab,url){

		$.ajax({
		   type: 'POST',
		    url: url,
		   data:jsonTab,
		success:function(response){
		                alert(response); 
		                $.fn.yiiGridView.update("ticketsupport-grid");
		              },
		   error: function(response) { // if error occured
		         alert("Error occured");
		    },
		 
		  dataType:'html'
		  });
	}

	$("#ticketsupport-grpEnAttente").unbind('submit').bind('submit',function(){
		var jsonTab = {idsToAppend:tab};
		var url = 'index.php?r=ticketsupport/grpenattente';
		console.log(jsonTab);
		sendAction(jsonTab,url);
		tab = [];
		return false;
	});

	$('#ticketsupport-grpSortirAttente').unbind('submit').bind('submit',function(){
		var jsonTab = {idsToAppend:tab};
		var url = 'index.php?r=ticketsupport/grpsortirattente';
		console.log(jsonTab);
		sendAction(jsonTab,url);
		tab = [];
		return false;
	  });
	$('#ticketsupport-affecter').unbind('submit').bind('submit',function(){
		var idtech = $('select#Ticketsupport_idtechnicien').val();
		var jsonTab = {idsToAppend:tab,
						idTechnicien:idtech};
		var url = 'index.php?r=ticketsupport/affecter';
		console.log(jsonTab);
		sendAction(jsonTab,url);
		tab = [];
		return false;
	  });
	$('#ticketsupport-grpCloturer').unbind('submit').bind('submit',function(){
		var jsonTab = {idsToAppend:tab};
		var url = 'index.php?r=ticketsupport/grpcloturer';
		console.log(jsonTab);
		sendAction(jsonTab,url);
		tab = [];
		return false;
	  });
});
	