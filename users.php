<?php
include 'db.php';

// Add User
if(isset($_POST['add'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $membership = $_POST['membership'];
    $conn->query("INSERT INTO users (name,email,membership_type) VALUES ('$name','$email','$membership')");
}

// Delete User
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE user_id='$id'");
}

// Search & Filter
$search = $_GET['search'] ?? '';
$order = $_GET['order'] ?? 'user_id';
$result = $conn->query("SELECT * FROM users WHERE name LIKE '%$search%' OR email LIKE '%$search%' ORDER BY $order");
?>
<!DOCTYPE html>
<html>
<head>
<title>Users</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
<h2>Users</h2>

<form class="row g-3 mb-3" method="GET">
  <div class="col-auto"><input type="text" name="search" class="form-control" placeholder="Search" value="<?php echo $search; ?>"></div>
  <div class="col-auto">
    <select name="order" class="form-select">
      <option value="user_id">ID</option>
      <option value="name">Name</option>
      <option value="email">Email</option>
    </select>
  </div>
  <div class="col-auto"><button type="submit" class="btn btn-primary">Search</button></div>
</form>

<form method="POST" class="row g-3 mb-3">
  <div class="col"><input type="text" name="name" class="form-control" placeholder="Name" required></div>
  <div class="col"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
  <div class="col"><input type="text" name="membership" class="form-control" placeholder="Membership Type"></div>
  <div class="col-auto"><input type="submit" name="add" class="btn btn-success" value="Add User"></div>
</form>

<table class="table table-striped table-bordered">
<thead>
<tr><th>ID</th><th>Name</th><th>Email</th><th>Membership</th><th>Action</th></tr>
</thead>
<tbody>
<?php
while($row = $result->fetch_assoc()){
    echo "<tr>
        <td>{$row['user_id']}</td>
        <td>{$row['name']}</td>
        <td>{$row['email']}</td>
        <td>{$row['membership_type']}</td>
        <td><a href='users.php?delete={$row['user_id']}' class='btn btn-danger btn-sm'>Delete</a></td>
    </tr>";
}
?>
</tbody>
</table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
