<?php
namespace app\models;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use app\core\Database;
use app\core\Config;
trait User{
  use Database;
  /**
   * @var string $mail
   *   Email address.
   */
  public $mail;

  /**
   * Send constructor.
   *
   * @param string $mail
   *   Email address.
   */
  public function retriveMail($mail)
  {
    $this->mail = $mail;
  }
  public function checkUserCredentails($username, $password)
  {
    $this->conn->begin_transaction();
    $sql = "SELECT UserName, hashed_password FROM users WHERE username = ?";
    try {
      // Execute queries
      $stmt = $this->conn->prepare($sql);
      $stmt->bind_param("s", $username);
      $stmt->execute();
      $stmt->store_result();
      // Check if a row was found with the given username
      if ($stmt->num_rows > 0) {
        $hashed_password=NULL;
        // Retrieve the hashed password
        $stmt->bind_result($username, $hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
          // Password is correct
          $_SESSION['loggedin'] = true;
          $_SESSION['username']=$username;
          header("Location:/public/home");
          // Proceed with authentication or redirect to authenticated area
        } else {
          // Password is incorrect
          echo "<script>alert('Incorrect Password');  window.location.href ='/public/login';</script>";
          // Display an error message or redirect to login page
        }
      } else {
        // Username not found
        echo "<script>alert('Username Not Found');  window.location.href ='/public/login';</script>";
        // Display an error message or redirect to registration page
      }
    } catch (\mysqli_sql_exception $e) {
      $this->conn->rollback();
      return "Error: " . $e->getMessage();
    }
  }
  public function insertUserData($username, $email, $password)
  {
    $this->conn->begin_transaction();

    $sql = "INSERT INTO users (Username,hashed_password,email) VALUES ('$username', '$password', '$email')";

    try {
      // Execute queries
      $query1 = $this->conn->query($sql);

      // Check if all queries were successful
      if ($query1) {
        // Commit transaction
        $this->conn->commit();
        $_SESSION['email']=$email;
        return "Registered Sucessfully";
      } else {
        // Rollback transaction
        $this->conn->rollback();
        return "Error: " . $this->conn->error;
      }
    } catch (\mysqli_sql_exception $e) {
      $this->conn->rollback();
      if ($e->getMessage() == "Duplicate entry '$username' for key 'users.PRIMARY'") {
        return "Already Registered with this username";
      }else if($e->getMessage()=="Duplicate entry '$email' for key 'users.email'"){
        return "Already Registered with this email";
      }
      return "Error: " . $e->getMessage();
    }
  }
  /**
   * Validate email address and check if it exists in the database.
   */
  public function emailValidate($email)
  {

    // Validate email.
    if (empty ($email)) {
      echo "<p>Mail is required! </p>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo "<p>Invalid email format!</p>";
    } else {
      $api_key = "0c7f6fd69a8b4143ae7f7c73b6656478";
      $ch = curl_init();
      curl_setopt_array($ch, [
        CURLOPT_URL => "https://emailvalidation.abstractapi.com/v1/?api_key=$api_key&email=$email",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
      ]);
      $response = curl_exec($ch);
      curl_close($ch);
      $data = json_decode($response, true);
      // Check if email is valid.
      if ($data['is_valid_format'] && $data['is_smtp_valid'] && $data['autocorrect'] == '') {
        return true;
      } else {
        return false;
      }
    }
  }
  public function forgotPassword()
  {
    new Config();
    // Get email from POST data.
    $this->mail = $_POST['mail'];

    // Validate email.
    if (empty($_POST["mail"])) {
      echo "<script>alert('Please Enter Email');  window.location.href ='forgotpassword';</script>";
    } elseif (!filter_var($this->mail, FILTER_VALIDATE_EMAIL)) {
      echo "<script>alert('Invalid Email Format');  window.location.href ='forgotpassword';</script>";
     
    } else {
      // Check if the email exists in the database.
      $conn = new \mysqli(SERVER_NAME, USER_NAME, PASSWORD, DB_NAME);

      // Check connection.
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // Prepare SQL statement to check if email exists.
      $sql = "SELECT * FROM users WHERE email = ?";
      $stmt =$conn->prepare($sql);
      $stmt->bind_param("s", $this->mail);
      $stmt->execute();
      $result = $stmt->get_result();

      // If the email exists in the database, proceed with sending the reset link.
      if ($result->num_rows > 0) {
        $this->sendResetLink();
      } else {
        echo "<script>alert('Email Not Registered');  window.location.href ='forgotpassword';</script>";
      }

      // Close database connection.
      $stmt->close();
      $conn->close();
    }
  }

