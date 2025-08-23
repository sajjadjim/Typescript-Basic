<?php
require 'db.php';

// Get row by id
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

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
  <form method="post" action="update.php">
    <input type="hidden" name="id" value="<?= htmlspecialchars($student['id']) ?>">

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
