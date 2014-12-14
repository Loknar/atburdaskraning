<?php
require_once "php/head.php";

// this page requires moderator or administrator login to access
requireMod();

// =============
// POST handling
// =============

// variables for the form
$newsTitle       = "";
$date_created = "";
$date_edited   = "";
$newsDescription = "";
$newsCreator = "";
$last_editor = "";

$post_happened = false;

if(isset($_POST["newsTitle"]) && 
   isset($_POST["newsDescription"])) {
  
  $post_happened = true;
  $post_success = true;
  $post_error = "";
  
  $newsTitle       = get_post("newsTitle");
  $newsDescription = get_post("newsDescription");
  //$date_edited      = get_post("eventEnding");
  
  // handle and check validity of the form variables
  
  // event title should not be empty string
  if(strlen($newsTitle) > 0) {
    // max length of event title is 200 characters
    $newsTitle = truncateString($newsTitle, 200);
  }
  else {
    $post_success = false;
    $post_error .= "<li>Titill fréttar má ekki vera tómur strengur.</li>\n";
  }
  
  // event description should not be empty string
  if(strlen($newsDescription) == 0) {
    $post_success = false;
    $post_error .= "<li>Lýsing fréttar má ekki vera tómur strengur.</li>\n";
  }
  
  if($post_success) {
    // insert event into database
    $insert = $db->prepare("INSERT INTO 'news' ('title', 'description') VALUES (:title,:description)");
    $result = $insert->execute(array('title' => $newsTitle,'description' => $newsDescription));
    if(!$result) {
      // $error = $insert->errorCode();
      die("Database error."); // þarf kannski að meðhöndla eitthvað betur
    }
    // post succeeded so we empty the variables from the form
    $newsTitle       = "";
    $date_created = "";
    $date_edited   = "";
    $newsDescription = "";
    $newsCreator = "";
    $last_editor = "";
  }
}

?>
<!DOCTYPE html>
<html lang="is">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $website_content; ?>">
    <meta name="author" content="Sveinn Flóki Guðmundsson, Tómas Páll Máté">
    <link rel="shortcut icon" href="ico/favicon.ico">

    <title><?php echo $website_title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="dist/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

    <!-- Custom styles -->
    <link href="css/main.css" rel="stylesheet">
  </head>

  <body>

<?php
require_once "parts/navbar.php";
?>

    <div class="container">
      
      <h1>Sláðu inn frétt</h1>
      
<?php

if($post_happened) {
  if($post_success) {
    echo <<<_END
      <div class="alert alert-block alert-success fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4>Frétt skráð</h4>
        <p>Frétt hefur verið skráð, smelltu á takkann hér fyrir neðan til að skoða/breyta frétt eða fletta henni upp í fréttalista.</p>
        <p>
          <a class="btn btn-success" href="#">Breyta</a> <a class="btn btn-default" href="#">Fara í fréttalista</a>
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

      <form role="form" method="post" action="news.add.php">
        <div class="form-group">
          <label for="newsTitle">Titill fréttar</label>
          <input class="form-control" id="newsTitle" name="newsTitle" placeholder="Titill" value="<?php echo $newsTitle; ?>">
        </div>

        
        <div class="form-group">
          <label for="newsDescription">Lýsing</label>
          <textarea id="newsDescription" name="newsDescription" class="form-control" rows="4" placeholder="Lýsing ..."><?php echo $newsDescription; ?></textarea>
        </div>

        
        <button type="submit" class="btn btn-default">Skrá frétt</button>
      </form>
    
    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
    <script src="dist/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript">
      $(function () {
        $('#datetimepicker1').datetimepicker({
          pickSeconds: false
        });
        $('#datetimepicker2').datetimepicker({
          pickSeconds: false
        });
        $('#datetimepicker3').datetimepicker({
          pickSeconds: false
        });
        $('#datetimepicker4').datetimepicker({
          pickSeconds: false
        });
      });
    </script>
  </body>
</html>