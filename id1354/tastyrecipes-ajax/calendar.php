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

    <title>Kalender</title>

    <!-- Bootstrap core JavaScript -->
    <script src="resources/jquery/jquery.min.js"></script>
    <script src="resources/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Favicon -->
    <link rel="icon" type="img/ico" href="img/favicon.ico">

    <!-- Reset Stylesheet -->
    <link rel="stylesheet" href="resources/css/reset.css">

    <!-- Bootstrap core CSS -->
    <link href="resources/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="resources/css/style.css">
    <link href="resources/css/shop-homepage.css" rel="stylesheet">
    <link rel="stylesheet" href="resources/css/calendar.css">
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
          <div class="calendar my-3" id="calendar">
            <div>Monday</div>
            <div>Tuesday</div>
            <div>Wednesday</div>
            <div>Thursday</div>
            <div>Friday</div>
            <div>Saturday</div>
            <div id="calendar-head-end">Sunday</div>
            <div>&nbsp;</div>
            <div>1</div>
            <div>2</div>
            <div>3</div>
            <div>4</div>
            <div>5</div>
            <div>6</div>
            <div>7</div>
            <div>8</div>
            <div>9</div>
            <a href="recipe.php?recipe=Pannkakor"><div class="text-white" id="pancakes">10</div></a>
            <div>11</div>
            <div>12</div>
            <div>13</div>
            <div>14</div>
            <a href="recipe.php?recipe=Köttbullar"><div class="text-white" id="meatballs">15</div></a>
            <div>16</div>
            <div>17</div>
            <div>18</div>
            <div>19</div>
            <div>20</div>
            <div>21</div>
            <div>22</div>
            <div>23</div>
            <div>24</div>
            <div>25</div>
            <div>26</div>
            <div>27</div>
            <div>28</div>
            <div>29</div>
            <div>30</div>
            <div>31</div>
            <div>&nbsp;</div>
            <div>&nbsp;</div>
            <div>&nbsp;</div>
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
    <script src="resources/jquery/jquery.min.js"></script>
    <script src="resources/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
