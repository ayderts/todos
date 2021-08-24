<?php
require 'db_conn.php';
?>
<!doctype html>
<html lang="en">
<head>
    <title>Login 01</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="css/style.css">

</head>
<body>
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="login-wrap p-4 p-md-5">
                    <div class="icon d-flex align-items-center justify-content-center">
                        <span class="fa fa-user-o"></span>
                    </div>
                    <h3 class="text-center mb-4">Sign In</h3>
                    <form action="app/sign.php" class="login-form" method="post">
                        <div class="form-group">
                            <input name="username" type="text" class="form-control rounded-left" placeholder="Username" required>
                        </div>
                        <div class="form-group d-flex">
                            <input type="password" name="password" class="form-control rounded-left" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="form-control btn btn-primary rounded submit px-3">Login</button>
                        </div>

                        <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error'){ ?>
                            <p>НЕВЕРНЫЙ ЛОГИН ИЛИ ПАРОЛЬ</p>

                        <?php } ?>
                        <?php if(isset($_GET['mess']) && $_GET['mess'] == 'notall'){ ?>
                            <p>ЗАПОЛНЕНЫ НЕ ВСЕ ПОЛЯ</p>

                        <?php } ?>

                    </form>
                    <div class="form-group">
                        <button onClick="redirect()" class="form-control btn btn-primary rounded submit px-3">Login as guest</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="js/jquery.min.js">
</script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
<script lang="text/javascript">
    function redirect(){
        window.location.href='../index.php?mess=guest';
    }
</script>
</body>
</html>

