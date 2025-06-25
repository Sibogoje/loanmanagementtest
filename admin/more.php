<?php 
session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}else{
include('auth.php');
$mid = $_GET['mid'];
if (isset($_POST['submit']) ) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $surname = $_POST['surname'];
    $phone = $_POST['phone'];
    $postal = $_POST['postal'];
    $national_id = $_POST['national_id'];
    $pass = $_POST['password'];
    $gender = $_POST['gender'];
    $home = $_POST['home'];
    $current = $_POST['current'];
    $payroll = $_POST['payroll'];
    $bank = $_POST['bank'];
   // $password = $name."123";

    $insert = $conn->prepare(" UPDATE  `members`  SET `name`=?, `surname`=?, `gender`=?, `email`=?, `phone`=?, `postal`=?, `national_id`=?, `password`=?, `home_address`=?, `current_address`=?, `payroll`=?, `bank`=? WHERE id = ?");
    $insert->bind_param("sssssssssssss",  $name, $surname,  $gender, $email, $phone, $postal, $national_id, $pass, $home, $current, $payroll, $bank,  $mid);
    $insert->execute();
    $insert->close();
    header('Location: allmembers.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>UMCENGE Member</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="logo.png" rel="icon">
  <link href="logo.png" rel="apple-touch-icon">

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

<body>

<?php include 'header.php'; ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Member Information</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="home.php">Home</a></li>
          <li class="breadcrumb-item active">Members</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

      <div class="col-lg-12">

<div class="card shadow-lg">
  <div class="card-body">
    <h5 class="card-title">Member Information</h5>

    <form class="row g-3" method="POST" action="">

    <?php
    $select = $conn->prepare("SELECT * FROM `members` WHERE `id` = ?");
    $select->bind_param("s", $mid);
    $select->execute();
    $result = $select->get_result();
    $row = $result->fetch_assoc();

    ?>
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="name" value="<?php echo $row['name']; ?>" name="name" placeholder="Name">
                    <label for="name"> Name</label>
                  </div>
                </div>
                
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="name" value="<?php echo $row['surname']; ?>"   name="surname" placeholder="Surname">
                    <label for="name"> Surname</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="payroll" value="<?php echo $row['payroll']; ?>"   name="payroll" placeholder="Surname">
                    <label for="name"> Payroll</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating mb-3">
                    <select name="gender" class="form-select" id="gender" aria-label="Gender">
                      <option value="<?php echo $row['gender']; ?>" selected><?php echo $row['gender']; ?></option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                    <label for="gender">Gender</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="email" class="form-control" value="<?php echo $row['email']; ?>"  name="email" id="email" placeholder=" Email">
                    <label for="email"> Email</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" class="form-control" value="<?php echo $row['phone']; ?>"  name="phone" id="email" placeholder=" Phone">
                    <label for="phone"> Phone</label>
                  </div>
                </div>
                 <div class="col-md-4">
                  <div class="form-floating">
                    <input type="number" class="form-control" value="<?php echo $row['bank']; ?>"  name="bank" id="bank" placeholder=" Phone">
                    <label for="phone"> Bank Account</label>
                  </div>
                </div>
            
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" name="national_id" value="<?php echo $row['national_id']; ?>"  class="form-control" id="national_id" placeholder="National ID">
                    <label for="national_id">National ID</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" name="postal" value="<?php echo $row['postal']; ?>"  class="form-control" id="postal" placeholder="National ID">
                    <label for="national_id">Postal Address</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating">
                    <textarea type="text" name="home"  class="form-control" id="home" placeholder="Home Address"><?php echo $row['home_address']; ?></textarea>
                    <label for="national_id">Home Address</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating">
                    <textarea type="text" name="current"  class="form-control" id="current" placeholder="Current Address"><?php echo $row['current_address']; ?></textarea>
                    <label for="national_id">Current Address</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" name="password" value="<?php echo $row['password']; ?>"  class="form-control" id="password" placeholder="Password">
                    <label for="password">Password</label>
                  </div>
                </div>

                <div class="text-center col-12">
                  <button type="submit" name="submit" class="btn btn-primary col-12" style="background-color: #d63600;">Update Information</button>
                 
                </div>
              </form><!-- End floating Labels Form -->

    
  </div>
</div>

</div>


       
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Umcenge</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://liquag.com/">Liquag</a>
    </div>
  </footer><!-- End Footer -->

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

</body>

</html>
<?php
}
?>