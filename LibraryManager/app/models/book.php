<?php

class Book extends LiteraryWork {
    private string $genre;
    private int $stock = 100;

    public function __construct(string $title, string $author, string $ISBN, string $genre, int $stock) {
        //Извикване на конструктора на бейс класа
        parent::__construct($title, $author, $ISBN);
        $this->genre = $genre;
        $this->stock = $stock;
    }

    //Гетъри и сетъри
    public function getGenre(): string {
        return $this->genre;
    }

    public function setGenre(string $genre): void {
        $this->genre = $genre;
    }

    public function getStock(): int {
        return $this->stock;
    }

    public function setStock(int $stock): void {
        if ($stock < 0) {
            throw new Exception('Няма наличност!');
        }
        $this->stock = $stock;
    }
}