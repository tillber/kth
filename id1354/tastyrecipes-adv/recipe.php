<!DOCTYPE html>
<?php
  session_start();
  $_SESSION["recipe"] = $_GET["title"];
  $_SESSION["country"] = $_GET["country"];
  require_once 'Comment.php';
?>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>no-recipe</title>

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
    <link href="css/blog-post.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/recipe.css" rel="stylesheet">

    <!-- Master inclusion script -->
    <script src="vendor/jquery/jquery.min.js"></script>
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

        <div class="col-lg-12">
          <!-- Title -->
          <h1 class="mt-4" id="title"></h1>
          <ol id="breadcrumbs" class="breadcrumb">
            <li class="breadcrumb-item"><a href="recipes.html">Recept</a></li>
            <li class="breadcrumb-item"><a href="#">Land</a></li>
          </ol>
        </div>

        <!-- Post Content Column -->
        <div class="col-lg-8" id="postContent">

          <!-- Author
          <p class="lead">
            by
            <a href="#">Start Bootstrap</a>
          </p>-->

          <!-- Preview Image -->
          <img class="img-fluid recipe rounded cropped cover-fit" id="image" alt="">

          <hr>

          <!-- Post Content -->
          <p class="lead" id="description"></p>

          <hr>

          <div class="row recipe-body">
          <div class="list-group col-lg-5" id="ingredients">
            <div class="center">
              <h6>Ingredienser</h6>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="center">
              <h6>Att göra</h6>
            </div>
            <ul id="tasks"></ul>
          </div>
        </div>

        <script>
        function getUrlParameter(name) {
            name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
            var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
            var results = regex.exec(location.search);
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
        };

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                myFunction(this);
            }
        };

        xhttp.open("GET", "data/" + getUrlParameter("country").toLowerCase() + ".xml", true);
        xhttp.send();

        function myFunction(xml) {
            var xmlDoc = xml.responseXML;

            var recipes = xmlDoc.getElementsByTagName("recipe");
            for(i = 0; i < recipes.length; i++){
                if(recipes[i].getAttribute("title") == getUrlParameter("title")){
                  document.title = recipes[i].getAttribute("title");

                  document.getElementById("title").innerHTML =
                  recipes[i].getAttribute('title');

                  // Breadcrumbs
                  var breadcrumb = document.createElement('li');
                  breadcrumb.classList.add('breadcrumb-item');
                  var link = document.createElement('a');
                  link.setAttribute("href", "recipe-menu.html?country=" + getUrlParameter("country"));
                  link.innerHTML = getUrlParameter("country");
                  breadcrumb.appendChild(link);
                  document.getElementById("breadcrumbs").appendChild(breadcrumb);
                  breadcrumb = document.createElement('li');
                  //Adds empty breadcrumb to get / at the end.
                  breadcrumb.classList.add('breadcrumb-item');
                  document.getElementById("breadcrumbs").appendChild(breadcrumb);

                  document.getElementById("description").innerHTML =
                  recipes[i].getElementsByTagName("description")[0].textContent;

                  document.getElementById("image").src =
                  recipes[i].getElementsByTagName("image")[0].childNodes[0].nodeValue;

                  var x = recipes[i].getElementsByTagName("ingredients")[0].childNodes;
                  for (j = 0; j < x.length; j++) {
                    if (x[j].nodeType == 1) {
                      var a = document.createElement('a');
                      a.classList.add('list-group-item', 'list-group-item-action', 'disabled');
                      a.innerHTML = recipes[i].getElementsByTagName("ingredients")[0].childNodes[j].textContent;
                      document.getElementById('ingredients').appendChild(a);
                    }
                  }

                  x = recipes[i].getElementsByTagName("tasks")[0].childNodes;
                  for (j = 0; j < x.length; j++) {
                    if (x[j].nodeType == 1) {
                      var li = document.createElement('li');
                      li.innerHTML = recipes[i].getElementsByTagName("tasks")[0].childNodes[j].textContent;
                      document.getElementById('tasks').appendChild(li);
                    }
                  }
                } else{
                  var a = document.createElement('a');
                  a.setAttribute("href", "recipe.php?country=" + getUrlParameter("country") + "&title=" + recipes[i].getAttribute("title"));
                  a.innerHTML = recipes[i].getAttribute("title");

                  var li = document.createElement('li');
                  li.appendChild(a);
                  document.getElementById("otherRecipes").appendChild(li);
                  document.getElementById("sameCountry").innerHTML = "Andra recept från " + getUrlParameter("country");
                }
            }
        }
        </script>

          <hr>

          <?php
            if (isset($_SESSION['valid']) && $_SESSION['valid'] == true) {
          ?>
          <!-- Comments Form -->
          <div class="card my-4">
            <h5 class="card-header">Lämna en kommentar</h5>
            <div class="card-body">
              <form id="comment-form" action="store-comment.php">
                <div class="form-group">
                  <textarea class="form-control" rows="3" name="content"></textarea>
                </div>
                <button type="submit" id="submitComment" class="btn btn-primary">Kommentera</button>
              </form>
            </div>
          </div> <hr>
        <?php } ?>

        <h6 class="comments-title mb-4">Kommentarer</h6>

        <?php
          if(isset($_SESSION['commented']) and $_SESSION['commented'] == 1){
            echo("<div class='alert alert-dismissible alert-primary mb-5'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            <strong>Framgång!</strong>&nbsp;Din kommentar lades till i receptet.</div>");
            $_SESSION['commented'] = 0;
          }else if(isset($_SESSION['commented']) and $_SESSION['commented'] == -1){
            echo("<div class='alert alert-dismissible alert-danger mb-5'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            <strong>Problem!</strong>&nbsp;Din kommentar kunde inte läggas till. Testa att skriv något nästa gång.</div>");
            $_SESSION['commented'] = 0;
          }

          $filename = 'comments.txt';
          $comments = explode("\n", file_get_contents($filename));
          $count = 0;
          for($i = count($comments) - 1; $i >= 0; $i--){
            $comment = unserialize($comments[$i]);
            if ($comment instanceof Comment and $comment->getRecipe() == $_SESSION['recipe'] and !$comment->isDeleted()) {
              echo ("<div class='media mb-4'>");
              echo("<img class='d-flex mr-3 rounded-circle comment' src='img/avatar.png' alt=''>");
              echo("<div class='media-body'>");
              echo("<div class='row'>");
              echo("<div class='col-sm-8'><h5 class='mt-0'>" . $comment->getAuthor() . "</h5></div>");
              echo("<div class='col-sm-4 comment-column-right'>" . $comment->getDate());
              if(isset($_SESSION['username']) and $comment->getAuthor() === $_SESSION['username']){
                echo("<form id='delete-form' action='delete-comment.php'>
                <input type='hidden' name='timestamp' value='" . $comment->getTimestamp() . "'/>");
                echo("<button type='submit' class='btn btn-danger btn-sm ml-3'>Ta bort</button>");
                echo("</form>");
              }
              echo("</div></div>" . nl2br($comment->getContent()) . "</div></div>");
              $count++;
            }
          }

          if($count == 0){
            echo("<p class='lead no-comments mb-5'>Inga kommentarer ännu!</p>");
          }
        ?>

          <!--<div class="media mb-4">
            <img class="d-flex mr-3 rounded-circle comment" src="img/avatar.png" alt="">
            <div class="media-body">
              <div class="row">
                <div class="col-sm-10">
                  <h5 class="mt-0">Commenter Name</h5>
                </div>
                <div class="col-sm-2">
                  12/11/2018
                </div>
              </div>
              Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
            </div>
          </div>-->
        </div>

        <!-- Sidebar Widgets Column -->
        <div class="col-md-4">

          <!-- Categories Widget -->
          <div class="card">
            <h5 class="card-header" id="sameCountry"></h5>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12">
                  <ul class="list-unstyled mb-0" id="otherRecipes">
                  </ul>
                </div>
              </div>
            </div>
          </div>

        </div>

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
