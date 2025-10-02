<?php

class Magazine extends LiteraryWork {
    //някъв (къстъм за класа) атрибут, да се различава от другите класове
    private string $issueDate;

    public function __construct(string $title, string $author, string $ISBN, string $issueDate) {
        parent::__construct($title, $author, $ISBN);
        $this->issueDate = $issueDate;
    }

    //Гетъри и сетъри
    public function getIssueDate(): string {
        return $this->issueDate;
    }

    public function setIssueDate(string $issueDate): void {
        $this->issueDate = $issueDate;
    }
}