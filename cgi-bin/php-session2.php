<?php
// Start the session (creates a cookie PHPSESSID automatically)
session_start();

// Output HTTP headers
header("Cache-Control: no-cache");
header("Content-Type: text/html");

// Get the cookie value (PHPSESSID)
$cookieValue = $_COOKIE['PHPSESSID'] ?? null;

// Get the username stored in the session
$name = $_SESSION['username'] ?? null;

// Start HTML output
echo <<<HTML
<!DOCTYPE html>
<html>
<head>
    <title>PHP Sessions - Page 2</title>
</head>
<body>
<h1>PHP Sessions Page 2</h1>
<table>
HTML;

// Display the session cookie
if ($cookieValue && $cookieValue !== 'destroyed') {
    echo "<tr><td>Session Cookie (PHPSESSID):</td><td>" . htmlspecialchars($cookieValue) . "</td></tr>\n";
} else {
    echo "<tr><td>Session Cookie (PHPSESSID):</td><td>None</td></tr>\n";
}

// Display the username from the session
if ($name) {
    echo "<tr><td>Username:</td><td>" . htmlspecialchars($name) . "</td></tr>\n";
} else {
    echo "<tr><td>Username:</td><td>Not set</td></tr>\n";
}

echo <<<HTML
</table>

<br />
<a href="/cgi-bin/php-session1.php">Session Page 1</a><br />
<a href="/php-state-demo.html">PHP CGI Form</a><br /><br />

<form action="/cgi-bin/php-destroy-session.php" method="get">
    <button type="submit">Destroy Session</button>
</form>

</body>
</html>
HTML;
?>
