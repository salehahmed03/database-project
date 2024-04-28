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
        <div class="card-deck">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Manage Users</h5>
              <p class="card-text">Click here to manage user accounts, including creating, editing, and deleting users.</p>
              <a href="#" class="btn btn-primary">Go to Users</a>
            </div>
          </div>
        
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Settings</h5>
              <p class="card-text">Adjust system settings and configurations to meet your needs.</p>
              <a href="#" class="btn btn-primary">Go to Settings</a>
            </div>
          </div>
        </div>
      </main>
  </div>
</div>
</body>
</html>
