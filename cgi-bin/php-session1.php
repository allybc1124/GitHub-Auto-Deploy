<?php
session_start();

if (isset($_POST['username']) && trim($_POST['username']) !== '') {
    $_SESSION['username'] = $_POST['username'];
}

$name = $_SESSION['username'] ?? null;

echo <<<HTML
<!DOCTYPE html>
<html>
<head>
    <title>PHP Sessions</title>
</head>
<body>
<h1>PHP Sessions Page 1</h1>
HTML;

if ($name) {
    echo "<p><b>Name:</b> " . htmlspecialchars($name) . "</p>";
} else {
    echo "<p><b>Name:</b> You do not have a name set</p>";
}

echo <<<HTML
<br/><br/>
<a href="/php-state-demo.html">PHP CGI Form</a><br/>
<form style="margin-top:30px" action="/cgi-bin/php-destroy-session.php" method="get">
    <button type="submit">Destroy Session</button>
</form>
</body>
</html>
HTML;
?>
