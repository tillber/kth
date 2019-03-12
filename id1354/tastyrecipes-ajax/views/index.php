<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Start</title>

    <!-- Favicon -->
    <link rel="icon" type="img/ico" href="../../resources/images/favicon.ico">

    <!-- Reset Stylesheet -->
    <link rel="stylesheet" href="../../resources/css/reset.css">

    <!-- Bootstrap core CSS -->
    <link href="../../resources/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../resources/css/style.css" rel="stylesheet">
    <link href="../../resources/css/shop-homepage.css" rel="stylesheet">
    <link href="../../resources/css/index.css" rel="stylesheet">
  </head>

  <body>

    <!-- Master -->
    <div id="master">
		<?php include 'resources/fragments/master.php'; ?>
	</div>

    <!-- Page Content -->
    <div class="container">

      <div class="row">

        <div class="col-lg-3">

          <!-- Side Widget -->

          <?php 
			if(count($comments) == 0){
				echo "<p class='no-comments mb-5 mt-5'>Inga kommentarer ännu!</p>";
			} else{
				$count = 0;
				foreach($comments as $comment){
					if($count == 0){
						echo ("<div class='card mb-3 mt-4 index-comment'><div class='card-body py-3 px-3'><h6 class='card-title user'>");
						echo ("<div class='left'>" . $comment->getAuthor() . "</div><div class='right'><small class='text-muted'>" . date("Y-m-d",strtotime($comment->getDate())) . "</small></div></h6>");
						echo("<p class='card-text'>" . nl2br($comment->getContent()) . "</p></div>");
						echo ("<div class='card-footer px-2 py-1 text-muted comment-footer'><ol class='breadcrumb comment'>");
						echo ("<li class='breadcrumb-item active'><a href='Recipe?recipe=" . $comment->getRecipe() . "'>" . $comment->getRecipe() . "</a></li></ol></div></div>");
					}else{
						echo ("<div class='card mb-3 index-comment'><div class='card-body py-3 px-3'><h6 class='card-title user'>");
						echo ("<div class='left'>" . $comment->getAuthor() . "</div><div class='right'><small class='text-muted'>" . date("Y-m-d",strtotime($comment->getDate())) . "</small></div></h6>");
						echo("<p class='card-text'>" . nl2br($comment->getContent()) . "</p></div>");
						echo ("<div class='card-footer px-2 py-1 text-muted comment-footer'><ol class='breadcrumb comment'>");
						echo ("<li class='breadcrumb-item active'><a href='Recipe?recipe=" . $comment->getRecipe() . "'>" . $comment->getRecipe() . "</a></li></ol></div></div>");
					}
				}
			}
		  ?>
        </div>
        <!-- /.col-lg-3 -->

        <div class="col-lg-9">

          <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
            <ol class="carousel-indicators">
              <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
              <div class="carousel-item active">
                <img class="d-block img-fluid rounded" src="../../resources/images/front/scandinavia.png" alt="First slide">
                <a href="RecipeMenu?country=Sverige"><div class="text-centered text-stylish"><h1>Smaka på Sverige</h1></div></a>
              </div>
              <div class="carousel-item">
                <img class="d-block img-fluid rounded" src="../../resources/images/front/japan.png" alt="Second slide">
                <a href="RecipeMenu?country=Japan"><div class="text-centered text-stylish"><h1>Smaka på Japan</h1></div></a>
              </div>
              <div class="carousel-item">
                <img class="d-block img-fluid rounded" src="../../resources/images/front/india.png" alt="Third slide">
                <a href="RecipeMenu?country=Indien"><div class="text-centered text-stylish"><h1>Smaka på Indien</h1></div></a>
              </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <h5>Välkommen till The Tasty Recipes!</h5>
              <p>
                På vår hemsida kan du hitta flera smakfulla recept från länder runt hela vår jord.
                Se recepten från länderna nedan och låt dig inspireras av ett par grymma maträtter.
                Gå gärna även in på vår kalender för att få en idé om vad du ska laga till middag ikväll!
              </p>
            </div>
			
			<?php
				foreach($countries as $country){
					echo ("<div class='col-lg-12 mb-3'>
							<div class='card h-95'>
								<div class='card-body'>
									<h4 class='card-title recipe-link'>
										<a href='RecipeMenu?country=" . $country->getName() . "'>" . $country->getName() . "</a>
									</h4>
									<p class='card-text country-desc'>" . $country->getDescription() . "</p>
									<div class='text-right'>
										<a href='RecipeMenu?country=" . $country->getName() . "' class='btn btn-outline-primary'>Se recept &rarr;</a>
									</div>
								</div>
							  </div>
							</div>");
				}
			?>
          </div>
          <!-- /.row -->

        </div>
        <!-- /.col-lg-9 -->

      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="py-3 bg-light">
      <?php include 'resources/fragments/footer.php' ?>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="../../resources/jquery/jquery.min.js"></script>
    <script src="../../resources/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="../../resources/js/master.js"></script>

  </body>

</html>
