<?php 
session_start();
if (!isset($_SESSION)   && !isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}else{
include('auth.php');
$id  = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>UMCENGE HOME</title>
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
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-4">
              <div class="card info-card sales-card">

               

                <div class="card-body">
                  <h5 class="card-title">FULL NAME</span></h5>
<?php
    $sql = "SELECT * FROM `members` where id = '$id'";
    $statement = $conn->prepare($sql);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $surname = $row['surname'];



?>
                  <div class="d-flex align-items-center warning">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo  $name." ".$surname; ?></h6>
                     

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-4">
              <div class="card info-card revenue-card">

                <div class="card-body">
                  <h5 class="card-title">All Loans <span>| Today</span></h5>

<?php
    $sql = "SELECT COUNT(ID) FROM `loans_application` where member = '$id'";
    $statement = $conn->prepare($sql);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result->fetch_assoc();
    $total_loans = $row['COUNT(ID)'];



?>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $total_loans ; ?></h6>
                      <span class="text-success small pt-1 fw-bold">All Loans ever requested</span> <span class="text-muted small pt-2 ps-1"></span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->


            <div class="col-xxl-4 col-md-4">
              <div class="card info-card revenue-card">

                <div class="card-body">
                  <h5 class="card-title">All Running <span>| Today</span></h5>

<?php
    $sql = "SELECT COUNT(ID) FROM `loans_application` where status = 'Processed' and member = '$id' ";
    $statement = $conn->prepare($sql);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result->fetch_assoc();
    //$total_loans = $row['COUNT(ID)'];
    if($row['COUNT(ID)'] == 0){
        $total_loans = 0;
    }else{
        $total_loans = $row['COUNT(ID)'];
    }
    



?>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-check2-all"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $total_loans ; ?></h6>
                      <span class="text-success small pt-1 fw-bold">Active Loans</span> <span class="text-muted small pt-2 ps-1"></span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->



            <div class="col-xxl-4 col-md-4">
              <div class="card info-card pendind-card">

                <div class="card-body">
                  <h5 class="card-title">Unprocessed <span>| Today</span></h5>

<?php
    $sql = "SELECT COUNT(ID) FROM `loans_application` where status = 'unprocessed' and member = '$id'";
    $statement = $conn->prepare($sql);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result->fetch_assoc();
    $total_loans = $row['COUNT(ID)'];



?>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-clock-history warning"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $total_loans ; ?></h6>
                      <span class="text-warning small pt-1 fw-bold">Still Under Review</span> <span class="text-muted small pt-2 ps-1"></span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->




            <div class="col-xxl-4 col-md-4">
              <div class="card info-card completed-card">

                <div class="card-body">
                  <h5 class="card-title">Completed <span>| Today</span></h5>

<?php
    $sql = "SELECT COUNT(ID) FROM `loans_application` WHERE status = 'Stop' and member = '$id'";
    $statement = $conn->prepare($sql);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result->fetch_assoc();
    $total_loans = $row['COUNT(ID)'];



?>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $total_loans ; ?></h6>
                      <span class="text-success small pt-1 fw-bold">Successfully Paid/Stopped</span> <span class="text-muted small pt-2 ps-1"></span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->


            <div class="col-xxl-4 col-md-4">
              <div class="card info-card reject-card">

                <div class="card-body">
                  <h5 class="card-title">Declined <span>| Today</span></h5>

<?php
    $sql = "SELECT COUNT(ID) FROM `loans_application` WHERE status = 'Decline' and member = '$id'";
    $statement = $conn->prepare($sql);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result->fetch_assoc();
    $total_loans = $row['COUNT(ID)'];



?>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-record-circle-fill"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $total_loans ; ?></h6>
                      <span class="text-danger small pt-1 fw-bold">Could not be processed</span> <span class="text-muted small pt-2 ps-1"></span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->


          </div>
        </div><!-- End Left side columns -->



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