<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Library LMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Library LMS</a>
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="books.php">Books</a></li>
        <li class="nav-item"><a class="nav-link" href="users.php">Users</a></li>
        <li class="nav-item"><a class="nav-link" href="transactions.php">Transactions</a></li>
    </ul>
  </div>
</nav>

<div class="container">
    <h1>Dashboard</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card p-3 mb-3 bg-light">
                <h5>Total Books</h5>
                <p><?php echo $conn->query("SELECT COUNT(*) as total FROM books")->fetch_assoc()['total']; ?></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 mb-3 bg-light">
                <h5>Total Users</h5>
                <p><?php echo $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total']; ?></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 mb-3 bg-light">
                <h5>Books Issued</h5>
                <p><?php echo $conn->query("SELECT COUNT(*) as total FROM books WHERE availability='Issued'")->fetch_assoc()['total']; ?></p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
