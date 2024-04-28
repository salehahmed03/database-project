<?php
// Include database connection file
include '../include/db_connection.php';
include '../include/scripts.php';

// Check if form is submitted and all required fields are filled
if (isset($_POST['Shop_Name'], $_POST['Location'], $_POST['Product_Category'], $_POST['SManager_Id'])) {
    // Fetch values from the form submission
    $Shop_Name = $_POST['Shop_Name'];
    $Location = $_POST['Location'];
    $Product_Category = $_POST['Product_Category'];
    $SManager_Id = $_POST['SManager_Id'];

    // Execute the AddShop procedure with the provided inputs
    $procedure_query = "EXEC AddShop @Shop_Name = ?, @Location = ?, @Product_Category = ?, @SManager_Id = ?";
    $params = array($Shop_Name, $Location, $Product_Category, $SManager_Id);
    $result = sqlsrv_query($conn, $procedure_query, $params);

    // Check if procedure execution was successful
    if ($result) {
        header("Location:../Shop.php");
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
