<?php
include "../db.php";
$id = $_GET['id'];
 
$get = mysqli_query($conn, "SELECT * FROM services WHERE service_id = $id");
$service = mysqli_fetch_assoc($get);
 
$message = "";
 
if (isset($_POST['update'])) {
  $name = $_POST['service_name'];
  $desc = $_POST['description'];
  $rate = $_POST['hourly_rate'];
  $active = $_POST['is_active'];
 
  if ($name == "") {
    $message = "Service Name is required!";
  } else {
    mysqli_query($conn, "UPDATE services
      SET service_name='$name', description='$desc', hourly_rate='$rate', is_active='$active'
      WHERE service_id=$id");
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
  <title>Edit Service</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include "../nav.php"; ?>

<div class="container">
  <div class="page-header">
    <h2>Edit Service</h2>
    <p>Update service information</p>
  </div>

  <?php if($message): ?>
    <div class="alert alert-danger"><?php echo $message; ?></div>
  <?php endif; ?>

  <form method="post" style="max-width: 500px;">
    <div class="form-group">
      <label>Service Name *</label>
      <input type="text" name="service_name" value="<?php echo htmlspecialchars($service['service_name']); ?>" required>
    </div>

    <div class="form-group">
      <label>Description</label>
      <textarea name="description" rows="4"><?php echo htmlspecialchars($service['description']); ?></textarea>
    </div>

    <div class="form-group">
      <label>Hourly Rate</label>
      <input type="text" name="hourly_rate" value="<?php echo $service['hourly_rate']; ?>">
    </div>

    <div class="form-group">
      <label>Active</label>
      <select name="is_active">
        <option value="1" <?php if($service['is_active']==1) echo "selected"; ?>>Yes</option>
        <option value="0" <?php if($service['is_active']==0) echo "selected"; ?>>No</option>
      </select>
    </div>

    <button type="submit" name="update" class="btn btn-success">Update Service</button>
    <a href="services_list.php" class="btn btn-primary">Cancel</a>
  </form>
</div>

<div class="footer">Assessment &copy; 2026</div>

</body>
</html>