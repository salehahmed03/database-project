<?php
// Include database connection file
include '../include/db_connection.php';
include '../include/scripts.php';

// Check if form is submitted and all required fields are filled
if (isset($_POST['Manager_ID'], $_POST['Clinic_NO'], $_POST['Exhibit_NO'], $_POST['Shop_NO'], $_POST['SSN'], $_POST['Fname'], $_POST['Lname'], $_POST['Address'], $_POST['Email'], $_POST['Salary'], $_POST['Gender'], $_POST['Role'], $_POST['Joining_Date'], $_POST['Birth_Date'], $_POST['Working_Hours'])) {
    // Fetch values from the form submission
    $Manager_ID = $_POST['Manager_ID'];
    $Clinic_NO = $_POST['Clinic_NO'];
    $Exhibit_NO = $_POST['Exhibit_NO'];
    $Shop_NO = $_POST['Shop_NO'];
    $SSN = $_POST['SSN'];
    $Fname = $_POST['Fname'];
    $Mname = isset($_POST['Mname']) ? $_POST['Mname'] : null;
    $Lname = $_POST['Lname'];
    $Address = $_POST['Address'];
    $Email = $_POST['Email'];
    $Salary = $_POST['Salary'];
    $Gender = $_POST['Gender'];
    $Role = $_POST['Role'];
    $Joining_Date = $_POST['Joining_Date'];
    $Birth_Date = $_POST['Birth_Date'];
    $Working_Hours = $_POST['Working_Hours'];

    // Execute the procedure with the provided inputs
    $procedure_query = "EXEC HireStaff @Manager_ID = ?, @Clinic_NO = ?, @Exhibit_NO = ?, @Shop_NO = ?, @SSN = ?, @Fname = ?, @Mname = ?, @Lname = ?, @Address = ?, @Email = ?, @Salary = ?, @Gender = ?, @Role = ?, @Joining_Date = ?, @Birth_Date = ?, @Working_Hours = ?";
    $params = array($Manager_ID, $Clinic_NO, $Exhibit_NO, $Shop_NO, $SSN, $Fname, $Mname, $Lname, $Address, $Email, $Salary, $Gender, $Role, $Joining_Date, $Birth_Date, $Working_Hours);
    $result = sqlsrv_query($conn, $procedure_query, $params);

    // Check if procedure execution was successful
    if ($result) {
        header("Location:../Staff.php");
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
