<?php
session_start();
require_once "koneksi.php"; // Sertakan file koneksi.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = trim($_POST["username"]);
  $password = md5($_POST["password"]); // Hash the entered password with MD5

  $sql = "SELECT * FROM admin WHERE username = :username AND password = :password LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':username', $username);
  $stmt->bindParam(':password', $password);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($result) {
    $_SESSION["admin_logged_in"] = true;
    $_SESSION["username"] = $username;
    header("Location: index.php");
    exit;
  } else {
    $errorMessage = "Username atau password salah.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Login - SRAMBI PAUD</title>
  <link href="assets/css/styles.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
  <style>
    body {
      background-color: #f8f9fa;
    }

    .card {
      margin-top: 100px;
      background-color: #ffffff;
      box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
      border-radius: 15px;
    }
  </style>
</head>

<body>
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
      <main>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-5">
              <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header text-center">
                  <img src="../assets/img/srambipaudlogo.png" alt="Srambi Paud Logo" class="img-fluid">
                </div>
                <div class="card-body">
                  <form method="POST">
                    <div class="form-floating mb-3">
                      <input class="form-control" id="inputUsername" name="username" type="text" placeholder="Username" />
                      <label for="inputUsername">Username</label>
                    </div>
                    <div class="form-floating mb-3 position-relative">
                      <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Password" />
                      <label for="inputPassword">Password</label>
                    </div>
                    <div class="d-flex align-items-center justify-content-center mt-4 mb-0">
                      <button class="btn btn-primary" type="submit">Login</button>
                    </div>
                  </form>
                  <?php if (!empty($errorMessage)) : ?>
                    <div class="text-center mt-3">
                      <p class="text-danger"><?php echo $errorMessage; ?></p>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>