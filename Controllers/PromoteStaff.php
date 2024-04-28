<?php
// Include database connection file
include '../include/db_connection.php';

// Check if form is submitted and staff_id is set
if (isset($_POST['staff_id'])) {
    // Fetch staff_id from the form submission
    $staff_id = $_POST['staff_id'];

    // Execute the PromoteStaff procedure with the provided staff_id
    $procedure_query = "EXEC PromoteStaff @staff_id = ?";
    $params = array($staff_id);
    $result = sqlsrv_query($conn, $procedure_query, $params);

    // Check if procedure execution was successful
    if ($result) {
        header("Location:../Staff.php");
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
    // If form is submitted without staff_id, display an error message
    echo "Error: Please provide a staff ID.";
}

// Close database connection
sqlsrv_close($conn);
?>
