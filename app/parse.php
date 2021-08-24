<?php

    require '../db_conn.php';

        $offset =$_POST['offset'];
        $stmt = $conn->prepare("SELECT *, count(title) OVER() as ROWNUM FROM todos ORDER BY id DESC LIMIT 3 OFFSET ".$offset);
        //$stmt = $conn->prepare("SELECT *, count(title) OVER() as ROWNUM FROM todos ORDER BY id DESC LIMIT 3 OFFSET ?");
        //$stmt = $conn->prepare("SELECT * FROM todos WHERE id=?");
        $res = $stmt->execute();
        $i=0;
        $info = [];
       while($todo = $stmt->fetch(PDO::FETCH_ASSOC)) {

           array_push($info, array($todo['id'],$todo['title'],$todo['email'],$todo['username'],$todo['date_time'],$todo['ROWNUM'],$todo['checked']));
           //echo json_encode($info);

           //echo json_encode($info);//.'/ttt/';
       }
        echo json_encode($info);
        exit();
