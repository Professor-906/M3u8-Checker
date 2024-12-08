<?php
session_start();

// Prevent access to this script without proper POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized access.']);
    exit;
}

// Validate and sanitize the input URL
$url = filter_var($_POST['url'], FILTER_VALIDATE_URL);
if (!$url) {
    echo json_encode(['error' => 'Invalid URL']);
    exit;
}

// Fetch the M3U playlist content
$content = @file_get_contents($url);
if ($content === false) {
    echo json_encode(['error' => 'Failed to fetch M3U playlist.']);
    exit;
}

// Parse the playlist
$lines = explode("\n", $content);
$channels = [];
foreach ($lines as $line) {
    if (strpos($line, '#EXTINF:') === 0) {
        preg_match('/,(.*)$/', $line, $matches);
        $name = trim($matches[1]);
        $link = trim(next($lines));
        if ($link) {
            $channels[] = ['name' => $name, 'link' => $link];
        }
    }
}

// Check the status of the channels
$live = [];
$dead = [];
foreach ($channels as $channel) {
    $status = @file_get_contents($channel['link'], false, null, 0, 1) ? 'Live' : 'Dead';
    if ($status === 'Live') {
        $live[] = ['name' => $channel['name'], 'status' => 'Live'];
    } else {
        $dead[] = ['name' => $channel['name'], 'status' => 'Dead'];
    }
}

// Save live and dead channels to files
file_put_contents('downloads/live_channels.txt', implode("\n", array_column($live, 'link')));
file_put_contents('downloads/dead_channels.txt', implode("\n", array_column($dead, 'link')));

echo json_encode([
    'total' => count($channels),
    'live' => count($live),
    'dead' => count($dead),
    'channels' => array_merge($live, $dead)
]);
exit;
?>
