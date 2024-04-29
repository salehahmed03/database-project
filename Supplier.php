<?php
// Include database connection file
include 'include/db_connection.php';

// Fetch column names from Staff table
$query_columns = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'Supplier'";
$result_columns = sqlsrv_query($conn, $query_columns);
$columns = array();
if ($result_columns) {
    while ($row = sqlsrv_fetch_array($result_columns, SQLSRV_FETCH_ASSOC)) {
        $columns[] = $row['COLUMN_NAME'];
    }
}

// Fetch data from Staff table
$query_data = "SELECT * FROM Supplier";
$result_data = sqlsrv_query($conn, $query_data);

// Check if query executed successfully
if ($result_data) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Supplier</title>
        <?php include 'include/scripts.php'; ?>
    </head>
    <body>
        <?php include 'include/navbar.php'; ?>

        <div class="container-fluid">
            <div class="row">
                <?php include 'include/sidebar.php'; ?>
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4" style="margin-left: 280px !important;">
                    <h2>Supplier Table</h2>
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
                    <div class="container" mt-5 mb-5>
        <h2>Add Equipment Supplier</h2>
        <form action="Controllers/OrderEquipment.php" method="post">
            <div class="form-group">
                <label for="Company_Name">Company Name:</label>
                <input type="text" class="form-control" id="Company_Name" name="Company_Name">
            </div>
            <div class="form-group">
                <label for="Email">Email:</label>
                <input type="email" class="form-control" id="Email" name="Email">
            </div>
            <div class="form-group">
                <label for="Phone_No">Phone Number:</label>
                <input type="text" class="form-control" id="Phone_No" name="Phone_No">
            </div>
            <div class="form-group">
                <label for="Clinic_No">Clinic Number:</label>
                <input type="number" class="form-control" id="Clinic_No" name="Clinic_No">
            </div>
            <div class="form-group">
                <label for="Quantity">Quantity:</label>
                <input type="number" class="form-control" id="Quantity" name="Quantity" value="1">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <div class="container" mt-5 mb-5>
        <h2>Add Food Supplier</h2>
        <form action="Controllers/OrderFood.php" method="post">
            <div class="form-group">
                <label for="Company_Name">Company Name:</label>
                <input type="text" class="form-control" id="Company_Name" name="Company_Name">
            </div>
            <div class="form-group">
                <label for="Email">Email:</label>
                <input type="email" class="form-control" id="Email" name="Email">
            </div>
            <div class="form-group">
                <label for="Phone_No">Phone Number:</label>
                <input type="text" class="form-control" id="Phone_No" name="Phone_No">
            </div>
            <div class="form-group">
                <label for="Food_Type">Food Type:</label>
                <input type="text" class="form-control" id="Food_Type" name="Food_Type">
            </div>
            <div class="form-group">
                <label for="Exhibit_No">Exhibit Number:</label>
                <input type="number" class="form-control" id="Exhibit_No" name="Exhibit_No">
            </div>
            <div class="form-group">
                <label for="Quantity">Quantity:</label>
                <input type="text" class="form-control" id="Quantity" name="Quantity" value="100kg">
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
