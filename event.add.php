<?php
require_once "php/head.php";

// this page requires moderator or administrator login to access
requireMod();

// =============
// POST handling
// =============

// variables for the form
$eventTitle       = "";
$eventStarting    = "";
$eventEnding      = "";
$registerStarting = "";
$registerEnding   = "";
$eventDescription = "";
$eventLocation    = "";
$eventSeats       = "";

$post_happened = false;

if(isset($_POST["eventTitle"]) && 
   isset($_POST["eventStarting"]) && 
   isset($_POST["eventEnding"]) && 
   isset($_POST["registerStarting"]) && 
   isset($_POST["registerEnding"]) && 
   isset($_POST["eventDescription"]) && 
   isset($_POST["eventLocation"]) && 
   isset($_POST["eventSeats"])) {
  
  $post_happened = true;
  $post_success = true;
  $post_error = "";
  
  $eventTitle       = get_post("eventTitle");
  $eventStarting    = get_post("eventStarting");
  $eventEnding      = get_post("eventEnding");
  $registerStarting = get_post("registerStarting");
  $registerEnding   = get_post("registerEnding");
  $eventDescription = get_post("eventDescription");
  $eventLocation    = get_post("eventLocation");
  $eventSeats       = get_post("eventSeats");
  
  // handle and check validity of the form variables
  
  // event title should not be empty string
  if(strlen($eventTitle) > 0) {
    // max length of event title is 200 characters
    $eventTitle = truncateString($eventTitle, 200);
  }
  else {
    $post_success = false;
    $post_error .= "<li>Titill atburðar má ekki vera tómur strengur.</li>\n";
  }
  
  // check validity of datetimes
  if(validateDatetime($eventStarting)) {
    $eventStarting_Unixtime = strtotime($eventStarting);
  }
  else {
    $post_success = false;
    $post_error .= "<li>Formvilla á inntaki fyrir upphaf atburðar.</li>\n";
    $eventStarting = "";
  }
  if(validateDatetime($eventEnding)) {
    $eventEnding_Unixtime = strtotime($eventEnding);
  }
  else {
    $post_success = false;
    $post_error .= "<li>Formvilla á inntaki fyrir endi atburðar.</li>\n";
    $eventEnding = "";
  }
  if(validateDatetime($registerStarting)) {
    $registerStarting_Unixtime = strtotime($registerStarting);
  }
  else {
    $post_success = false;
    $post_error .= "<li>Formvilla á inntaki fyrir upphaf skráningar.</li>\n";
    $registerStarting = "";
  }
  if(validateDatetime($registerEnding)) {
    $registerEnding_Unixtime = strtotime($registerEnding);
  }
  else {
    $post_success = false;
    $post_error .= "<li>Formvilla á inntaki fyrir endi skráningar.</li>\n";
    $registerEnding = "";
  }
  
  // event description should not be empty string
  if(strlen($eventDescription) == 0) {
    $post_success = false;
    $post_error .= "<li>Lýsing atburðar má ekki vera tómur strengur.</li>\n";
  }
  
  // event location should not be empty string
  if(strlen($eventLocation) > 0) {
    // max length of event location is 200 characters
    $eventLocation = truncateString($eventLocation, 200);
  }
  else {
    $post_success = false;
    $post_error .= "<li>Staðsetning atburðar má ekki vera tómur strengur.</li>\n";
  }
  
  // event seats should be an integer and not an empty string
  if(holds_int($eventSeats)) {
    // max length of event location is 200 characters
    $eventSeats_int = (int) $eventSeats;
  }
  else {
    $post_success = false;
    $post_error .= "<li>Fjöldi lausra sæta þarf að vera tala, ef það er engin fjöldatakmörkun skal setja fjölda sæta sem 0.</li>\n";
  }
  
  if($post_success) {
    // insert event into database
    $date_created = time();
    $insert = $db->prepare("INSERT INTO 'events' ('title','start','end','registration_start','registration_end','description','location','seats','creator','date_created') VALUES (:title,:start,:end,:registration_start,:registration_end,:description,:location,:seats,:creator,:date_created)");
    $result = $insert->execute(array('title' => $eventTitle,'start' => $eventStarting_Unixtime,'end' => $eventEnding_Unixtime,'registration_start' => $registerStarting_Unixtime,'registration_end' => $registerEnding_Unixtime,'description' => $eventDescription,'location' => $eventLocation,'seats' => $eventSeats_int,'creator' => USER_ID,'date_created' => $date_created));
    if(!$result) {
      // $error = $insert->errorCode();
      die("Database error."); // þarf kannski að meðhöndla eitthvað betur
    }
    // post succeeded so we empty the variables from the form
    $eventTitle       = "";
    $eventStarting    = "";
    $eventEnding      = "";
    $registerStarting = "";
    $registerEnding   = "";
    $eventDescription = "";
    $eventLocation    = "";
    $eventSeats       = "";
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
      
      <h1>Sláðu inn atburð</h1>
      
<?php

if($post_happened) {
  if($post_success) {
    echo <<<_END
      <div class="alert alert-block alert-success fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4>Atburður skráður</h4>
        <p>Atburðurinn hefur verið skráður, smelltu á takkann hér fyrir neðan til að skoða/breyta atburðinum eða flettu honum upp í atburðalista.</p>
        <p>
          <a class="btn btn-success" href="#">Breyta</a> <a class="btn btn-default" href="#">Fara í atburðalista</a>
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

      <form role="form" method="post" action="event.add.php">
        <div class="form-group">
          <label for="eventTitle">Titill atburðar</label>
          <input class="form-control" id="eventTitle" name="eventTitle" placeholder="Titill" value="<?php echo $eventTitle; ?>">
        </div>
        
        <div class="row">
          <div class="form-group col-md-6">
            <label for="eventStarting">Atburður hefst</label>
            <div class='input-group date' id='datetimepicker1'>
              <input id="eventStarting" name="eventStarting" type='text' class="form-control" data-format="dd-MM-yyyy" placeholder="dd-mm-áááá kk:mm" value="<?php echo $eventStarting; ?>" />
              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
          </div>
          <div class="form-group col-md-6">
            <label for="eventEnding">Atburður endar</label>
            <div class='input-group date' id='datetimepicker2'>
              <input id="eventEnding" name="eventEnding" type='text' class="form-control" data-format="dd-MM-yyyy" placeholder="dd-mm-áááá kk:mm" value="<?php echo $eventEnding; ?>" />
              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="form-group col-md-6">
            <label for="registerStarting">Skráning hefst</label>
            <div class='input-group date' id='datetimepicker3'>
              <input id="registerStarting" name="registerStarting" type='text' class="form-control" data-format="dd-MM-yyyy" placeholder="dd-mm-áááá kk:mm" value="<?php echo $registerStarting; ?>" />
              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
          </div>
          <div class="form-group col-md-6">
            <label for="registerEnding">Skráning endar</label>
            <div class='input-group date' id='datetimepicker4'>
              <input id="registerEnding" name="registerEnding" type='text' class="form-control" data-format="dd-MM-yyyy" placeholder="dd-mm-áááá kk:mm" value="<?php echo $registerEnding; ?>" />
              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
          </div>
        </div>
        
        <div class="form-group">
          <label for="eventDescription">Lýsing atburðar</label>
          <textarea id="eventDescription" name="eventDescription" class="form-control" rows="4" placeholder="Lýsing ..."><?php echo $eventDescription; ?></textarea>
        </div>
        
        <div class="form-group">
          <label for="eventLocation">Staðsetning atburðar</label>
          <input class="form-control" id="eventLocation" name="eventLocation" placeholder="Staðsetning" value="<?php echo $eventLocation; ?>">
        </div>
        
        <div class="row">
          <div class="form-group col-md-2">
            <label for="eventSeats">Fjöldi sæta</label>
            <input class="form-control" id="eventSeats" name="eventSeats" placeholder="Fjöldi" value="<?php echo $eventSeats; ?>">
          </div>
        </div>
        
        <button type="submit" class="btn btn-default">Skrá atburð</button>
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