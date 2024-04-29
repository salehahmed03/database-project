<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Include the script to add the animal
    include 'Controllers/AddShop.php';

    // Redirect to the same page to prevent form resubmission
    header('Location: Shop.php');
    exit;
}
// Include database connection file
include 'include/db_connection.php';

// Fetch column names from Staff table
$query_columns = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'Shop'";
$result_columns = sqlsrv_query($conn, $query_columns);
$columns = array();
if ($result_columns) {
    while ($row = sqlsrv_fetch_array($result_columns, SQLSRV_FETCH_ASSOC)) {
        $columns[] = $row['COLUMN_NAME'];
    }
}

// Fetch data from Staff table
$query_data = "SELECT * FROM Shop";
$result_data = sqlsrv_query($conn, $query_data);

// Check if query executed successfully
if ($result_data) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Shop</title>
        <?php include 'include/scripts.php'; ?>
    </head>
    <body>
        <?php include 'include/navbar.php'; ?>

        <div class="container-fluid">
            <div class="row">
                <?php include 'include/sidebar.php'; ?>
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4" style="margin-left: 280px !important;">
                    <h2>Shop Table</h2>
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
        <h2>Add Shop Form</h2>
        <form action="Controllers/AddShop.php" method="post">
            <div class="form-group">
                <label for="Shop_Name">Shop Name:</label>
                <input type="text" class="form-control" name="Shop_Name" id="Shop_Name" required>
            </div>

            <div class="form-group">
                <label for="Location">Location:</label>
                <input type="text" class="form-control" name="Location" id="Location" required>
            </div>

            <div class="form-group">
                <label for="Product_Category">Product Category:</label>
                <input type="text" class="form-control" name="Product_Category" id="Product_Category" required>
            </div>

            <div class="form-group">
                <label for="SManager_Id">Store Manager ID:</label>
                <input type="number" class="form-control" name="SManager_Id" id="SManager_Id" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Shop</button>
        </form>
    </div>
    <div class="container mt-5 mb-5">
    <h2>Remove Shop Form</h2>
    <form action="Controllers/RemoveShop.php" method="post">
        <div class="form-group">
            <label for="ShopNo">Shop Number:</label>
            <input type="number" class="form-control" name="ShopNo" id="ShopNo" required>
        </div>
        <button type="submit" class="btn btn-danger">Remove Shop</button>
    </form>
</div>
<div class="container mt-5 mb-5">
    <h2>Shop Revenue</h2>
    <form action="Controllers/GetShopRevenue.php" method="post">
        <div class="form-group">
            <label for="ShopNo">Shop Number:</label>
            <input type="number" class="form-control" name="ShopNo" id="ShopNo" required>
        </div>
        <button type="submit" class="btn btn-primary">Get Shop Revenue</button>
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
