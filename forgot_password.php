<?php
include 'db.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $new_password = $_POST['password'];

    // Check if the email exists in the database
    $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Email exists, update the password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $update_stmt->bind_param("ss", $hashed_password, $email);

        if ($update_stmt->execute()) {
            // Password successfully updated, redirect to the login page
            header("Location: index.html");
            exit();
        } else {
            $error_message = "Error updating password.";
        }

        $update_stmt->close(); // Close the update statement only if it's initialized
    } else {
        $error_message = "Email does not exist.";
    }

    $stmt->close(); // Close the select statement
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
  <div class="form-container d-flex justify-content-center" style="align-items: center;">
    <div class="row">
      <div class="container" style="margin-top: 10%;">
        <div class="row d-flex justify-content-center" style="align-items: center;">
          <h2 class="text-center">Forgot Password</h2>
          <div class="col-12">
            <form id="loginForm" method="POST" action="forgot_password.php">
              <label for="email" class="mb-2 mt-3" style="color: #67BEFF;">Email</label>
              <input type="email" name="email" class="w-100 form-control rounded-3" placeholder="Enter your Email" required style="background-color: #D2EBFF; height: 50px;">

              <label for="password" class="mb-2 mt-3" style="color: #67BEFF;">Enter New Password</label>
              <input type="password" name="password" class="w-100 form-control rounded-3" style="background-color: #D2EBFF; height: 50px;" placeholder="Enter your new password" required>

              <!-- Display error message if there's any -->
              <?php if (isset($error_message)): ?>
                <div class="alert alert-danger mt-3">
                  <?php echo $error_message; ?>
                </div>
              <?php endif; ?>

              <label for="password" class="mb-2 mt-3">
                <a href="login.html" class="text-end" style="text-decoration: none; color:#67BEFF;">Back to Login</a>
              </label>
              <input type="submit" value="Reset" name="reset_password" class="btn text-white mt-2 mb-3 w-100" style="background-color: #0594FF; height: 50px;">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
