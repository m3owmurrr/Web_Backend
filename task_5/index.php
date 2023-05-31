<?php
header('Content-Type: text/html; charset=UTF-8');

require 'ability.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $messages = array();
    if (!empty($_COOKIE['save'])) {
        setcookie('save', null, -1);
        setcookie('login', null, -1);
        setcookie('password', null, -1);
        $messages['save'] = '<span class="ok"> Спасибо, результаты сохранены </span>';
        $messages['login'] = '<span class="ok"> Ваш логин ' . $_COOKIE['login'] . '</span>';
        $messages['password'] = '<span class="ok"> Ваш пароль ' . $_COOKIE['password'] . '</span>';
    }

    if (!empty($_COOKIE['name_error'])) {
        setcookie('name_error', null, -1);
        $messages['name'] = $_COOKIE['name_error'];
    }

    if (!empty($_COOKIE['email_error'])) {
        setcookie('email_error', null, -1);
        $messages['email'] = $_COOKIE['email_error'];
    }

    if (!empty($_COOKIE['birthDate_error'])) {
        setcookie('birthDate_error', null, -1);
        $messages['birthDate'] = $_COOKIE['birthDate_error'];
    }

    if (!empty($_COOKIE['gender_error'])) {
        setcookie('gender_error', null, -1);
        $messages['gender'] = $_COOKIE['gender_error'];
    }

    if (!empty($_COOKIE['numOfLimbs_error'])) {
        setcookie('numOfLimbs_error', null, -1);
        $messages['numOfLimbs'] = $_COOKIE['numOfLimbs_error'];
    }

    if (!empty($_COOKIE['ability_error'])) {
        setcookie('ability_error', null, -1);
        $messages['ability'] = $_COOKIE['ability_error'];
    }

    if (!empty($_COOKIE['check_error'])) {
        setcookie('check_error', null, -1);
        $messages['check'] = $_COOKIE['check_error'];
    }

    $values = array();
    $values['name'] = empty($_COOKIE['name_value']) ? null : $_COOKIE['name_value'];
    $values['email'] = empty($_COOKIE['email_value']) ? null : $_COOKIE['email_value'];
    $values['birthDate'] = empty($_COOKIE['birthDate_value']) ? '2002-08-08' : $_COOKIE['birthDate_value'];
    $values['gender'] = empty($_COOKIE['gender_value']) ? null : $_COOKIE['gender_value'];
    $values['numOfLimbs'] = empty($_COOKIE['numOfLimbs_value']) ? null : $_COOKIE['numOfLimbs_value'];
    $values['ability'] = empty($_COOKIE['ability_value']) ? null : $_COOKIE['ability_value'];

    if (!empty($_SESSION['login'])) {
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
            $stmt = $db->prepare("SELECT pers_id FROM user WHERE login=:login");
            $stmt->execute(['login' => $_SESSION['login']]);
            $pers_id = $stmt->fetchAll();
            $stmt = $db->prepare("SELECT * FROM person WHERE person_id=:pers_id");
            $stmt->execute(['pers_id' => $pers_id[0]['pers_id']]);
            $person = $stmt->fetchALL();
            $values['name'] = $person[0]['name'];
            $values['email'] = $person[0]['email'];
            $values['birthDate'] = $person[0]['birthDate'];
            $values['gender'] = $person[0]['gender'];
            $values['numOfLimbs'] = $person[0]['numOfLimbs'];

            $stmt = $db->prepare("SELECT ab_id FROM personAbility WHERE pers_id=:pers_id");
            $stmt->execute(['pers_id' => $pers_id[0]['pers_id']]);
            $temp = $stmt->fetchAll();
            $ab = array();
            foreach ($temp as $value) {
                array_push($ab, $value['ab_id']);
            }
            $values['ability']  = json_encode($ab);

        } catch (PDOException $e) {
            print('Error: ' . $e->getMessage());
            exit();

        }
    }



    include('form.php');
    exit();
} else {

    $birthDate = strtotime($_POST['birthDate']);
    $birthDate = date('Y-m-d', $birthDate);

    setcookie('name_value', $_POST['name'], time() + 30 * 24 * 60 * 60);
    setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
    setcookie('birthDate_value', $birthDate, time() + 30 * 24 * 60 * 60);
    setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);
    setcookie('numOfLimbs_value', $_POST['numOfLimbs'], time() + 30 * 24 * 60 * 60);
    if (!empty($_POST['ability']))
        setcookie('ability_value', json_encode($_POST['ability']), time() + 30 * 24 * 60 * 60);


    $errors = array();

    if (empty($_POST['name'])) {
        $errors['name'] = '<span class="error">Заполните имя</span>';
    } else if (!preg_match('/^[a-zA-Zа-яА-Я\s]+$/u', $_POST['name'])) {
        $errors['name'] = '<span class="error">Используйте только буквы в данном поле</span>';
    }

    if (empty($_POST['email'])) {
        $errors['email'] = '<span class="error">Заполните почту</span>';
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = '<span class="error">Заполните почту корректно</span>';
    }

    if (empty($birthDate)) {
        $errors['birthDate'] = '<span class="error">Выберете дату вашего рождения</span>';
    }

    if (empty($_POST['gender'])) {
        $errors['gender'] = '<span class="error">Укажите свой пол</span>';
    }

    if (empty($_POST['numOfLimbs'])) {
        $errors['numOfLimbs'] = '<span class="error">Выберете один из вариантов</span>';
    }

    if (empty($_POST['ability'])) {
        $errors['ability'] = '<span class="error">Выберете хотя бы одну способность</span>';
    }

    if (empty($_POST['check'])) {
        $errors['check'] = '<span class="error">Согласитесь с условиями, которых нет</span>';
    }

    if (!empty($errors)) {
        foreach ($errors as $key => $value) {
            setcookie($key . '_error', $value, time() + 24 * 60 * 60);
        }
        header('Location: /');
        exit();
    }


    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ#$%&';
    function generate_string($input, $strength = 16)
    {
        $input_length = strlen($input);
        $random_string = '';
        for ($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
        return $random_string;
    }

    if (!empty($_SESSION['uid'])) {
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
            $stmt = $db->prepare("UPDATE person SET name=:name,email=:email,birthDate=:birthDate,gender=:gender,numOfLimbs=:numOfLimbs,biography=:biography WHERE person_id=:uid ");
            $stmt->execute(['uid' => $_SESSION['uid'], 'name' => $_POST['name'], 'email' => $_POST['email'], 'birthDate' => $birthDate, 'gender' => $_POST['gender'], 'numOfLimbs' => $_POST['numOfLimbs'], 'biography' => $_POST['biography']]);
            $stmt = $db->prepare("DELETE from personAbility WHERE pers_id=:uid");
            $stmt->execute(['uid' => $_SESSION['uid']]);
            foreach ($_POST['ability'] as $ab_id) {
                $stmt = $db->prepare("INSERT INTO personAbility VALUES (null,:pers_id,:ab_id)");
                $stmt->execute(['pers_id' => $_SESSION['uid'], 'ab_id' => $ab_id]);
            }
            $pers_id = $_SESSION['uid'];
            setcookie('changed', TRUE);
        } catch (PDOException $e) {
            print('Error : ' . $e->getMessage());
            exit();
        }
    } else {
        $login = generate_string($permitted_chars, 8);
        $password = generate_string($permitted_chars, 8);
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

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
            $stmt = $db->prepare("INSERT INTO person VALUES (null,:name,:email,:birthDate,:gender,:numOfLimbs,:biography)");
            $stmt->execute(['name' => $_POST['name'], 'email' => $_POST['email'], 'birthDate' => $birthDate, 'gender' => $_POST['gender'], 'numOfLimbs' => $_POST['numOfLimbs'], 'biography' => $_POST['biography']]);
            $pers_id = $db->lastInsertId();
            foreach ($_POST['ability'] as $ab_id) {
                $stmt = $db->prepare("INSERT INTO personAbility VALUES (null,:pers_id,:ab_id)");
                $stmt->execute(['pers_id' => $pers_id, 'ab_id' => $ab_id]);
            }


            $stmt = $db->prepare("INSERT INTO user VALUES (null, :pers_id , :login, :password_hash)");
            $stmt->execute(['pers_id' => $pers_id, 'login' => $login, 'password_hash' => $password_hash]);



        } catch (PDOException $e) {
            print('Error : ' . $e->getMessage());
            exit();
        }
    }

    setcookie('save', 1);
    setcookie('login', $login);
    setcookie('password', $password);
    header('Location: /');
}
?>