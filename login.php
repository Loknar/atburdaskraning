<?php
require_once "php/head.php";

// if user is already logged in we forward the user to index
if(USER_LOGGEDIN) {
    redirectToRoot();
}

$login_error = "";
if (isset($_POST['user']) && isset($_POST['pass'])) {
  $user = $_POST['user'];
  $pass = $_POST['pass'];
  //$encripted_pass = md5("$salt1$pass$salt2");
  
  // check in database for user
  $query = $db->prepare("SELECT name,post,pass,privileges FROM users WHERE post=:post;");
  $query->execute(array('post' => $user));
  $result = $query->fetchAll();
  if (1 == count($result) && uglaValidateLogin($user, $pass)) {
    //$result = $result[0];
    //$name = $result['name'];
    //$post = $result['post'];
    
    $_SESSION['loggedin_user'] = $user;
    //$_SESSION['user_hash_key'] = $encripted_pass; // commented out because bad idea to store pass in session variable
    redirectToRoot();
  }
  else {
    // login failed, maybe do something here
  }
}



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
    <link href="css/signin.css" rel="stylesheet">
  </head>

  <body>

<?php require_once "parts/navbar.php"; ?>

    <div class="container">

      <form class="form-signin" method="post" action="login.php">
        <h2 class="form-signin-heading">Innskráning</h2>
        <input name="user" type="text" class="form-control" placeholder="Notandanafn" autofocus>
        <input name="pass" type="password" class="form-control" placeholder="Lykilorð">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Innskrá</button>
      </form>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
  </body>
</html>