<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>รายชื่อผู้ใช้</title>
</head>
<body>
    <h2>รายชื่อผู้ใช้</h2>
    <a href="add_user.php">เพิ่มผู้ใช้ใหม่</a>
    <br><br>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>ชื่อ</th>
            <th>อีเมล</th>
            <th>บทบาท</th>
            <th>วันที่สร้าง</th>
            <th>จัดการ</th>
        </tr>
        <?php
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);
        
        if (!$result) {
            die("Query ผิดพลาด: " . $conn->error);
        }
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['role']}</td>
                    <td>{$row['created_at']}</td>
                    <td>
                        <a href='edit_user.php?id={$row['id']}'>แก้ไข</a> | 
                        <a href='delete_user.php?id={$row['id']}' onclick='return confirm(\"แน่ใจหรือไม่?\")'>ลบ</a>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>ไม่มีข้อมูล</td></tr>";
        }
        ?>
    </table>
</body>
</html>
