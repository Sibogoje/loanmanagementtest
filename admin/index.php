<?php
session_start();
include('auth.php');


if (isset($_POST['submit']) ) {
  $user = $_POST['username'];
// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if ($_POST['username'] === "" && $_POST['password'] === "")  {
	// Could not get the data that should have been sent.
	exit('Please fill both the username and password fields!');
}
// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $conn->prepare('SELECT `id`, `password` FROM `useraccounts` WHERE `username` = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	// Store the result so we can check if the account exists in the database.
	$stmt->store_result();
//	$stmt->close();
}

// Username doesnt exist, show error
if ($stmt->num_rows == 0) {
  echo 'Incorrect username and/or password!';
} else {
  $stmt->bind_result($id, $password);
  $stmt->fetch();
  // Account exists, now we verify the password.
  // Note: remember to use password_hash in your registration file to store the hashed passwords.
 // if (password_verify($_POST['password'], $password)) {
    if ($_POST['password'] === $password) {
    // Verification success! User has loggedin!
    // Create sessions so we know the user is logged in, they basically act like cookies but remember the data on the server.
    session_regenerate_id();
    $sessid = session_id();
    $_SESSION['loggedin'] = TRUE;
    $_SESSION['name'] = $_POST['username'];
    $_SESSION['id'] = $id;
    $online = '1';
 
$statement = $conn->prepare("UPDATE `useraccounts` SET `sessionid` = ?, `onlines` = ?  WHERE `username` = ?");
$statement->bind_param("sss", $sessid, $online, $user);
$statement->execute();

    header('Location: home.php');
  } else {
    // Incorrect password
    echo 'Incorrect username and/or password!';
  }
}

}



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin - v2.4.1
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body style="background-color: white;">

  <main>
    <div class="container" >

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="" class="logo d-flex align-items-center w-auto">
                  <img src="logo.png" alt="">
                  <span class=" d-lg-block" style="color: #d63600;">Umcenge Admin</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3 shadow-lg">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4" style="color: #03a329;">Login to Your Account</h5>
                    <p class="text-center small" style="color: #03a329;">Enter your username & password to login</p>
                  </div>

                  <form class="row g-3 needs-validation" method="post" action="" novalidate>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label" style="color: #03a329;">Username</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="username" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback" style="color: #03a329;">Please enter your username.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label" style="color: #03a329;">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback" style="color: #03a329;">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe" style="color: #03a329;">Remember me</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <button  class="btn btn w-100" name="submit" style="background: #d63600; color: white;" type="submit">Login</button>
                    </div>
                  </form>

                </div>
              </div>

              <div class="credits" style="color: #d63600;">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                Designed by <a href="https://liquag.com/">Liquag</a>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
<script>

</script>
</body>

</html>
