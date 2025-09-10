<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-body">
          <h4 class="card-title mb-4">Profile</h4>
          <!-- Tempat isi profile -->
          <div id="profile">
            Memuat data profile...
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
    async function loadProfile() {
        const token = localStorage.getItem("token");
        if (!token) {
            document.getElementById("profile").innerText = "Token tidak ditemukan, silakan login dulu.";
            return;
        }

        try {
            const res = await fetch("/api/auth/profile", {
                headers: {
                    "Authorization": "Bearer " + token
                }
            });

            const data = await res.json();

            if (data.status === "success") {
                document.getElementById("profile").innerHTML = `
                    <p><strong>Nomor:</strong> ${data.user.nomor}</p>
                    <p><strong>Nama:</strong> ${data.user.nama}</p>
                    <p><strong>Role ID:</strong> ${data.user.role_id}</p>
                `;
            } else {
                document.getElementById("profile").innerText = data.message;
            }
        } catch (err) {
            document.getElementById("profile").innerText = "Error saat memuat profile: " + err;
        }
    }

    loadProfile();
</script>
</body>
</html>
