<?php
session_start();

session_unset();
session_destroy();

setcookie(session_name(), '', time() - 3600, '/');

echo <<<HTML
<!DOCTYPE html>
<html>
<head>
    <title>PHP Session Destroyed</title>
</head>
<body>
<h1>Session Destroyed</h1>
<a href="/php-state-demo.html">Back to the PHP CGI Form</a><br />
<a href="/cgi-bin/php-session1.php">Back to Page 1</a><br />
</body>
</html>
HTML;
?>
