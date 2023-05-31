<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();

if (!empty($_SESSION['login'])) {
    setcookie('name', null, -1);
    setcookie('email', null, -1);
    setcookie('birthDate', null, -1);
    setcookie('gender', null, -1);
    setcookie('numOfLimbs', null, -1);
    setcookie('ability', null, -1);
    session_destroy();
    header('Location: ./');
}


if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $messages = array();
    if (!empty($_COOKIE['login_error'])) {
        setcookie('login_error', null, -1);
        $messages['login'] = $_COOKIE['login_error'];
    }
    if (!empty($_COOKIE['password_error'])) {
        setcookie('password_error', null, -1);
        $messages['password'] = $_COOKIE['password_error'];
    }
    if (!empty($_COOKIE['enter_error'])) {
        setcookie('enter_error', null, -1);
        $messages['enter'] = $_COOKIE['enter_error'];
    }
    ?>
    
    <head>
        <meta charset="utf-8">
        <title> Задание 5 </title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="task5.css">
        <style>

        </style>
    </head>

    <body>
    <a href="./" style="position: absolute">выйти</a>
        <div class="form_block container">
            <div class="form_panels d-flex flex-column align-items-center col-5 mx-auto">
                <div class="form_panel">
                    <h1>Авторизация </h1>
                    <form action="" method="POST" autocomplete="off">

                        <div class="form_elem">
                            <h5>Логин</h5>
                            <div class="form_field">
                                <input type="name" name="login" placeholder="введите логин" class="crutch">
                            </div>
                            <div class="form_error_log">
                                <?php
                                if (!empty($messages['login']))
                                    print $messages['login'];
                                ?>
                            </div>
                        </div>


                        <div class="form_elem">
                            <h5>Пароль</h5>
                            <div class="form_field">
                                <input type="name" name="password" placeholder="введите пароль" class="crutch">
                            </div>
                            <div class="form_error_log">
                                <?php
                                if (!empty($messages['password']))
                                    print $messages['password'];
                                ?>
                            </div>
                        </div>

                        <div class="form_elem">
                                <input type="submit" value="Войти">
                                <?php
                                if (!empty($messages['enter']))
                                    print $messages['enter'];
                                ?>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </body>
    <?php
} else {

    $error = FALSE;
    if (empty($_POST['login'])) {
        setcookie('login_error', '<span class="error">Введите логин</span>', time() + 24 * 60 * 60);
        $error = TRUE;
    }
    if (empty($_POST['password'])) {
        setcookie('password_error', '<span class="error">Введите пароль</span>', time() + 24 * 60 * 60);
        $error = TRUE;
    }
    if ($error) {
        session_destroy();
        header('Location: /login.php');
        exit();
    }





    try {
            $user = 'u52960';
            $pass = '7531864';
            $db = new PDO(
                'mysql:host=localhost;dbname=u52960',
                $user,
                $pass,
                [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $error) {
            exit($error->getMessage());
        }
    try {
        $stmt = $db->prepare("SELECT * FROM user WHERE login=:login");
        $stmt->execute(['login' => $_POST['login']]);
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $temp = $stmt->fetchAll();
        if (empty($temp)) {
            setcookie('enter_error', '<span class="error">Неверный логин</span>', time() + 24 * 60 * 60);
           echo ('Неверный логин');
           session_destroy();
           header('Location: /login.php');
           exit();
        } else {
            setcookie('login', $_POST['login'], time() + 24 * 60 * 60);
            if (password_verify($_POST['password'], $temp[0]['password_hash'])) {
                $_SESSION['uid'] = $temp[0]['pers_id'];
                $_SESSION['login'] = $_POST['login'];
            } else {
                echo ('Неверный пароль');
                setcookie('enter_error', '<span class="error">Неверный пароль</span>', time() + 24 * 60 * 60);
                session_destroy();
                header('Location: /login.php');
                exit();
            }
        }
    } catch (PDOException $e) {
        die($e->getMessage());
    }
    header('Location: /index.php');
}