let queryString = location.search;
let urlParams = new URLSearchParams(location.search);

function getUsername(){
	let username;
	
	$.getJSON({url: "../Username", async: false, success: function(result){ 
		username = result; 
	}});
	
	return username;
}

function getComments(){	
	$.getJSON({url: "../GetCommentsRecipe?recipe="+urlParams.get('recipe'), success: function(result){
		let comments = result;
		$("#comments").empty();
		let username = getUsername();
		
		if(comments.length == 0){
			$("#comments").append("<p class='no-comments mb-5 mt-5'>Inga kommentarer finns till detta recept.</p>");
		}else{
			$.each(comments, function (i, comment) {
				let date = new Date(comment.date);
				date = date.getDate()+"/"+(date.getMonth()+1)+"/"+date.getFullYear();
				
				if(username != null && comment.author == username){
					$("#comments").append("<div class='card border-primary mb-3'><div class='card-body'><div class='row'><div class='col-sm-8'><h5 class='mt-0'>" + comment.author + "</h5></div><div class='col-sm-4 comment-column-right'><form class='delete-form' name='delete-form'><input name='commentID' type='hidden' value='" + comment.id + "'/><button type='submit' class='btn btn-danger btn-sm mr-2 delete-button'>Ta bort</button></form>" + date + "</div></div><p class='card-text'>" + comment.content + "</p></div></div>");
					
				}else{
					$("#comments").append('<div class="card mb-3"><div class="card-body"><div class="row"><div class="col-sm-8"><h5 class="mt-0">' + comment.author + '</h5></div><div class="col-sm-4 comment-column-right">' + date + '</div></div><p class="card-text">' + comment.content + '</p></div></div>');
				}
			});
		}
	}});
}

$(document).ready(function() {			
	function deleteComment(id){
		let modal = confirm("Är du säker på att du vill radera kommentaren?");
		if (modal == true) {
			$.ajax({url: "../DeleteComment?id="+id, success: function(result){
				getComments();
			}});
		}
	}

	function storeComment(content, recipe){
		$.ajax({url: "../StoreComment?content="+content+"&recipe="+recipe, success: function(result){
			getComments();
		}});
	}
	
	$(document).on("submit", "#comment-form", function(e){
		storeComment($("#content").val(), urlParams.get('recipe'));
		$("#content").val("");
		getComments();
		e.preventDefault();
	});
	
	$(document).on("submit",'form.delete-form', function(e){
		deleteComment($(this).children('[name="commentID"]').val());
		e.preventDefault();
	});
	
	getComments();
});

