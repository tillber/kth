$(document).ready(function() {
    	  $('#calculate').click(function(e) {
    		e.preventDefault();
    	    $.ajax({
 		         url: "./api/stations", 
 		         dataType: "json",
 		         type: 'POST',
 		         data: $("#calcForm").serialize(), 
 		         //contentType: "application/x-www-form-urlencoded",
 		         success: function(data){ 
 		        	 console.log(data);
 		        	$("#results").empty();
 		        	$.each( data, function( index, value ) { 		        		
 		        		$("#results").append('<p>' + value.firstFuel.type + ": " + value.secondStation + " is " + value.cheaper + " kr/l cheaper (" + value.secondFuel.price + " kr/l compared to "
 		        				+ value.firstFuel.price + " kr/l, save of " + value.save + " kr), you will pay " + value.cost + " kr for " + value.liters + " l</p>");
	  			    });
 		         },
 		         error: function(){
 		        	 alert("error");
 		         }
 		      });
    	  });
    	  
    	  $('#add').click(function(e) {
      		e.preventDefault();
      	    $.ajax({
   		         url: "./api/stations/add", 
   		         dataType: "json",
   		         type: 'POST',
   		         data: $("#addStationForm").serialize(), 
   		         //contentType: "application/x-www-form-urlencoded",
   		         success: function(data){ 
   		        	$("#successfulAdd").append("Successfully added station!");
   		        	$("#successfulAdd").show();
   		         },
   		         error: function(){
   		        	 alert("error");
   		         }
   		      });
      	  });
    	  
    	  $("#getall").click(function() {
  			$("#table").css("display", "inline-table");
	  			$.get("./api/stations", function(data){
	  				$("#table tbody").empty();
	  				$.each( data, function( index, value ) {
	  			        var $tr = $('<tr>').append(
	  			            $('<td>').text(value.company),
	  			            $('<td>').text(value.unleaded95.price),
	  			            $('<td>').text(value.unleaded98.price),
	  			            $('<td>').text(value.diesel.price),
	  			            $('<td>').text(value.ethanol.price)
	  			        );
	  			        
	  			        $("#table tbody").append($tr);
	  			    });
	  			});
  			});
    	  
    	  $.get("./api/stations", function(data){
				$.each( data, function( index, value ) {					
					 $('#station1').append("<option value=" + value.id + ">" + value.company + "</option>");
					 $('#station2').append("<option value=" + value.id + ">" + value.company + "</option>");
					 $('#bycompany').append("<option value=" + value.id + ">" + value.company + "</option>");
			    });
			});
    	  
    	  $("#getbycompany").click(function() {
    		  $("#table").css("display", "inline-table");
	  			$.get("./api/stations/" + $("#bycompany").val(), function(data){
	  				$("#table tbody").empty();
	  				var $tr = $('<tr>').append(
	  			            $('<td>').text(data.company),
	  			            $('<td>').text(data.unleaded95.price),
	  			            $('<td>').text(data.unleaded98.price),
	  			            $('<td>').text(data.diesel.price),
	  			            $('<td>').text(data.ethanol.price)
	  			        );
	  			        
	  			    $("#table tbody").append($tr);
	  			});
    	  });
    });		