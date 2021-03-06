<?php
require_once "php/head.php";

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
    <link href="dist/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles -->
    <link href="css/main.css" rel="stylesheet">
  </head>

  <body>

<?php
$news_active = " class=\"active\"";
require_once "parts/navbar.php";
?>

    <div class="container">
      <div class="starter-template">
 <?php
/*if (!isset($to_be_or_not_to_be)) {
  // not to be
  exit();
}*/

$temp_counter = 0;
$result = $db->query("SELECT news_id,title,description,date_created,date_edited,creator,last_editor FROM news ORDER BY date_created desc;");
foreach($result as $row_data) {
  $temp_counter++;
  $news_id = $row_data["news_id"];
  $title = $row_data["title"];
  $date_created = date("d-m-Y H:i", $row_data["date_created"]);
  $date_edited = date("d-m-Y H:i", $row_data["date_edited"]);
  $description = nl2br($row_data["description"]);
  $creator_id = $row_data["creator"];
  $editor_id = $row_data["last_editor"];

  $creator_statement = $db->prepare("SELECT name FROM users WHERE user_id = :user_id");
  $creator_statement->execute(array('user_id' => $creator_id));
  $creator_name_result = $creator_statement->fetchAll();
  $creator_name = $creator_name_result[0]["name"];


  $editor_statement = $db->prepare("SELECT name FROM users WHERE user_id = :user_id");
  $editor_statement->execute(array('user_id' => $editor_id));
  $editor_result = $editor_statement->fetchAll();
  $editor_name = $editor_result[0]["name"];

  $changebutton = "";
  if (USER_LOGGEDIN && ($user_privileges == 2 || $user_privileges == 1)){
    $changebutton = "<p><a class='btn btn-warning' href='news.change.php?id=$news_id''>Breyta frétt &raquo;</a></p>";
  }

  echo <<<_END

      <div class="panel-group" id="accordion">
        <div class="panel panel-default">
          <div class="panel-heading">
          <h3 class="panel-title">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse$temp_counter">
              $title <small>Skráð $date_created af $creator_name</small>
            </a>
          </h3>
          </div>
          <div id="collapse$temp_counter" class="panel-collapse collapse">
            <div class="panel-body">
              <p>
              $description
              </p>
              <p>
              <small>Síðast breytt: $date_edited af $editor_name</small>
              </p>
              <p><a class="btn btn-default" href="news.single.php?id=$news_id">Skoða sem staka frétt &raquo;</a></p>
              $changebutton
            </div>
          </div>
        </div>
      </div>
      </div>

_END;
}
?>
    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
  </body>
</html>