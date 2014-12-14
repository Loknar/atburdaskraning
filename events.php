<?php
require_once "php/head.php";

// admin delete event handling
$delete_success_message = false;
if(USER_PRIVILEGES == 2 && isset($_POST["delete_event"])) {
  $delete_event_id = intval(get_post("delete_event"));
  // remove event from database
  $delete = $db->prepare("DELETE FROM events WHERE event_id=:event_id;");
  $result = $delete->execute(array('event_id' => $delete_event_id));
  if(!$result) {
    // $error = $insert->errorCode();
    die("Database error."); // þarf kannski að meðhöndla eitthvað betur
  }
  $delete = $db->prepare("DELETE FROM registrations WHERE event_id=:event_id;");
  $result = $delete->execute(array('event_id' => $delete_event_id));
  if(!$result) {
    // $error = $insert->errorCode();
    die("Database error."); // þarf kannski að meðhöndla eitthvað betur
  }

  // show confirmation message that the deletion was successful
  $delete_success_message = true;
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
    <link href="dist/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles -->
    <link href="css/main.css" rel="stylesheet">
  </head>

  <body>

<?php
$events_active = " class=\"active\"";
require_once "parts/navbar.php";
?>

    <div class="container">

      <div class="starter-template">
 <?php
/*if (!isset($to_be_or_not_to_be)) {
  // not to be
  exit();
}*/

if($delete_success_message) {
  echo <<<_END
      <div class="alert alert-block alert-success fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4>Viðburði eytt</h4>
        <p>Viðburðuri og skráningargögnum á þann viðburð hefur verið eytt.</p>
      </div><!-- alert message -->
_END;
}

$temp_counter = 0;
$result = $db->query("SELECT event_id,title,start,end,registration_start,registration_end,description,location,seats,date_created,date_edited,creator,last_editor FROM events ORDER BY start DESC;");
foreach($result as $row_data) {
  $temp_counter++;
  $event_id = $row_data["event_id"];
  $title = $row_data["title"];
  $start = date("d-m-Y H:i", $row_data["start"]);
  $end = date("d-m-Y H:i", $row_data["end"]);
  $registration_start = date("d-m-Y H:i", $row_data["registration_start"]);
  $registration_end = date("d-m-Y H:i", $row_data["registration_end"]);
  $description = nl2br($row_data["description"]);
  $location = $row_data["location"];
  $seats = $row_data["seats"];
  $date_created = date("d-m-Y H:i",$row_data["date_created"]);
  $date_edited = date("d-m-Y H:i",$row_data["date_edited"]);
  $creator_id = $row_data["creator"];
  $editor_id = $row_data["last_editor"];
  
  $creator_statement = $db->prepare("SELECT name FROM users WHERE user_id = :user_id");
  $creator_statement->execute(array('user_id' => $creator_id));
  $creator_name_result = $creator_statement->fetchAll();
  $creator_name = $creator_name_result[0]["name"];


  $editor_statement = $db->prepare("SELECT name FROM users WHERE user_id = :user_id");
  $editor_statement->execute(array('user_id' => $editor_id));
  $editor_result = $editor_statement->fetchAll();
  if (isset($editor_result[0]["name"])) {
    $editor_name = $editor_result[0]["name"];
    $edited = "Síðast breytt $date_edited af $editor_name.";
  }
  else {
    $edited = "";
  }

  $changebutton = "";
  if (USER_LOGGEDIN && ($user_privileges == 2 or $user_privileges == 1)){
    $changebutton = "<p><a class='btn btn-warning' href='event.change.php?id=$event_id''>Breyta viðburði &raquo;</a></p>";
    if ($user_privileges == 2) {
      $changebutton .= <<<_END
      <form role="form" method="post" action="events.php">
        <input type="hidden" name="delete_event" value=$event_id />
        <button type="submit" class="btn btn-danger" onclick="return confirm('Þú ert að fara að eyða viðburðinum, þessi aðgerð er óafturkallanleg! Ertu viss um að þú viljir halda áfram?')">Eyða viðburði</button>
      </form>
_END;
    }
  }

  
  echo <<<_END

      <div class="panel-group" id="accordion">
        <div class="panel panel-default">
          <div class="panel-heading">
          <h3 class="panel-title">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse$temp_counter">
              $title <small>Hefst $start, lýkur $end</small>
            </a>
          </h3>
          </div>
          <div id="collapse$temp_counter" class="panel-collapse collapse">
            <div class="panel-body">
              <p>
              $description
              </p>
              <p>
              Staðsetning: $location.
              </p>
              <p>
              Skráning hefst $registration_start <br />
              Skráningu lýkur $registration_end
              </p>
              <p>
              Sætafjöldi: $seats
              </p>
              <p><a class="btn btn-default" href="event.php?id=$event_id">Fara í skráningarlista viðburðar &raquo;</a></p>
              <p><small>Skráð $date_created af $creator_name. $edited </small></p>
              $changebutton
            </div>
          </div>
        </div>
      </div>
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