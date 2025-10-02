<?php

class Newspaper extends LiteraryWork {
    //някъв (къстъм за класа) атрибут, да се различава от другите класове
    private bool $isFree = false;

    public function __construct(string $title, string $author, string $ISBN, bool $isFree) {
        parent::__construct($title, $author, $ISBN);
        $this->isFree = $isFree;
    }

    //Гетъри и сетъри
    public function getIsFree(): bool {
        return $this->isFree;
    }

    public function setIsFree(bool $isFree): void {
        $this->isFree = $isFree;
    }
}