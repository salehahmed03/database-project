<?php
// Include database connection file
include '../include/db_connection.php';
include '../include/scripts.php';


// Check if form is submitted and all required fields are filled
if (isset($_POST['Animal_Id'], $_POST['Status'], $_POST['Diagnosis'], $_POST['Date_Diagnosed'], $_POST['Event_Type'], $_POST['Clinic_No'])) {
    // Fetch values from the form submission
    $Animal_Id = $_POST['Animal_Id'];
    $Status = $_POST['Status'];
    $Diagnosis = $_POST['Diagnosis'];
    $Date_Diagnosed = $_POST['Date_Diagnosed'];
    $Event_Type = $_POST['Event_Type'];
    $Clinic_No = $_POST['Clinic_No'];

    // Execute the DiagnoseAnimal procedure with the provided inputs
    $procedure_query = "EXEC DiagnoseAnimal @Animal_Id = ?, @Status = ?, @Diagnosis = ?, @Date_Diagnosed = ?, @Event_Type = ?, @Clinic_No = ?";
    $params = array($Animal_Id, $Status, $Diagnosis, $Date_Diagnosed, $Event_Type, $Clinic_No);
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
