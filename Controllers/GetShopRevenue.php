<?php
// Include database connection file
include '../include/scripts.php';
include '../include/db_connection.php';

// Check if form is submitted and ShopNo is set
if (isset($_POST['ShopNo'])) {
    // Fetch ShopNo from the form submission
    $ShopNo = $_POST['ShopNo'];

    // Execute the GetShopRevenue procedure with the provided ShopNo
    $procedure_query = "EXEC GetShopRevenue @ShopNo = ?";
    $params = array($ShopNo);
    $result = sqlsrv_query($conn, $procedure_query, $params);

    // Check if procedure execution was successful
    if ($result) {
        // Check if the result set is empty
        if (sqlsrv_has_rows($result)) {
            // Display the total revenue
            echo "<h2>Total Revenue for Shop Number: " . $ShopNo . "</h2>";
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                echo "Total Revenue: " . $row['TotalRevenue'];
            }
        } else {
            echo "No transactions found for the provided shop number.";
        }
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