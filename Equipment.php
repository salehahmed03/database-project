<?php
// Include database connection file
include 'include/db_connection.php';

// Fetch column names from Staff table
$query_columns = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'Equipment'";
$result_columns = sqlsrv_query($conn, $query_columns);
$columns = array();
if ($result_columns) {
    while ($row = sqlsrv_fetch_array($result_columns, SQLSRV_FETCH_ASSOC)) {
        $columns[] = $row['COLUMN_NAME'];
    }
}

// Fetch data from Staff table
$query_data = "SELECT * FROM Equipment";
$result_data = sqlsrv_query($conn, $query_data);

// Check if query executed successfully
if ($result_data) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Equipment</title>
        <?php include 'include/scripts.php'; ?>
    </head>
    <body>
        <?php include 'include/navbar.php'; ?>

        <div class="container-fluid">
            <div class="row">
                <?php include 'include/sidebar.php'; ?>
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                    <h2>Equipment Table</h2>
                    <div class="table-responsive">
                        <table class="table table-bordered border-primary">
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
