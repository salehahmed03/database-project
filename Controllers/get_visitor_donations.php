<?php
// Include database connection file
include '../include/db_connection.php';

// Check if form is submitted and visitor_ticket is set
if (isset($_POST['visitor_ticket'])) {
    // Fetch visitor_ticket from the form submission
    $visitor_ticket = $_POST['visitor_ticket'];

    // Execute the GetVisitorDonations procedure with the provided visitor_ticket
    $procedure_query = "EXEC GetVisitorDonations @Visitor_Ticket = ?";
    $params = array($visitor_ticket);
    $result = sqlsrv_query($conn, $procedure_query, $params);

    // Check if procedure execution was successful
    if ($result) {
        // Check if the result set is empty
        if (sqlsrv_has_rows($result)) {
            // Display the retrieved donations
            echo "<h2>Visitor Donations</h2>";
            echo "<table class='table table-bordered'>";
            echo "<thead><th>Visitor Ticket</th><th>Amount</th></tr></thead>";
            echo "<tbody>";
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['Visitor_Ticket'] . "</td>";
                echo "<td>" . $row['Amount'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "No donations found for the provided visitor ticket.";
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
    // If form is submitted without visitor_ticket, display an error message
    echo "Error: Please provide a visitor ticket.";
}

// Close database connection
sqlsrv_close($conn);
?>