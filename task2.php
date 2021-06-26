<?php 
    require_once 'components/library.php'; // вывод списка книг
    require_once 'components/book.php'; // книга
    require_once 'components/connection.php'; // БД

    require_once 'components/menu-header.php'; // верхнее меню

    $library = new Library($_GET);
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
    <!-- Верхнее меню -->
    <?php 
        drawTopMenu("task2");
    ?>

    <!-- Сообщения об ошибках -->
    <?php
        if(isset($_GET['error']) && $_GET['error'] == 'incorrectInput') {
            echo '<div class="container error">Ошибка: неполный или некорректный ввод данных.</div>';
        }
    ?>

    <!-- действия при загрузке страницы -->
    <?php
        // Добавить книгу
        if(isset($_GET['action']) && $_GET['action'] == 'addBook') {
            if(isset($_POST['book_name']) && isset($_POST['author_name']) && isset($_POST['year_published'])){
                $library -> addBook(new Book(null, $_POST['book_name'], $_POST['author_name'], $_POST['year_published']));
            }
        }

        // Редактировать книгу
        if(isset($_GET['action']) && $_GET['action'] == 'editBook') {
            if(isset($_GET['id'])) {
                $library -> updateBook($_GET['id'], new Book(null, $_POST['book_name'], $_POST['author_name'], $_POST['year_published']));
            }
        }

        // Удалить книгу
        if(isset($_GET['action']) && $_GET['action'] == 'removeBook') {
            if(isset($_GET['id'])) {
                $library -> removeBook($_GET['id']);
            }
        }
    ?>

    <!-- Форма фильтров -->
    <div class="main-wrapper">
        <div class="container">
            <div class="accordion">
                <div class="accordion__wrapper">
                    <div class="accordion__item">
                        <input checked="checked" class="checkbox-xs_block" type="checkbox"> <i>&nbsp;</i>
                        <div class="accordion__title">
                            <div> Фильтры
                            </div>
                        </div>
                        <div class="accordion__content">
                            <form method="GET" name="editBook">
                                <p>
                                    <label for="book_name">Название содержит:</label><br>
                                    <input type="text" name="book_name" size="40" class="textbox" value="<?php 
                                            if(isset($_GET['book_name'])) {
                                                echo $_GET['book_name'];
                                            }
                                        ?>" />
                                </p>
                                <p>
                                    <label for="author_name">Автор:</label><br>
                                    <input type="text" name="author_name" size="40" class="textbox" value="<?php 
                                        if(isset($_GET['author_name'])) {
                                            echo $_GET['author_name'];
                                        }
                                    ?>" />
                                </p>
                                <p>
                                    <label for="year_from">Год от:</label><br>
                                    <input type="number" name="year_from" size="40" class="textbox" value="<?php 
                                        if(isset($_GET['year_from'])) {
                                            echo $_GET['year_from'];
                                        }
                                    ?>" />
                                </p>
                                <p>
                                    <label for="year_before">Год до:</label><br>
                                    <input type="number" name="year_before" size="40" class="textbox" value="<?php 
                                        if(isset($_GET['year_before'])) {
                                            echo $_GET['year_before'];
                                        }
                                    ?>" />
                                </p>
                                <p>
                                    <input type="submit" value="Применить" class="button" />
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Отображение таблицы -->
    <div class="main-wrapper">
        <div class="container">
            <h1>Таблица</h1>
            <?php
                displayLibraryTable($library);

                function displayLibraryTable($library) {
                    echo '<table>';
                    echo '<th>ID</th><th>Название книги</th><th>Автор</th><th>Год выпуска</th>';
                    foreach ($library -> books as $key => $value) {
                        echo '<tr>';
                        echo    '<td>' . $value -> id . 
                                '</td><td>' . $value -> bookName . 
                                '</td><td>' . $value -> authorName . 
                                '</td><td>' . $value -> yearPublished . 
                                '</td><td><a href="?editId=' . $value -> id . '">Редактировать</a></td>' . 
                                '<td><a href="?action=removeBook&id=' . $value -> id . '">Удалить</a></td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                }
            ?>
        </div>

        <!-- Форма добавления записи -->
        <?php if(!isset($_GET['editId'])): ?>
            <div class="container new-article">
                <h2>Добавить новую запись</h2>
                <form action="?action=addBook" method="POST" name="addBook">
                    <p>Название книги<br> 
                        <input type="text" name="book_name" size="40" class="textbox" />
                        <span class="error" id="username_errortext">
                            <?php 
                                if(isset($bookName_correct) && $bookName_correct == false) {
                                    echo "Поле не должно быть пустым";
                                }
                            ?>
                        </span>
                    </p>
                    <p>Автор<br> 
                        <input type="text" name="author_name" size="40" class="textbox" />
                        <span class="error" id="username_errortext">
                            <?php 
                                if(isset($authorName_correct) && $authorName_correct == false) {
                                    echo "Поле не должно быть пустым";
                                }
                            ?>
                        </span>
                    </p>
                    <p>Год выпуска<br> 
                        <input type="number" name="year_published" size="4" class="textbox" />
                        <span class="error" id="username_errortext">
                            <?php 
                                if(isset($authorName_correct) && $authorName_correct == false) {
                                    echo "Поле не должно быть пустым";
                                }
                            ?>
                        </span>
                    </p>
                    <input type="submit" value="Добавить" class="button" />
                </form>
            </div>
        <?php endif; ?>

        <!-- Форма редактирования записи -->
        <?php if(isset($_GET['editId'])): ?>
            <?php 
                $book = $library -> getBookById($_GET['editId']); 
            ?>
            <div class="container edit-article">
                <h2>Редактировать запись</h2>
                <form action="?action=editBook&id=<?php echo $book -> id ?>" method="POST" name="editBook">
                    <p>ID<br> 
                        <input 
                            type="text" 
                            name="id" 
                            size="40" 
                            class="textbox" 
                            value="<?php echo $book -> id ?>" 
                            disabled />
                    </p>
                    <p>Название книги<br> 
                        <input 
                            type="text" 
                            name="book_name" 
                            size="40" 
                            class="textbox" 
                            value="<?php echo $book -> bookName ?>" 
                            />
                        <span class="error" id="username_errortext">
                            <?php 
                                if(isset($bookName_correct) && $bookName_correct == false) {
                                    echo "Поле не должно быть пустым";
                                }
                            ?>
                        </span>
                    </p>
                    <p>Автор<br> 
                        <input 
                            type="text" 
                            name="author_name" 
                            size="40" 
                            class="textbox" 
                            value="<?php echo $book -> authorName ?>" 
                            />
                        <span class="error" id="username_errortext">
                            <?php 
                                if(isset($authorName_correct) && $authorName_correct == false) {
                                    echo "Поле не должно быть пустым";
                                }
                            ?>
                        </span>
                    </p>
                    <p>Год выпуска<br> 
                        <input 
                            type="number" 
                            name="year_published" 
                            size="40" 
                            class="textbox" 
                            value="<?php echo $book -> yearPublished ?>" 
                            />
                        <span class="error" id="username_errortext">
                            <?php 
                                if(isset($authorName_correct) && $authorName_correct == false) {
                                    echo "Поле не должно быть пустым";
                                }
                            ?>
                        </span>
                    </p>
                    <input type="submit" value="Изменить" class="button" />
                    <a href="task2.php">Отмена</a>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>