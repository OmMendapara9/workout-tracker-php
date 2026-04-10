<?php
include("../config/db.php");

if(isset($_POST['register'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password) VALUES ('$name','$email','$password')";

    if($conn->query($sql)){
        header("Location: login.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <!-- Bootstrap CSS Framework -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome for Interaction Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <main class="container">
  <div class="row justify-content-center align-items-center min-vh-100">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">

      <!-- Authentication Card Container -->
      <div class="auth-container">

        <section class="form-container active">
          <header class="form-header">
            <h2 class="form-title" id="registerTitle">Create Account</h2>
            <p class="form-subtitle">Sign up to get started</p>
          </header>

          <form class="auth-form" method="POST">
            <!-- Full Name Input -->
            <div class="form-group mb-3">
              <label for="registerName" class="form-label" >
                <i class="fas fa-user me-2" aria-hidden="true"></i>Full Name
              </label>
              <input type="text" class="form-control" name="name" placeholder="Enter your full name" autocomplete="name" required>
            </div>

            <!-- Email Input -->
            <div class="form-group mb-3">
              <label for="registerEmail" class="form-label">
                <i class="fas fa-envelope me-2" aria-hidden="true"></i>Email Address
              </label>
              <input type="email" class="form-control" name="email" placeholder="Enter your email" autocomplete="email" required>
            </div>

            <!-- Password Input -->
            <div class="form-group mb-3">
              <label class="form-label">
                <i class="fas fa-lock me-2" aria-hidden="true"></i>Password
              </label>
              <div class="password-input-wrapper">
                <input type="password" class="form-control" name="password" placeholder="Create a password" autocomplete="new-password" required>
                <button type="button" class="password-toggle" >
                  <i class="fas fa-eye" aria-hidden="true"></i>
                </button>
              </div>
            </div>


            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary btn-auth w-100 mb-3" name="register">
              <span>Create Account</span>
              <i class="fas fa-arrow-right ms-2" aria-hidden="true"></i>
            </button>

            <!-- Switch to Login -->
            <footer class="form-footer">
              <p>Already have an account?
                <a href="./login.php" class="switch-form">Login</a>
              </p>
            </footer>
          </form>
        </section>
      </div>
    </div>
  </div>
</main>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- <script src="../assets/js/main.js"></script> -->
</body>
</html>

<!-- <form method="POST">
  <h2>Register</h2>
  <input type="text" name="name" placeholder="Name" required><br>
  <input type="email" name="email" placeholder="Email" required><br>
  <input type="password" name="password" placeholder="Password" required><br>
  <button name="register">Register</button>
</form> -->