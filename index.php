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
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
          </p>
          
          <div class="row">
            <br/>
            <br/>
            <br/>
            <div class="bs-example">
                  <div class="page-header">
                    <h1>Example page header <small>Subtext for header</small></h1>
                  </div>
                </div>
          </div><!--/row-->
        </div><!--/span-->

        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
          <div class="list-group">
            <a href="#" class="list-group-item active">Link</a>
            <a href="#" class="list-group-item">
              <p>Vísindaferð í Ölgerðina - 21. Nóv.<br />
              <span class="label label-default">Skráning hefst 1. Des</span></p>
            </a>
            <a href="#" class="list-group-item"><span class="glyphicon glyphicon-user"></span> Linkur með löngum texta til að tékka hvernig þetta lítur allt saman út</a>
            <a href="#" class="list-group-item"><span class="label label-default">Default</span> Linkur með löngum texta til að tékka hvernig þetta lítur allt saman út</a>
            <a href="#" class="list-group-item">Link</a>
            <a href="#" class="list-group-item">Link</a>
            <a href="#" class="list-group-item">Link</a>
            <a href="#" class="list-group-item">Link</a>
            <a href="#" class="list-group-item">Link</a>
            <a href="#" class="list-group-item">Link</a>
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