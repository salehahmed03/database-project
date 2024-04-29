<?php include '../include/scripts.php';?>

<div class="container">
        <h2>Total Shop Revenue View</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Shop Number</th>
                        <th>Total Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- PHP code to fetch and display data -->
                    <?php
                    // Include database connection file
                    include '../include/db_connection.php';

                    // Query to fetch data from GetTotalShopRevenue view
                    $query = "SELECT shop_no, TotalRevenue FROM GetTotalShopRevenue";

                    // Execute the query
                    $result = sqlsrv_query($conn, $query);

                    // Check if query executed successfully
                    if ($result) {
                        // Loop through each row and display data in table rows
                        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . $row['shop_no'] . "</td>";
                            echo "<td>" . $row['TotalRevenue'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        // Display error message if query fails
                        echo "<tr><td colspan='2'>Error fetching data.</td></tr>";
                    }

                    // Close database connection
                    sqlsrv_close($conn);
                    ?>
                    <!-- End of PHP code -->
                </tbody>
            </table>
        </div>
    </div>