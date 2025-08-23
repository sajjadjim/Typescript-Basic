<?php
require 'db.php';

// Insert when form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name  = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $sid   = trim($_POST['sid'] ?? '');

  if ($name !== '' && $email !== '' && $sid !== '') {
    // Simple prepared statement to avoid SQL injection
    $stmt = mysqli_prepare($conn, "INSERT INTO students (name, email, sid) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sss", $name, $email, $sid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
  }
  // refresh page so reloading doesn't double-submit
  header("Location: index.php");
  exit;
}

// Get all rows
$result = mysqli_query($conn, "SELECT * FROM students ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Simple Student CRUD</title>
  <script>
    function validateForm() {
      let name  = document.forms["studentForm"]["name"].value.trim();
      let email = document.forms["studentForm"]["email"].value.trim();
      let sid   = document.forms["studentForm"]["sid"].value.trim();

      if (name === "" || email === "" || sid === "") {
        alert("All fields are required!");
        return false;
      }

      // Simple email pattern check
      let emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,}$/;
      if (!email.match(emailPattern)) {
        alert("Please enter a valid email address.");
        return false;
      }

      // SID length check (example: at least 3 characters)
      if (sid.length < 3) {
        alert("SID must be at least 3 characters long.");
        return false;
      }

      return true; // allow form to submit
    }
  </script>
</head>
<body>
  <h2>Add Student</h2>
  <form name="studentForm" method="post" action="index.php" onsubmit="return validateForm()">
    <label>Name:</label><br>
    <input type="text" name="name"><br><br>

    <label>Email:</label><br>
    <input type="text" name="email"><br><br>

    <label>SID:</label><br>
    <input type="text" name="sid"><br><br>

    <button type="submit">Submit</button>
  </form>

  <hr>

  <h2>All Students</h2>
  <table border="1" cellpadding="6" cellspacing="0">
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>SID</th>
      <th>Actions</th>
    </tr>
    <?php if ($result && mysqli_num_rows($result) > 0): ?>
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
          <td><?= htmlspecialchars($row['id']) ?></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['sid']) ?></td>
          <td>
            <a href="edit.php?id=<?= $row['id'] ?>">Update</a> |
            <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this record?');">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="5">No data found.</td></tr>
    <?php endif; ?>
  </table>
</body>
</html>
