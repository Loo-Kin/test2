<?php
class Book
{
    // объявление свойства
    public $id = null;
    public $bookName;
    public $authorName;
    public $yearPublished;

    // объявление метода
    public function updateBook() {
        
    }

    public function __construct($id, $bookName, $authorName, $yearPublished)
    {
        $this->id = $id;
        $this->bookName = $bookName;
        $this->authorName = $authorName;
        $this->yearPublished = $yearPublished;
    }
}
?>