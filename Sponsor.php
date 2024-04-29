<?php
// Include database connection file
include 'include/db_connection.php';

// Fetch column names from Staff table
$query_columns = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'Sponsor'";
$result_columns = sqlsrv_query($conn, $query_columns);
$columns = array();
if ($result_columns) {
    while ($row = sqlsrv_fetch_array($result_columns, SQLSRV_FETCH_ASSOC)) {
        $columns[] = $row['COLUMN_NAME'];
    }
}

// Fetch data from Staff table
$query_data = "SELECT * FROM Sponsor";
$result_data = sqlsrv_query($conn, $query_data);

// Check if query executed successfully
if ($result_data) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sponsor</title>
        <?php include 'include/scripts.php'; ?>
    </head>
    <body>
        <?php include 'include/navbar.php'; ?>

        <div class="container-fluid">
            <div class="row">
                <?php include 'include/sidebar.php'; ?>
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4" style="margin-left: 280px !important;">
                    <h2>Sponsor Table</h2>
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
    <h2>Add Sponsor</h2>
    <form action="Controllers/AddSponsor.php" method="POST">
        <div class="form-group">
            <label for="Sponsor_Name">Sponsor Name:</label>
            <input type="text" class="form-control" id="Sponsor_Name" name="Sponsor_Name" required>
        </div>
        <div class="form-group">
            <label for="Email">Email:</label>
            <input type="email" class="form-control" id="Email" name="Email" required>
        </div>
        <div class="form-group">
            <label for="Start_Date">Start Date:</label>
            <input type="date" class="form-control" id="Start_Date" name="Start_Date" required>
        </div>
        <div class="form-group">
            <label for="End_Date">End Date:</label>
            <input type="date" class="form-control" id="End_Date" name="End_Date" required>
        </div>
        <div class="form-group">
            <label for="Shop_Name">Shop Name:</label>
            <input type="text" class="form-control" id="Shop_Name" name="Shop_Name">
        </div>
        <div class="form-group">
            <label for="Location">Location:</label>
            <input type="text" class="form-control" id="Location" name="Location">
        </div>
        <div class="form-group">
            <label for="Product_Category">Product Category:</label>
            <input type="text" class="form-control" id="Product_Category" name="Product_Category">
        </div>
        <div class="form-group">
            <label for="SManager_Id">Manager ID:</label>
            <input type="number" class="form-control" id="SManager_Id" name="SManager_Id">
        </div>
        <div class="form-group">
            <label for="Phone_Number">Phone Number:</label>
            <input type="number" class="form-control" id="Phone_Number" name="Phone_Number"  placeholder="Format: 1234567890">
        </div>
        <button type="submit" class="btn btn-primary">Add Sponsor</button>
    </form>
</div>
<div class="container mt-5 mb-5">
    <h2>Cancel Sponsor</h2>
    <form action="Controllers/CancelSponsor.php" method="post">
        <div class="form-group">
            <label for="SponsorId">Sponsor ID:</label>
            <input type="number" class="form-control" name="SponsorId" id="SponsorId" required>
        </div>
        <button type="submit" class="btn btn-danger">Cancel Sponsor</button>
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
