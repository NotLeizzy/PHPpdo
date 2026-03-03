<?php
require 'insert.php';
require 'update.php';
require 'delete.php';
require 'select.php';
?>

<h2 style="color: darkgray; text-align: left; font-family: 'Segoe UI', sans-serif;">Simple PDO CRUD</h2>
<?php
// CHECK IF EDIT MODE
$editUser = null;

if (isset($_GET['edit'])) {
  $users_id = $_GET['edit'];
  $stmt = $pdo->prepare("SELECT * FROM users WHERE users_id = ?");
  $stmt->execute([$users_id]);
  $editUser = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PDO User and Order List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="landingStyle.css">
</head>
<body>

<div class="container mt-5">
  <div class="row">

    <!-- Add/Edit User Form -->
    <div class="col-md-4">
      <div class="card p-4 shadow-sm">
        <h5 class="card-title text-center mb-3">
          <?= $editUser ? 'Update User' : 'Add User' ?>
        </h5>
        <form method="POST">

          <?php if (!empty($editUser)): ?>
              <input type="hidden" name="users_id" value="<?= $editUser['users_id'] ?>">
          <?php endif; ?>

          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" name="name"
                   value="<?= !empty($editUser) ? $editUser['name'] : '' ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email"
                   value="<?= !empty($editUser) ? $editUser['email'] : '' ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Product</label>
            <input type="text" class="form-control" name="product" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Amount</label>
            <input type="number" step="0.01" class="form-control" name="amount" required>
          </div>

          <div class="d-flex justify-content-between">
            <?php if (!empty($editUser)): ?>
                <button type="submit" name="update" class="btn btn-primary w-100 me-2">Update</button>
                <a href="landing.php" class="btn btn-outline-secondary w-100">Cancel</a>
            <?php else: ?>
                <button type="submit" name="add" class="btn btn-success w-100">Add User</button>
            <?php endif; ?>
          </div>

        </form>
      </div>
    </div>

    <!-- User List Table -->
    <div class="col-md-8">
      <div class="card p-4 shadow-sm">
        <h5 class="card-title mb-3">User List</h5>
        <table class="table table-striped table-hover">
          <thead class="table-dark">
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Product</th>
              <th>Amount</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
              <td><?= $user['users_id'] ?></td>
              <td><?= $user['name'] ?></td>
              <td><?= $user['email'] ?></td>
              <td><?= $user['product'] ?></td>
              <td class="text-success">₱<?= number_format($user['amount'], 2) ?></td>
              <td class="text-center">
                <a href="?edit=<?= $user['users_id'] ?>" class="btn btn-warning btn-sm me-2">Edit</a>
                <a href="?delete=<?= $user['users_id'] ?>" class="btn btn-danger btn-sm">Delete</a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

</body>
</html>