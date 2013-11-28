<?php
if (!isset($to_be_or_not_to_be)) {
  // not to be
  exit();
}

// current time
$now = time();

// here we want to get next 5 upcoming events from database
// preparing statement
$query = $db->prepare("SELECT title,description,date_created,date_edited,creator,last_editor,news_id FROM news ORDER BY date_created LIMIT 0, 5;");
$query->execute(); // no variables to add
// fetch results into a results variable
$result = $query->fetchAll();

if (0 < count($result)) {
  foreach($result as $row_data) {
    $title = $row_data["title"];
    $description = nl2br($row_data["description"]);
    $date_created = $row_data["date_created"];
    $date_edited = $row_data["date_edited"];
    $creator = $row_data["creator"];
    $last_editor = $row_data["last_editor"];
    $news_id = $row_data["news_id"];
    echo <<<_END
            <div class="fretta_haldari">
              <h2>$title</h2>
              <p>$description</p>
              <p><a class="btn btn-default" href="news.single.php?id=$news_id" role="button">Lesa nánar &raquo;</a></p>
            </div>
_END;
  }
}
else {
  echo <<<_END
              <p>Engar fréttir skráðar.</p>

_END;
}


?>