<?php
require 'db.php';

// 1) Get the ID safely
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
  die("Invalid ID.");
}

// 2) If the form was submitted, update the row, then go back to index.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Very basic trimming (simple level)
  $name  = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $sid   = trim($_POST['sid'] ?? '');

  if ($name !== '' && $email !== '' && $sid !== '') {
    // Simple prepared update
    $stmt = mysqli_prepare($conn, "UPDATE students SET name = ?, email = ?, sid = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "sssi", $name, $email, $sid, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Go back to list page
    header("Location: index.php");
    exit;
  } else {
    $error = "All fields are required.";
  }
}

// 3) Load current data to show in the form
$stmt = mysqli_prepare($conn, "SELECT id, name, email, sid FROM students WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$student = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$student) {
  die("Record not found.");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit Student</title>
</head>
<body>
  <h2>Edit Student (ID: <?= htmlspecialchars($student['id']) ?>)</h2>

  <?php if (!empty($error)): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

  <form method="post">
    <label>Name:</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($student['name']) ?>" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= htmlspecialchars($student['email']) ?>" required><br><br>

    <label>SID:</label><br>
    <input type="text" name="sid" value="<?= htmlspecialchars($student['sid']) ?>" required><br><br>

    <button type="submit">Update</button>
    <a href="index.php">Cancel</a>
  </form>
</body>
</html>
