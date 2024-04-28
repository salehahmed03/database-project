<?php
// Include database connection file
include '../include/db_connection.php';
include '../include/scripts.php';

// Check if form is submitted and input_id is set
if (isset($_POST['input_id'])) {
    // Fetch input_id from the form submission
    $input_id = $_POST['input_id'];

    // Execute the FireStaff procedure with the provided input_id
    $procedure_query = "EXEC FireStaff @input_id = ?";
    $params = array($input_id);
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
    // If form is submitted without input_id, display an error message
    echo "Error: Please provide an input ID.";
}

// Close database connection
sqlsrv_close($conn);
?>
