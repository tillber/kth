<!DOCTYPE html>
<?php
//Image meta data charsets
ini_set('exif.decode_unicode_motorola', 'UCS-2LE');
ini_set('exif.encode_unicode', 'utf8');
?>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $country->getName();?></title>

    <!-- Favicon -->
    <link rel="icon" type="img/ico" href="../../resources/images/favicon.ico">

    <!-- Reset Stylesheet -->
    <link rel="stylesheet" href="../../resources/css/reset.css">

    <!-- Bootstrap core CSS -->
    <link href="../../resources/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../resources/css/small-business.css" rel="stylesheet">
    <link href="../../resources/css/shop-homepage.css" rel="stylesheet">
    <link rel="stylesheet" href="../../resources/css/style.css">
    <link rel="stylesheet" href="../../resources/css/recipe-menu.css">

  </head>

  <body>

    <!-- Master -->
    <div id="master">
		<?php include 'resources/fragments/master.php' ?>
	</div>

    <!-- Page Content -->
    <div class="container">

      <!-- Heading Row -->
      <div class="row my-4">
        <div class="col-lg-8">
          <div id="carouselExampleIndicators" class="carousel slide my-4 recipe-menu-slide" data-ride="carousel">
            <ol class="carousel-indicators">
              <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
			<?php
				$i = 0;
				foreach($country->getImages() as $image){
					if($i == 0){
						echo "<div class='carousel-item active'>
						<img class='d-block img-fluid rounded' src='../../" . $image . "' alt='Bild på " . exif_read_data($image)['Title'] . "'>
						<div class='text-centered text-stylish'><h1>" . exif_read_data($image)['Title'] . "</h1></div></div>";
					}else{
						echo "<div class='carousel-item'>
						<img class='d-block img-fluid rounded' src='../../" . $image . "' alt='Bild på " . exif_read_data($image)['Title'] . "'>
						<div class='text-centered text-stylish'><h1>" . exif_read_data($image)['Title'] . "</h1></div></div>";
					}
					
					$i++;
				}
			?>
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
        </div>
        <!-- /.col-lg-8 -->
        <div class="col-lg-4">
          <h1 id="title"><?php echo $country->getName();?></h1>
          <p class="lead">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">Recept</li>
              <li class="breadcrumb-item">Land</li>
              <li class="breadcrumb-item active" id="breadcrumb"><?php echo $country->getName();?></li>
            </ol>
          </p>
          <p id="description"><?php echo $country->getDescription();?></p>
        </div>
        <!-- /.col-md-4 -->
      </div>
      <!-- /.row -->

      <!-- Call to Action Well -->
      <div class="card text-white bg-secondary my-4 text-center">
        <div class="card-body">
          <p class="text-white m-0">"<i id="quote"></i><?php echo $country->getQuote();?>" -<b id="chef"><?php echo $country->getChef();?></b></p>
        </div>
      </div>

      <!-- Content Row -->
      <div class="row">
	  <?php
		foreach($country->getRecipes() as $recipe){
			echo "<div class='col-lg-4 col-md-6 mb-4 recipe-link'><div class='card h-95'>";
			echo "<a href='#'><img class='card-img-top cover-fit' src='" . $recipe->getImage() . "' alt=''></a>";
			echo "<div class='card-body recipe-link'>";
			echo "<h4 class='card-title recipe-link'>";
			echo "<a href='Recipe?recipe=" . $recipe->getName() . "'>" . $recipe->getName() . "</a></h4>";
			echo "<small class='cooking-time text-muted'>TILLAGNINGSTID " . $recipe->getCookingTime() . "</small>";
			echo "<p class='card-text recipe-link'>" . $recipe->getDescription() . "</p></div></div></div>";
		}
	  ?>
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

  </body>

</html>
