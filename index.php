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
$index_active = " class=\"active\"";
require_once "parts/navbar.php";
?>

    <div class="container">

      <div class="starter-template">
        <h1>Velkomin/n á Atburðaskráningasíðuna</h1>
        <p class="lead">
        Á þessari síðu geta stjórnendur sett inn atburði/skráningar.<br /> 
        Á skráningartímabili atburðar geta notendur skráð sig á tiltekinn atburð.
        </p>
        <p>
        tl:dr vísóskráningarsíða yayy <br /> 
<?php

if (USER_LOGGEDIN) {
  echo "innskráður notandi\n";
}

if (isset($_GET['title']))
{
  $title = $_GET['title'];
  $insert = $db->prepare("INSERT INTO events (title) VALUES(:title);");
  $insert->execute(array('title' => $title));
  
  echo "Bætti ".$title." við! <br />\n";
}

echo "Getting event titles from database.<br />\n";
$result = $db->query("SELECT title FROM events;");
foreach($result as $row_data)
{
  echo $row_data["title"]."\n";
}

$pass = "adminpowers";
$encripted_pass = md5("$salt1$pass$salt2");
echo $encripted_pass."\n";

echo time();

?>
        </p>
      </div>
      <h2>Skráðir atburðir</h2>
<?php require_once "parts/listed.events.php"; ?>
    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
  </body>
</html>