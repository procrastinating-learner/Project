<?php
session_start();

include 'DbConnection.php';
include 'User.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $user = new User($username, $password);
  $error_message = $user->authenticate();
}

?>
<?php include 'head.php'; ?>

<body>
  <main>
    <div class="left">
      <div class="wrapper">
        <div class="content">
          <h1 class="mb-5">Login</h1>
          <form method="post" action="">
            <div class="form-group">
              <label for="username">Username:</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" />
            </div>
            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" />
            </div>
            <button type="submit" class="custom-button">Login</button>
          </form>
          <?php if (isset($error_message)) { ?>
            <div class="text-danger mt-3"><?php echo $error_message; ?></div>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="right"></div>
  </main>