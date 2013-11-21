<?php
require_once "php/head.php";

?>
<!DOCTYPE html>
<html lang="is">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Vefforritunarverkefni 5 (TÖL306G haust 2013)">
    <meta name="author" content="Sveinn Flóki Guðmundsson">
    <link rel="shortcut icon" href="ico/favicon.ico">

    <title><?php echo $website_title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles -->
    <link href="css/main.css" rel="stylesheet">
    <link href="css/offcanvas.css" rel="stylesheet">
  </head>

  <body>

<?php
$index_active = " class=\"active\"";
require_once "parts/navbar.php";
?>

    <div class="container">

      <div class="row row-offcanvas row-offcanvas-right">
        <div class="col-xs-12 col-sm-9">
          <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Næstu atburðir</button>
          </p>
          
          <div class="row">
<?php require_once "parts/index.recent.news.php"; ?>
          </div><!--/row-->
        </div><!--/span-->

        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
          <div class="list-group">
          <li class="list-group-item active">Næstu atburðir</li>
<?php require_once "parts/index.sidebar.events.php"; ?>
          </div>
        </div><!--/span-->

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
    <script src="js/offcanvas.js"></script>
  </body>
</html>