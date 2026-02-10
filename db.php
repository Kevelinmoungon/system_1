<?php
// แก้ตรงนี้ให้ชื่อฐานข้อมูลเป็น systemuser
 $conn = mysqli_connect("localhost", "root", "", "systemuser");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>