<?php
// Include database connection file
include '../include/scripts.php';
include '../include/db_connection.php';

// Check if form is submitted and exhibit_no is set
if (isset($_POST['exhibit_no'])) {
    // Fetch exhibit_no from the form submission
    $exhibit_no = $_POST['exhibit_no'];

    // Execute the GetExhibitAnimals procedure with the provided exhibit_no
    $procedure_query = "EXEC GetExhibitAnimals @Exhibit_No = ?";
    $params = array($exhibit_no);
    $result = sqlsrv_query($conn, $procedure_query, $params);

    // Check if procedure execution was successful

if ($result) {
    echo "<table class='table table-bordered'>";
    echo "<thead><tr><th>Animal ID</th><th>Name</th><th>Gender</th><th>Habitat</th><th>General Name</th><th>Genus</th><th>Species</th><th>Status</th><th>Diet Type</th><th>Date of Birth</th><th>Family Tree</th><th>Exhibit Number</th></tr></thead>";
    echo "<tbody>";
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['Animal_Id'] . "</td>";
        echo "<td>" . $row['Animal_Name'] . "</td>";
        echo "<td>" . $row['Gender'] . "</td>";
        echo "<td>" . $row['Habitat'] . "</td>";
        echo "<td>" . $row['General_Name'] . "</td>";
        echo "<td>" . $row['Genus'] . "</td>";
        echo "<td>" . $row['Species'] . "</td>";
        echo "<td>" . $row['Status'] . "</td>";
        echo "<td>" . $row['Diet_Type'] . "</td>";
        echo "<td>" . $row['Date_of_Birth']->format('Y-m-d') . "</td>";
        echo "<td>" . $row['Family_Tree'] . "</td>";
        echo "<td>" . $row['Exhibit_no'] . "</td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
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
    // If form is submitted without exhibit_no, display an error message
    echo "Error: Please provide an exhibit number.";
}

// Close database connection
sqlsrv_close($conn);
?>