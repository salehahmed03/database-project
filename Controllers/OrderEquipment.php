<?php
// Include database connection file
include '../include/db_connection.php';
include '../include/scripts.php';

// Check if form is submitted and all required fields are filled
if (isset($_POST['Company_Name'], $_POST['Email'], $_POST['Phone_No'], $_POST['Clinic_No'], $_POST['Quantity'])) {
    // Fetch values from the form submission
    $Company_Name = $_POST['Company_Name'];
    $Email = $_POST['Email'];
    $Phone_No = $_POST['Phone_No'];
    $Clinic_No = $_POST['Clinic_No'];
    $Quantity = $_POST['Quantity'];

    // Execute the OrderEquipment procedure with the provided inputs
    $procedure_query = "EXEC OrderEquipment @Company_Name = ?, @Email = ?, @Phone_No = ?, @Clinic_No = ?, @Quantity = ?";
    $params = array($Company_Name, $Email, $Phone_No, $Clinic_No, $Quantity);
    $result = sqlsrv_query($conn, $procedure_query, $params);

    // Check if procedure execution was successful
    if ($result) {
        header("Location:../Supplier.php");
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