<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register user</title>

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

      <div class="row justify-content-center">
		<div class="col-lg-5 mt-5">
		<h5 class="px-3 mb-4">Registrera användare</h5>
			<form action="RegisterUser" class="mt-3 px-3" method="post">
             <div class="form-group">
               <input type="text" name="username" class="form-control" placeholder="Användarnamn" required="required">
             </div>
             <div class="form-group">
               <input type="password" name="password" class="form-control" placeholder="Lösenord" required="required">
             </div>
			 <div class="form-group">
               <input type="password" name="password2" class="form-control" placeholder="Lösenord igen" required="required">
             </div>
             <div class="form-group">
               <input type="submit" class="btn btn-primary btn-block btn-lg" value="Registrera">
            </div>
			<a href="Index">&larr; Återvänd till index</a>
          </form>
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
