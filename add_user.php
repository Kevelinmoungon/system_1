<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    
    $conn->query("INSERT INTO users (name, email, password, role) 
                  VALUES ('$name', '$email', '$password', '$role')");
    header("Location: account.php");
}
?>
<form method="POST">
    ชื่อ: <input type="text" name="name" required><br>
    อีเมล: <input type="email" name="email" required><br>
    รหัสผ่าน: <input type="password" name="password" required><br>
    บทบาท: <select name="role">
        <option value="user">user</option>
        <option value="admin">admin</option>
    </select><br>
    <button type="submit">บันทึก</button>
</form>