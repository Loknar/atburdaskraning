<?php
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 'On');
error_reporting(E_ALL);

// load config file
require_once "php/config.php";

// sqlite database login
require_once "php/db_login.php";

// load utility functions
require_once "php/utils.php";

// domain constant defined
//define("THIS_DOMAIN", "https://notendur.hi.is/~".HOST_USER."/$website_subfolder"); // on notendur.hi.is
define("THIS_DOMAIN", "http://localhost:8888/vefforritun/atburdaskraning/"); // on localhost

// creating salt variables for hashing
$salt1 = "v@ult";
$salt2 = "pod!";

// variable created for included php scripts to let them know if they exist or not, move along pls
$to_be_or_not_to_be = "genesis";

// load the session setup file
require_once "php/session_setup.php";

?>