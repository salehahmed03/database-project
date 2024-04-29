<?php
// Include database connection file
include '../include/db_connection.php';
include '../include/scripts.php';

// Check if form is submitted and staff_id is set
if (isset($_POST['staff_id'])) {
    // Fetch staff_id from the form submission
    $staff_id = $_POST['staff_id'];

    // Call the GetStaffRole function with the provided staff_id
    $query = "SELECT dbo.GetStaffRole(?) AS role";
    $params = array($staff_id);
    $result = sqlsrv_query($conn, $query, $params);

    // Check if query execution was successful
    
    if ($result) {
        // Fetch each row from the result set
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            // Print the row in a Bootstrap alert message
            echo '<div class="alert alert-success" role="alert">';
            echo implode("",$row);
            echo '</div>';
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
    // If form is submitted without staff_id, display an error message
    echo "Error: Please provide a staff ID.";
}

// Close database connection
sqlsrv_close($conn);
?>
