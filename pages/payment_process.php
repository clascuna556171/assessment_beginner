<?php
include "../config/db.php";
 
 
$booking_id = $_GET['booking_id'];
 
 
$booking = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM bookings WHERE booking_id=$booking_id"));
 
 
$paidRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS paid FROM payments WHERE booking_id=$booking_id"));
$total_paid = $paidRow['paid'];
 
 
$balance = $booking['total_cost'] - $total_paid;
$message = "";
 
 
if (isset($_POST['pay'])) {
  $amount = $_POST['amount_paid'];
  $method = $_POST['method'];
 
 
  if ($amount <= 0) {
    $message = "Invalid amount!";
  } else if ($amount > $balance) {
    $message = "Amount exceeds balance!";
  } else {
 
 
    // 1) Insert payment
    mysqli_query($conn, "INSERT INTO payments (booking_id, amount_paid, method)
      VALUES ($booking_id, $amount, '$method')");
 
 
    // 2) Recompute total paid (after insert)
    $paidRow2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS paid FROM payments WHERE booking_id=$booking_id"));
    $total_paid2 = $paidRow2['paid'];
 
 
    // 3) Recompute new balance
    $new_balance = $booking['total_cost'] - $total_paid2;
 
 
    // 4) If fully paid, update booking status to PAID
    if ($new_balance <= 0.009) {
      mysqli_query($conn, "UPDATE bookings SET status='PAID' WHERE booking_id=$booking_id");
    }
 
 
    header("Location: bookings_list.php");
    exit;
  }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Process Payment</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include "../components/nav.php"; ?>

<div class="container">
  <div class="page-header">
    <h2>Process Payment (Booking #<?php echo $booking_id; ?>)</h2>
    <p>Record payment and update booking status</p>
  </div>

  <div class="summary-card" style="max-width: 560px; margin-bottom: 20px;">
    <p>Total Cost: <strong>₱<?php echo number_format($booking['total_cost'],2); ?></strong></p>
    <p>Total Paid: <strong>₱<?php echo number_format($total_paid,2); ?></strong></p>
    <p>Balance: <strong>₱<?php echo number_format($balance,2); ?></strong></p>
  </div>

<?php if($message): ?>
  <div class="alert alert-danger" style="max-width: 560px;"><?php echo $message; ?></div>
<?php endif; ?>

<form method="post" class="form-card" style="max-width: 560px;">
  <div class="form-group">
  <label>Amount Paid</label>
  <input type="number" name="amount_paid" step="0.01"><br><br>
  </div>

  <div class="form-group">
  <label>Method</label>
  <select name="method">
    <option value="CASH">CASH</option>
    <option value="GCASH">GCASH</option>
    <option value="CARD">CARD</option>
  </select><br><br>
  </div>

  <button type="submit" name="pay" class="btn btn-success">Save Payment</button>
  <a href="bookings_list.php" class="btn btn-primary">Back</a>
</form>

</div>

<div class="footer">Assessment &copy; 2026</div>
</body>
</html>