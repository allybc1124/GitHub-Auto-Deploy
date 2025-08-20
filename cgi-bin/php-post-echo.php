<?php
// Tell the browser not to cache
header("Cache-Control: no-cache");
header("Content-Type: text/html");

// Start HTML output
echo <<<HTML
<!DOCTYPE html>
<html>
<head>
    <title>POST Request Echo</title>
</head>
<body>
    <h1 align="center">POST Request Echo</h1>
    <hr>
HTML;

// Output the message body
echo "<b>Message Body:</b><br />\n";
echo "<ul>\n";

// Loop through POST data
$loop = 0;
foreach ($_POST as $key => $value) {
    $loop++;
    if ($loop % 2 != 0) { // only odd-numbered parameters
        echo "<li>" . htmlspecialchars($key) . " = " . htmlspecialchars($value) . "</li>\n";
    }
}

echo "</ul>\n";

// Close HTML
echo "</body></html>";
?>
