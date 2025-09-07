<?php
include 'db.php';
$fine_per_day = 5;

// Issue Book
if(isset($_POST['issue'])){
    $book_id = $_POST['book_id'];
    $user_id = $_POST['user_id'];
    $date = date('Y-m-d');
    $availability = $conn->query("SELECT availability FROM books WHERE book_id='$book_id'")->fetch_assoc()['availability'];
    if($availability == 'Available'){
        $conn->query("INSERT INTO transactions (book_id,user_id,issue_date) VALUES ('$book_id','$user_id','$date')");
        $conn->query("UPDATE books SET availability='Issued' WHERE book_id='$book_id'");
    } else {
        $msg = "Book is already issued!";
    }
}

// Return Book
if(isset($_POST['return'])){
    $trans_id = $_POST['transaction_id'];
    $date = date('Y-m-d');
    $book_id = $conn->query("SELECT book_id FROM transactions WHERE transaction_id='$trans_id'")->fetch_assoc()['book_id'];
    $conn->query("UPDATE transactions SET return_date='$date', status='Returned' WHERE transaction_id='$trans_id'");
    $conn->query("UPDATE books SET availability='Available' WHERE book_id='$book_id'");
}

// Search & Filter
$search = $_GET['search'] ?? '';
$result = $conn->query("SELECT * FROM transactions 
    WHERE transaction_id LIKE '%$search%' OR book_id LIKE '%$search%' OR user_id LIKE '%$search%'");
?>
<!DOCTYPE html>
<html>
<head>
<title>Transactions</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
<h2>Transactions</h2>

<?php if(isset($msg)) echo "<div class='alert alert-warning'>$msg</div>"; ?>

<h4>Issue Book</h4>
<form method="POST" class="row g-3 mb-3">
  <div class="col"><input type="number" name="book_id" class="form-control" placeholder="Book ID" required></div>
  <div class="col"><input type="number" name="user_id" class="form-control" placeholder="User ID" required></div>
  <div class="col-auto"><input type="submit" name="issue" class="btn btn-success" value="Issue Book"></div>
</form>

<h4>Return Book</h4>
<form method="POST" class="row g-3 mb-3">
  <div class="col"><input type="number" name="transaction_id" class="form-control" placeholder="Transaction ID" required></div>
  <div class="col-auto"><input type="submit" name="return" class="btn btn-primary" value="Return Book"></div>
</form>

<h4>All Transactions</h4>
<form method="GET" class="row g-3 mb-3">
  <div class="col-auto"><input type="text" name="search" class="form-control" placeholder="Search by ID/Book/User" value="<?php echo $search; ?>"></div>
  <div class="col-auto"><button type="submit" class="btn btn-primary">Search</button></div>
</form>

<table class="table table-striped table-bordered">
<thead>
<tr><th>ID</th><th>Book ID</th><th>User ID</th><th>Issue Date</th><th>Return Date</th><th>Status</th><th>Fine</th></tr>
</thead>
<tbody>
<?php
while($row = $result->fetch_assoc()){
    $fine = 0;
    if($row['status']=='Issued'){
        $issued = new DateTime($row['issue_date']);
        $today = new DateTime();
        $days = $today->diff($issued)->days;
        if($days>14) $fine = ($days-14)*$fine_per_day;
    }
    echo "<tr>
        <td>{$row['transaction_id']}</td>
        <td>{$row['book_id']}</td>
        <td>{$row['user_id']}</td>
        <td>{$row['issue_date']}</td>
        <td>{$row['return_date']}</td>
        <td>{$row['status']}</td>
        <td>₹$fine</td>
    </tr>";
}
?>
</tbody>
</table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
