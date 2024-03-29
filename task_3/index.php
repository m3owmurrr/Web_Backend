<?php
header('Content-Type: text/html; charset=UTF-8');

require 'ability.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!empty($_GET['save'])) {
        print('Спасибо, результаты сохранены.');
    }
    include('form.php');
    exit();
}

$errors = FALSE;
if (empty($_POST['name'])) {
    print('Заполните имя.<br/>');
    $errors = TRUE;
}


if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    print('Заполните почту корректно.<br/>');
    $errors = TRUE;
}

$birthDate = strtotime($_POST['birthDate']);
$birthDate = date('Y-m-d', $birthDate);

if (empty($birthDate)) {
    print('Заполните год.<br/>');
    $errors = TRUE;
}

if (empty($_POST['gender'])) {
    print('Выберите пол.<br/>');
    $errors = TRUE;
}

if (empty($_POST['numOfLimbs'])) {
    print('Выберите количество конечностей.<br/>');
    $errors = TRUE;
}

if (empty($_POST['ability'])) {
    print('Выберите хотя бы одну способность.<br/>');
    $errors = TRUE;
}

// if (!preg_match('/^([а-яА-ЯЁёa-zA-Z0-9_,.\s-]+)$/u', $_POST['biography'])) {
//     print('Заполните биографию корректно.<br/>');
//     $errors = TRUE;
// }

if (empty($_POST['check'])) {
    print('Вы не согласились с условиями.<br/>');
    $errors = TRUE;
}

if ($errors) {
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

header('Location: ?save=1');