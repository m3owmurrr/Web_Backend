<?php    
if ($flag) {
} else {
    try {
        $user = 'root';
        $pass = null;
        $db = new PDO(
            'mysql:host=localhost;dbname=webBack',
            $user,
            $pass,
            [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    } catch (PDOException $error) {
        exit($error->getMessage());
    }

    try {
        $stmt = $db->prepare("SELECT ability_id, name FROM ability");
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            $abilityArr[$row['ability_id']] = $row['name'];
    } catch (PDOException $error) {
        print('Error : ' . $error->getMessage());
        exit();
    }
    $flag = true;
}
?>