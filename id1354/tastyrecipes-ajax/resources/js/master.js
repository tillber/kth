function getUsername(){
	let username;
	
	$.getJSON({url: "../Username", async: false, success: function(result){ 
		username = result; 
	}});
	
	return username;
}

$(document).ready(function() {
	let username = getUsername();
	
	if(username != null){
		$("#log-button").empty().html("<a href='' id='logout-button' class='nav-link'>Logga ut (" + getUsername() + ")</a>");
		$("#comment-section").empty().html("<div class='card my-4'><h5 class='card-header'>Lämna en kommentar</h5><div class='card-body'><form id='comment-form'><div class='form-group'><textarea class='form-control' rows='3' id='content' name='content'></textarea></div><button type='submit' id='comment' class='btn btn-primary'>Kommentera</button></form></div></div><hr>");
	}else{
		$("#log-button").empty().html("<a href='' id='login-button' class='nav-link login-button' data-toggle='modal' data-target='#login-modal'>Logga in</a>");
		$("#comment-section").empty();
	}
	
	$(document).on("click", "#login", function(){		
		$.ajax({url: "../Login?username=" + $("#username").val() + "&password=" + $("#password").val(), success: function(result){
			
			$("#log-button").empty().html("<a href='' id='logout-button' class='nav-link'>Logga ut (" + getUsername() + ")</a>");
			
			$("#comment-section").html("<div class='card my-4'><h5 class='card-header'>Lämna en kommentar</h5><div class='card-body'><form id='comment-form'><div class='form-group'><textarea class='form-control' rows='3' id='content' name='content'></textarea></div><button type='submit' id='comment' class='btn btn-primary'>Kommentera</button></form></div></div><hr>");
			
			getComments();			
		}});
	});
	
	$(document).on("click", "#logout-button", function(e){
		$.ajax({url: "../Logout", success: function(result){
			
			$("#log-button").empty().html("<a href='' id='login-button' class='nav-link login-button' data-toggle='modal' data-target='#login-modal'>Logga in</a>");
			
			$("#comment-section").empty();
			
			getComments();
		}});
		e.preventDefault();
	});
});
