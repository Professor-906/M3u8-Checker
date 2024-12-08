<?php
// Start the session for security measures
session_start();

// Disable right-click and viewing the source
echo '<script>
  document.addEventListener("contextmenu", function(e) {
    e.preventDefault();
    alert("Right-click is disabled for security reasons.");
  });
  document.addEventListener("keydown", function(e) {
    if (e.ctrlKey && (e.key === "u" || e.key === "U" || e.key === "s" || e.key === "S")) {
      e.preventDefault();
      alert("Viewing the source is disabled.");
    }
  });
</script>';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>M3U Playlist Link Checker</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>M3U Playlist Link Checker</h1>
    <h3>Made By - Professor</h3>
    <h4>Telegram: @professor906</h4>
    
    <input type="text" id="playlistUrl" placeholder="Enter M3U playlist URL">
    <button id="checkPlaylist">Check Playlist</button>

    <!-- Loading Spinner -->
    <div id="loadingSpinner" class="spinner" style="display:none;"></div>

    <div class="results">
      <p>Total Channels: <span id="total">0</span> | 
      Live: <span id="live">0</span> | 
      Dead: <span id="dead">0</span></p>
      <button id="downloadLive" disabled>Download Live Channels (.txt)</button>
      <button id="downloadDead" disabled>Download Dead Channels (.txt)</button>
    </div>

    <table>
      <thead>
        <tr>
          <th>Channel Name</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody id="channelList"></tbody>
    </table>
  </div>

  <!-- Footer -->
  <footer>
    <p>&copy; 2024 Professor. All rights reserved.</p>
  </footer>

  <script src="app.js"></script>
</body>
</html>
