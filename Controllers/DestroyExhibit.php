<?php
// Include database connection file
include '../include/db_connection.php';
include '../include/scripts.php';

// Check if form is submitted and all required fields are filled
if (isset($_POST['old_exhibit_id'], $_POST['new_exhibit_id'])) {
    // Fetch values from the form submission
    $old_exhibit_id = $_POST['old_exhibit_id'];
    $new_exhibit_id = $_POST['new_exhibit_id'];

    // Execute the DestroyExhibit procedure with the provided inputs
    $procedure_query = "EXEC DestroyExhibit @old_exhibit_id = ?, @new_exhibit_id = ?";
    $params = array($old_exhibit_id, $new_exhibit_id);
    $result = sqlsrv_query($conn, $procedure_query, $params);

    // Check if procedure execution was successful
    if ($result) {
        header("Location:../Exhibit.php");
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
    // If form is submitted without all required fields, display an error message
    echo "Error: Please fill out all required fields.";
}

// Close database connection
sqlsrv_close($conn);
?>