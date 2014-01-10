<?php
// for sessions to work on notendur.hi.is we need to set a custom session save folder, abd chmod -R 0777 [foldername] that folder
$sessions_placement = "/heima/".HOST_USER."/.my_web_assets/sessions";
if(!$development) {
  ini_set("session.save_path",$sessions_placement); // needed on notendur.hi.is
}

// unset sessions save path placement variable for security reasons
unset($sessions_placement);

session_start();

// session warden, sets constant USER_LOGGEDIN to true if session has valid user, else to false
if (isset($_SESSION["loggedin_user"])) {
  $session_user = $_SESSION["loggedin_user"];
  //$session_hash = $_SESSION["user_hash_key"]; // commented out because bad idea to store pass in session variable
  
  // check in database for user
  $query = $db->prepare("SELECT name,post,pass,privileges,user_id FROM users WHERE post=:post;");
  $query->execute(array('post' => $session_user));
  $result = $query->fetchAll();
  
  if (!empty($result)) {
    // set additional variables with info about user
    $result = $result[0];
    $user_name = $result["name"]; // these should perhaps be made constants for security reasons, so they can't be overwritten
    $user_id = $result["user_id"];
    $user_privileges = $result["privileges"];
    
    // THESE SHOULD BE USED WHEN CRUCIAL THAT THEY HAVEN'T BEEN FIDDLED WITH
    define("USER_NAME", $user_name);
    define("USER_ID", $user_id);
    define("USER_PRIVILEGES", $user_privileges);
    
    define("USER_LOGGEDIN", TRUE);
  }
  else {
    define("USER_LOGGEDIN", FALSE);
  }
}
else {
  define("USER_LOGGEDIN", FALSE);
}

?>