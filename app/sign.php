<?php

if(isset($_POST['username']) && isset($_POST['password'])){
    require '../db_conn.php';
    $password = $_POST['password'];
    $username = $_POST['username'];

    if(empty($username) || empty($password)){
        header("Location: ../login.php?mess=notall");
    }else {

        $stmt = $conn->prepare("SELECT * FROM username WHERE username=? and password=? and role_id=1");
        $res = $stmt->execute([$username,$password]);

        if($stmt->rowCount() <= 0)
        {
            header("Location: ../login.php?mess=error");
        }
        else {
            header("Location: ../index.php?mess=admin");
        }


        $conn = null;
        exit();
    }
}else {
    echo 'MDAAAAA';
    echo $_POST['username'];
    echo $_POST['password'];
}