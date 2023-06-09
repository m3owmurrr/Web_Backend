<!DOCTYPE html>
<html>

<head>
    <title>Посты охраны</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>
    <header>
        <?php include("../other/navigationBar.php"); ?>
    </header>

    <div class="table_block container">
        <div class="table_panels d-flex flex-column align-items-center col-10 mx-auto">
            <div class="tabel_panel row my-5">
                <h3>Добавить запись:&nbsp</h3>
                <form action="" method="POST">
                    <input type="hidden" name="action" value="add">
                    <input type="text" name="post_name" placeholder="Название поста" required>
                    <input type="text" name="post_location" placeholder="Адрес" required>
                    <input type="submit" value="Добавить">
                </form>
            </div>

            <div class="tabel_panel my-0">
                <?php
                // Вывод таблицы с данными
                echo '<table>';
                echo '<tr><th>id</th><th>Название поста</th><th>Адрес</th><th>Действия</th></tr>';
                foreach ($result as $row) {
                    echo '<tr>';
                    echo '<td>' . $row['post_id'] . '</td>';

                    // Редактирование записи
                    echo '<td>';
                    echo '<form action="" method="POST">';
                    echo '<input type="hidden" name="action" value="edit">';
                    echo '<input type="hidden" name="edit_id" value="' . $row['post_id'] . '">';
                    echo '<input type="text" name="edit_post_name" value="' . $row['post_name'] . '" required>';
                    echo '</td>';

                    echo '<td>';
                    echo '<input type="text" name="edit_post_location" value="' . $row['post_location'] . '" required>';
                    echo '</td>';

                    echo '<td class="d-flex row">';
                    echo '<input type="submit" value="Сохранить">';
                    echo '</form>';

                    // Удаление записи
                    echo '<form action="" method="POST">';
                    echo '<input type="hidden" name="action" value="delete">';
                    echo '<input type="hidden" name="delete_id" value="' . $row['post_id'] . '">';
                    echo '<input type="submit" value="Удалить">';
                    echo '</form>';
                    echo '</td>';

                    echo '</tr>';
                }
                echo '</table>';
                ?>
            </div>
            <div class="tabel_panel row my-5">
                <h3>Фильтр:&nbsp</h3>
                <form action="" method="POST">
                    <input type="hidden" name="action" value="search">
                    <input type="text" name="search_query" placeholder="Введите фильтр">
                    <input type="submit" value="Применить">
                </form>
                <form action="" method="GET">
                <input type="submit" onclick="location.href='./script.php'"value="Сбросить">
            </form>
            </div>
        </div>
    </div>
</body>

</html>