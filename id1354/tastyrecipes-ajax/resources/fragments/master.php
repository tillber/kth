<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  <div class="container">
    <a class="navbar-brand" href="Index">The Tasty Recipes</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="Index">Start</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Recept
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="RecipeMenu?country=Sverige">Sverige</a>
            <a class="dropdown-item" href="RecipeMenu?country=Japan">Japan</a>
            <a class="dropdown-item" href="RecipeMenu?country=Japan">Indien</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="calendar.php">Kalender</a>
        </li>
        <li class="nav-item" id="log-button"></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Modal -->
<div id="login-modal" class="modal fade">
 <div class="modal-dialog modal-login">
   <div class="modal-content">
    <div class="modal-body px-0 pb-0">
		<h5 class="px-3 mb-4">Logga in</h5>
		<form class="mt-3 px-3" id="login-form">
             <div class="form-group">
               <input type="text" id="username" class="form-control" placeholder="Användarnamn" required="required">
             </div>
             <div class="form-group">
               <input type="password" id="password" class="form-control" placeholder="Lösenord" required="required">
             </div>
             <div class="form-group">
               <input type="submit" id="login" data-dismiss="modal" class="btn btn-primary btn-block btn-lg" value="Logga in">
            </div>
          </form>
      <div class="modal-footer">
		  <a class="mr-auto" href="RegisterPage">Registrera användare</a>
		  <a href="" data-dismiss="modal">Stäng</a>
       </div>
     </div>
    </div>
  </div>
</div>