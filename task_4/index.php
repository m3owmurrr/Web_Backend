<?php
header('Content-Type: text/html; charset=UTF-8');

require 'ability.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $messages = array();
    if (!empty($_COOKIE['save'])) {
        setcookie('save', null, -1);
        $messages['save'] = '<span class="ok"> Спасибо, результаты сохранены </span>';
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
        header('Location: /task_4');
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
    $stmt = $db->prepare("INSERT INTO person VALUES (null,:name,:email,:birthDate,:gender,:numOfLimbs,:biography)");
    $stmt -> execute(['name'=>$_POST['name'], 'email'=>$_POST['email'],'birthDate'=>$birthDate,'gender'=>$_POST['gender'],'numOfLimbs'=>$_POST['numOfLimbs'],'biography'=>$_POST['biography']]);
    $pers_id = $db->lastInsertId();
    foreach ($_POST['ability'] as $ab_id) {
        $stmt = $db->prepare("INSERT INTO personAbility VALUES (null,:pers_id,:ab_id)");
        $stmt -> execute(['pers_id'=>$pers_id, 'ab_id'=>$ab_id]);
      }
    } catch(PDOException $error){
        print('Error : ' . $error->getMessage());
        exit();
    }

    setcookie('save', 1);
    header('Location: /task_4');
}
?>