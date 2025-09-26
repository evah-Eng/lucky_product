<?php
session_start();
require 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$msg = "";
$order_id = null;
$total = 0;

// PLACE ORDER
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['pay_now'])) {
        // Handle simulated payment
        $order_id = (int)$_POST['order_id'];
        $amount = (int)$_POST['amount'];
        $method = $_POST['method'];
        $msg = "✅ Payment of " . number_format($amount) . " TSH via $method for Order #$order_id received!";
    } else {
        // Handle new order
        $user_id = $_SESSION['user_id'];
        $name = htmlspecialchars(trim($_POST['name']));
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $contact = htmlspecialchars(trim($_POST['contact']));
        $location = htmlspecialchars(trim($_POST['location']));
        $qty500  = (int)($_POST['qty500'] ?? 0);
        $qty1000 = (int)($_POST['qty1000'] ?? 0);
        $total   = ($qty500 * 500) + ($qty1000 * 1000);

        if ($total > 0) {
            $stmt = $conn->prepare("INSERT INTO orders 
                (user_id, name, email, contact_number, location, qty500, qty1000, total) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssiiii", 
                $user_id, $name, $email, $contact, $location, $qty500, $qty1000, $total);

            if ($stmt->execute()) {
                $order_id = $stmt->insert_id;
                $msg = "✅ Order placed successfully (Order #$order_id). Total: " . number_format($total) . " TSH.";
            } else {
                $msg = "❌ Error placing order. Try again.";
            }
            $stmt->close();
        } else {
            $msg = "⚠️ Select at least one product before ordering.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order & Payment</title>
<style>
    body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
    h2 { color: #333; }
    .msg { font-weight: bold; color: green; margin-bottom: 20px; }
    .pay { border: 1px solid #ccc; padding: 15px; border-radius: 8px; margin-bottom: 20px; background: #fff; }
    .m-pesa-flex { display: flex; align-items: center; gap: 15px; }
    .delivery-image img { max-width: 120px; height: auto; border-radius: 6px; }
    form input, form button { margin: 5px 0; padding: 8px; border-radius: 4px; border: 1px solid #ccc; }
    form button { background-color: #28a745; color: white; cursor: pointer; border: none; }
    form button:hover { background-color: #218838; }
</style>
</head>
<body>

<h2>Place Your Order</h2>

<?php if (!empty($msg)) : ?>
    <p class="msg"><?= $msg; ?></p>
<?php endif; ?>

<?php if (!$order_id) : ?>
<!-- Order Form -->
<form method="post">
    <input type="text" name="name" placeholder="Your Name" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="text" name="contact" placeholder="Contact Number" required><br>
    <input type="text" name="location" placeholder="Delivery Location" required><br>
    <label>Qty 500 TSH Product:</label>
    <input type="number" name="qty500" value="0" min="0"><br>
    <label>Qty 1000 TSH Product:</label>
    <input type="number" name="qty1000" value="0" min="0"><br>
    <button type="submit">Place Order</button>
</form>
<?php else: ?>
<!-- Payment Options -->
<h2>Payment Options for Order #<?= $order_id ?></h2>

<div class="pay">
    <h3>Bank Transfer</h3>
    <p>Account: Lucky Product</p>
    <p>Account Number: 1234567890</p>
    <p>Bank: ABC Bank</p>
    <p><strong>Total: <?= number_format($total) ?> TSH</strong></p>
</div>

<div class="pay m-pesa-flex">
    <div>
        <h3>M-Pesa Payment</h3>
        <p>Paybill: 0747456589</p>
        <p>Account Name: Rachel Yohana Kalidushi</p>
        <p><strong>Total: <?= number_format($total) ?> TSH</strong></p>
    </div>
    <div class="delivery-image">
        <img src="./img/m-pesa.png" alt="M-Pesa">
    </div>
</div>

<!-- Simulate Payment -->
<form method="post">
    <input type="hidden" name="order_id" value="<?= $order_id ?>">
    <input type="hidden" name="amount" value="<?= $total ?>">
    <input type="hidden" name="method" value="M-Pesa">
    <button type="submit" name="pay_now">Simulate Payment</button>
</form>

<?php endif; ?>

</body>
</html>

