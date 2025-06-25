<?php 
session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}else{
include('auth.php');

if (isset($_POST['submit']) ) {
    $member = $_POST['member'];
   // $income = $_POST['income'];
    $net = $_POST['net'];
    $add_income_source = $_POST['add_income_source'];
    $add_income = $_POST['add_income'];
    $total_income = $_POST['total_income'];
    $rent = $_POST['rent'];
    $mortgage = $_POST['mortgage'];
    $utilities = $_POST['utilities'];
    $schoolFees = $_POST['schoolFees'];
    $transport = $_POST['transport'];
    $otherloan = $_POST['otherloan'];
    $otherexpenses = $_POST['otherexpenses'];
    $total_expenses = $_POST['total_expenses'];
    $delivery = $_POST['delivery'];
    $loandates = date('Y-m-d');
    $amount = $_POST['amount'];
    $type = $_POST['type'];
    $status = "unprocessed";

    $balance = $bal['balance'];
    $monthsleft = $bal['monthsleft'] - 1;
    
    $interest = 0.0;
    if ($type == "Long term" ){
        $interest = 1.5;
       // $Insurance = 1.; 
    }else if ($type == "Short term"){
        $interest = 10;
        //$Insurance = 1.5;
    }else if ($type == "Emergency"){
        $interest = 5.25;
        //$Insurance = 1.5;
    }else if ($type == "School loan"){
        $interest = 1.5;
        //$Insurance = 1.5;
    }else if ($type == "Helpline"){
        $interest = 22.75;
        //$Insurance = 1.5;
    }







    $statement = $conn->prepare("INSERT INTO `loans_application` (`member`, `reqdate`, `salarynet`, `add_income`,  `add_income_value`, `total_income`, `rent`, `mortgage`, `utilities`, `school_fees`, `transport`, `other_loan`,`other_expenses`, `total_expenses`, `delivery`, `amount`, `type`, `interestpercent`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $statement->bind_param("sssssssssssssssssss", $member, $loandates, $net, $add_income_source, $add_income, $total_income, $rent, $mortgage, $utilities, $schoolFees, $transport, $otherloan, $otherexpenses, $total_expenses, $delivery, $amount, $type, $interest, $status);

    $statement->execute();
    $statement->close();
    header('Location: processloans.php');

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>UMCENGE NEW APPLICATION</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="logo.png" rel="icon">
  <link href="logo.png" rel="apple-touch-icon">
  <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
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
      <h1>New Loan Application</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="home.php">Home</a></li>
          <li class="breadcrumb-item active">New Loans</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

      <div class="col-lg-12">

<div class="card shadow-lg">
  <div class="card-body">
    <h5 class="card-title">Income</h5>
   

    <form class="row g-3" method="POST" action="">
    <hr style="margin-bottom: 1px">
               <div class="col-md-4">
                  <div class="form-floating mb-3">
                    <select name="member" class="form-select" id="member" aria-label="Member" required>
                      <option selected>Select Member</option>
                        <?php
                        $select = $conn->prepare("SELECT * FROM `members`");
                        $select->execute();
                        $result = $select->get_result();
                        while ($row = $result->fetch_assoc()) {
                        ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?> <?php echo $row['surname']; ?></option>
                        <?php } ?>

                      
                    </select>
                    <label for="delivery">Member</label>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-floating mb-3">
                    <select name="type" class="form-select" id="type" aria-label="Member" required>
                      <option selected>Select Type</option>
                      <option value="Long term">Long term</option>
                      <option value="Short loan">Short loan</option>
                      <option value="School loan">School loan</option>
                      <option value="Emergency ">Emergency </option>
                      <option value="Helpline">Helpline</option>
                                          
                    </select>
                    <label for="delivery">Type of Loan</label>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="number" step="0.1" class="form-control" value="0.00" id="net" name="net" placeholder="Salary Net E:">
                    <label for="net"> Salary Net E:</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" class="form-control"  id="add_income_source" name="add_income_source" placeholder="Additional Income Source">
                    <label for="add_income_source"> Additional Income Source</label>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="number" step="0.1" value="0.00" class="form-control" id="add_income" name="add_income" placeholder="Additional Income (attach proof)">
                    <label for="add_income"> Additional Income (attach proof)</label>
                  </div>
                </div>

                <div class="col-md-4" >
                  <div class="form-floating grey">
                    <input type="text" step="0.1" value="0.00" class="form-control" id="total_income" name="total_income" placeholder=" Total Income" readonly>
                    <label for="name"> Total Income</label>
                  </div>
                </div>
                <div class="col-md-4" >
                  <div class="form-floating">
                    <input type="text" step="0.1" value="0.00" class="form-control" id="amount" name="amount" placeholder=" Loan Amount" >
                    <label for="name"> Loan Amount</label>
                  </div>
                </div>
                <hr style="margin-bottom: 1px;">
        <h5 class="card-title" style="margin-bottom: 1px;">Expenses</h5>
        <hr style="margin-bottom: 1px">
                <div class="col-md-4" >
                  <div class="form-floating">
                    <input type="number" step="0.1" value="0.00" class="form-control" id="rent" name="rent" placeholder="Rent">
                    <label for="rent"> Rent</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="number" step="0.1" value="0.00" class="form-control" id="mortgage" name="mortgage" placeholder="Mortgage">
                    <label for="mortgage"> Mortgage</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="number" step="0.1" value="0.00" class="form-control" id="Utilities" name="utilities" placeholder="Utilities">
                    <label for="utilities"> Utilities</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="number" step="0.1" value="0.00" class="form-control" id="schoolFees" name="schoolFees" placeholder="School Fees">
                    <label for="schoolFees"> School Fees</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="number" step="0.1" value="0.00" class="form-control" id="transport" name="transport" placeholder="Transport">
                    <label for="transport"> Transport</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="number" step="0.1" value="0.00" class="form-control" id="otherloan" name="otherloan" placeholder="Other Loan">
                    <label for="otherloan"> Other Loan</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="number" step="0.1" value="0.00" class="form-control" id="otherexpenses" name="otherexpenses" placeholder="Other Expenses">
                    <label for="otherexpenses"> Other Expenses</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" step="0.1" value="0.00" class="form-control" id="total_expenses" name="total_expenses" placeholder="Total Expenses">
                    <label for="name"> Total Expenses</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating mb-3">
                    <select name="delivery" class="form-select" name="delivery" id="delivery" aria-label="Prefered Loan Delivery Option">
                      <option selected>Choose One Option</option>
                      <option value="Mobile Money">Mobile Money</option>
                      <option value="Bank">Bank</option>
                      <option value="Cheque">Cheque</option>
                    </select>
                    <label for="delivery">Prefered Loan Delivery Option</label>
                  </div>
                </div>
                <hr>

                <div class="text-center col-xs-12 col-lg-12">
                  <button type="submit" name="submit" class="btn btn-primary col-12 col-lg-12" style="background-color: #d63600;">Submit</button>
                 
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
<script>
   // $('#net').value();
  //  $('#total_income').value();
  //  $('#total_expenses').value();

$income = function() {
        var net = parseFloat($('#net').val());
        var add_income = parseFloat($('#add_income').val());
        var total_income = parseFloat(add_income + net);
        if (net != total_income) {
            $('#total_income').val(parseFloat(total_income).toFixed(2));
        }else{
            $('#total_income').val(parseFloat(total_income).toFixed(2));
        }
};

$expenses = function() {    

    var rent = parseFloat($('#rent').val());
    var mortgage = parseFloat($('#mortgage').val());
    var Utilities = parseFloat($('#Utilities').val());
    var schoolFees = parseFloat($('#schoolFees').val());
    var transport = parseFloat($('#transport').val());
    var otherloan = parseFloat($('#otherloan').val());
    var otherexpenses = parseFloat($('#otherexpenses').val());
   
    var total_expenses = parseFloat(rent + mortgage + Utilities + schoolFees + transport + otherloan + otherexpenses);
    if (rent != total_expenses) {
        $('#total_expenses').val(parseFloat(total_expenses).toFixed(2));
    }else{
        $('#total_expenses').val(parseFloat(total_expenses).toFixed(2));
    }

   
}

$('#rent').on('input', function() {
    $expenses();
});
$('#mortgage').on('input', function() {
    $expenses();
});
$('#Utilities').on('input', function() {
    $expenses();
});
$('#schoolFees').on('input', function() {
    $expenses();
});
$('#transport').on('input', function() {
    $expenses();
});
$('#otherloan').on('input', function() {
    $expenses();
});
$('#otherexpenses').on('input', function() {
    $expenses();
});




    $('#net').on('input', function() {
        $income();
    });
    $('#add_income').on('input', function() {
        $income();
    });

</script>
</body>

</html>
<?php
}
?>