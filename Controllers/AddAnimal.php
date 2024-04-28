<?php
// Include database connection file
include '../include/db_connection.php';
include '../include/scripts.php';


// Check if form is submitted and all required fields are filled
if (isset($_POST['Animal_Name'], $_POST['Gender'], $_POST['Habitat'], $_POST['General_Name'], $_POST['Genus'], $_POST['Species'], $_POST['Status'], $_POST['Diet_Type'], $_POST['Date_of_Birth'], $_POST['Exhibit_no'])) {
    // Fetch values from the form submission
    $Animal_Name = $_POST['Animal_Name'];
    $Gender = $_POST['Gender'];
    $Habitat = $_POST['Habitat'];
    $General_Name = $_POST['General_Name'];
    $Genus = $_POST['Genus'];
    $Species = $_POST['Species'];
    $Status = $_POST['Status'];
    $Diet_Type = $_POST['Diet_Type'];
    $Date_of_Birth = $_POST['Date_of_Birth'];
    $Exhibit_no = $_POST['Exhibit_no'];

    // Execute the AddAnimal procedure with the provided inputs
    $procedure_query = "EXEC AddAnimal @Animal_Name = ?, @Gender = ?, @Habitat = ?, @General_Name = ?, @Genus = ?, @Species = ?, @Status = ?, @Diet_Type = ?, @Date_of_Birth = ?, @Exhibit_no = ?";
    $params = array($Animal_Name, $Gender, $Habitat, $General_Name, $Genus, $Species, $Status, $Diet_Type, $Date_of_Birth, $Exhibit_no);
    $result = sqlsrv_query($conn, $procedure_query, $params);

    // Check if procedure execution was successful
    if ($result) {
        header("Location:../Animal.php");
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
