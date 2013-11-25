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
  </head>

  <body>

<?php
$users_active = " class=\"active\"";
require_once "parts/navbar.php";
?>

    <div class="container">

      <div class="starter-template">
        <h1>Notendur</h1>
<?php

// preparing statement
$query = $db->prepare("SELECT name,post,privileges FROM users ORDER BY name;");
// insert variables safely into the prepared statement and execute it
$query->execute();
// fetch results into a results variable
$users = $query->fetchAll();
foreach($users as $user) {
  $user_name = $user["name"];
  echo <<<_END
  <p>$user_name</p>
_END;
}
?>

      </div>
    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
  </body>
</html>