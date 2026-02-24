<?php
include "../db.php";
 
$message = "";
 
if (isset($_POST['save'])) {
  $full_name = $_POST['full_name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
 
  if ($full_name == "" || $email == "") {
    $message = "Name and Email are required!";
  } else {
    $sql = "INSERT INTO clients (full_name, email, phone, address)
            VALUES ('$full_name', '$email', '$phone', '$address')";
    mysqli_query($conn, $sql);
    header("Location: clients_list.php");
    exit;
  }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Client</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include "../nav.php"; ?>

<div class="container">
  <div class="page-header">
    <h2>Add Client</h2>
    <p>Create a new client record</p>
  </div>

  <?php if($message): ?>
    <div class="alert alert-danger"><?php echo $message; ?></div>
  <?php endif; ?>

  <form method="post" style="max-width: 500px;">
    <div class="form-group">
      <label>Full Name *</label>
      <input type="text" name="full_name" required>
    </div>

    <div class="form-group">
      <label>Email *</label>
      <input type="email" name="email" required>
    </div>

    <div class="form-group">
      <label>Phone</label>
      <input type="text" name="phone">
    </div>

    <div class="form-group">
      <label>Address</label>
      <input type="text" name="address">
    </div>

    <button type="submit" name="save" class="btn btn-success">Save Client</button>
    <a href="clients_list.php" class="btn btn-primary">Cancel</a>
  </form>
</div>

<div class="footer">Assessment &copy; 2026</div>

</body>
</html>