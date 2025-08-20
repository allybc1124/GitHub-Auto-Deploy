<?php
// Tell the browser not to cache
header("Cache-Control: no-cache");
header("Content-Type: text/html");

echo "<html>";
echo "<head>";
echo "<title>Hello, PHP!</title>";
echo "</head>";
echo "<body>";

echo "<h1>Allison was here - Hello, PHP!</h1>";
echo "<p>This page was generated with the PHP programming language</p>";

// Current time
$date = date("r");
echo "<p>Current Time: $date</p>";

// IP Address
$address = $_SERVER['REMOTE_ADDR'];
echo "<p>Your IP Address: $address</p>";

echo "</body>";
echo "</html>";
?>
