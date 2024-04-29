<?php
// Include database connection file
include '../include/scripts.php';
include '../include/db_connection.php';

// Check if form is submitted and Location is set
if (isset($_POST['Location'])) {
    // Fetch Location from the form submission
    $Location = $_POST['Location'];

    // Execute the GetTotalDonationsInLocation procedure with the provided Location
    $procedure_query = "EXEC GetTotalDonationsInLocation @Location = ?";
    $params = array($Location);
    $result = sqlsrv_query($conn, $procedure_query, $params);

    // Check if procedure execution was successful
    if ($result) {
        // Check if the result set is empty
        if (sqlsrv_has_rows($result)) {
            // Display the total donations
            echo "<h2>Total Donations in Location: " . $Location . "</h2>";
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                echo "Total Donations: " . $row['TotalDonations'];
            }
        } else {
            echo "No donations found for the provided location.";
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
    // If form is submitted without Location, display an error message
    echo "Error: Please provide a location.";
}

// Close database connection
sqlsrv_close($conn);
?>