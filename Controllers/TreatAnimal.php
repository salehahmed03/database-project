<?php
// Include database connection file
include '../include/db_connection.php';
include '../include/scripts.php';

// Check if form is submitted and all required fields are filled
if (isset($_POST['Animal_Id'], $_POST['Diagnosis'], $_POST['Treatment_Date'], $_POST['Clinic_No'], $_POST['Event_Type'])) {
    // Fetch values from the form submission
    $Animal_Id = $_POST['Animal_Id'];
    $Diagnosis = $_POST['Diagnosis'];
    $Treatment_Date = $_POST['Treatment_Date'];
    $Clinic_No = $_POST['Clinic_No'];
    $Event_Type = $_POST['Event_Type'];

    // Execute the TreatAnimal procedure with the provided inputs
    $procedure_query = "EXEC TreatAnimal @Animal_Id = ?, @Diagnosis = ?, @Treatment_Date = ?, @Clinic_No = ?, @Event_Type = ?";
    $params = array($Animal_Id, $Diagnosis, $Treatment_Date, $Clinic_No, $Event_Type);
    $result = sqlsrv_query($conn, $procedure_query, $params);

    // Check if procedure execution was successful
    if ($result) {
        ?>
        <div class="alert alert-success" role="alert">
            Animal Treated successfully!Return to table and refresh to see changes.
        </div>
        <?php
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
