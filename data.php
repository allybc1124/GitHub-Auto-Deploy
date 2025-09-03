<?php

$rawInput = file_get_contents('db.json');
$input = json_decode($rawInput, true);

if ($input === null) {
    echo json_encode(["error" => "Invalid JSON input"]);
    exit;
}

$host = "localhost";
$username = "allison";
$password = "Allison1124Web!";
$database = "serverdatabase";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

foreach ($input['posts'] as $item) {

    if (
        isset($item['sessionId']) && 
        isset($item['timestamp']) &&
        isset($item['userAgent']) &&
        isset($item['language']) &&
        isset($item['cookiesEnabled']) &&
        isset($item['javascriptEnabled']) &&
        isset($item['screenWidth']) &&
        isset($item['screenHeight']) &&
        isset($item['windowWidth']) &&
        isset($item['windowHeight']) &&
        isset($item['connectionType']) &&
        isset($item['imagesEnabled'])
    ) {
        $sessionId = $item['sessionId'];
        $timestamp = $item['timestamp'];
        $userAgent = $item['userAgent'];
        $language = $item['language'];
        $cookiesEnabled = $item['cookiesEnabled'] ? 1 : 0;
        $javascriptEnabled = $item['javascriptEnabled'] ? 1 : 0;
        $screenWidth = $item['screenWidth'];
        $screenHeight = $item['screenHeight'];
        $windowWidth = $item['windowWidth'];
        $windowHeight = $item['windowHeight'];
        $connectionType = $item['connectionType'];
        $imagesEnabled = $item['imagesEnabled'] ? 1 : 0;

        $query = "INSERT INTO static_data 
                  (session_id, timestamp, user_agent, language, cookies_enabled, javascript_enabled, screen_width, screen_height, window_width, window_height, connection_type, images_enabled) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($query);
        if ($stmt !== false) {
            $stmt->bind_param(
                "sisssiiiiisi",
                $sessionId, 
                $timestamp, 
                $userAgent, 
                $language, 
                $cookiesEnabled, 
                $javascriptEnabled, 
                $screenWidth, 
                $screenHeight, 
                $windowWidth, 
                $windowHeight, 
                $connectionType, 
                $imagesEnabled
            );
            $stmt->execute();
            $stmt->close();
        }
    }

    if (isset($item['performanceData'])) {
        $perf = $item['performanceData'];

        $sessionId = $perf['sessionId'];
        $pageLoadStart = $perf['pageLoadStart'];
        $pageLoadEnd = $perf['pageLoadEnd'];
        $totalLoadTime = $perf['totalLoadTime'];

        $query = "INSERT INTO performance_data 
                  (session_id, page_load_start, page_load_end, total_load_time)
                  VALUES (?, ?, ?, ?)";

        $stmt = $conn->prepare($query);
        if ($stmt !== false) {
            $stmt->bind_param(
                "siii",
                $sessionId,
                $pageLoadStart,
                $pageLoadEnd,
                $totalLoadTime
            );
            $stmt->execute();
            $stmt->close();
        }
    }

    if (isset($item['activityData'])) {
        $activity = $item['activityData'];

        $sessionId = $activity['sessionId'];
        $errorCount = isset($activity['errors']) ? count($activity['errors']) : 0;
        $mouseMovementsCount = isset($activity['mouseMovements']) ? count($activity['mouseMovements']) : 0;
        $clicksCount = isset($activity['clicks']) ? count($activity['clicks']) : 0;
        $scrollsCount = isset($activity['scrolls']) ? count($activity['scrolls']) : 0;
        $keyEventsCount = isset($activity['keyEvents']) ? count($activity['keyEvents']) : 0;
        $idlePeriodsCount = isset($activity['idlePeriods']) ? count($activity['idlePeriods']) : 0;

        $query = "INSERT INTO activity_data 
                  (session_id, error_count, mouse_movements_count, clicks_count, scrolls_count, key_events_count, idle_periods_count)
                  VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($query);
        if ($stmt !== false) {
            $stmt->bind_param(
                "siiiiii",
                $sessionId,
                $errorCount,
                $mouseMovementsCount,
                $clicksCount,
                $scrollsCount,
                $keyEventsCount,
                $idlePeriodsCount
            );
            $stmt->execute();
            $stmt->close();
        }
    }
}

$conn->close();

echo json_encode(["success" => "Static, Performance, and Activity data inserted successfully"]);

?>

