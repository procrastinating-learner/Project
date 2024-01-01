<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'DbConnection.php';
include 'User.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION['user_id'];
    $newPassword = $_POST['new_password'];
    $email = $_POST['new_email'];
    $user = new User('', '');
    $message = $user->updateUser($userId, $email, $newPassword);
}

?>
<?php include 'head.php'; ?>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container" style="padding: 10rem 0;">
        <h2 class="welcome-message" style="color:hsl(0, 36%, 70%);">User Settings</h2>
        <div class="card">

            <div class="card-body">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="new_email">New Email:</label>
                        <input type="text" class="form-control" id="new_email" name="new_email" placeholder="Enter your new email" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password">New Password:</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter your new password" required>
                    </div>
                    <button type="submit" class="custom-button" style="background-color: #ffe4e3;color: black;">Update Profile</button>
                </form>

                <?php
                if (isset($message)) {
                    if (strpos($message, 'Password updated successfully.') === 0) { ?>
                        <div class="text-success mt-3"><?php echo $message; ?></div>
                    <?php } else { ?>
                        <div class="text-danger mt-3"><?php echo $message; ?></div>
                <?php }
                } ?>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>