<?php
session_start();
require 'db.php'; // your database connection

$message = '';

// Redirect logged-in users directly to home
if(isset($_SESSION['user_id'])){
    header("Location: home.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $stmt_check = $conn->prepare("SELECT id FROM users WHERE email=?");
    if(!$stmt_check){
        die("Prepare failed: " . $conn->error);
    }
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        $message = "Email already registered. Please <a href='login.php'>login</a>.";
    } else {
        $stmt_insert = $conn->prepare("INSERT INTO users (name,email,password) VALUES (?,?,?)");
        if(!$stmt_insert){
            die("Prepare failed: " . $conn->error);
        }
        $stmt_insert->bind_param("sss", $name, $email, $password);

        if ($stmt_insert->execute()) {
            // Registration successful, redirect to login
            header("Location: login.php");
            exit;
        } else {
            $message = "Error occurred. Try again.";
        }
        $stmt_insert->close();
    }
    $stmt_check->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register — Lucky Product</title>
    <style>
        body{font-family: Arial, sans-serif; background:#fdf2f8; color:#0f172a;}
        form{max-width:400px;margin:50px auto;padding:20px;background:#fff;border-radius:10px;box-shadow:0 6px 18px rgba(0,0,0,0.1);}
        label{display:block;margin-top:10px;font-weight:600;}
        input{width:100%;padding:10px;margin-top:5px;border-radius:8px;border:1px solid #e6edf0;}
        button{margin-top:15px;padding:12px 20px;background:#db2777;color:#fff;border:none;border-radius:8px;cursor:pointer;font-weight:700;}
        p{margin-top:10px;text-align:center;}
        .message{color:red;text-align:center;margin-bottom:10px;}
        a{color:#db2777;}
    </style>
</head>
<body>

<h2 style="text-align:center;">Register</h2>

<?php if($message) echo "<div class='message'>$message</div>"; ?>

<form method="post" action="">
    <label>Name:</label>
    <input type="text" name="name" required>

    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Password:</label>
    <input type="password" name="password" required>

    <button type="submit">Register</button>
</form>

<p>Already have an account? <a href="login.php">Login</a></p>

</body>
</html>
