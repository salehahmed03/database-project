<?php
// Include database connection file
include '../include/db_connection.php';

// Check if form is submitted and ShopNo is set
if (isset($_POST['ShopNo'])) {
    // Fetch ShopNo from the form submission
    $shop_no = $_POST['ShopNo'];

    // Execute the RemoveShop procedure with the provided ShopNo
    $procedure_query = "EXEC RemoveShop @ShopNo = ?";
    $params = array($shop_no);
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
    // If form is submitted without ShopNo, display an error message
    echo "Error: Please provide a shop number.";
}

// Close database connection
sqlsrv_close($conn);
?>