<?php
// ==== DB CONNECTION (XAMPP defaults) ====
$cn = new mysqli('localhost', 'root', '', 'simple_app');
if ($cn->connect_error) { die('DB connection failed: ' . $cn->connect_error); }

// (Optional) If table not created yet, uncomment below once to auto-create it.
// $cn->query("CREATE TABLE IF NOT EXISTS students (
//   id INT AUTO_INCREMENT PRIMARY KEY,
//   name VARCHAR(100) NOT NULL,
//   email VARCHAR(150) NOT NULL,
//   sid VARCHAR(50) NOT NULL
// )");

// ==== DELETE ====
if (isset($_GET['del'])) {
  $id = (int) $_GET['del'];
  if ($id > 0) {
    $stmt = $cn->prepare("DELETE FROM students WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
  }
  header("Location: index.php");
  exit;
}

// ==== EDIT (load one row to prefill form) ====
$editId = 0;
$editRow = null;
if (isset($_GET['edit'])) {
  $editId = (int) $_GET['edit'];
  if ($editId > 0) {
    $stmt = $cn->prepare("SELECT id, name, email, sid FROM students WHERE id=?");
    $stmt->bind_param("i", $editId);
    $stmt->execute();
    $res = $stmt->get_result();
    $editRow = $res->fetch_assoc();
    $stmt->close();
  }
}

// ==== CREATE / UPDATE (same form) ====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id    = (int)($_POST['id'] ?? 0);
  $name  = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $sid   = trim($_POST['sid'] ?? '');

  if ($name !== '' && $email !== '' && $sid !== '') {
    if ($id > 0) {
      // UPDATE
      $stmt = $cn->prepare("UPDATE students SET name=?, email=?, sid=? WHERE id=?");
      $stmt->bind_param("sssi", $name, $email, $sid, $id);
      $stmt->execute();
      $stmt->close();
    } else {
      // INSERT
      $stmt = $cn->prepare("INSERT INTO students (name, email, sid) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $name, $email, $sid);
      $stmt->execute();
      $stmt->close();
    }
  }
  header("Location: index.php");
  exit;
}

// ==== LIST ALL ====
$all = $cn->query("SELECT * FROM students ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Simple Student CRUD (Single File)</title>
  <script>
    function validateForm() {
      const f = document.forms["studentForm"];
      const name = f["name"].value.trim();
      const email = f["email"].value.trim();
      const sid = f["sid"].value.trim();
      if (!name || !email || !sid) { alert("All fields are required!"); return false; }
      const emailOk = /^[^ ]+@[^ ]+\.[a-z]{2,}$/i.test(email);
      if (!emailOk) { alert("Please enter a valid email address."); return false; }
      if (sid.length < 3) { alert("SID must be at least 3 characters."); return false; }
      return true;
    }
    function confirmDel(id) {
      return confirm("Delete record ID " + id + "?");
    }
  </script>
</head>
<body>
  <h2><?= $editRow ? 'Edit Student' : 'Add Student' ?></h2>

  <form name="studentForm" method="post" onsubmit="return validateForm()">
    <input type="hidden" name="id" value="<?= $editRow ? (int)$editRow['id'] : 0; ?>">

    <label>Name:</label><br>
    <input type="text" name="name" value="<?= $editRow ? htmlspecialchars($editRow['name']) : '' ?>"><br><br>

    <label>Email:</label><br>
    <input type="text" name="email" value="<?= $editRow ? htmlspecialchars($editRow['email']) : '' ?>"><br><br>

    <label>SID:</label><br>
    <input type="text" name="sid" value="<?= $editRow ? htmlspecialchars($editRow['sid']) : '' ?>"><br><br>

    <button type="submit"><?= $editRow ? 'Update' : 'Submit' ?></button>
    <?php if ($editRow): ?>
      <a href="index.php">Cancel Edit</a>
    <?php endif; ?>
  </form>

  <hr>

  <h2>All Students</h2>
  <table border="1" cellpadding="6" cellspacing="0">
    <tr>
      <th>ID</th><th>Name</th><th>Email</th><th>SID</th><th>Actions</th>
    </tr>
    <?php if ($all && $all->num_rows > 0): ?>
      <?php while ($r = $all->fetch_assoc()): ?>
        <tr>
          <td><?= (int)$r['id'] ?></td>
          <td><?= htmlspecialchars($r['name']) ?></td>
          <td><?= htmlspecialchars($r['email']) ?></td>
          <td><?= htmlspecialchars($r['sid']) ?></td>
          <td>
            <a href="?edit=<?= (int)$r['id'] ?>">Update</a> |
            <a href="?del=<?= (int)$r['id'] ?>" onclick="return confirmDel(<?= (int)$r['id'] ?>)">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="5">No data found.</td></tr>
    <?php endif; ?>
  </table>
</body>
</html>
