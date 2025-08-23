<?php
// ==== DB CONNECTION (XAMPP defaults) ====
$cn = new mysqli('localhost', 'root', '', 'simple_app');
if ($cn->connect_error) {
  die('DB connection failed: ' . $cn->connect_error);
}


// ==== DELETE ====

// ultra short code delete version 
if ($_GET['del'] ?? 0) {
  $cn->query("DELETE FROM students WHERE id=" . (int)$_GET['del']);
  header("Location:index.php");
  exit;
}


// ultra level easy code this one 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = (int)($_POST['id'] ?? 0);
  $name = $_POST['name'] ?? '';
  $email = $_POST['email'] ?? '';
  $sid = $_POST['sid'] ?? '';
  if ($name && $email && $sid) {
    $sql = $id ?
      "UPDATE students SET name='$name',email='$email',sid='$sid' WHERE id=$id" :
      "INSERT INTO students(name,email,sid) VALUES('$name','$email','$sid')";
    $cn->query($sql);
  }
  header('Location:index.php');
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
      if (!name || !email || !sid) {
        alert("All fields are required!");
        return false;
      }
      const emailOk = /^[^ ]+@[^ ]+\.[a-z]{2,}$/i.test(email);
      if (!emailOk) {
        alert("Please enter a valid email address.");
        return false;
      }
      if (sid.length < 3) {
        alert("SID must be at least 3 characters.");
        return false;
      }
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


  <!-- data show on the website  -->
  <h2>All Students</h2>
  <table border="1" cellpadding="6" cellspacing="0">
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>SID</th>
      <th>Actions</th>
    </tr>

    <?php while ($r = $all->fetch_assoc()): ?>
      <tr>
        <td><?= (int)$r['id'] ?></td>
        <td><?= htmlspecialchars($r['name']) ?></td>
        <td><?= htmlspecialchars($r['email']) ?></td>
        <td><?= htmlspecialchars($r['sid']) ?></td>
        <td>
          <a href="?edit=<?= (int)$r['id'] ?>">Update</a> |
          <a href="?del=<?= (int)$r['id'] ?>">Delete</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>
</body>

</html>