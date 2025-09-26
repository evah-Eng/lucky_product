<?php
session_start();
require 'db.php';

$message = '';

if(isset($_SESSION['user_id'])){
    header("Location: home.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id,name,password FROM users WHERE email=?");
    if(!$stmt){ die("Prepare failed: " . $conn->error); }
    
    $stmt->bind_param("s", $email);
    if(!$stmt->execute()){ die("Execute failed: " . $stmt->error); }

    $stmt->bind_result($id,$name,$hash);
    if($stmt->fetch() && password_verify($password,$hash)){
        $_SESSION['user_id'] = $id;
        $_SESSION['user_name'] = $name;
        header("Location: home.php");
        exit;
    } else {
        $message = "Invalid email or password.";
    }
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — Lucky Product</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
body { font-family:'Poppins',sans-serif; background:#fdf2f8; display:flex; justify-content:center; align-items:center; height:100vh; margin:0; color:#0f172a;}
.login-container { background:#fff; padding:30px 40px; border-radius:16px; box-shadow:0 6px 24px rgba(2,6,23,0.06); width:100%; max-width:400px;}
h2 { text-align:center; color:#db2777; margin-bottom:20px;}
form label { display:block; font-weight:600; margin-top:12px;}
form input { width:100%; padding:10px; margin-top:6px; border-radius:10px; border:1px solid #e6edf0; box-sizing:border-box;}
form button { width:100%; margin-top:20px; padding:12px; border-radius:10px; border:none; background:#db2777; color:white; font-weight:700; cursor:pointer; transition:0.3s;}
form button:hover { background:#c026d3; }
.message { color:red; text-align:center; margin-bottom:12px;}
.register-link { text-align:center; margin-top:12px; }
.register-link a { color:#db2777; font-weight:600; text-decoration:none;}
.register-link a:hover { text-decoration:underline;}
</style>
</head>
<body>
<div class="login-container">
    <h2>Login</h2>
    <?php if($message) echo "<p class='message'>$message</p>"; ?>
    <form method="post">
        <label>Email:</label>
        <input type="email" name="email" required>
        <label>Password:</label>
        <input type="password" name="password" required>
        <button type="submit">Login</button>
    </form>
    <div class="register-link">
        <p>Don't have an account? <a href="index.php">Register</a></p>
        <p>Forgot password? <a href="forgot.php">Click here</a></p>
    </div>
</div>
</body>
</html>
