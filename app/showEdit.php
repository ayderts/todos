<?php
if(isset($_POST['id'])){
    require '../db_conn.php';
    $id = $_POST['id'];
    $stmt = $conn->prepare("SELECT * FROM todos WHERE id=?");
    $res = $stmt->execute([$id]);
    $todo = $stmt->fetch();
    /*$title = $todo['title'];
    $username = $todo['username'];
    $email = $todo['email'];*/
    $info = array($todo['title'],$todo['email'],$todo['username'],$id);
    echo json_encode($info);
}