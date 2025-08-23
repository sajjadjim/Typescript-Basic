<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id    = (int)($_POST['id'] ?? 0);
  $name  = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $sid   = trim($_POST['sid'] ?? '');

  if ($id > 0 && $name !== '' && $email !== '' && $sid !== '') {
    $stmt = mysqli_prepare($conn, "UPDATE students SET name = ?, email = ?, sid = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "sssi", $name, $email, $sid, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
  }
}

header("Location: index.php");
exit;
