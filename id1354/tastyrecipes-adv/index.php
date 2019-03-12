<!DOCTYPE html>
<?php session_start();
  require_once 'Comment.php';
?>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Start</title>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Favicon -->
    <link rel="icon" type="img/ico" href="img/favicon.ico">

    <!-- Reset Stylesheet -->
    <link rel="stylesheet" href="css/reset.css">

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="css/style.css">
    <link href="css/shop-homepage.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">

    <!-- Master inclusion script -->
    <script>
      $(function(){
        $("#master").load("master.php");
      });
    </script>

  </head>

  <body>

    <!-- Master -->
    <div id="master"></div>

    <!-- Page Content -->
    <div class="container">

      <div class="row">

        <div class="col-lg-3">

          <!-- Side Widget -->

          <h6 class="latest-comments mb-3">De senaste kommentarerna</h6>
          <?php
            $filename = 'comments.txt';
            $comments = explode("\n", file_get_contents($filename));
            $count = 0;

            for($i = count($comments) - 1; $i >= 0; $i--){
              $comment = unserialize($comments[$i]);
              if ($comment instanceof Comment and !$comment->isDeleted()) {
                echo ("<div class='card mb-4 index-comment'><div class='card-body'><h6 class='card-title user'>");
                echo ("<div class='left'>" . $comment->getAuthor() . "</div><div class='right'><small class='text-muted'>" . $comment->getDate() . "</small></div></h6>");
                echo("<p class='card-text'>" . nl2br($comment->getContent()) . "</p></div>");
                echo ("<div class='card-footer text-muted comment-footer'><ol class='breadcrumb comment'>");
                echo ("<li class='breadcrumb-item'><a href='recipe-menu.html?country=" . $comment->getCountry() . "'>" . $comment->getCountry() . "</a></li><li class='breadcrumb-item active'>
                <a href='recipe.php?country=" . $comment->getCountry() . "&title=" . $comment->getRecipe() .
                "'>" . $comment->getRecipe() . "</a></li></ol></div></div>");
                $count++;
              }
            }

            if($count == 0){
              echo("<p class='lead no-comments mb-4 my-4'>Inga kommentarer ännu!</p>");
            }
          ?>
          <hr>
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
                <img class="d-block img-fluid rounded" src="img/front/scandinavia.png" alt="First slide">
                <a href="recipe-menu.html?country=Sverige"><div class="text-centered text-stylish"><h1>Smaka på Sverige</h1></div></a>
              </div>
              <div class="carousel-item">
                <img class="d-block img-fluid rounded" src="img/front/japan.png" alt="Second slide">
                <a href="recipe-menu.html?country=Japan"><div class="text-centered text-stylish"><h1>Smaka på Japan</h1></div></a>
              </div>
              <div class="carousel-item">
                <img class="d-block img-fluid rounded" src="img/front/india.png" alt="Third slide">
                <a href="recipe-menu.html?country=Indien"><div class="text-centered text-stylish"><h1>Smaka på Indien</h1></div></a>
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

            <div class="col-lg-12 mb-3">
              <div class="card h-95">
                <div class="card-body">
                  <h4 class="card-title recipe-link">
                    <a href="#" id="cardTitle0">Sverige</a>
                  </h4>
                  <p class="card-text country-desc" id="cardDesc0">Den svenska maten har påverkats av våra långa vintrar. Rotfrukter, bär, sill, kantareller, fläsk och vilt är några av råvarorna vi hade tillgång till året om, eller kunde bevara. Utomlands är vi mest kända för köttbullar, smörgåsbord och knäckebröd. Här har vi samlat våra recept på svensk mat.</p>
                  <a href="recipe-menu.html?country=Sverige" class="btn btn-outline-primary">Se recept &rarr;</a>
                </div>
              </div>
            </div>

            <div class="col-lg-12 mb-3">
              <div class="card h-95">
                <div class="card-body">
                  <h4 class="card-title recipe-link">
                    <a href="#" id="cardTitle1">Japan</a>
                  </h4>
                  <p class="card-text country-desc" id="cardDesc1">Japansk mat är ofta sofistikerad och elegant mat. Främst tänker vi på sushi, men det ryms mycket mer i det japanska köket. Vanliga råvaror i japansk mat är kokt ris, fisk, skaldjur och grönsaker. Hitta inspirationen bland våra japanska recept.</p>
                  <a href="recipe-menu.html?country=Japan" class="btn btn-outline-primary">Se recept &rarr;</a>
                </div>
              </div>
            </div>

            <div class="col-lg-12 mb-3">
              <div class="card h-95">
                <div class="card-body">
                  <h4 class="card-title recipe-link">
                    <a href="#" id="cardTitle2">Indien</a>
                  </h4>
                  <p class="card-text country-desc" id="cardDesc2">I indisk mat samsas kryddiga vegetariska grytor med mustiga kötträtter, och den söta chutneyn är ett lika gott tillbehör som yoghurtsåsen raita. Vindaloo, tikka masala, korma och tandoori är några smaker från Indien som slagit rot i Sverige. Laga indiskt hemma med våra indiska recept!</p>
                  <a href="recipe-menu.html?country=Indien" class="btn btn-outline-primary">Se recept &rarr;</a>
                </div>
              </div>
            </div>
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
      <div class="container">
        <p class="m-0 text-center text-grey">Copyright &copy; The Tasty Recipes 2018</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
