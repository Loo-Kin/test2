<?php 
    require_once 'components/tree-list.php'; // вывод иерархического списка

    require_once 'components/menu-header.php'; // верхнее меню
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="style/compiled/style.css" />
    <title>Задание 1</title>
</head>
<body>
    <?php 
        drawTopMenu("index");
    ?>
    <div class="main-wrapper">
        <div class="container">
            <h1>Иерархическое отображение</h1>
            <?php 
                echo createFolderWithSubfolders();
            ?>
        </div>
    </div>
</body>
</html>