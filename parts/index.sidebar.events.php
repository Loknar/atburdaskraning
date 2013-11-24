<?php
if (!isset($to_be_or_not_to_be)) {
  // not to be
  exit();
}

// current time
$now = time();

// here we want to get next 5 upcoming events from database
// preparing statement
$query = $db->prepare("SELECT title,start,end,registration_start,registration_end,description,location,seats,event_id FROM events WHERE end > :now ORDER BY start LIMIT 0, 5;");
// insert variables safely into the prepared statement and execute it
$query->execute(array('now' => $now));
// fetch results into a results variable
$result = $query->fetchAll();

if (0 < count($result)) {
  foreach($result as $row_data) {
    $title = $row_data["title"];
    $start = date("d-m-Y H:i", $row_data["start"]);
    $end = date("d-m-Y H:i", $row_data["end"]);
    $registration_start = date("d-m-Y H:i", $row_data["registration_start"]);
    $registration_end = date("d-m-Y H:i", $row_data["registration_end"]);
    $description = nl2br($row_data["description"]);
    $location = $row_data["location"];
    $seats = $row_data["seats"];
    $event_id = $row_data["event_id"];
    echo <<<_END
              <a href="event.php?id=$event_id" class="list-group-item">
                <p>$title</p>
                <p class="text-muted">
                  Atburður hefst: $start <br />
                  Skráning hefst: $registration_start
                </p>
              </a>
_END;
  }
}
else {
  echo <<<_END
              <li class="list-group-item">...</li>

_END;
}


?>