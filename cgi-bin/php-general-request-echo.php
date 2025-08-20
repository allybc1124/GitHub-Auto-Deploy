<?php
header("Cache-Control: no-cache");
header("Content-Type: text/html");

echo <<<HTML
<!DOCTYPE html>
<html>
<head>
    <title>General Request Echo</title>
</head>
<body>
    <h1 align="center">General Request Echo</h1>
    <hr>
HTML;

echo "<p><b>HTTP Protocol:</b> " . htmlspecialchars($_SERVER['SERVER_PROTOCOL'] ?? 'Unknown') . "</p>\n";
echo "<p><b>HTTP Method:</b> " . htmlspecialchars($_SERVER['REQUEST_METHOD'] ?? 'Unknown') . "</p>\n";
echo "<p><b>Query String:</b> " . htmlspecialchars($_SERVER['QUERY_STRING'] ?? '') . "</p>\n";

$form_data = file_get_contents('php://input');
$form_data = htmlspecialchars($form_data);
echo "<p><b>Message Body:</b> $form_data</p>\n";

echo "</body></html>";
?>
