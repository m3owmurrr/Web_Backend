<!DOCTYPE html>
<html>

<head>
    <title>Управление записями</title>
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
                <h3>Добавить запись:&nbsp&nbsp&nbsp</h3>
                <form action="" method="POST" class="row">
                    <input type="hidden" name="action" value="add">

                    <!-- Выбор охранника -->
                    <select name="guard_id" required>
                        <?php
                        $guardsQuery = "SELECT guard_id, guard_name FROM Guards";
                        $guardsResult = $pdo->query($guardsQuery);
                        while ($guard = $guardsResult->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $guard['guard_id'] . '">' . $guard['guard_name'] . '</option>';
                        }
                        ?>
                    </select>

                    <!-- Выбор поста -->
                    <select name="post_id" required>
                        <?php
                        $postsQuery = "SELECT post_id, post_name FROM SecurityPosts";
                        $postsResult = $pdo->query($postsQuery);
                        while ($post = $postsResult->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $post['post_id'] . '">' . $post['post_name'] . '</option>';
                        }
                        ?>
                    </select>

                    <input type="date" name="complaint_date" value="<?php echo date("Y-m-d"); ?>" required>
                    <textarea name="complaint_description" placeholder="Текст жалобы" rows="1" required></textarea>
                    <input type="submit" value="Добавить">
                </form>
            </div>

            <div class="tabel_panel my-0">
                <?php
                // Вывод таблицы с данными
                echo '<table>';
                echo '<tr><th>id</th><th>Имя охранника</th><th>Навание поста</th><th>Дата жалобы</th><th>Содержание жалобы</th><th>Действия</th></tr>';

                foreach ($result as $row) {
                    echo '<tr>';
                    echo '<td>' . $row['complaint_id'] . '</td>';

                    // Редактирование записи
                    echo '<td>';
                    echo '<form action="" method="POST">';
                    echo '<input type="hidden" name="action" value="edit">';
                    echo '<input type="hidden" name="edit_id" value="' . $row['complaint_id'] . '">';

                    // Выбор охранника
                    echo '<select name="edit_guard_id" required>';
                    $guardsQuery = "SELECT guard_id, guard_name FROM Guards";
                    $guardsResult = $pdo->query($guardsQuery);
                    while ($guard = $guardsResult->fetch(PDO::FETCH_ASSOC)) {
                        $selected = ($guard['guard_id'] == $row['guard_id']) ? 'selected' : '';
                        echo '<option value="' . $guard['guard_id'] . '" ' . $selected . '>' . $guard['guard_name'] . '</option>';
                    }
                    echo '</select>';
                    echo '</td>';

                    // Выбор поста
                    echo '<td>';
                    echo '<select name="edit_post_id" required>';
                    $postsQuery = "SELECT post_id, post_name FROM SecurityPosts";
                    $postsResult = $pdo->query($postsQuery);
                    while ($post = $postsResult->fetch(PDO::FETCH_ASSOC)) {
                        $selected = ($post['post_id'] == $row['post_id']) ? 'selected' : '';
                        echo '<option value="' . $post['post_id'] . '" ' . $selected . '>' . $post['post_name'] . '</option>';
                    }
                    echo '</select>';
                    echo '</td>';

                    echo '<td>';
                    echo '<input type="date" name="edit_complaint_date" value="' . $row['complaint_date'] . '" required>';
                    echo '</td>';

                    echo '<td>';
                    echo '<textarea name="edit_complaint_description" rows="1" required>' . $row['complaint_description'] . '</textarea>';
                    echo '</td>';

                    echo '<td class="row">';
                    echo '<input type="submit" value="Сохранить">';
                    echo '</form>';

                    // Удаление записи
                    echo '<form action="" method="POST">';
                    echo '<input type="hidden" name="action" value="delete">';
                    echo '<input type="hidden" name="delete_id" value="' . $row['complaint_id'] . '">';
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
                    <input type="date" name="search_query" required>
                    <input type="submit" value="Применить">
                </form>
                <form action="" method="GET">
                    <input type="submit" onclick="location.href='./script.php'" value="Сбросить">
                </form>
            </div>
        </div>
    </div>
</body>

</html>