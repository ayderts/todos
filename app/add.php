<?php

if(isset($_POST['title']) && isset($_POST['email']) && isset($_POST['username'])){
    require '../db_conn.php';
    $itemRole = $_POST['itemRole'];
    $title = $_POST['title'];
    $email = $_POST['email'];
    $username = $_POST['username'];

    if(empty($title)){
        header("Location: ../index.php?mess=error");
    }else {

        $stmt = $conn->prepare("INSERT INTO todos(title,email,username) VALUE(?,?,?)");
        $res = $stmt->execute([$title,$email,$username]);

        if($res){
            if($itemRole=='admin')
            {
                header("Location: ../index.php?mess=admin");
            }
            else{
                header("Location: ../index.php?mess=guest");
            }
        }else {
            header("Location: ../index.php");
        }
        $conn = null;
        exit();
    }
}else {
    header("Location: ../index.php?mess=error");
}