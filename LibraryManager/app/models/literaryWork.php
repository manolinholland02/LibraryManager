<?php

//Абтрактен клас литературно произведение
abstract class LiteraryWork {
    private string $ISBN;
    private string $title;
    private string $author;

    public function __construct(string $title, string $author, string $ISBN) {
        $this->title = $title;
        $this->author = $author;
        $this->ISBN = $ISBN;
    }

    //Гетъри и сетъри
    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function getAuthor(): string {
        return $this->author;
    }

    public function setAuthor(string $author): void {
        $this->author = $author;
    }

    public function getISBN(): string {
        return $this->ISBN;
    }

    public function setISBN(string $ISBN): void {
        $this->ISBN = $ISBN;
    }
}