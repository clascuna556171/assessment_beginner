<?php
include "../db.php";
 
 
/* ============================
   SOFT DELETE (Deactivate)
   ============================ */
if (isset($_GET['delete_id'])) {
  $delete_id = $_GET['delete_id'];
 
 
  // Soft delete (set is_active to 0)
  mysqli_query($conn, "UPDATE services SET is_active=0 WHERE service_id=$delete_id");
 
 
  header("Location: services_list.php");
  exit;
}
 
 
/* ============================
   FETCH ALL SERVICES
   ============================ */
$result = mysqli_query($conn, "SELECT * FROM services ORDER BY service_id DESC");
?>
 
 
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Services</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
 
 
<?php include "../nav.php"; ?>
 

<div class="container">
  <div class="page-header">
    <h2>Services</h2>
    <p>Manage all service offerings</p>
  </div>

  <div class="quick-links" style="margin-bottom: 20px;">
    <a class="btn btn-primary" href="services_add.php">+ Add Service</a>
  </div>

  <table>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Rate</th>
      <th>Status</th>
      <th>Action</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($result)) { ?>
      <tr>
        <td><?php echo $row['service_id']; ?></td>
        <td><?php echo htmlspecialchars($row['service_name']); ?></td>
        <td>₱<?php echo number_format($row['hourly_rate'],2); ?></td>
        <td>
          <span class="status-badge <?php echo $row['is_active'] == 1 ? 'status-active' : 'status-inactive'; ?>">
            <?php echo $row['is_active'] == 1 ? 'Active' : 'Inactive'; ?>
          </span>
        </td>
        <td class="table-actions">
          <a class="btn btn-primary btn-sm" href="services_edit.php?id=<?php echo $row['service_id']; ?>">Edit</a>

          <?php if ($row['is_active'] == 1) { ?>
            <a class="btn btn-sm btn-danger" href="services_list.php?delete_id=<?php echo $row['service_id']; ?>"
               onclick="return confirm('Deactivate this service?')">
              Deactivate
            </a>
          <?php } ?>
        </td>
      </tr>
    <?php } ?>
  </table>
</div>

<div class="footer">Assessment &copy; 2026</div>

</body>
</html>