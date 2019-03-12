<?php
namespace TastyRecipes\View;
use TastyRecipes\Controller\Controller;

$controller = new Controller();
		$comments = $controller->getComments($this->recipe);
		
		if(count($comments) == 0){
				echo "<p class='no-comments mb-5 mt-5'>Inga kommentarer finns till detta recept.</p>";
			} else{
				foreach($comments as $comment){				
					if($this->session->get('username') != null and $comment->getAuthor() === $this->session->get('username')){						
						echo("<div class='card border-primary mb-3'>
								<div class='card-body'>
									<div class='row'>
										<div class='col-sm-8'><h5 class='mt-0'>" . $comment->getAuthor() . "</h5></div>
										<div class='col-sm-4 comment-column-right'>
											<form method='get' class='delete-form' action='DeleteComment'>
												<input type='hidden' name='id' value='" . $comment->getId() . "' />
												<button type='submit' class='btn btn-danger btn-sm mr-2 delete-button'>Ta bort</button>
											</form>
											" . date("Y-m-d",strtotime($comment->getDate())) . "
										</div>
									</div>
									<p class='card-text'>" . $comment->getContent() . "</p>
								</div>
							</div>");
						
					}else{
						echo("<div class='card mb-3'>
								<div class='card-body'>
									<div class='row'>
										<div class='col-sm-8'><h5 class='mt-0'>" . $comment->getAuthor() . "</h5></div>
										<div class='col-sm-4 comment-column-right'>" . date("Y-m-d",strtotime($comment->getDate())) . "</div>
									</div>
									<p class='card-text'>" . $comment->getContent() . "</p>
								</div>
							</div>");
					}
				}
			}
?>