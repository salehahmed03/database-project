<?php
// Include database connection file
include 'include/db_connection.php';

// Fetch column names from Staff table
$query_columns = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'Staff'";
$result_columns = sqlsrv_query($conn, $query_columns);
$columns = array();
if ($result_columns) {
    while ($row = sqlsrv_fetch_array($result_columns, SQLSRV_FETCH_ASSOC)) {
        $columns[] = $row['COLUMN_NAME'];
    }
}

// Fetch data from Staff table
$query_data = "SELECT * FROM Staff";
$result_data = sqlsrv_query($conn, $query_data);

// Check if query executed successfully
if ($result_data) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Staff</title>
        <?php include 'include/scripts.php'; ?>
    </head>
    <body>
        <?php include 'include/navbar.php'; ?>

        <div class="container-fluid">
            <div class="row">
                <?php include 'include/sidebar.php'; ?>
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4" style="margin-left: 280px !important;">
                    <h2>Staff Table</h2>
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
    <h2>Raise</h2>
    <form action="Controllers/SalaryRaise.php" method="post">
        <div class="form-group">
            <label for="Raise">Raise:</label>
            <input type="number" class="form-control" name="Raise" id="Raise" required>
        </div>

        <div class="form-group">
            <label for="ID">ID:</label>
            <input type="number" class="form-control" name="ID" id="ID" required>
        </div>

        <button type="submit" class="btn btn-primary">Salary Raise</button>
    </form>
</div>

<div class="container mt-5 mb-5">
    <h2>Deduction</h2>
    <form action="Controllers/SalaryDeduction.php" method="post">
        <div class="form-group">
            <label for="Raise">Deduction</label>
            <input type="number" class="form-control" name="Deduction" id="Deduction" required>
        </div>

        <div class="form-group">
            <label for="ID">ID:</label>
            <input type="number" class="form-control" name="ID" id="ID" required>
        </div>

        <button type="submit" class="btn btn-primary">Salary Deduction</button>
    </form>
</div>

<div class="container mt-5 mb-5">
        <h2>Fire Staff Form</h2>
        <form action="Controllers/FireStaff.php" method="post">
            <div class="form-group">
                <label for="input_id">Input ID:</label>
                <input type="number" class="form-control" name="input_id" id="input_id" required>
            </div>

            <button type="submit" class="btn btn-danger">Fire Staff</button>
        </form>
    </div>
    <div class="container mt-5 mb-5">
        <h2>Add Employee Form</h2>
        <form action="Controllers/HireStaff.php" method="post">
            <div class="form-group">
                <label for="Manager_ID">Manager ID:</label>
                <input type="number" class="form-control" name="Manager_ID" id="Manager_ID" required>
            </div>

            <div class="form-group">
                <label for="Clinic_NO">Clinic Number:</label>
                <input type="number" class="form-control" name="Clinic_NO" id="Clinic_NO" required>
            </div>

            <div class="form-group">
                <label for="Exhibit_NO">Exhibit Number:</label>
                <input type="number" class="form-control" name="Exhibit_NO" id="Exhibit_NO" required>
            </div>

            <div class="form-group">
                <label for="Shop_NO">Shop Number:</label>
                <input type="number" class="form-control" name="Shop_NO" id="Shop_NO" required>
            </div>

            <div class="form-group">
                <label for="SSN">SSN:</label>
                <input type="text" class="form-control" name="SSN" id="SSN" required>
            </div>

            <div class="form-group">
                <label for="Fname">First Name:</label>
                <input type="text" class="form-control" name="Fname" id="Fname" required>
            </div>

            <div class="form-group">
                <label for="Mname">Middle Name:</label>
                <input type="text" class="form-control" name="Mname" id="Mname">
            </div>

            <div class="form-group">
                <label for="Lname">Last Name:</label>
                <input type="text" class="form-control" name="Lname" id="Lname" required>
            </div>

            <div class="form-group">
                <label for="Address">Address:</label>
                <input type="text" class="form-control" name="Address" id="Address" required>
            </div>

            <div class="form-group">
                <label for="Email">Email:</label>
                <input type="email" class="form-control" name="Email" id="Email" required>
            </div>

            <div class="form-group">
                <label for="Salary">Salary:</label>
                <input type="number" step="0.01" class="form-control" name="Salary" id="Salary" required>
            </div>

            <div class="form-group">
                <label for="Gender">Gender:</label>
                <select class="form-control" name="Gender" id="Gender" required>
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                    <option value="O">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="Role">Role:</label>
                <input type="text" class="form-control" name="Role" id="Role" required>
            </div>

            <div class="form-group">
                <label for="Joining_Date">Joining Date:</label>
                <input type="date" class="form-control" name="Joining_Date" id="Joining_Date" required>
            </div>

            <div class="form-group">
                <label for="Birth_Date">Birth Date:</label>
                <input type="date" class="form-control" name="Birth_Date" id="Birth_Date" required>
            </div>

            <div class="form-group">
                <label for="Working_Hours">Working Hours:</label>
                <input type="text" class="form-control" name="Working_Hours" id="Working_Hours" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Employee</button>
        </form>
    </div>

    <div class="container mt-5 mb-5">
        <h2>Transfer Staff Form</h2>
        <form action="Controllers/TransferStaff.php" method="post">
            <div class="form-group">
                <label for="staff_id">Staff ID:</label>
                <input type="number" class="form-control" name="staff_id" id="staff_id" required>
            </div>

            <div class="form-group">
                <label for="new_location_no">New Location Number:</label>
                <input type="number" class="form-control" name="new_location_no" id="new_location_no" required>
            </div>

            <button type="submit" class="btn btn-primary">Transfer Staff</button>
        </form>
    </div>

    <div class="container mt-5 mb-5">
        <h2>Promote Staff Form</h2>
        <form action="Controllers/PromoteStaff.php" method="post">
            <div class="form-group">
                <label for="staff_id">Staff ID:</label>
                <input type="number" class="form-control" name="staff_id" id="staff_id" required>
            </div>

            <button type="submit" class="btn btn-primary">Promote Staff</button>
        </form>
    </div>
    <div class="container mt-5 mb-5">
        <h2>Get Staff Role Form</h2>
        <form action="Controllers/GetStaffRole.php" method="post">
            <div class="form-group">
                <label for="staff_id">Staff ID:</label>
                <input type="number" class="form-control" name="staff_id" id="staff_id" required>
            </div>

            <button type="submit" class="btn btn-primary">Get Staff Role</button>
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
