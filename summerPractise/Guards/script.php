<?php
include('../other/dbconnect.php');
if ($_SERVER['REQUEST_METHOD'] == 'GET' || $_POST['action'] == 'search') {
    if(empty($_POST['action'])) {
        $_POST['action'] = "";
    }
    if ($_POST['action'] == 'search') {
        $statement = $pdo->prepare("SELECT guard_id, guard_name, guard_rank FROM Guards WHERE guard_name LIKE CONCAT('%', :search_query, '%') OR guard_rank LIKE CONCAT('%', :search_query, '%')");
        $statement->execute(['search_query' => $_POST['search_query']]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $result = $pdo->query("SELECT guard_id, guard_name, guard_rank FROM Guards")->fetchAll(PDO::FETCH_ASSOC);
    }
    include('./form.php');
} else {
    // Обработка добавления записи
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add') {
        $insertStatement = $pdo->prepare("INSERT INTO Guards VALUES (null,:guard_name,:guard_rank)");
        $insertStatement->execute(['guard_name' => $_POST['guard_name'], 'guard_rank' => $_POST['guard_rank']]);
    }

    // Обработка редактирования записи
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'edit') {
        $updateStatement = $pdo->prepare("UPDATE Guards SET guard_name=:guard_name, guard_rank=:guard_rank WHERE guard_id = :guard_id");
        $updateStatement->execute(['guard_id' => $_POST['edit_id'], 'guard_name' => $_POST['edit_guard_name'], 'guard_rank' => $_POST['edit_guard_rank']]);
    }

    // Обработка удаления записи
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'delete') {
        $deleteStatement = $pdo->prepare("DELETE FROM Guards WHERE guard_id=:guard_id");
        $deleteStatement->execute(['guard_id' => $_POST['delete_id']]);
    }
    header('Location: ./script.php');
}
?>