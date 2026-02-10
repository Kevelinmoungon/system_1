โค้ดที่ให้ไปในครั้งล่าสุด **ถูกต้องแล้วครับ** สอดคล้องกับโครงสร้างตารางที่คุณแจ้งมา 100% ไม่ต้องเปลี่ยนอะไรในส่วนของชื่อตัวแปร (Column) แล้วครับ

นี่คือการยืนยันว่าโค้ดตรงกับฐานข้อมูลของคุณหรือไม่:
*   `id` -> ใช้รับค่า $_GET['id'] (ถูกต้อง)
*   `name` -> ใช้ใน SQL SELECT/UPDATE (ถูกต้อง)
*   `email` -> ใช้ใน SQL SELECT/UPDATE (ถูกต้อง)
*   `password` -> ใช้ใน SQL UPDATE (ถูกต้อง)
*   `role` -> ใช้ใน SQL SELECT/UPDATE (ถูกต้อง)
*   `created_at` -> ใช้แสดงผล (ถูกต้อง)

**เงื่อนไขสำคัญ:**
เพื่อให้โค้ดชุดนี้ทำงานได้ คุณต้องแน่ใจว่า:
1.  ชื่อฐานข้อมูล (Database) ชื่อ `systemuser`
2.  ชื่อตาราง (Table) ชื่อ `users`
3.  ชื่อไฟล์เชื่อมต่อคือ `db.php` และมีการเชื่อมต่อไปยังฐาน `systemuser` อยู่แล้ว (ตามที่ผมแนะนำในข้อก่อนหน้า)

**โค้ดฉบับสมบูรณ์ (พร้อมใช้งาน):**

```php
<?php
include 'db.php'; 

// ตรวจสอบ ID ที่ส่งมา
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header("Location: account.php");
    exit();
}

// ดึงข้อมูลจากตาราง users
$result = $conn->query("SELECT * FROM users WHERE id='$id'");

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    die("ไม่พบข้อมูลผู้ใช้งาน (ID: $id)");
}

// ตรวจสอบการกดปุ่มแก้ไข
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับค่าจากฟอร์ม ตรงกับ Column ในตาราง
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $new_password = $_POST['password'];
    
    // ลอจิกสำหรับรหัสผ่าน: ถ้ากรอกใหม่ก็อัปเดต ถ้าไม่กรอกก็เก็บค่าเดิม
    if (!empty($new_password)) {
        $sql = "UPDATE users SET 
                name='$name', 
                email='$email', 
                role='$role', 
                password='$new_password' 
                WHERE id='$id'";
    } else {
        $sql = "UPDATE users SET 
                name='$name', 
                email='$email', 
                role='$role' 
                WHERE id='$id'";
    }
            
    if ($conn->query($sql) === TRUE) {
        header("Location: account.php");
        exit();
    } else {
        echo "ผิดพลาด: " . $conn->error;
    }
}
?>

<form method="POST">
    <!-- ตรงกับ Column: name -->
    ชื่อ: <input type="text" name="name" value="<?=$user['name']?>" required><br>
    
    <!-- ตรงกับ Column: email -->
    อีเมล: <input type="email" name="email" value="<?=$user['email']?>" required><br>
    
    <!-- ตรงกับ Column: password (ถ้ากรอกค่าว่างจะไม่อัปเดต) -->
    รหัสผ่าน (เว้นว่างถ้าไม่เปลี่ยน): 
    <input type="text" name="password" value=""><br>
    
    <!-- ตรงกับ Column: role -->
    บทบาท: <select name="role">
        <option value="user" <?=$user['role']=='user'?'selected':''?>>user</option>
        <option value="admin" <?=$user['role']=='admin'?'selected':''?>>admin</option>
    </select><br>
    
    <!-- ตรงกับ Column: created_at (แสดงอย่างเดียว) -->
    วันที่สร้าง: 
    <input type="text" value="<?=$user['created_at']?>" readonly style="background:#eee;"><br>
    
    <button type="submit">แก้ไข</button>
</form>
```