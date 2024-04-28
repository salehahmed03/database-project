<?php
// Include database connection file
include '../include/db_connection.php';
include '../include/scripts.php';

// Check if form is submitted and all required fields are filled
if (isset($_POST['Exhibit_Name'], $_POST['Capacity'], $_POST['Theme'], $_POST['Location'], $_POST['Size'], $_POST['Security_Level'], $_POST['EManager_Id'])) {
    // Fetch values from the form submission
    $Exhibit_Name = $_POST['Exhibit_Name'];
    $Capacity = $_POST['Capacity'];
    $Theme = $_POST['Theme'];
    $Location = $_POST['Location'];
    $Size = $_POST['Size'];
    $Security_Level = $_POST['Security_Level'];
    $EManager_Id = $_POST['EManager_Id'];

    // Execute the CreateExhibit procedure with the provided inputs
    $procedure_query = "EXEC CreateExhibit @Exhibit_Name = ?, @Capacity = ?, @Theme = ?, @Location = ?, @Size = ?, @Security_Level = ?, @EManager_Id = ?";
    $params = array($Exhibit_Name, $Capacity, $Theme, $Location, $Size, $Security_Level, $EManager_Id);
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