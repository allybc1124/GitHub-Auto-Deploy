<?php
header("Cache-Control: no-cache");
header("Content-Type: text/html");

echo '<!DOCTYPE html>
<html>
<head>
    <title>GET Request Echo</title>
</head>
<body>
    <h1 align="center">Get Request Echo</h1>
    <hr>';

echo '<b>Query String:</b> ' . htmlspecialchars($_SERVER['QUERY_STRING']) . '<br />';

// Loop through GET parameters
$loop = 0;
foreach ($_GET as $key => $value) {
    $loop++;
    if ($loop % 2 != 0) { // only odd-numbered parameters
        echo htmlspecialchars($key) . ' = ' . htmlspecialchars($value) . '<br />';
    }
}

echo '</body></html>';
?>
