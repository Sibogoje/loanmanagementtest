<?php
// Assuming you have a database connection established
include('auth.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $userId = $_GET['id'];
    
    // Fetch user details from the database
    $getUserQuery = "SELECT username, role FROM useraccounts WHERE id = $userId";
    $userResult = mysqli_query($conn, $getUserQuery);
    
    if ($userResult) {
        $userDetails = mysqli_fetch_assoc($userResult);
        echo json_encode($userDetails);
    } else {
        echo json_encode(array("error" => "Unable to fetch user details."));
    }
} else {
    echo json_encode(array("error" => "Invalid request."));
}
?>
