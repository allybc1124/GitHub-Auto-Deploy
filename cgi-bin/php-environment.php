<?php
header("Cache-Control: no-cache");
header("Content-type: text/html");

echo '<!DOCTYPE html>
<html><head><title>Environment Variables</title>
</head><body><h1 align="center">Environment Variables</h1>
<hr>';

foreach (array_keys($_SERVER) as $variable) {
    echo "<b>$variable:</b> " . htmlspecialchars($_SERVER[$variable]) . "<br />\n";
}

echo '</body></html>';
?>
