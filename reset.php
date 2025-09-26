<?php
session_start();
require 'db.php';

$message = '';
$token = $_GET['token'] ?? '';

if (!$token) {
    die("Invalid token.");
}

// Check if token exists and is not expired
$stmt = $conn->prepare("SELECT id FROM users WHERE reset_token=? AND reset_expires > NOW()");
$stmt->bind_param("s", $token);
$stmt->execute();
$stmt->store_result();

if($stmt->num_rows == 0){
    die("Invalid or expired token.");
}

$stmt->bind_result($user_id);
$stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt_update = $conn->prepare("UPDATE users SET password=?, reset_token=NULL, reset_expires=NULL WHERE id=?");
    $stmt_update->bind_param("si", $new_password, $user_id);
    if($stmt_update->execute()){
        $message = "Password successfully reset. <a href='login.php'>Login now</a>.";
    } else {
        $message = "Error. Try again.";
    }
    $stmt_update->close();
}

$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password — Lucky Product</title>
    <style>
        body{font-family: Arial, sans-serif; background:#fdf2f8; color:#0f172a;}
        form{max-width:400px;margin:50px auto;padding:20px;background:#fff;border-radius:10px;box-shadow:0 6px 18px rgba(0,0,0,0.1);}
        label{display:block;margin-top:10px;font-weight:600;}
        input{width:100%;padding:10px;margin-top:5px;border-radius:8px;border:1px solid #e6edf0;}
        button{margin-top:15px;padding:12px 20px;background:#db2777;color:#fff;border:none;border-radius:8px;cursor:pointer;font-weight:700;}
        .message{color:red;text-align:center;margin-bottom:10px;}
        a{color:#db2777;}
    </style>
</head>
<body>

<h2 style="text-align:center;">Reset Password</h2>

<?php if($message) echo "<div class='message'>$message</div>"; ?>

<?php if(!$message): ?>
<form method="post">
    <label>New Password:</label>
    <input type="password" name="password" required>
    <button type="submit">Reset Password</button>
</form>
<?php endif; ?>

</body>
</html>
