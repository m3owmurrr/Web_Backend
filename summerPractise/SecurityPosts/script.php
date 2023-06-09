<?php
include('../other/dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET' || $_POST['action'] == 'search') {
    if ($_POST['action'] == 'search') {
        $statement = $pdo->prepare("SELECT post_id, post_name, post_location FROM SecurityPosts WHERE post_name LIKE CONCAT('%', :search_query, '%') OR post_location LIKE CONCAT('%', :search_query, '%')");
        $statement->execute(['search_query' => $_POST['search_query']]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $result = $pdo->query("SELECT post_id, post_name, post_location FROM SecurityPosts")->fetchAll(PDO::FETCH_ASSOC);
    }
    include('./form.php');
} else {
    // Обработка добавления записи
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add') {
        $insertStatement = $pdo->prepare("INSERT INTO SecurityPosts VALUES (null,:post_name,:post_location)");
        $insertStatement->execute(['post_name' => $_POST['post_name'], 'post_location' => $_POST['post_location']]);
    }

    // Обработка редактирования записи
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'edit') {
        $updateStatement = $pdo->prepare("UPDATE SecurityPosts SET post_name=:post_name, post_location=:post_location WHERE post_id = :post_id");
        $updateStatement->execute(['post_id' => $_POST['edit_id'], 'post_name' => $_POST['edit_post_name'], 'post_location' => $_POST['edit_post_location']]);
    }

    // Обработка удаления записи
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'delete') {
        $deleteStatement = $pdo->prepare("DELETE FROM SecurityPosts WHERE post_id=:post_id");
        $deleteStatement->execute(['post_id' => $_POST['delete_id']]);
    }
    header('Location: ./script.php');
}
?>