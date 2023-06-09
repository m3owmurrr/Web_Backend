<?php
try {
    $user = 'u52960';
    $pass = '7531864';
    $pdo = new PDO(
        'mysql:host=localhost;dbname=u52960',
        $user,
        $pass,
        [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION] //(1)
    );
} catch (PDOException $error) {
    exit($error->getMessage());
}
?>

<!-- (1) -->
<!-- Cоединение с базой данных должно быть постоянным; -->
<!-- Режим обработки ошибок для объекта PDO, PDO::ERRMODE_EXCEPTION указывает, что PDO должен выбрасывать исключения в случае возникновения ошибок -->