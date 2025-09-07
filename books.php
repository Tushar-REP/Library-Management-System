<?php
include 'db.php';
if(isset($_POST['add'])){
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $genre = $_POST['genre'];
    $conn->query("INSERT INTO books (title, author, isbn, genre) VALUES ('$title','$author','$isbn','$genre')");
}
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $conn->query("DELETE FROM books WHERE book_id='$id'");
}

$search = $_GET['search'] ?? '';
$order = $_GET['order'] ?? 'book_id';
$result = $conn->query("SELECT * FROM books WHERE title LIKE '%$search%' OR author LIKE '%$search%' ORDER BY $order");
?>
<!DOCTYPE html>
<html>
<head>
<title>Books</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
<h2>Books</h2>

<form class="row g-3 mb-3" method="GET">
  <div class="col-auto"><input type="text" name="search" class="form-control" placeholder="Search" value="<?php echo $search; ?>"></div>
  <div class="col-auto">
    <select name="order" class="form-select">
      <option value="book_id">ID</option>
      <option value="title">Title</option>
      <option value="author">Author</option>
    </select>
  </div>
  <div class="col-auto"><button type="submit" class="btn btn-primary">Search</button></div>
</form>

<form method="POST" class="row g-3 mb-3">
  <div class="col"><input type="text" name="title" class="form-control" placeholder="Title" required></div>
  <div class="col"><input type="text" name="author" class="form-control" placeholder="Author" required></div>
  <div class="col"><input type="text" name="isbn" class="form-control" placeholder="ISBN" required></div>
  <div class="col"><input type="text" name="genre" class="form-control" placeholder="Genre"></div>
  <div class="col-auto"><input type="submit" name="add" class="btn btn-success" value="Add Book"></div>
</form>

<table class="table table-striped table-bordered">
<thead>
<tr><th>ID</th><th>Title</th><th>Author</th><th>ISBN</th><th>Genre</th><th>Availability</th><th>Action</th></tr>
</thead>
<tbody>
<?php
while($row = $result->fetch_assoc()){
    $badge = $row['availability']=='Available' ? 'bg-success' : 'bg-warning text-dark';
    echo "<tr>
        <td>{$row['book_id']}</td>
        <td>{$row['title']}</td>
        <td>{$row['author']}</td>
        <td>{$row['isbn']}</td>
        <td>{$row['genre']}</td>
        <td><span class='badge $badge'>{$row['availability']}</span></td>
        <td><a href='books.php?delete={$row['book_id']}' class='btn btn-danger btn-sm'>Delete</a></td>
    </tr>";
}
?>
</tbody>
</table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
