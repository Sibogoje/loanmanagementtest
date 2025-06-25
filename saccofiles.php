<?php 
session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}else{
include('auth.php');

if (isset($_POST['submit'])) { // if save button on the form is clicked
    // name of the uploaded file
    $filename = $_FILES['myfile']['name'];
   
    $dates = date("Y-m-d H:i:s");
    $owner = $_POST['member'];
    $month = $_POST['month'];

   // $destination = 'uploads/'.$filename;

    $file_path = 'admin/statements/'.$owner;
  
// Checking whether file exists or not
if (!file_exists($file_path)) {
  
    // Create a new file or direcotry
    mkdir($file_path, 0777, true);
}
   


    // destination of the file on the server
    //$destination = 'uploads/'.$owner.'/'.$filename;
  
    // get the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $view = 1;

    // the physical file on a temporary uploads directory on the server
    $file = $_FILES['myfile']['tmp_name'];
    $size = $_FILES['myfile']['size'];

    if (!in_array($extension, ['zip', 'pdf', 'docx', 'png', 'jpg', 'jpeg', 'doc'])) {
        echo "You file extension must be .zip, .pdf or .docx";
    } elseif ($_FILES['myfile']['size'] > 5000000) { // file shouldn't be larger than 5Megabyte
        echo "File too large!";
    } else {
        // move the uploaded (temporary) file to the specified destination
        if (move_uploaded_file($file, $file_path.'/'.$filename)) {
            $sql = "INSERT INTO statements (`owner`, `name`, `dateupload`, `view`, `month`) VALUES ('$owner','$filename', '$dates', '$view', '$month')";
            if (mysqli_query($conn, $sql)) {
                header('Location: statements.php');                
            }
        } else {
            echo "Failed to upload file.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>SACCCO FILES</title>
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
      <h1>SACCO FILES</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="home.php">Home</a></li>
          <li class="breadcrumb-item active">Files</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

      <div class="col-lg-12">

<div class="card shadow-lg">
  <div class="card-body">
    <h5 class="card-title">Sacco Files</h5>
   

    

              <table id="memberstbl" class="display nowrap" style="width:100%">
        <thead>
            <tr>
           
                <th>File Name</th>
                <th>Purpose</th>
                <th>Date Upload</th>
               
                <th>Action</th>
              

                
            </tr>
        </thead>
        <tbody>
            <?php

            $sql = "SELECT * FROM saccofiles ORDER BY id DESC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    
                    echo "<td>".$row['name']."</td>";
                     echo "<td>".$row['purpose']."</td>";
                    echo "<td>".$row['dateupload']."</td>";
                    
                   
              
                    echo "<td> <button type='submit' title='View' data-id='' data-link='admin/saccofiles/".$row['name']."'  class='btn btn-success'><i class='bi bi-eye'></i></button>
                    
                    </td>";
                    echo "</tr>";
                }
            }
            ?>


        </tbody>
        <tfoot>
            <tr>
           
                <th>File Name</th>
                <th>Purpose</th>
                <th>Date Upload</th>
               
                <th>Action</th>
                
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
</body>

</html>
<?php
}
?>