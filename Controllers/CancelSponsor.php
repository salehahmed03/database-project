<?php
// Include database connection file
include '../include/db_connection.php';
include '../include/scripts.php';

// Check if form is submitted and SponsorId is set
if (isset($_POST['SponsorId'])) {
    // Fetch SponsorId from the form submission
    $SponsorId = $_POST['SponsorId'];

    // Execute the CancelSponsor procedure with the provided SponsorId
    $procedure_query = "EXEC CancelSponsor @SponsorId = ?";
    $params = array($SponsorId);
    $result = sqlsrv_query($conn, $procedure_query, $params);

    // Check if procedure execution was successful
    if ($result) {
        header("Location:../Sponsor.php");
        exit();
    } else {
        // Error handling
        $errors = sqlsrv_errors();
        if ($errors !== null) {
            foreach ($errors as $error) {
                echo "SQLSTATE: " . $error['SQLSTATE'] . "<br />";
                echo "Code: " . $error['code'] . "<br />";
                echo "Message: " . $error['message'] . "<br />";
            }
        } else {
            echo "Unknown error occurred.";
        }
    }
} else {
    // If form is submitted without SponsorId, display an error message
    echo "Error: Please provide a sponsor ID.";
}

// Close database connection
sqlsrv_close($conn);
?>