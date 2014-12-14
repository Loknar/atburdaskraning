<?php
require_once "php/head.php";

// this page requires moderator or administrator login to access
requireMod();

// get id
$news_id = intGET("id");

// check if given id is valid or not, and fetch info about the event if id is valid
// preparing statement
$query = $db->prepare("SELECT title,description FROM news WHERE news_id = :news_id;");
// insert variables safely into the prepared statement and execute it
$query->execute(array('news_id' => $news_id));
// fetch results into a results variable
$news_result = $query->fetchAll();
if (0 == count($news_result)) redirectToRoot(); // if no news with id then gtfo

$row_data = $news_result[0];

$title = $row_data["title"];
$description = $row_data["description"];

// =============
// POST handling
// =============

// variables for the form
$newsTitle       = $title;
$date_created = "";
$date_edited   = "";
$newsDescription = $description;
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
    $last_editor = USER_ID;
    $date_edited = time();
    // insert event into database
    $insert = $db->prepare("UPDATE news SET title=:title,description=:description,date_edited=:date_edited,last_editor=:last_editor WHERE news_id=:news_id;");
    $result = $insert->execute(array('title' => $newsTitle,'description' => $newsDescription,'news_id' => $news_id,'date_edited'=>$date_edited,'last_editor'=>$last_editor));
    if(!$result) {
      // $error = $insert->errorCode();
      die("Database error."); // þarf kannski að meðhöndla eitthvað betur
    }
    // post succeeded
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
      
      <h1>Breyta skráðri frétt</h1>
      
<?php

if($post_happened) {
  if($post_success) {
    echo <<<_END
      <div class="alert alert-block alert-success fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4>Frétt breytt</h4>
        <p>Frétt hefur verið uppfærð.</p>
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

      <form role="form" method="post" action="news.change.php?id=<?php echo $news_id; ?>">
        <div class="form-group">
          <label for="newsTitle">Titill fréttar</label>
          <input class="form-control" id="newsTitle" name="newsTitle" placeholder="Titill" value="<?php echo $newsTitle; ?>">
        </div>

        
        <div class="form-group">
          <label for="newsDescription">Lýsing</label>
          <textarea id="newsDescription" name="newsDescription" class="form-control" rows="4" placeholder="Lýsing ..."><?php echo $newsDescription; ?></textarea>
        </div>

        
        <button type="submit" class="btn btn-default">Breyta frétt</button>
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