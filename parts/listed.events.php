<?php
if (!isset($to_be_or_not_to_be)) {
  // not to be
  exit();
}

$temp_counter = 0;
$result = $db->query("SELECT title,start,end,registration_start,registration_end,description,location,seats FROM events ORDER BY start;");
foreach($result as $row_data) {
  $temp_counter++;
  $title = $row_data["title"];
  $start = date("d-m-Y H:i", $row_data["start"]);
  $end = date("d-m-Y H:i", $row_data["end"]);
  $registration_start = date("d-m-Y H:i", $row_data["registration_start"]);
  $registration_end = date("d-m-Y H:i", $row_data["registration_end"]);
  $description = nl2br($row_data["description"]);
  $location = $row_data["location"];
  $seats = $row_data["seats"];
  
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
              <p><a class="btn btn-default" href="#">Fara í skráningarlista viðburðar &raquo;</a></p>
            </div>
          </div>
        </div>
      </div>
_END;
}
?>