<?php
// Include database connection file
include '../include/db_connection.php';
include '../include/scripts.php';

// Check if form is submitted and all required fields are filled
if (isset($_POST['Sponsor_Name'], $_POST['Email'], $_POST['Start_Date'], $_POST['End_Date'])) {
    // Fetch values from the form submission
    $Sponsor_Name = $_POST['Sponsor_Name'];
    $Email = $_POST['Email'];
    $Start_Date = $_POST['Start_Date'];
    $End_Date = $_POST['End_Date'];

    // Optional fields
    $Shop_Name = isset($_POST['Shop_Name']) ? $_POST['Shop_Name'] : NULL;
    $Location = isset($_POST['Location']) ? $_POST['Location'] : NULL;
    $Product_Category = isset($_POST['Product_Category']) ? $_POST['Product_Category'] : NULL;
    $SManager_Id = isset($_POST['SManager_Id']) ? $_POST['SManager_Id'] : NULL;
    $Phone_Number = isset($_POST['Phone_Number']) ? $_POST['Phone_Number'] : NULL;

    // Execute the AddSponsor procedure with the provided inputs
    $procedure_query = "EXEC AddSponsor @Sponsor_Name = ?, @Email = ?, @Start_Date = ?, @End_Date = ?, @Shop_Name = ?, @Location = ?, @Product_Category = ?, @SManager_Id = ?, @Phone_Number = ?";
    $params = array($Sponsor_Name, $Email, $Start_Date, $End_Date, $Shop_Name, $Location, $Product_Category, $SManager_Id, $Phone_Number);
    $result = sqlsrv_query($conn, $procedure_query, $params);

    // Check if procedure execution was successful
    if ($result) {
        // Redirect to a page showing the list of sponsors
        header("Location:../Sponsor.php");
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
