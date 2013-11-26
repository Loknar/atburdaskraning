<?php
require_once "php/head.php";

requireLogin();

// get id
$event_id = intGET("id");

// check if given id is valid or not, and fetch info about the event if id is valid
// preparing statement
$query = $db->prepare("SELECT title,start,end,registration_start,registration_end,description,location,seats FROM events WHERE event_id = :event_id;");
// insert variables safely into the prepared statement and execute it
$query->execute(array('event_id' => $event_id));
// fetch results into a results variable
$event_result = $query->fetchAll();
if (0 < count($event_result)) $valid_event_id = True;
else $valid_event_id = False;

// if id valid check if user is registered to the event
if ($valid_event_id) {
  // preparing statement
  $query = $db->prepare("SELECT user_id FROM registrations WHERE event_id=:event_id AND user_id=:user_id;");
  // insert variables safely into the prepared statement and execute it
  $query->execute(array('event_id' => $event_id,'user_id' => USER_ID));
  // fetch results into a results variable
  $result = $query->fetchAll();
  if (0 == count($result)) $user_registered_to_event = False;
  else $user_registered_to_event = True;
}

// get current time
$now = time();

// if id valid handle post register
if($valid_event_id && isset($_POST["register"]) && !$user_registered_to_event) {
  // preparing statement
  $query = $db->prepare("INSERT INTO 'registrations' ('user_id','event_id','timing') VALUES (:user_id,:event_id,:timing);");
  // insert variables safely into the prepared statement and execute it
  $result = $query->execute(array('user_id' => USER_ID,'event_id' => $event_id, 'timing' => $now));
  
  $user_registered_to_event = True;
  //echo "registered";
}

// if id valid handle post unregister
if($valid_event_id && isset($_POST["unregister"])) {
  // preparing statement
  $query = $db->prepare("DELETE FROM 'registrations' WHERE user_id=:user_id AND event_id=:event_id;");
  // insert variables safely into the prepared statement and execute it
  $result = $query->execute(array('user_id' => USER_ID,'event_id' => $event_id));
  
  $user_registered_to_event = False;
  //echo "unregistered";
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
  </head>

  <body>

<?php
require_once "parts/navbar.php";
?>

    <div class="container">

      <div class="starter-template">
<?php

if ($valid_event_id) {
  // there should only be one result, let's fetch that
  $row_data = $event_result[0];
  
  $title = $row_data["title"];
  $start = intval($row_data["start"]);
  $start_string = date("d-m-Y H:i",$start);
  $end = intval($row_data["end"]);
  $end_string = date("d-m-Y H:i",$end);
  $registration_start = intval($row_data["registration_start"]);
  $registration_start_string = date("d-m-Y H:i",$registration_start);
  $registration_end = intval($row_data["registration_end"]);
  $registration_end_string = date("d-m-Y H:i",$registration_end);
  $description = nl2br($row_data["description"]);
  $location = $row_data["location"];
  $seats = intval($row_data["seats"]);
  echo <<<_END
        <h1>$title</h1>
        <p class="text-muted">$start_string</p>
        <p>
        $description
        </p>
        <h2>Skráning</h2>
_END;
  
  // different things shown based on whether registartion is not yet started, started or over
  if ($now < $registration_start) {
    // registration not yet started
    if (0 < $seats) {
      $seats_string = "Sætafjöldi: $seats";
    }
    else {
      $seats_string = "Engin fjöldatakmörkun.";
    }
    
    echo <<<_END
        <p>
        Skráning hefst: $registration_start_string<br/>
        Skráningu lýkur: $registration_end_string<br/>
        $seats_string
        </p>
_END;
  }
  elseif ($registration_end < $now) {
    // registration over
    echo <<<_END
        <p>Skráningu lokið.</p>
_END;
  }
  else {
    // registration open
    if ($user_registered_to_event) {
      echo <<<_END
        <!-- Button trigger modal -->
        <button class="btn btn-danger" data-toggle="modal" data-target="#confirmUnregister">
          Afskrá mig
        </button>
        
        <!-- Modal -->
        <div class="modal fade" id="confirmUnregister" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Staðfesta afskráningu</h4>
              </div>
              <div class="modal-body">
                Þú ert við það að afskrá þig af viðkomandi atburði, þessa aðgerð er ekki hægt að draga til baka.
                Ertu viss um að þú viljir afskrá þig?
              </div>
              <div class="modal-footer">
                
                <form role="form" method="post" action="event.php?id=$event_id">
                  <input type="hidden" name="unregister" value="do it" />
                  <button type="button" class="btn btn-default" data-dismiss="modal">Hætta við</button>
                  <button type="submit" class="btn btn-danger">Já, afskráðu mig</button>
                </form>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

_END;
    }
    else {
      echo <<<_END
        <form role="form" method="post" action="event.php?id=$event_id">
          <input type="hidden" name="register" value="do it" />
          <button type="submit" class="btn btn-success">Skrá mig</button>
        </form>
_END;
    }
  }
  // different things shown based on whether registartion is not yet started, started or over
  
  // now we want to fetch users that have registered to this event
  
  // preparing statement
  $query = $db->prepare("SELECT name,user_id FROM users WHERE user_id IN (SELECT user_id FROM registrations WHERE event_id=:event_id ORDER BY timing DESC);");
  // insert variables safely into the prepared statement and execute it
  $query->execute(array('event_id' => $event_id));
  // fetch results into a results variable
  $result = $query->fetchAll();
  //var_dump($result);
  
  echo <<<_END
        <div class="fixed_width">
        <ol>
_END;
  
  $nr = 0;
  foreach($result as $row_data) {
    $name = $row_data["name"];
    
    $nr++;
    $listyle = "";
    if ($seats > 0 && $seats - $nr < 0) {
      $listyle = " style=\"color: #BBB;\" ";
    }
    echo <<<_END
        <li$listyle>$name</li>
_END;
  }
  
  echo <<<_END
        </ol>
        </div>
_END;
  
}
else {
  echo <<<_END
        <p>Atburður fannst ekki :(</p>

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