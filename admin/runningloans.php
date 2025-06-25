<?php 
session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}else{
include('auth.php');

if (isset($_POST['submit']) ) {
 

    $loan = $_POST['loanid'];
    $paydate = $_POST['paydate'];
    $comment = $_POST['comments'];
    $amount = $_POST['amount'];
    $filename = $_FILES['proof']['name'];  
    
    $joindate  = date('Y-m-d', strtotime($paydate));

    $balanceqry = $conn->prepare("SELECT balance, member, monthsleft FROM loans_application WHERE id = ?");
    $balanceqry->bind_param('i', $loan);
    $balanceqry->execute();
    $balresult = $balanceqry->get_result();
    $bal = $balresult->fetch_assoc();
    $balance = $bal['balance'];
    $monthsleft = $bal['monthsleft'] - 1;

    $owner = $bal['member'];

    $newbalance = $balance - $amount;

    $update = "UPDATE `loans_application` SET `balance`=?, `monthsleft`=?,  `lastpaid`=? WHERE `id`=?";
    $stmt = $conn->prepare($update);
    $stmt->bind_param("ssss", $newbalance, $monthsleft, $paydate, $loan);
    if($stmt->execute()){

        if($filename == ''){

            $insert = "INSERT INTO `runningloans`(`loanid`, `paydate`, `comment`) VALUES (?,?,?)";
            $stmt = $conn->prepare($insert);
            $stmt->bind_param("sss", $loan, $paydate, $comment);
            if($stmt->execute()){
                echo "<script>alert('Repayment Successful Exit 0!'); window.location.href='runningloans.php';</script>";
            }else{
                echo "<script>alert('Failed to update Repayment Exit 0!'); window.location.href='runningloans.php';</script>";
            }

        }else{

            $file_path = 'proofs/'.$owner.'/'.$loan;
                if (!file_exists($file_path)) {
                    mkdir($file_path, 0777, true);
                }
                $extension = pathinfo($filename, PATHINFO_EXTENSION);
                $view = 1;
            
                // the physical file on a temporary uploads directory on the server
                $file = $_FILES['proof']['tmp_name'];
                $size = $_FILES['proof']['size'];
                
                if (!in_array($extension, ['zip', 'pdf', 'docx', 'jpg', 'png'])) {
                    echo "You file extension must be .zip, .pdf or .docx";
                } elseif ($_FILES['proof']['size'] > 1000000) { // file shouldn't be larger than 1Megabyte
                    echo "File too large!";
                } else {
                    // move the uploaded (temporary) file to the specified destination
                    if (move_uploaded_file($file, $file_path.'/'.$filename)) {
                        $sql = "INSERT INTO `runningloans`(`loanid`, `paydate`, `comment`, `proof`) VALUES (?,?,?,?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("ssss", $loan, $paydate, $comment, $filename);
                        if($stmt->execute()){
                            echo "<script>alert('RePayment Successful Exit 1!'); window.location.href='runningloans.php';</script>";
                        }else{
                            echo "<script>alert('Failed to update Repayment Exit 1!'); window.location.href='runningloans.php';</script>";
                        }
                    } else {
                        echo "<script>alert('Failed to Upload Proof of RePayment!'); window.location.href='runningloans.php';</script>";
                    }
                }

        }

        
        
       
    }else{
        echo "<script>alert('RePayment Failed!'); window.location.href='runningloans.php';</script>";
    }
   
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Running Loans</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="logo.png" rel="icon">
  <link href="logo.png" rel="apple-touch-icon">

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/date-1.1.2/fh-3.2.4/r-2.3.0/rg-1.2.0/sc-2.0.7/sb-1.3.4/sp-2.0.2/sl-1.4.0/datatables.min.css"/>

 <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/date-1.1.2/fh-3.2.4/r-2.3.0/rg-1.2.0/sc-2.0.7/sb-1.3.4/sp-2.0.2/sl-1.4.0/datatables.min.js"></script>
 <script type="text/javascript" src=" https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>

  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/date-1.1.2/fh-3.2.4/r-2.3.0/rg-1.2.0/sc-2.0.7/sb-1.3.4/sp-2.0.2/sl-1.4.0/datatables.min.css"/>

 <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/date-1.1.2/fh-3.2.4/r-2.3.0/rg-1.2.0/sc-2.0.7/sb-1.3.4/sp-2.0.2/sl-1.4.0/datatables.min.js"></script>
 <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
 <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
 <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
 






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

  <link href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">
  <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" rel="stylesheet">

 
  

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
      <h1>Running Loans </h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="home.php">Home</a></li>
          <li class="breadcrumb-item active">Loans </li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard" >
      <div class="row">

      <div class="col-lg-12">

<div class="card shadow-lg" >
  <div class="card-body">
  <h4 class="card-title">Update Loan</h4>
  <form class="row g-3" method="POST" action="" enctype="multipart/form-data">
   
               <div class="col-md-4">
                  <div class="form-floating mb-3">
                    <select name="loanid" class="form-select" id="loanid" aria-label="loanid" required>
                      <option selected>Select Loan</option>
                        <?php
                        $select = $conn->prepare("SELECT * FROM `loans_application` WHERE `status` = 'Processed' ");
                        $select->execute();
                        $result = $select->get_result();
                        while ($row = $result->fetch_assoc()) {

                            $members = $row['member'];

                            $statementz = $conn->prepare("SELECT * FROM members WHERE id = ?");
                            $statementz->bind_param('i',  $members);
                            $statementz->execute();
                            $resultz = $statementz->get_result();
                            $memberz = $resultz->fetch_assoc();
                            $namez = $memberz['name'];
                            $surnamez = $memberz['surname'];
                            $fullnamez = $namez.' '.$surnamez;
                            



                        ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $fullnamez." LoanId - ".$row['id']; ?></option>
                        <?php } ?>

                      
                    </select>
                    <label for="delivery">Member</label>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="date"  class="form-control"  id="paydate" name="paydate" placeholder="Pay Date " required>
                    <label for="net"> Payment Date</label>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="number" step="any" class="form-control" value="0.00" id="amount" name="amount" placeholder="Salary Net E:" required>
                    <label for="net"> Amount:</label>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-floating">
                    <input type="text"  class="form-control" value="" id="comments" name="comments" placeholder="">
                    <label for="net"> Comments:</label>
                  </div>
                </div>

                <div class="col-md-4">
                <label for="delivery">Attach proof</label>
              
                  <div class="col-sm-12">
                    <input type="file" class="form-control" name='proof'  id="formFile">
                  </div>
                </div>
                <div class="text-center col-xs-12 col-lg-12">
                  <button type="submit" name="submit" class="btn btn-primary col-12 col-lg-12" style="background-color: green;">Update Loan</button>
                 
                </div>


                        </form>
                        </div>
                        </div>


<div class="card shadow-lg" style="padding-top: 20px;">
  <div class="card-body">

    <table id="memberstbl" class="display nowrap" style="width:100%">
        <thead>
            <tr>
                <th>Member Name</th>
                <th>Loan ID</th>
                <th>T. Credit</th>
                <th>Months left</th>
                <th>Monthly Instal.</th>
                <th>Last Paid Date</th>
                <th>Balance</th>
               
              

                
            </tr>
        </thead>
        <tbody>
            <?php

            $sql = "SELECT * FROM `loans_application` WHERE `status` = 'Processed' ";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";


                $name = "SELECT `name`, `surname` FROM `members` WHERE `id` = '".$row['member']."' ";
                $nameresult = $conn->query($name);
                if ($nameresult->num_rows > 0) {
                    while($namerow = $nameresult->fetch_assoc()) {
                        $fullname = $namerow['name'].' '.$namerow['surname'];


                   
                    echo "<td>".$fullname."</td>";
                    echo "<td>".$row['id']."</td>";
                    echo "<td>".$row['total_credit']."</td>";
                    echo "<td>".$row['monthsleft']."</td>";
                    echo "<td>".$row['monthlypay']."</td>";
                    echo "<td>".$row['lastpaid']."</td>";
                    echo "<td>".$row['balance']."</td>";

                    }}
             
                   
                }
            }
            ?>


        </tbody>
        <tfoot>
            <tr>
            <th>Member Name</th>
                <th>Loan ID</th>
                <th>T. Credit</th>
                <th>Months left</th>
                <th>Monthly Instal.</th>
                <th>Last Paid Date</th>
                <th>Balance</th>
                
              
            </tr>
        </tfoot>
    </table>

  
    
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
<script>
    $(document).ready(function() {
        var table = $('#memberstbl').DataTable( {
            lengthChange: false,
            dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        responsive: true
    } );
} );
</script>
<script>
    $(document).ready(function() {
        $('#memberstbl').on('click', 'button', function() {
            var id = $(this).data('mid');
            var link = $(this).data('link');
            window.location.href = link;
        });
    });
</script>
</html>
<?php
}
?>