  /**
   * Send password reset link with token.
   */
  public function sendResetLink()
  {
    new Config();
    // Store the token and its expiration time in the database.
    $conn = new \mysqli(SERVER_NAME, USER_NAME, PASSWORD, DB_NAME);

    // Check connection.
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Generate a unique token.
    $token = bin2hex(random_bytes(32)); // Change the token length as needed.
    // Prepare SQL statement to update token and expiration time.
    $sql = "UPDATE users SET token = ?, expire_time = ? WHERE email = ?";
    $expireTime = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token expires in 1 hour.
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $token, $expireTime, $this->mail);
    $stmt->execute();

    // Check if any rows were affected by the update.
    if ($stmt->affected_rows > 0) {
      // Send email with the reset link containing the token.
      $this->sendMail("$token");
    } else {
      // No rows were updated, meaning the email does not exist in the database.
      echo "<script>alert('Email Not Registered');  window.location.href ='forgotpassword';</script>";
      // echo "<a class='link' href='registration.php'>Register</a><br><br>";
      // echo "<a href='login.php'>Login</a>";
    }

    // Close statement and database connection.
    $stmt->close();
    $conn->close();
  }


  /**
   * Send email with reset link.
   *
   * @param string $token
   *   The generated token.
   */
  public function sendMail($token)
  {
    // Include PHPMailer library.
    require '../vendor/autoload.php';

    // Get email from POST data.
    $email = $_POST['mail'];
    $mail = new PHPMailer(true);

    try {
      // SMTP settings.
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'kulpratap98@gmail.com';
      $mail->Password = 'xmwguqpvtmclskcb';
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;

      // Set sender and recipient.
      $mail->setFrom('kulpratap98@gmail.com', 'Kul Pratap Singh');
      $mail->addAddress($email);
      $x=ROOT;
      // Set email content.
      $resetLink = "$x/public/resetpassword?token=" . $token;
      $mail->isHTML(true);
      $mail->Subject = 'Forgot Password';
      $mail->Body = 'Click the following link to reset your password: <a href="' . $resetLink . '">' . $resetLink . '</a>';
      // Send email.
      $mail->send();
      $x=$_SESSION['email_Send']=$this->mail;
      echo "<script>alert('Email Sent Sucessfully');  window.location.href ='forgotpassword';</script>";
    
    } catch (Exception $e) {
      // Display error if email cannot be sent.
      echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
  }
  public function getEmailFromToken($token)
  {
    // Prepare SQL statement to select email associated with the token
    $sql = "SELECT email FROM users WHERE token = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any rows were returned
    if ($result->num_rows > 0) {
      // Fetch the email from the result set
      $row = $result->fetch_assoc();
      return $row['email'];
    } else {
      // Token not found
      return false;
    }
  }
  /**
   * Function updates the password
   * 
   * @param string $token
   * token
   * @param string $password
   * The password that will be updated
   */
  public function UpdateData($token, $password)
  {

    // Hash the new password before updating it in the database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL statement to update password
    $sql = "UPDATE users SET hashed_password = ? WHERE token = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("ss", $hashed_password, $token);

    // Execute the update statement
    if ($stmt->execute()) {
      header('Location:login');
    } else {
      echo "Error updating password: " . $this->conn->error;
    }
  }
  public function tokennull($mail)
  {
    $token = NULL;
    $sql = "UPDATE users SET token='$token' WHERE email='$mail'";
    $this->conn->query($sql);
  }
  /**
   * Validate email address and check if it exists in the database.
   */
  public function isTokenValid($token)
  {
    echo "This is function";
    // Get the current time in GMT (UTC).
    $current_time_utc = gmdate('Y-m-d H:i:s');
    // Prepare SQL statement to check if the token exists and is still valid.
    $sql = "SELECT * FROM users WHERE token = ? AND expire_time >= ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("ss", $token, $current_time_utc);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any rows were returned.
    if ($result->num_rows > 0) {
      // Token exists and is still valid in the database.
      return true;
    } else {
      // Token does not exist or has expired in the database.
      return false;
    }
  }
  public function googleAuth()
  {
    require '../vendor/autoload.php';
  
      $client = new \Google_Client();
      $client->setClientId(YOUR_CLIENT_ID);
      $client->setClientSecret("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");
      $client->setRedirectUri(YOUR_REDIRECT_URI);
      $client->addScope('email');
      $client->addScope('profile');
  
      if (isset($_GET['code'])) {
  
          // Exchange authorization code for access token
          $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
          $client->setAccessToken($token['access_token']);
          $_SESSION['google_access_token'] = $token;
          // Get user information
          $oauth2 = new \Google_Service_Oauth2($client);
          $userInfo = $oauth2->userinfo->get();
          
          // Check if user exists in the database
          $user = $this->getUserByEmail($userInfo->email);

          if ($user) {
              // User exists, log them in
              $this->loginUser($user);

          } else {
              // User doesn't exist, create a new account
              $this->createUser($userInfo);
          }
          $_SESSION['loggedin']=true;
          header('Location: /public/home');

          exit;
      } else {
          // Redirect to Google authentication page
          $auth_url = $client->createAuthUrl();
          header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
          exit;
      }
  }
  

  public function getUserByEmail($email)
  {
    $stmt = $this->conn->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
  }

  // Function to create a new user in the database
  public function createUser($userInfo) {
    // Implement your database query to create a new user using $userInfo
    $stmt = $this->conn->prepare('INSERT INTO users (email, UserName) VALUES (?, ?)');
    $stmt->bind_param('ss', $userInfo->email, explode('@', $userInfo->email)[0]);
    $username=explode('@', $userInfo->email)[0];
    $_SESSION['username']=$username;
    $stmt->execute();
}

  // Function to login the user (set session, etc.)
  public function loginUser($user) {
    $_SESSION['username'] = $user['UserName'];
}
public function getAllPosts() {
  // Prepare the SQL statement to fetch all posts
  $sql = "SELECT * FROM posts ORDER BY created_at DESC";
  
  // Prepare the statement
  $stmt = $this->conn->prepare($sql);
  
  // Execute the statement
  $stmt->execute();
  
  // Get the result
  $result = $stmt->get_result();
  $posts = $result->fetch_all(MYSQLI_ASSOC);
  
  // Close the statement
  $stmt->close();
  
  // Return the posts
  return $posts;
}
public function getPostsByUsername($username) {
// Prepare the SQL statement to fetch posts by username
$sql = "SELECT post_id, user_name, content, image_path, created_at FROM posts WHERE user_name = ? ORDER BY created_at DESC";

// Prepare the statement
$stmt = $this->conn->prepare($sql);

// Bind the parameter
$stmt->bind_param("s", $username);

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Fetch the posts
$posts = $result->fetch_all(MYSQLI_ASSOC);

// Close the statement
$stmt->close();

// Return the posts
return $posts;
}
public function getUserByUsername($username) {

// Prepare SQL statement
$stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$row = $result->fetch_assoc();

$stmt->close();

return $row;
}
public function checkAndUpdateEmail($email,$user_name)
{
  
  $email = mysqli_real_escape_string($this->conn, $email);
  $UserName = mysqli_real_escape_string($this->conn, $user_name);

  // Check if the same user is registered with this email
  $sql = "SELECT UserName FROM users WHERE email = '$email' AND UserName = '$UserName'";
  $result = $this->conn->query($sql);

  if ($result->num_rows > 0) {
      // Same user is registered with this email, update the email
      $sql = "UPDATE users SET email = '$email' WHERE UserName = '$UserName'";
      if ($this->conn->query($sql) === TRUE) {
        return true;
      } else {
          return "Error: " . $sql . "<br>" . $this->conn->error;
      }
  } else {
      // Check if email is associated with any other user
      $sql = "SELECT UserName FROM users WHERE email = '$email' AND UserName != '$UserName'";
      $result = $this->conn->query($sql);

      if ($result->num_rows > 0) {
          echo "<script>alert('Email Already Registered'); window.location.href='update';</script>";
      } else {
          // Update the email for the user
          $sql = "UPDATE users SET email = '$email' WHERE UserName = '$UserName'";
          if ($this->conn->query($sql) === TRUE) {
             return true;
          } else {
              return "Error: " . $sql . "<br>" . $this->conn->error;
          }
      }
}
}
public function checkAndUpdateUsername($new_user_name,$user_name)
{
try{
  $new_user_name = mysqli_real_escape_string($this->conn, $new_user_name);
  $user_name = mysqli_real_escape_string($this->conn, $user_name);

  // Check if the same user is registered with this UserName
  $sql = "SELECT UserName FROM users WHERE UserName = '$user_name'";
  $result = $this->conn->query($sql);

  if ($result->num_rows > 0) {
      // Same user is registered with this UserName, update the UserName
      $sql = "UPDATE users SET UserName = '$new_user_name' WHERE UserName = '$user_name'";
      if ($this->conn->query($sql) === TRUE) {
        $_SESSION['username']=$new_user_name;
        return true;
      } else {
          return "Error: " . $sql . "<br>" . $this->conn->error;
      }
  } else {
      // Check if UserName is associated with any other user
      $sql = "SELECT UserName FROM users WHERE UserName = '$new_user_name' AND UserName != '$user_name'";
      $result = $this->conn->query($sql);

      if ($result->num_rows > 0) {
        echo "<script>alert('Username Already Registered'); window.location.href='update';</script>";
      } else {
          // Update the UserName for the user
          $sql = "UPDATE users SET UserName = '$new_user_name' WHERE UserName = '$user_name'";
          if ($this->conn->query($sql) === TRUE) {
            $_SESSION['username']=$new_user_name;
             return true;
              
          } else {
              return "Error: " . $sql . "<br>" . $this->conn->error;
          }
      }
}
}catch (\mysqli_sql_exception $e) {
$this->conn->rollback();
echo $e->getMessage();
}
}
} 
