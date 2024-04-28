<?php

// Include database connection file
include 'include/db_connection.php';

// Fetch column names from Staff table
$query_columns = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'Animal'";
$result_columns = sqlsrv_query($conn, $query_columns);
$columns = array();
if ($result_columns) {
    while ($row = sqlsrv_fetch_array($result_columns, SQLSRV_FETCH_ASSOC)) {
        $columns[] = $row['COLUMN_NAME'];
    }
}

// Fetch data from Staff table
$query_data = "SELECT * FROM Animal";
$result_data = sqlsrv_query($conn, $query_data);


// Check if query executed successfully
if ($result_data) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Animal</title>
        <?php include 'include/scripts.php'; ?>
    </head>
    <body>
        <?php include 'include/navbar.php'; ?>

        <div class="container-fluid">
            <div class="row">
                <?php include 'include/sidebar.php'; ?>
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                    <h2>Animal Table</h2>
                    <div class="table-responsive">
                        <table class="table table-bordered border-primary mt-5">
                            <thead>
                                <tr>
                                    <?php
                                    // Output table headers dynamically
                                    foreach ($columns as $column) {
                                        echo "<th>$column</th>";
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Loop through the result set and output data in rows
                                while ($row = sqlsrv_fetch_array($result_data, SQLSRV_FETCH_ASSOC)) {
                                    echo "<tr>";
                                    foreach ($row as $key => $value) {
                                        if ($value instanceof DateTime) {
                                            // Format DateTime object before outputting
                                            echo "<td>" . $value->format('Y-m-d H:i:s') . "</td>";
                                        } else {
                                            echo "<td>$value</td>";
                                        }
                                    }
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </main>
            </div>
        </div>

    </div>
    <div class="container mt-5 mb-5">
        <h2>Add Info Form</h2>
        <form action="Controllers/AddAnimal.php" method="post">
            <div class="form-group">
                <label for="Animal_Name">Animal Name:</label>
                <input type="text" class="form-control" name="Animal_Name" id="Animal_Name" required>
            </div>

            <div class="form-group">
                <label for="Gender">Gender:</label>
                <input type="text" class="form-control" name="Gender" id="Gender" required>
            </div>

            <div class="form-group">
                <label for="Habitat">Habitat:</label>
                <input type="text" class="form-control" name="Habitat" id="Habitat" required>
            </div>

            <div class="form-group">
                <label for="General_Name">General Name:</label>
                <input type="text" class="form-control" name="General_Name" id="General_Name" required>
            </div>

            <div class="form-group">
                <label for="Genus">Genus:</label>
                <input type="text" class="form-control" name="Genus" id="Genus" required>
            </div>

            <div class="form-group">
                <label for="Species">Species:</label>
                <input type="text" class="form-control" name="Species" id="Species" required>
            </div>

            <div class="form-group">
                <label for="Status">Status:</label>
                <input type="text" class="form-control" name="Status" id="Status" required>
            </div>

            <div class="form-group">
                <label for="Diet_Type">Diet Type:</label>
                <input type="text" class="form-control" name="Diet_Type" id="Diet_Type" required>
            </div>

            <div class="form-group">
                <label for="Date_of_Birth">Date of Birth:</label>
                <input type="date" class="form-control" name="Date_of_Birth" id="Date_of_Birth" required>
            </div>

            <div class="form-group">
                <label for="Exhibit_no">Exhibit Number:</label>
                <input type="number" class="form-control" name="Exhibit_no" id="Exhibit_no" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Animal</button>
        </form>
    </div>

    <div class="container mt-5 mb-5">
        <h2>Diagnose Animal Form</h2>
        <form action="Controllers/DiagnoseAnimal.php" method="post">
            <div class="form-group">
                <label for="Animal_Id">Animal ID:</label>
                <input type="number" class="form-control" name="Animal_Id" id="Animal_Id" required>
            </div>

            <div class="form-group">
                <label for="Status">Status:</label>
                <input type="text" class="form-control" name="Status" id="Status" required>
            </div>

            <div class="form-group">
                <label for="Diagnosis">Diagnosis:</label>
                <input type="text" class="form-control" name="Diagnosis" id="Diagnosis" required>
            </div>

            <div class="form-group">
                <label for="Date_Diagnosed">Date Diagnosed:</label>
                <input type="date" class="form-control" name="Date_Diagnosed" id="Date_Diagnosed" required>
            </div>

            <div class="form-group">
                <label for="Event_Type">Event Type:</label>
                <input type="text" class="form-control" name="Event_Type" id="Event_Type" required>
            </div>

            <div class="form-group">
                <label for="Clinic_No">Clinic Number:</label>
                <input type="number" class="form-control" name="Clinic_No" id="Clinic_No" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit Diagnosis</button>
        </form>
    </div>

    <div class="container mt-5 mb-5">
        <h2>Transfer Animal Form</h2>
        <form action="Controllers/TransferAnimal.php" method="post">
            <div class="form-group">
                <label for="Animal_ID">Animal ID:</label>
                <input type="number" class="form-control" name="Animal_ID" id="Animal_ID" required>
            </div>

            <div class="form-group">
                <label for="Exhibit_no">Exhibit Number:</label>
                <input type="number" class="form-control" name="Exhibit_no" id="Exhibit_no" required>
            </div>

            <button type="submit" class="btn btn-primary">Transfer Animal</button>
        </form>
    </div>

    <div class="container mt-5 mb-5">
        <h2>Treat Animal Form</h2>
        <form action="Controllers/TreatAnimal.php" method="post">
            <div class="form-group">
                <label for="Animal_Id">Animal ID:</label>
                <input type="number" class="form-control" name="Animal_Id" id="Animal_Id" required>
            </div>

            <div class="form-group">
                <label for="Diagnosis">Diagnosis:</label>
                <input type="text" class="form-control" name="Diagnosis" id="Diagnosis" required>
            </div>

            <div class="form-group">
                <label for="Treatment_Date">Treatment Date:</label>
                <input type="date" class="form-control" name="Treatment_Date" id="Treatment_Date" required>
            </div>

            <div class="form-group">
                <label for="Clinic_No">Clinic Number:</label>
                <input type="number" class="form-control" name="Clinic_No" id="Clinic_No" required>
            </div>

            <div class="form-group">
                <label for="Event_Type">Event Type:</label>
                <input type="text" class="form-control" name="Event_Type" id="Event_Type" required>
            </div>

            <button type="submit" class="btn btn-primary">Treat Animal</button>
        </form>
    </div>


    </body>
    </html>
    <?php

} else {
    // Error handling
    echo "Error: " . sqlsrv_errors();
}

// Close database connection
sqlsrv_close($conn);
?>

