<?php
include "../db.php";
$result = mysqli_query($conn, "SELECT * FROM clients ORDER BY client_id DESC");
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Clients</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include "../nav.php"; ?>

<div class="container">
  <div class="page-header">
    <h2>Clients</h2>
    <p>Manage your client records</p>
  </div>

  <div class="quick-links" style="margin-bottom: 20px;">
    <a class="btn btn-primary" href="clients_add.php">+ Add Client</a>
  </div>

  <table>
    <tr>
      <th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Action</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)) { ?>
      <tr>
        <td><?php echo $row['client_id']; ?></td>
        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
        <td><?php echo htmlspecialchars($row['email']); ?></td>
        <td><?php echo htmlspecialchars($row['phone']); ?></td>
        <td>
          <a class="btn btn-primary" style="padding:6px 12px;font-size:0.8rem;" href="clients_edit.php?id=<?php echo $row['client_id']; ?>">Edit</a>
        </td>
      </tr>
    <?php } ?>
  </table>
</div>

<div class="footer">Assessment &copy; 2026</div>

</body>
</html>