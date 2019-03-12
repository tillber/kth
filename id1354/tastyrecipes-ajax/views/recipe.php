<!DOCTYPE html>
<?php $this->session->set('recipe', $_GET['recipe']); ?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?php echo $recipe->getName(); ?></title>

	<!-- Favicon -->
	<link rel="icon" type="img/ico" href="../../resources/images/favicon.ico">

	<!-- Reset Stylesheet -->
	<link rel="stylesheet" href="../../resources/css/reset.css">

    <!-- Bootstrap core CSS -->
    <link href="../../resources/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../resources/css/blog-post.css" rel="stylesheet">
    <link href="../../resources/css/style.css" rel="stylesheet">
    <link href="../../resources/css/recipe.css" rel="stylesheet">
    </head>

    <body>

    <!-- Master -->
    <div id="master">
		<?php include 'resources/fragments/master.php' ?>
	</div>

    <!-- Page Content -->
    <div class="container">

      <div class="row">

        <div class="col-lg-12">
          <!-- Title -->
          <h1 class="mt-4" id="title"><?php echo $recipe->getName(); ?></h1>
          <ol id="breadcrumbs" class="breadcrumb">
			<li class="cooking-time">TILLAGNINGSTID <?php echo $recipe->getCookingTime(); ?> MIN</li>
			<li class="breadcrumb-item first-breadcrumb">Recept</li>
			<li class="breadcrumb-item">Land</li>
			<li class="breadcrumb-item"><a href="RecipeMenu?country=<?php echo $recipe->getCountry(); ?>"><?php echo $recipe->getCountry(); ?></a></li>
          </ol>
        </div>

        <!-- Post Content Column -->
        <div class="col-lg-8" id="postContent">

          <!-- Preview Image -->
          <img class="img-fluid recipe rounded cropped cover-fit" id="image" 
		  src='<?php echo $recipe->getImage(); ?>'
		  alt="Bild på <?php echo $recipe->getName(); ?>">

          <hr>

          <!-- Post Content -->
          <p class="lead" id="description"><?php echo $recipe->getDescription(); ?></p>

          <hr>

          <div class="row recipe-body">
          <div class="list-group col-lg-5" id="ingredients">
			<div class="center">
				<h6>Ingredienser</h6> 
				<?php 
					foreach($recipe->getIngredients() as $ingredient){
						echo "<a href='#' class='list-group-item list-group-item-action'>" . $ingredient . "</a>";
					}
				?>
			</div>
          </div>
			<div class="col-lg-7">
				<div class="center">
				  <h6>Att göra</h6>
				</div>
				<ul id="tasks">
					<?php 
						foreach($recipe->getTasks() as $task){
							echo "<li>" . $task . "</li>";
						}
					?>
				</ul>
			</div>
        </div>

        <hr>

        <div id="comment-section"></div>

        <h6 class="comments-title mb-4">Kommentarer</h6>
		<div id="comments">
		</div>
		</div>

        <!-- Sidebar Widgets Column -->
        <div class="col-md-4">

          <!-- Categories Widget -->
          <div class="card">
            <h5 class="card-header" id="sameCountry">Andra recept från <a href="RecipeMenu?country=<?php echo $recipe->getCountry(); ?>"><?php echo $recipe->getCountry(); ?></a></h5>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12">
                  <ul class="list-unstyled mb-0" id="otherRecipes">
					<?php 
						foreach($recipe->getOtherRecipes() as $otherRecipe){
							echo "<li><a href='Recipe?recipe=" . $otherRecipe . "'>" . $otherRecipe . "</a></li>";
						}
					?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
		  
		  <form class="form-inline my-2 mt-3">
			<input type="text" class="w-100 form-control" placeholder="Sök efter recept..." id="inputDefault">
		  </form>

        </div>

      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="py-3 bg-light">
      <?php include 'resources/fragments/footer.php'; ?>
    </footer>
	
    <!-- Bootstrap core JavaScript -->
    <script src="../../resources/jquery/jquery.min.js"></script>
    <script src="../../resources/bootstrap/js/bootstrap.bundle.min.js"></script>
	
	<script src="../../resources/js/recipe.js"></script>
	<script src="../../resources/js/master.js"></script>

  </body>

</html>
