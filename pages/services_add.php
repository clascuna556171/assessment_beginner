<?php
include "../db.php";
 
$message = "";
 
if (isset($_POST['save'])) {
  $service_name = $_POST['service_name'];
  $description = $_POST['description'];
  $hourly_rate = $_POST['hourly_rate'];
  $is_active = $_POST['is_active'];
 
  // simple validation
  if ($service_name == "" || $hourly_rate == "") {
    $message = "Service name and hourly rate are required!";
  } else if (!is_numeric($hourly_rate) || $hourly_rate <= 0) {
    $message = "Hourly rate must be a number greater than 0.";
  } else {
    $sql = "INSERT INTO services (service_name, description, hourly_rate, is_active)
            VALUES ('$service_name', '$description', '$hourly_rate', '$is_active')";
    mysqli_query($conn, $sql);
 
    header("Location: services_list.php");
    exit;
  }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Service</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include "../nav.php"; ?>

<div class="container">
  <div class="page-header">
    <h2>Add Service</h2>
    <p>Create a new service offering</p>
  </div>

  <?php if($message): ?>
    <div class="alert alert-danger"><?php echo $message; ?></div>
  <?php endif; ?>

  <form method="post" style="max-width: 520px;">
    <div class="form-group">
      <label>Service Name *</label>
      <input type="text" name="service_name" required>
    </div>

    <div class="form-group">
      <label>Description</label>
      <textarea name="description" rows="4"></textarea>
    </div>

    <div class="form-group">
      <label>Hourly Rate (₱) *</label>
      <input type="number" name="hourly_rate" step="0.01" min="0.01" required>
    </div>

    <div class="form-group">
      <label>Active?</label>
      <select name="is_active">
        <option value="1">Yes</option>
        <option value="0">No</option>
      </select>
    </div>

    <button type="submit" name="save" class="btn btn-success">Save Service</button>
    <a href="services_list.php" class="btn btn-primary">Cancel</a>
  </form>
</div>

<div class="footer">Assessment &copy; 2026</div>

</body>
</html>