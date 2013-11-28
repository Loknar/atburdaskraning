<?php
require_once "php/head.php";

// this page requires moderator or administrator login to access
requireMod();

// get id
$change_user_id = intGET("id");

// check if given id is valid or not, and fetch info about the user if id is valid
// preparing statement
$query = $db->prepare("SELECT name,post,privileges FROM users WHERE user_id = :user_id;");
// insert variables safely into the prepared statement and execute it
$query->execute(array('user_id' => $change_user_id));
// fetch results into a results variable
$user_result = $query->fetchAll();
if (0 == count($user_result)) redirectToRoot(); // if no user with id then gtfo

$row_data = $user_result[0];

$change_user_privileges = $row_data["privileges"];

if (USER_PRIVILEGES == 1 && ($change_user_privileges == 1 || $change_user_privileges == 2)) {
  redirectToRoot(); // moderators only allowed to change normal users, but admins can do what they want
}

// =============
// POST handling
// =============

// variables for the form
$newUserName     = $row_data["name"];
$newUserUsername = $row_data["post"];

$post_happened = false;

if(isset($_POST["name"]) && 
   isset($_POST["username"])) {
  
  $post_happened = true;
  $post_success = true;
  $post_error = "";
  
  $newUserName     = get_post("name");
  $newUserUsername = get_post("username");
  
  // handle and check validity of the form variables
  
  // name of user title should not be empty string
  if(strlen($newUserName) > 0) {
    // max length of event title is 200 characters
    $newUserName = truncateString($newUserName, 100);
  }
  else {
    $post_success = false;
    $post_error .= "<li>Nafn notanda má ekki vera tómur strengur.</li>\n";
  }
  
  // username of user title should not be empty string
  if(strlen($newUserUsername) > 0) {
    // max length of event title is 200 characters
    $newUserUsername = truncateString($newUserUsername, 100);
  }
  else {
    $post_success = false;
    $post_error .= "<li>Notandanafn notanda má ekki vera tómur strengur.</li>\n";
  }
  
  if($post_success) {
    // fake pass for fooling the stupid
    $newUserPass = encriptPassword($newUserUsername, $salt1, $salt2);
    
    $newUserPrivileges = 0;
    
    // insert event into database
    $insert = $db->prepare("UPDATE users SET name=:name,post=:post WHERE user_id=:user_id;");
    $result = $insert->execute(array('name' => $newUserName,'post' => $newUserUsername,'user_id' => $change_user_id));
    if(!$result) {
      $errorInfo = $insert->errorInfo();
      if ($errorInfo[1] == 19) { // database constraint violation
        $post_success = false;
        $post_error .= "<li>Innslegið notandanafn nú þegar til.</li>\n";
      }
      else {
        // unforseen error happened
        die("Database error: $errorInfo"); // þarf kannski að meðhöndla eitthvað betur
      }
    }
    else {
      // post succeeded
    }
  }
}

// admin post change privileges of user
if(isset($_POST["set_privileges"]) && USER_PRIVILEGES == 2) {
  $new_privileges = intval(get_post("set_privileges"));
  if ($new_privileges != 1) $new_privileges = 0;
  
  // preparing statement
  $query = $db->prepare("UPDATE users SET privileges=:privileges WHERE user_id=:user_id;");
  // insert variables safely into the prepared statement and execute it
  $result = $query->execute(array('privileges' => $new_privileges,'user_id' => $change_user_id));
  
  $change_user_privileges = $new_privileges;
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
    <link href="css/main.css" rel="stylesheet">
    <link href="css/user.add.css" rel="stylesheet">
  </head>

  <body>

<?php
require_once "parts/navbar.php";
?>

    <div class="container">

      <div class="starter-template">
        <h1>Breyta notanda</h1>
        <div class="fixed_width">
<?php

if($post_happened) {
  if($post_success) {
    echo <<<_END
      <div class="alert alert-block alert-success fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4>Notandi uppfærður</h4>
        <p>Notandi hefur verið uppfærður, smelltu á takkann hér fyrir neðan til að fara í lista yfir notendur</p>
        <p>
          <a class="btn btn-default" href="#">Fara í notendalista</a>
        </p>
      </div><!-- alert message -->
_END;
  }
  else {
    echo <<<_END
      <div class="alert alert-block alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4>Úps! Eitthvað klikkaði</h4>
        <p>Eftirfarandi villur komu upp:</p>
        <ul>
          $post_error
        </ul>
        <p>Lagaðu ofangreindar villur og reyndu svo aftur.</p>
      </div><!-- alert message -->
_END;
  }
}

?>

          <div class="login-or">
            <hr class="hr-or">
            <span class="span-or">~</span>
          </div>
          
          <form role="form" method="post" action="user.change.php?id=<?php echo $change_user_id; ?>">
            <div class="form-group">
              <label for="inputUsernameEmail">Nafn</label>
              <input type="text" class="form-control" name="name" id="name" placeholder="Nafn"  value="<?php echo $newUserName; ?>">
            </div>
            <div class="form-group">
              <label for="inputPassword">Notandanafn</label>
              <input type="text" class="form-control" name="username" id="username" placeholder="Notandanafn"  value="<?php echo $newUserUsername; ?>">
            </div>
            <button type="submit" class="btn btn btn-primary">
              Breyta notanda
            </button>
          </form>
        </div>
<?php
if (USER_PRIVILEGES == 2) {
  if ($change_user_privileges == 0) {
    echo <<<_END
          <h2>Admin stillingar</h2>
          <form role="form" method="post" action="user.change.php?id=$change_user_id">
            <input type="hidden" name="set_privileges" value=1 />
            <button type="submit" class="btn btn-success">Gefa notanda moderator réttindi</button>
          </form>

_END;
  }
  elseif ($change_user_privileges == 1) {
    echo <<<_END
          <h2>Admin stillingar</h2>
          <form role="form" method="post" action="user.change.php?id=$change_user_id">
            <input type="hidden" name="set_privileges" value=0 />
            <button type="submit" class="btn btn-warning">Taka moderator réttindi af notanda</button>
          </form>

_END;
  }
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