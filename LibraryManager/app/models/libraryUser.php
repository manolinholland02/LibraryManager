<?php

class LibraryUser
{
    private string $name;
    private string $libraryCardNumber;
    //нотация за подсказване на типа на масива
    /** @var LiteraryWork[] */
    private array $borrowedWorks;

    public function __construct(string $name, string $libraryCardNumber)
    {
        $this->name = $name;
        $this->libraryCardNumber = $libraryCardNumber;
        $this->borrowedWorks = [];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getLibraryCardNumber(): string
    {
        return $this->libraryCardNumber;
    }

    public function setLibraryCardNumber(string $libraryCardNumber): void
    {
        $this->libraryCardNumber = $libraryCardNumber;
    }

    public function getBorrowedWorks(): array
    {
        return $this->borrowedWorks;
    }

    //метод за заемане на произведения
    public function borrowWork(LiteraryWork $work): void
    {
        //Ако е книга, намали наличността
        if ($work instanceof Book) $work->setStock($work->getStock() - 1);
        $this->borrowedWorks[] = $work;
    }

    //метод за проверка дали потребителя е заемал дадено произведение
    public function hasBorrowed(LiteraryWork $work): bool
    {
        foreach ($this->borrowedWorks as $borrowedWork) {
            if ($borrowedWork->getISBN() === $work->getISBN()) {
                return true;
            }
        }
        return false;
    }

    //метод за премахване на заети произведения(когато произведенеито е изтрито от библиотеката)
    public function removeBorrowedWork(LiteraryWork $work): void
    {
        $key = array_search($work, $this->borrowedWorks);
        if ($key !== false) {
            unset($this->borrowedWorks[$key]);
            //реиндиксирам масива, защото ънсет само премахва елемента, но не преномерява ключовете
            $this->borrowedWorks = array_values($this->borrowedWorks);
        }
    }

    //метод за връщане на произведения
    public function returnWork(LiteraryWork $work): void
    {
        $key = array_search($work, $this->borrowedWorks);
        //Ако е книга, увеличи наличността
        if ($key !== false) {
            if ($work instanceof Book) $work->setStock($work->getStock() + 1);
            unset($this->borrowedWorks[$key]);
            //реиндиксирам масива, защото ънсет само премахва елемента, но не преномерява ключовете
            $this->borrowedWorks = array_values($this->borrowedWorks);
        } else throw new Exception('Work not found in borrowed works!');
    }
}
