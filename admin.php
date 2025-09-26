<?php
// Database connection
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "lucky_product";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch all orders
$sql = "SELECT * FROM orders ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin - Lucky Product Orders</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    body {font-family:'Poppins', sans-serif; background:#fdf2f8; color:#0f172a; margin:0; padding:20px;}
    h1 {text-align:center; color:#db2777;}
    table {width:100%; border-collapse:collapse; margin-top:20px;}
    th, td {border:1px solid #ddd; padding:12px; text-align:left;}
    th {background:#db2777; color:white;}
    tr:nth-child(even) {background:#f9e6f0;}
    tr:hover {background:#ffe0f2;}
    a {text-decoration:none;color:#db2777;font-weight:600;}
  </style>
</head>
<body>
  <h1>Lucky Product - Orders</h1>
  <a href="index.php">⬅ Go to Homepage</a>
  <table>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Contact Number</th>
      <th>Qty 500 TSH</th>
      <th>Qty 1000 TSH</th>
      <th>Total Price</th>
      <th>Submitted At</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".htmlspecialchars($row['id'])."</td>
                <td>".htmlspecialchars($row['name'])."</td>
                <td>".htmlspecialchars($row['email'])."</td>
                <td>".htmlspecialchars($row['contact_number'])."</td>
                <td>".htmlspecialchars($row['qty_500'])."</td>
                <td>".htmlspecialchars($row['qty_1000'])."</td>
                <td>".number_format($row['total_price'])." TSH</td>
                <td>".htmlspecialchars($row['created_at'])."</td>
              </tr>";
      }
    } else {
      echo "<tr><td colspan='8'>No orders found.</td></tr>";
    }
    $conn->close();
    ?>
  </table>
</body>
</html>
