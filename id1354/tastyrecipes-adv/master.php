<!-- Navigation -->
<?php session_start(); ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  <div class="container">
    <a class="navbar-brand" href="index.php">The Tasty Recipes</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Start</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Recept
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="recipe-menu.html?country=Sverige">Sverige</a>
            <a class="dropdown-item" href="recipe-menu.html?country=Japan">Japan</a>
            <a class="dropdown-item" href="recipe-menu.html?country=Indien">Indien</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="calendar.html">Kalender</a>
        </li>
        <li class="nav-item">
          <?php
            if (!isset($_SESSION['valid']) || $_SESSION['valid'] == false) {
          ?>
          <a href="" id="login-button" class="nav-link" data-toggle="modal" data-target="#login-modal">Logga in</a>
        <?php }else{?>
          <a href="logout.php" class="nav-link">Logga ut (<?php echo $_SESSION['username']; ?>)</a>
        <?php } ?>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Modal -->
<div id="login-modal" class="modal fade">
 <div class="modal-dialog modal-login">
   <div class="modal-content">
    <div class="modal-body px-0 pb-0">
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" href="#login">Logga in</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="register-page" data-toggle="tab" href="#register">Registrera</a>
        </li>
      </ul>
      <div id="myTabContent" class="tab-content">
        <?php //Issue alerts
          if(isset($_SESSION['wrongPassword']) and $_SESSION['wrongPassword'] == true){
            $msg = "<strong>Fel lösenord!</strong>&nbsp;Var god försök igen.
            <script>$('#login-button').click();</script>";
            $_SESSION['wrongPassword'] = false;
          }else if(isset($_SESSION['userExists']) and $_SESSION['userExists'] == true){
            $msg = "<strong>Oops!</strong>&nbsp;Det angivna användarnamnet existerar redan.
            <script>$('#login-button').click(); $('#register-page').click();</script>";

            $_SESSION['userExists'] = false;
          }else if(isset($_SESSION['userDoesntExist']) and $_SESSION['userDoesntExist'] == true){
            $msg = "<strong>Oops!</strong>&nbsp;Det finns ingen användare med det namnet.
            <script>$('#login-button').click(); $('#register-page').click();</script>";

            $_SESSION['userDoesntExist'] = false;
          }else if(isset($_SESSION['passNoMatch']) and $_SESSION['passNoMatch'] == true){
            $msg = "<strong>Oops!</strong>&nbsp;De två lösenorden matchade inte. Försök igen!
            <script>$('#login-button').click(); $('#register-page').click();</script>";

            $_SESSION['passNoMatch'] = false;
          }

          if(!empty($msg)){ ?>
            <div class="alert alert-dismissible alert-danger mt-3 mx-3">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <?php echo $msg; ?>
            </div>
          <?php } ?>
        <div class="tab-pane fade show active" id="login">
          <form action="login.php" class="mt-3 px-3" method="post">
             <div class="form-group">
               <input type="text" name="username" class="form-control" placeholder="Användarnamn" required="required">
             </div>
             <div class="form-group">
               <input type="password" name="password" class="form-control" placeholder="Lösenord" required="required">
             </div>
             <div class="form-group">
               <input type="submit" name="login" class="btn btn-primary btn-block btn-lg" value="Logga in">
            </div>
          </form>
        </div>
        <div class="tab-pane fade show" id="register">
          <form action="register-user.php" class="mt-3 px-3" method="post">
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
               <input type="submit" name="register" class="btn btn-outline-primary btn-block btn-lg" value="Registrera">
            </div>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <a href="" data-dismiss="modal alert">Stäng</a>
       </div>
     </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
