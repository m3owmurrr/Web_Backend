<?php
include('../other/dbconnect.php');
if ($_SERVER['REQUEST_METHOD'] == 'GET' || $_POST['action'] == 'search') {
    if ($_POST['action'] == 'search') {
        $statement = $pdo->prepare("SELECT complaint_id, guard_id, post_id, complaint_date, complaint_description FROM ComplaintLog WHERE complaint_date LIKE CONCAT('%', :search_query, '%')");
        $statement->execute(['search_query' => $_POST['search_query']]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $result = $pdo->query("SELECT complaint_id, guard_id, post_id, complaint_date, complaint_description FROM ComplaintLog")->fetchAll(PDO::FETCH_ASSOC);
    }
    include('./form.php');
} else {
    // Обработка добавления записи
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add') {
        $insertStatement = $pdo->prepare("INSERT INTO ComplaintLog (guard_id, post_id, complaint_date, complaint_description) VALUES (:guard_id, :post_id, :complaint_date, :complaint_description)");
        $insertStatement->execute(['guard_id' => $_POST['guard_id'], 'post_id' => $_POST['post_id'], 'complaint_date' => date("Y-m-d"), 'complaint_description' => $_POST['complaint_description']]);
    }

    // Обработка редактирования записи
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'edit') {
        $updateStatement = $pdo->prepare("UPDATE ComplaintLog SET guard_id=:guard_id, post_id=:post_id, complaint_date=:complaint_date, complaint_description=:complaint_description WHERE complaint_id = :complaint_id");
        $updateStatement->execute(['complaint_id' => $_POST['edit_id'], 'guard_id' => $_POST['edit_guard_id'], 'post_id' => $_POST['edit_post_id'], 'complaint_date' => $_POST['edit_complaint_date'], 'complaint_description' => $_POST['edit_complaint_description']]);
    }

    // Обработка удаления записи
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'delete') {
        $deleteStatement = $pdo->prepare("DELETE FROM ComplaintLog WHERE complaint_id=:complaint_id");
        $deleteStatement->execute(['complaint_id' => $_POST['delete_id']]);
    }
    header('Location: ./script.php');
}
?>