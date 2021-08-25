<?php

if(isset($_POST['title']) && isset($_POST['email']) && isset($_POST['username'])){
    require '../db_conn.php';

    $title = $_POST['title'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $id = $_POST['id'];


    $stmt = $conn->prepare("UPDATE todos SET title=?,email=?,username=? where id=?");
    $res = $stmt->execute([$title,$email,$username,$id]);

    if($res){
        header("Location: ../index.php?mess=admin");
    }else {
        header("Location: ../index.php");
    }
    $conn = null;
    exit();

}