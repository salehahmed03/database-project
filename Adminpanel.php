<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel</title>
  <?php include 'include/scripts.php'; ?>
</head>
<body>
 
   <?php include 'include/navbar.php'; ?>
    <?php include 'include/sidebar.php'; ?>

    <div class="content-container">
  <div class="container">
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="my-4">
        <h2>Welcome to the Admin Panel</h2>
        <p>This panel allows you to manage various aspects of your system. You can perform tasks such as managing users, viewing reports, and updating settings.</p>
        <p>Please use the sidebar navigation to explore the different sections of the admin panel.</p>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Get Managers</h5>
              <p class="card-text">Click here to get all Managers Information</p>
              <a href="Views/Managers.php" class="btn btn-primary">Go to Table</a>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Get Number of Each Role</h5>
              <p class="card-text">To Get Number Of Employees In Each Role </p>
              <a href="Views/Roles.php" class="btn btn-primary">Go to Table</a>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Get Total Shop Revenue</h5>
              <p class="card-text">To see Every Shop And Its Revenue</p>
              <a href="Views/ShopRevenue.php" class="btn btn-primary">Go to Table</a>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Get Number of Animals in Exhibit</h5>
              <p class="card-text">To See the Number of Animals in Every Exhibit</p>
              <a href="Views/AnimalsInExhibit.php" class="btn btn-primary">Go to Table</a>
            </div>
          </div>
        </div>
      </div>

    </main>
  </div>
</div>

  </div>
</div>
</body>
</html>
