document.getElementById("checkPlaylist").addEventListener("click", () => {
  const url = document.getElementById("playlistUrl").value;
  if (!url) {
    alert("Please enter a valid M3U URL.");
    return;
  }

  // Show loading spinner
  document.getElementById("loadingSpinner").style.display = "block";

  fetch("process.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `url=${encodeURIComponent(url)}`,
  })
    .then((response) => response.json())
    .then((data) => {
      document.getElementById("loadingSpinner").style.display = "none";
      if (data.error) {
        alert(data.error);
        return;
      }

      // Update Results
      document.getElementById("total").textContent = data.total;
      document.getElementById("live").textContent = data.live;
      document.getElementById("dead").textContent = data.dead;

      // Enable download buttons
      document.getElementById("downloadLive").disabled = false;
      document.getElementById("downloadDead").disabled = false;

      // Populate Table
      const tbody = document.getElementById("channelList");
      tbody.innerHTML = "";
      data.channels.forEach((channel) => {
        const row = document.createElement("tr");
        row.innerHTML = `
          <td>${channel.name}</td>
          <td>${channel.status}</td>
        `;
        tbody.appendChild(row);
      });
    })
    .catch((err) => {
      document.getElementById("loadingSpinner").style.display = "none";
      console.error(err);
    });
});

document.getElementById("downloadLive").addEventListener("click", () => {
  window.location.href = "downloads/live_channels.txt";
});

document.getElementById("downloadDead").addEventListener("click", () => {
  window.location.href = "downloads/dead_channels.txt";
});
