<?php 
session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}else{
include('auth.php');
$MID = $_GET['mid'];
$LID = $_GET['lid'];


if (isset($_POST['submit']) ) {
 

    $initiationfee = $_POST['initiation'];
    $interestpercent = $_POST['interest'];
    $interest = $_POST['total_installment'];
    $insurance = $_POST['afterinsurance'];
    $frequency = $_POST['frequency'];
    $monthlypay = $_POST['monthpay'];
    $total_credit = $_POST['total_credit'];
    $first_installment = $_POST['initial_installment'];
    $delivery = $_POST['delivery'];
    $principal = $_POST['principaldebt'];
    $installments = $_POST['installments'];
    $status = $_POST['status'];
    $reason = $_POST['reason'];
    $decldate = "";

    if($reason == 'Decline'){
        $decldate = date('Y-m-d');
    }

    $update = "UPDATE `loans_application` SET `amount`=?,  `initiationfee`=?, `interestpercent`=?, `interest`=?, `insurance`=?, `frequency`=?, `installment`=?, `monthlypay`=?, `total_credit`=?, `first_installment`=?, `delivery`=?, `status`=?, `balance`=?, `monthsleft`=?, `reason`=?, `closedate`=? WHERE `id`=?";
    $stmt = $conn->prepare($update);
    $stmt->bind_param("sssssssssssssssss", $principal, $initiationfee, $interestpercent, $interest, $insurance, $frequency, $installments, $monthlypay, $total_credit, $first_installment, $delivery, $status, $total_credit, $installments, $reason, $decldate, $LID);
    $stmt->execute();
    $stmt->close();
 
    header('Location: processloans.php');

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>UMCENGE PROCESS</title>
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

  <style>
    .disabled {
      pointer-events: none;
      cursor: default;
      background-color: #b8b8b8;
      font-weight: bold;
    }
    label{
      font-weight: bold;
    }
  </style>

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
      <h1>Process Loan</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="home.php">Home</a></li>
          <li class="breadcrumb-item active">Loans</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

      <div class="col-lg-12">

<div class="card shadow-lg">
  <div class="card-body">


    <form class="row g-3" method="POST" action="">

    <h5 class="card-title">Figures</h5> 
    <?php
    $sql = "SELECT * FROM `members` WHERE `id` = ?";
    $statement = $conn->prepare($sql);
    $statement->bind_param("s", $MID);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $surname = $row['surname'];
    $statement->close();

    $sql = "SELECT * FROM `loans_application` WHERE `id` = ? ";
    $statement = $conn->prepare($sql);
    $statement->bind_param("s", $LID);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result->fetch_assoc();
    $total_expenses = $row['total_expenses'];
    $total_income = $row['total_income'];
    $requested = $row['amount'];
    $delivery = $row['delivery'];
    $afterinsurancez = $row['insurance'];
    $interestpercent = $row['interestpercent'];
    $status = $row['status'];
    $initiationfee = $row['initiationfee'];
    $type  = $row['type'];
    $frequency = $row['frequency'];
    $installmentz = $row['installment'];
    $monthlypayz = $row['monthlypay'];
    $tinterest = $row['interest'];
    $total_creditz = $row['total_credit'];
    $first_installmentz = $row['first_installment'];




    $statement->close();



    




    ?>
           


                <div class="col-md-3 " style="color: blue;" >
                  <div class="form-floating ">
                    <input type="number" step="0.1" value="<?php echo $total_income ?>" class="form-control disabled" id="total_income" name="total_income" placeholder="" readonly>
                    <label for="rent"> Total Income: E</label>
                  </div>
                </div>
                <div class="col-md-3 " style="color: red;">
                  <div class="form-floating">
                    <input type="number" step="0.1" value="<?php echo $total_expenses ?>" class="form-control disabled" id="total_expenses" name="total_expenses" placeholder="" readonly>
                    <label for="rent"> Total Expenses: E </label>
                  </div>
                </div>
                <div class="col-md-3 " style="color: green;">
                  <div class="form-floating">
                    <input type="number" step="0.1" value="<?php echo $total_income - $total_expenses ?>" class="form-control disabled" id="total_expenses" name="total_expenses" placeholder="" readonly>
                    <label for="rent"> Total Disposable: E </label>
                  </div>
                </div>
                
                <div class="col-md-3">
                  <div class="form-floating">
                    <input type="text" step="0.1" value="<?php echo  $type; ?>" class="form-control disabled" id="afterinterest" name="afterinterest" placeholder="Interest %" readonly>
                    <label for="mortgage"> Type</label>
                  </div>
                </div>

 
            

                <h5 class="card-title">Loan Details</h5>    
             

                <div class="col-md-4">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control disabled" name="status" value="<?php echo $requested; ?>" readonly>
                    <label for="delivery">Principal Debt</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control disabled" name="status" value="<?php echo $initiationfee; ?>" readonly>
                    <label for="delivery">Initiation Fee</label>
                  </div>
                </div>
                
                <div class="col-md-4">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control disabled" name="status" value="<?php echo $interestpercent; ?>" readonly>
                    <label for="delivery">Interest %</label>
                  </div>
                </div>
               
               
                <div class="col-md-4">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control disabled" name="status" value="<?php echo $afterinsurancez; ?>" readonly>
                    <label for="delivery">Insurance</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control disabled" name="status" value="<?php echo $frequency; ?>" readonly>
                    <label for="delivery">Update Status [Not Reversable]</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control disabled" name="status" value="<?php echo $installmentz; ?>" readonly>
                    <label for="delivery">Installements</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control disabled" name="status" value="<?php echo $monthlypayz; ?>" readonly>
                    <label for="delivery">Months</label>
                  </div>
                </div>
              
                <div class="col-md-4">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control disabled" name="status" value="<?php echo $tinterest; ?>" readonly>
                    <label for="delivery">Total Interest</label>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control disabled" name="status" value="<?php echo $total_creditz; ?>" readonly>
                    <label for="delivery">Total Credit</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control disabled" name="status" value="<?php echo $first_installmentz; ?>" readonly>
                    <label for="delivery">First Installment</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control disabled" name="status" value="<?php echo $delivery; ?>" readonly>
                    <label for="delivery">Delivery Mode</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control disabled" name="status" value="<?php echo $status; ?>" readonly>
                    <label for="delivery">Status</label>
                  </div>
                </div>
                <div class="col-md-12" id="reasondiv">
                  <div class="form-floating">
                    <input type="text"   class="form-control" id="reason" name="reason" placeholder="" readonly>
                    <label for="name"> Reason for Declining</label>
                  </div>
                </div>
                <hr>

              
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

$interest = function() {
  var initiation = parseFloat($('#initiation').val());
        var principal = parseFloat($('#principaldebt').val());
        var sum = principal + initiation;
        var interest = parseFloat($('#interest').val());
        var afterinterest = parseFloat((sum * interest) / 100);
        if (interest != 0) {
            $('#afterinterest').val(parseFloat(afterinterest).toFixed(2));
        }else{
            $('#afterinterest').val(parseFloat(afterinterest).toFixed(2));
        }
};

$insurance = function() {
  
        var initiation = parseFloat($('#initiation').val());
        var principal = parseFloat($('#principaldebt').val());
        var sum1 = principal + initiation;
        var insurance = parseFloat($('#insurance').val());
        var afterinsurance = parseFloat((  sum1 * insurance) / 100);
        if (insurance != 0) {
         //   $('#afterinsurance').val(parseFloat(afterinsurance).toFixed(2));
        }else{
          //  $('#afterinsurance').val(parseFloat(afterinsurance).toFixed(2));
        }
};

$installments = function() {    
  var initiation = parseFloat($('#initiation').val());
        var principal = parseFloat($('#principaldebt').val());
        var afterinsurance = parseFloat($('#afterinsurance').val());
       // var afterinterest = parseFloat($('#afterinterest').val());
        var interest = parseFloat($('#interest').val());

        var sum2 = principal + initiation + afterinsurance;
        installments = parseFloat($('#installments').val());
        var months = 0;
        var total_interest = 0;
        while (months < installments) {
            
            var install = parseFloat((sum2 * interest) / 100);
            sum2 = sum2 + install;
            var total_interest = total_interest + install;
            var monthpay = parseFloat(sum2 / installments);
           
            
          months++;
        }
        if (installments != 0) {
            $('#total_installment').val(parseFloat(total_interest).toFixed(2));
            $('#total_credit').val(parseFloat(sum2).toFixed(2));
            $('#monthpay').val(parseFloat( monthpay).toFixed(2));
        }
          


   
};

$('#interest').on('input', function() {
    $interest();
});
$('#insurance').on('input', function() {
    $insurance();
});
$('#installments').on('input', function() {
    $installments();
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

<script type="text/javascript">
  $(document).ready(function() {
    $('#reasondiv').hide();
   
} );
</script>
<script>
function myFunction() {
  if($('#status').val() == 'Decline'){
    $('#reasondiv').show();
   
  }else{    
    $('#reasondiv').hide();
   
  }
  
}
</script>
</body>

</html>
<?php
}
?>