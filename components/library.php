<?php
    class Library {
        public $books = array();
        private $connection, $link;

        public function getBookById($id) {
            foreach ($this->books as $value) {
                if($value -> id == $id) {
                    return $value;
                }
            }
            return null;
        }

        private function isInputCorrect($input) {
            $input_correct =    (bool)preg_match('/.+/', $input -> bookName) && 
                                (bool)preg_match('/.+/', $input -> authorName) && 
                                (bool)preg_match('/.+/', $input -> yearPublished);

            return $input_correct;
        }

        private function connect() {
            $this -> link = mysqli_connect($this -> connection::HOST, $this -> connection::USER, $this -> connection::PASSWORD, $this -> connection::DATABASE) 
            or die("Ошибка " . mysqli_error($this -> link)); 
        }

        private function disconnect() {
            mysqli_close($this -> link);
        }

        // Добавляет книгу newBook в БД
        public function addBook($newBook) {
            if($this -> isInputCorrect($newBook)) {
                // подключаемся к серверу
                $this -> connect();
        
                // экранирования символов для mysql
                $book_name = htmlentities(mysqli_real_escape_string($this -> link, $newBook -> bookName));
                $author_name = htmlentities(mysqli_real_escape_string($this -> link, $newBook -> authorName));
                $year_published = htmlentities(mysqli_real_escape_string($this -> link, $newBook -> yearPublished));
        
                // создание строки запроса
                $query ="INSERT INTO books VALUES(NULL,'$book_name','$author_name','$year_published')";
        
                // выполняем запрос
                $result = mysqli_query($this -> link, $query) or die("Ошибка " . mysqli_error($this -> link)); 
                if($result)
                {
                    echo "Данные добавлены";
                }
                // закрываем подключение
                $this -> disconnect();
                header("Location: task2.php");
            } else {
                header("Location: task2.php?error=incorrectInput");
            }
        }

        // Добавляет книгу с индексом book_id из БД
        public function removeBook($book_id) {
            $this -> connect();

            $query = "DELETE FROM books WHERE book_id = $book_id";
            $result = mysqli_query($this -> link, $query) or die("Ошибка " . mysqli_error($this -> link)); 
            
            if($result) {
                echo "Книга удалена";
            }
            $this -> disconnect();
            header("Location: task2.php");
        }

        // Заменяет книгу с индексом book_id, значениями из newBook
        public function updateBook($book_id, $newBook) {
            if($this -> isInputCorrect($newBook)) {
                // подключаемся к серверу
                $this -> connect();
        
                // экранирования символов для mysql
                $book_name = htmlentities(mysqli_real_escape_string($this -> link, $newBook -> bookName));
                $author_name = htmlentities(mysqli_real_escape_string($this -> link, $newBook -> authorName));
                $year_published = htmlentities(mysqli_real_escape_string($this -> link, $newBook -> yearPublished));
        
                // создание строки запроса
                $query ="UPDATE `books` SET `book_name` = '$book_name ', `author_name` = '$author_name', `year_published` = '$year_published' WHERE `books`.`book_id` = $book_id;
                    ";
        
                // выполняем запрос
                $result = mysqli_query($this -> link, $query) or die("Ошибка " . mysqli_error($this -> link)); 
                if($result)
                {
                    echo "Данные обновлены";
                }
                // закрываем подключение
                $this -> disconnect();
                header("Location: task2.php");
            } else {
                header("Location: task2.php?error=incorrectInput");
            }
        }

        // Создание списка книг для отображения на экране с фильтрами
        public function __construct($filters)
        {
            $this -> connection = new Connection();

            if(isset($filters['book_name'])) {
                $bookNameFilter = $filters['book_name'];
            } else {
                $bookNameFilter = "";
            }
            if(isset($filters['author_name'])) {
                $authorNameFilter = $filters['author_name'];
            } else {
                $authorNameFilter = "";
            }
            if(isset($filters['year_from'])) {
                $yearsFromFilter = $filters['year_from'];
            } else {
                $yearsFromFilter = "";
            }
            if(isset($filters['year_before'])) {
                $yearsBeforeFilter = $filters['year_before'];
            } else {
                $yearsBeforeFilter = "";
            }

            // подключаемся к серверу
            $this -> connect();    
        
            $query ="SELECT * FROM books WHERE 
                book_name LIKE '%$bookNameFilter%' AND 
                author_name LIKE '%$authorNameFilter%'";
            if($yearsFromFilter != "") {
                $query .= "AND  year_published >= '$yearsFromFilter'";
            }
            if($yearsBeforeFilter != "") {
                $query .= "AND  year_published <= '$yearsBeforeFilter'";
            }
            $result = mysqli_query($this -> link, $query) or die("Ошибка " . mysqli_error($this -> link));

            $books = ($result->fetch_all(MYSQLI_ASSOC));

            foreach ($books as $row) {
                $result = array_push($this -> books, new Book($row['book_id'], $row['book_name'], $row['author_name'], $row['year_published']));
            }

            // закрываем подключение
            $this -> disconnect();
        }
    }
?>