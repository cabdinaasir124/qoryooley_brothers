document.addEventListener("DOMContentLoaded", () => {
  const userRole = document.getElementById('userRole').value;
  console.log("User Role:", userRole);

  function fetchNotifications() {
    fetch(`../api/notification_api.php?role=${userRole}`)
      .then(response => response.json())
      .then(data => {
        const container = document.querySelector('.noti-scroll');
        const badge = document.querySelector('.noti-icon-badge');
        container.innerHTML = '';

        let count = data.length;

        data.forEach(item => {
          playSound();
          showToast(item.title, item.body);

          container.innerHTML += `
            <a href="../admin/announcements.php" class="dropdown-item notify-item text-muted link-primary">
              <div class="notify-icon">
                <img src="../upload/profile/${item.profile_image}" class="img-fluid rounded-circle" width="40" height="40" />
              </div>
              <div class="d-flex align-items-center justify-content-between">
                <p class="notify-details">${item.username}</p>
                <small class="text-muted">${new Date(item.created_at).toLocaleString()}</small>
              </div>
              <p class="mb-0 user-msg"><small class="fs-14">${item.body}</small></p>
            </a>
          `;
        });

        badge.innerText = count;
      });
  }

  function playSound() {
    const audio = new Audio('../assets/audio/notify.mp3');
    audio.play();
  }

  function showToast(title, message) {
    Toastify({
      text: `${title}: ${message}`,
      duration: 5000,
      gravity: "top",
      position: "left",
      backgroundColor: "#4f46e5",
      stopOnFocus: true
    }).showToast();
  }

  // Clear all (mark as read)
  document.getElementById('markAllRead').addEventListener('click', function (e) {
    e.preventDefault();

    fetch('../api/mark_notifications_read.php')
      .then(res => res.json())
      .then(res => {
        if (res.status === 'success') {
          Toastify({
            text: "All notifications marked as read.",
            duration: 3000,
            backgroundColor: "#10b981"
          }).showToast();
          fetchNotifications(); // refresh
        }
      });
  });

  fetchNotifications(); // initial
  setInterval(fetchNotifications, 10000); // every 10s
});
