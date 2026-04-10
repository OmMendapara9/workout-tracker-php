<?php
session_start();
include("../config/db.php");

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email='$email'");
    $user = $result->fetch_assoc();

    if($user && password_verify($password, $user['password'])){
        $_SESSION['user'] = $user['id'];
        header("Location: ../dashboard.php");
    } else {
        echo "Invalid credentials";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        <!-- 
                  Login Form Section
                  Default visible form
                -->
        <section class="form-container active" id="loginForm" aria-labelledby="loginTitle">
          <header class="form-header">
            <h2 class="form-title" id="loginTitle">Welcome Back</h2>
            <p class="form-subtitle">Login to your account</p>
          </header>

          <form class="auth-form" method="POST" novalidate>
            <!-- Email Input -->
            <div class="form-group mb-3">
              <label for="loginEmail" class="form-label">
                <i class="fas fa-envelope me-2" aria-hidden="true"></i>Email Address
              </label>
              <input type="email" class="form-control" id="loginEmail" name="email"  placeholder="Enter your email" autocomplete="email" required>
            </div>

            <!-- Password Input -->
            <div class="form-group mb-3">
              <label for="loginPassword" class="form-label">
                <i class="fas fa-lock me-2" aria-hidden="true"></i>Password
              </label>
              <div class="password-input-wrapper">
                <input type="password" class="form-control" id="loginPassword" name="password" placeholder="Enter your password" autocomplete="current-password" required>
                <button type="button" class="password-toggle" aria-label="Toggle password visibility" onclick="togglePassword('loginPassword')">
                  <i class="fas fa-eye" aria-hidden="true"></i>
                </button>
              </div>
            </div>

            <!-- Form Options: Remember Me & Forgot Password -->
            <div class="form-options mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="rememberMe">
                <label class="form-check-label" for="rememberMe">
                  Remember me
                </label>
              </div>
              <a href="#" class="forgot-password">Forgot Password?</a>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary btn-auth w-100 mb-3" name="login">
              <span>Login</span>
              <i class="fas fa-arrow-right ms-2" aria-hidden="true"></i>
            </button>

            <!-- Switch to Register -->
            <footer class="form-footer">
              <p>Don't have an account?
                <a href="./register.php" class="switch-form" >Register</a>
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
</body>
</html>

<!-- 
<form method="POST">
  <h2>Login</h2>
  <input type="email" name="email" placeholder="Email" required><br>
  <input type="password" name="password" placeholder="Password" required><br>
  <button name="login">Login</button>
</form> -->