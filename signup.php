<?php
session_start();

include 'DbConnection.php';
include 'User.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  $user = new User($username, $password, $email);
  $resultMessage = $user->signup();
}



?>
<?php include 'head.php'; ?>

<body>
  <main>
    <div class="left">
      <div class="wrapper">
        <div class="content">
          <h1 class="mb-5">Sign up</h1>
          <form method="post" action="">
            <div class="form-group">
              <label for="username">Username:</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" />
            </div>
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" />
            </div>
            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" />
            </div>
            <button type="submit" class="custom-button">Signup</button>
          </form>
          <?php if (isset($resultMessage)) { ?>
            <div class="text-danger mt-3"><?php echo $resultMessage; ?></div>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="right"></div>
  </main>
  <?php include 'footer.php'; ?>