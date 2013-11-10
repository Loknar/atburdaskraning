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



echo strlen("");


/*
try {
  $n = explode(" ","");
  echo count($n);
}
catch (Exception $e) {
  echo "not possible";
}*/

?>