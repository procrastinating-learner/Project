<?php
class User
{
  private $username;
  private $email;
  private $password;
  private $db;

  public function __construct($username, $password, $email = null)
  {
    $this->username = $username;
    $this->password = $password;
    $this->db = new DbConnection();
    if (!is_null($email)) {
      $this->email = $email;
    }
  }

  public function updateUser($userId, $email, $password)
  {
    $conn = $this->db->getConnection();
    try {
      $this->validateEmail($email);
      $this->validatePassword($password);
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

      $sql = "UPDATE users SET password = '$hashedPassword', email='$email' WHERE user_id = '$userId'";
      if ($conn->query($sql) === TRUE) {
        echo "Password updated successfully.";
      } else {
        echo "Error updating password: " . $conn->error;
      }
    } catch (InvalidArgumentException $e) {
      return $e->getMessage();
    }
  }

  public function signup()
  {
    $conn = $this->db->getConnection();
    try {
      $this->validateUsername($this->username);
      $this->validateEmail($this->email);
      $this->validatePassword($this->password);
      $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

      $sql = "INSERT INTO users (username, email, password, created_at, is_active) VALUES ('$this->username', '$this->email', '$hashedPassword', NOW(), true)";

      if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
        header("Location: login.php");
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
    } catch (InvalidArgumentException $e) {
      return $e->getMessage();
    }
    $conn->close();
  }

  public function authenticate()
  {
    $conn = $this->db->getConnection();
    $sql = "SELECT user_id, username, password, is_active FROM users WHERE username = '$this->username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      if (password_verify($this->password, $row['password'])) {
        if ($row['is_active'] == 1) {
          $_SESSION['user_id'] = $row['user_id'];
          $_SESSION['username'] = $row['username'];
          header("Location: dashboard.php");
          exit();
        } else {
          $error_message = "User is not active. Please contact the administrator.";
        }
      } else {
        $error_message = "Invalid credentials";
      }
    } else {
      $error_message = "Invalid credentials";
    }

    $conn->close();
    return $error_message;
  }

  private function validateUsername($username)
  {
    if (empty($username)) {
      throw new InvalidArgumentException("Username is required.");
    }
  }

  private function validateEmail($email)
  {
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
      throw new InvalidArgumentException("Invalid email format.");
    }
  }

  private function validatePassword($password)
  {
    if (empty($password) || strlen($password) < 8 || !preg_match('/[A-Z]/', $password)) {
      throw new InvalidArgumentException("Password must be at least 8 characters long and contain at least one uppercase letter.");
    }
  }
}
