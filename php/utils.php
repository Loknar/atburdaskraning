<?php
// utility functions stored here

// function for destroying current session
function destroySession() {
	$_SESSION = array();
	if (session_id() != "" || isset($_COOKIE[session_name()])) {
	  setcookie(session_name(), '', time()-2592000, '/');
	}
	session_destroy();
}

// redirects client to website root, must be called before anything else is printed to work
function redirectToRoot() {
  header("Location: ".THIS_DOMAIN);
  exit();
}

// function for guarding pages that require user login to access
function requireLogin() {
  // if user is not logged in we forward the user to index
  if(!USER_LOGGEDIN) {
    redirectToRoot();
  }
}

// function for guarding pages that require moderator or administrator login to access
function requireMod() {
  requireLogin();
  if(USER_PRIVILEGES != 1 && USER_PRIVILEGES != 2) {
    redirectToRoot();
  }
}

// function for guarding pages that require administrator login to access
function requireAdmin() {
  requireLogin();
  if(USER_PRIVILEGES != 2) {
    redirectToRoot();
  }
}

// truncate a string provided by the maximum limit
function truncateString($str, $maxlen) {
  if (strlen($str) > $maxlen) {
    return substr($str, 0, $maxlen);
  }
  return $str;
}

// truncate a string provided by the maximum limit without breaking a word
function truncateStringWords($str, $maxlen) {
  if (strlen($str) <= $maxlen) return $str;
  $newstr = substr($str, 0, $maxlen);
  if (substr($newstr, -1, 1) != ' ') $newstr = substr($newstr, 0, strrpos($newstr, " "));
  return $newstr;
}

// tekur við streng og tékkar hvort hann sé á einhverju valid datetime formi með því að nota strtotime,
// takist það skilar fallið true, annars false
function validateDatetime($string){
	if(strtotime($string)) {
	  return true;
	}
	else {
	  return false;
	}
}

// þægilegri ritháttur til að sækja post gildi, fjarlægir html tags
function get_post($var) {
	return strip_tags($_POST[$var]);
}

// checks if a string holds an integer
function holds_int($str) {
  return filter_var($str, FILTER_VALIDATE_INT) !== false;
}

// gets an integer from GET variable, if it's not set or not an integer then returns 0
function intGET($name) {
  if (filter_has_var(INPUT_GET, $name) !== False && filter_input(INPUT_GET, $name, FILTER_VALIDATE_INT) !== False) {
    return filter_input(INPUT_GET, $name, FILTER_SANITIZE_NUMBER_INT);
  }
  return 0;
}


?>