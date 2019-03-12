<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>404</title>

    <!-- Favicon -->
    <link rel="icon" type="img/ico" href="../../resources/images/favicon.ico">

    <!-- Reset Stylesheet -->
    <link rel="stylesheet" href="../../resources/css/reset.css">

    <!-- Bootstrap core CSS -->
    <link href="../../resources/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="../../resources/css/style.css">
    <link href="../../resources/css/shop-homepage.css" rel="stylesheet">
  </head>

  <body>

    <!-- Master -->
    <div id="master">
		<?php include 'resources/fragments/master.php'; ?>
	</div>

    <!-- Page Content -->
    <div class="container">

      <div class="row">
		<div class="col-lg-12 mt-5">
			<h1><b>404</b> Sidan hittades inte</h1>
			<p class="lead mt-3">Den efterfrågade sidan kunde inte hittas på servern!</p>
			<p>Referrer: <?php echo $_SERVER['HTTP_REFERER']; ?></p>
			<a href="Index">&larr; Återvänd till index</a>
		</div>
      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Bootstrap core JavaScript -->
    <script src="../../resources/jquery/jquery.min.js"></script>
    <script src="../../resources/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
