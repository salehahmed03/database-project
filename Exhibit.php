<?php
// Include database connection file
include 'include/db_connection.php';

// Fetch column names from Staff table
$query_columns = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'Exhibit'";
$result_columns = sqlsrv_query($conn, $query_columns);
$columns = array();
if ($result_columns) {
    while ($row = sqlsrv_fetch_array($result_columns, SQLSRV_FETCH_ASSOC)) {
        $columns[] = $row['COLUMN_NAME'];
    }
}

// Fetch data from Staff table
$query_data = "SELECT * FROM Exhibit";
$result_data = sqlsrv_query($conn, $query_data);

// Check if query executed successfully
if ($result_data) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Exhibit</title>
        <?php include 'include/scripts.php'; ?>
    </head>
    <body>
        <?php include 'include/navbar.php'; ?>

        <div class="container-fluid">
            <div class="row">
                <?php include 'include/sidebar.php'; ?>
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                    <h2>Exhibit Table</h2>
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
                    <div class="container mt-5 mb-5">
        <h2>Create Exhibit</h2>
        <form action="Controllers/CreateExhibit.php" method="post">
            <div class="form-group">
                <label for="Exhibit_Name">Exhibit Name:</label>
                <input type="text" class="form-control" id="Exhibit_Name" name="Exhibit_Name">
            </div>
            <div class="form-group">
                <label for="Capacity">Capacity:</label>
                <input type="number" class="form-control" id="Capacity" name="Capacity">
            </div>
            <div class="form-group">
                <label for="Theme">Theme:</label>
                <input type="text" class="form-control" id="Theme" name="Theme">
            </div>
            <div class="form-group">
                <label for="Location">Location:</label>
                <input type="text" class="form-control" id="Location" name="Location">
            </div>
            <div class="form-group">
                <label for="Size">Size:</label>
                <input type="text" class="form-control" id="Size" name="Size">
            </div>
            <div class="form-group">
                <label for="Security_Level">Security Level:</label>
                <input type="text" class="form-control" id="Security_Level" name="Security_Level">
            </div>
            <div class="form-group">
                <label for="EManager_Id">Manager ID:</label>
                <input type="number" class="form-control" id="EManager_Id" name="EManager_Id">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <div class="container mt-5 mb-5">
        <h2>Create Exhibit</h2>
        <form action="Controllers/CreateExhibit.php" method="post">
            <div class="form-group">
                <label for="Exhibit_Name">Exhibit Name:</label>
                <input type="text" class="form-control" id="Exhibit_Name" name="Exhibit_Name">
            </div>
            <div class="form-group">
                <label for="Capacity">Capacity:</label>
                <input type="number" class="form-control" id="Capacity" name="Capacity">
            </div>
            <div class="form-group">
                <label for="Theme">Theme:</label>
                <input type="text" class="form-control" id="Theme" name="Theme">
            </div>
            <div class="form-group">
                <label for="Location">Location:</label>
                <input type="text" class="form-control" id="Location" name="Location">
            </div>
            <div class="form-group">
                <label for="Size">Size:</label>
                <input type="text" class="form-control" id="Size" name="Size">
            </div>
            <div class="form-group">
                <label for="Security_Level">Security Level:</label>
                <input type="text" class="form-control" id="Security_Level" name="Security_Level">
            </div>
            <div class="form-group">
                <label for="EManager_Id">Manager ID:</label>
                <input type="number" class="form-control" id="EManager_Id" name="EManager_Id">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <div class="container mt-5 mb-5">
        <h2>Destroy Exhibit</h2>
        <form action="Controllers/DestroyExhibit.php" method="post">
            <div class="form-group">
                <label for="old_exhibit_id">Old Exhibit ID:</label>
                <input type="number" class="form-control" id="old_exhibit_id" name="old_exhibit_id">
            </div>
            <div class="form-group">
                <label for="new_exhibit_id">New Exhibit ID:</label>
                <input type="number" class="form-control" id="new_exhibit_id" name="new_exhibit_id">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
                </main>
            </div>
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
