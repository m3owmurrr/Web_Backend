<?php
include('../other/dbconnect.php' );
if ($_SERVER['REQUEST_METHOD'] == 'GET' || $_POST['action'] == 'search') {
    if ($_POST['action'] == 'search') {
        $statement = $pdo->prepare("SELECT duty_id, guard_id, post_id, duty_date FROM DutyLog WHERE duty_date LIKE CONCAT('%', :search_query, '%')");
        $statement->execute(['search_query' => $_POST['search_query']]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $result = $pdo->query("SELECT duty_id, guard_id, post_id, duty_date FROM DutyLog")->fetchAll(PDO::FETCH_ASSOC);
    }
    include('./form.php');
} else {
    // Обработка добавления записи
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add') {
        $insertStatement = $pdo->prepare("INSERT INTO DutyLog (guard_id, post_id, duty_date) VALUES (:guard_id, :post_id, :duty_date)");
        $insertStatement->execute(['guard_id' => $_POST['guard_id'], 'post_id' => $_POST['post_id'], 'duty_date' => $_POST['duty_date']]);
    }

    // Обработка редактирования записи
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'edit') {
        $updateStatement = $pdo->prepare("UPDATE DutyLog SET guard_id=:guard_id, post_id=:post_id, duty_date=:duty_date WHERE duty_id = :duty_id");
        $updateStatement->execute(['duty_id' => $_POST['edit_id'], 'guard_id' => $_POST['edit_guard_id'], 'post_id' => $_POST['edit_post_id'], 'duty_date' => $_POST['edit_duty_date']]);
    }

    // Обработка удаления записи
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'delete') {
        $deleteStatement = $pdo->prepare("DELETE FROM DutyLog WHERE duty_id=:duty_id");
        $deleteStatement->execute(['duty_id' => $_POST['delete_id']]);
    }
    header('Location: ./script.php');
}
?>