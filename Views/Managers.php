<?php include '../include/scripts.php';?>
<div class="container">
        <h2>GetManagers View</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Role</th>
                        <th>Salary</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- PHP code to fetch and display data -->
                    <?php
                    // Include database connection file
                    include '../include/db_connection.php';

                    // Query to fetch data from GetManagers view
                    $query = "SELECT ID, Fname, Lname, Role, salary FROM GetManagers";

                    // Execute the query
                    $result = sqlsrv_query($conn, $query);

                    // Check if query executed successfully
                    if ($result) {
                        // Loop through each row and display data in table rows
                        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . $row['ID'] . "</td>";
                            echo "<td>" . $row['Fname'] . "</td>";
                            echo "<td>" . $row['Lname'] . "</td>";
                            echo "<td>" . $row['Role'] . "</td>";
                            echo "<td>" . $row['salary'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        // Display error message if query fails
                        echo "<tr><td colspan='5'>Error fetching data.</td></tr>";
                    }

                    // Close database connection
                    sqlsrv_close($conn);
                    ?>
                    
                </tbody>
            </table>
        </div>
    </div>