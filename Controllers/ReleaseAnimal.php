<?php
// Include database connection file
include '../include/db_connection.php';
include '../include/scripts.php';

// Check if form is submitted and AnimalId is set
if (isset($_POST['AnimalId'])) {
    // Fetch AnimalId from the form submission
    $AnimalId = $_POST['AnimalId'];

    // Execute the ReleaseAnimal procedure with the provided AnimalId
    $procedure_query = "EXEC ReleaseAnimal @Animal_Id = ?";
    $params = array($AnimalId);
    $result = sqlsrv_query($conn, $procedure_query, $params);

    // Check if procedure execution was successful
    if ($result) {
        header("Location:../Animal.php");
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
    // If form is submitted without AnimalId, display an error message
    echo "Error: Please provide an animal ID.";
}

// Close database connection
sqlsrv_close($conn);
?>