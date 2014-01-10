<?php

// sqlite database kept outside of the .public_html folder so it's not accessible by url
if($development) {
  $db_placement = "my_web_assets/sqlite/events_website.db"; // on localhost we need this
}
else {
  $db_placement = "/heima/".HOST_USER."/.my_web_assets/sqlite/events_website.db"; // on notendur.hi.is we need this
}

// creating connection to sqlite database
$db = new PDO("sqlite:$db_placement");

// unset db placement variable for security reasons
unset($db_placement);

?>