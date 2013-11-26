<?php
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 'On');
error_reporting(E_ALL);

// this is a trash file just for testing some php functionality, can be safely deleted

if (!(false)) {
  echo "true";
}
else {
  echo "false";
}

echo "\n";

/*
$timestamp = strtotime("13-12-2008 23:30");
echo $timestamp;
echo "\n";
echo is_int($timestamp);

$string = "13-12-2008 24:59:01";

if(strtotime($string)) {
  echo "success ".strtotime($string);
}
else {
  echo "false ".strtotime($string);
}
*/

// truncate a string provided by the maximum limit without breaking a word
function truncateStringWords($str, $maxlen) {
    if (strlen($str) <= $maxlen) return $str;
    $newstr = substr($str, 0, $maxlen);
    if (substr($newstr, -1, 1) != ' ') $newstr = substr($newstr, 0, strrpos($newstr, " "));
    return $newstr;
}

// truncate a string provided by the maximum limit
function truncateString($str, $maxlen) {
  if (strlen($str) > $maxlen) {
    return substr($str, 0, $maxlen);
  }
  return $str;
}

$salt1 = "v@ult";
$salt2 = "pod!";

$pass = "pass";

$encripted_pass = md5("$salt1$pass$salt2");

echo "md5 pass:";
echo $encripted_pass;
echo "\n";

$usr_password = hash('sha256', "$salt1$pass$salt2");
$usr_password2 = hash('sha256', $usr_password);
$usr_password3 = hash('sha256', $usr_password2);
$usr_password4 = hash('sha256', $usr_password3);
$usr_password5 = hash('sha256', $usr_password4);

echo "sha pass:";
echo "\n";
echo $usr_password;
echo "\n";
echo $usr_password2;
echo "\n";
echo $usr_password3;
echo "\n";
echo $usr_password4;
echo "\n";
echo $usr_password5;

$my_var = "0";


if(filter_var($my_var, FILTER_VALIDATE_INT)) {
  echo "virkar";
  echo $my_var;
}

echo "\n";

var_dump(filter_var("0", FILTER_VALIDATE_INT));


/*
try {
  $n = explode(" ","");
  echo count($n);
}
catch (Exception $e) {
  echo "not possible";
}*/

?>