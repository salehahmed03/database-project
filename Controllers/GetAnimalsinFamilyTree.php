<?php
// Include database connection file
include '../include/scripts.php';
include '../include/db_connection.php';

// Execute the GetAnimalsinFamilyTree procedure
$procedure_query = "EXEC GetAnimalsinFamilyTree";
$result = sqlsrv_query($conn, $procedure_query);

// Check if procedure execution was successful
if ($result) {
    // Check if the result set is empty
    if (sqlsrv_has_rows($result)) {
        // Display the retrieved animals
        echo "<h2>Animals in Family Tree</h2>";
        echo "<table class='table table-bordered'>";
        echo "<thead><tr><th>Family Tree</th><th>Animal Name</th><th>General Name</th><th>Genus</th><th>Species</th></tr></thead>";
        echo "<tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['Family_Tree'] . "</td>";
            echo "<td>" . $row['Animal_Name'] . "</td>";
            echo "<td>" . $row['General_Name'] . "</td>";
            echo "<td>" . $row['Genus'] . "</td>";
            echo "<td>" . $row['Species'] . "</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "No animals found.";
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

// Close database connection
sqlsrv_close($conn);
?>