
<?php
// Include database connection file
include '../include/db_connection.php';
include '../include/scripts.php';


// Check if form is submitted and all required fields are filled
if (isset($_POST['Animal_ID'], $_POST['Exhibit_no'])) {
    // Fetch values from the form submission
    $Animal_ID = $_POST['Animal_ID'];
    $Exhibit_no = $_POST['Exhibit_no'];

    // Execute the TransferAnimal procedure with the provided inputs
    $procedure_query = "EXEC TransferAnimal @Animal_ID = ?, @Exhibit_no = ?";
    $params = array($Animal_ID, $Exhibit_no);
    $result = sqlsrv_query($conn, $procedure_query, $params);

    // Check if procedure execution was successful
    if ($result) {
        ?>
        <div class="alert alert-success" role="alert">
            Animal Transfered successfully!Return to table and refresh to see changes.
        </div>
        <?php
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
