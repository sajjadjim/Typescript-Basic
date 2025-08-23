<?php
$db = new mysqli('localhost','root','','simple_app');
 if($db->connect_error) 
die($db->connect_error);

function h($s)
{
  return htmlspecialchars($s??'',ENT_QUOTES);
}

$edit = null;
if (isset($_GET['edit'])) 
    { 
        $id=(int)$_GET['edit']; 
        $s=$db->prepare("SELECT * FROM students WHERE id=?"); 
        $s->bind_param("i",$id); 
        $s->execute(); 
        $edit=$s->get_result()->fetch_assoc(); 
        $s->close(); 
    }

if (isset($_GET['del'])) 
     { 
        $id=(int)$_GET['del']; 
        $s=$db->prepare("DELETE FROM students WHERE id=?"); 
        $s->bind_param("i",$id); 
        $s->execute(); 
        $s->close(); 
        header("Location: index.php"); 
        exit; 
     }

if ($_SERVER['REQUEST_METHOD']==='POST') {
  $id=(int)($_POST['id']??0); 
  $name=trim($_POST['name']??''); 
  $email=trim($_POST['email']??''); 
  $sid=trim($_POST['sid']??'');
  if($name&&$email&&$sid){
    if($id){
      $s=$db->prepare("UPDATE students SET name=?,email=?,sid=? WHERE id=?"); 
      $s->bind_param("sssi",$name,$email,$sid,$id);
    } 
    else 
      {
      $s=$db->prepare("INSERT INTO students(name,email,sid) VALUES(?,?,?)");  
       $s->bind_param("sss",$name,$email,$sid);
    }
    $s->execute(); 
    $s->close();
  }
  header("Location: index.php"); exit;
}

$all = $db->query("SELECT * FROM students ORDER BY id DESC");
?>

<!doctype html><html><head><meta charset="utf-8"><title>Students</title></head><body>
<h3><?= $edit?'Edit Student':'Add Student' ?></h3>
<form method="post">
  <input type="hidden" name="id" value="<?= $edit?(int)$edit['id']:0 ?>">
  Name:  <input name="name"  value="<?= h($edit['name']  ??'') ?>"><br>
  Email: <input name="email" value="<?= h($edit['email'] ??'') ?>"><br>
  SID:   <input name="sid"   value="<?= h($edit['sid']   ??'') ?>"><br>
<button><?= $edit?'Update':'Submit' ?>
</button> <?= $edit?'<a href="index.php">Cancel</a>':'' ?>
</form>

<hr><h3>All Students</h3>
<table border="1" cellpadding="6" cellspacing="0">
<tr><th>ID</th><th>Name</th><th>Email</th><th>SID</th><th>Actions</th></tr>
<?php while($r=$all->fetch_assoc()): ?>
<tr>
  <td><?= (int)$r['id'] ?></td>
  <td><?= h($r['name']) ?></td>
  <td><?= h($r['email']) ?></td>
  <td><?= h($r['sid']) ?></td>
  <td><a href="?edit=<?= (int)$r['id'] ?>">Edit</a> | <a href="?del=<?= (int)$r['id'] ?>" onclick="return confirm('Delete?')">Delete</a></td>
</tr>
<?php endwhile; ?>
</table>
</body></html>
