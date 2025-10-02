<?php
require_once(__DIR__ . '/../config/mockData.php');
require_once(__DIR__ . '/../models/literaryWork.php');
require_once(__DIR__ . '/../models/book.php');
require_once(__DIR__ . '/../models/magazine.php');
require_once(__DIR__ . '/../models/newspaper.php');
require_once(__DIR__ . '/../models/libraryUser.php');

class Library
{
    //нотация за подсказване на типа на масива
    /** @var LiteraryWork[] */
    private array $literaryWorks;
    /** @var LibraryUser[] */
    private array $libraryUsers;

    public function __construct()
    {
        //сторвам масивите в сесията, за да не се губят данните, защото ПХП е стейтлесс (щеше да е много по-лесно да използвам база данни :Д)
        if (isset($_SESSION['literaryWorks'])) {
            $this->literaryWorks = $_SESSION['literaryWorks'];
            $this->libraryUsers = $_SESSION['libraryUsers'];
        } else {
            $this->initializeData();
        }
    }

    //Инициализирам данните тук, за да не пиша всичко в конструктора
    private function initializeData()
    {
        $mockData = new MockData();
        $this->literaryWorks = array_merge($mockData->LoadBooksData(), $mockData->LoadMagazinesData(), $mockData->LoadNewspaperData());
        $this->libraryUsers = $mockData->LoadLibraryUsers();
        //Сторвам в сесията, за да направя данните персистънт
        $_SESSION['literaryWorks'] = $this->literaryWorks;
        $_SESSION['libraryUsers'] = $this->libraryUsers;
    }

    //Метод за вземане на всички произведения и асаинване на типа им (книга, списание, вестник)
    public function getLiteraryWorks(): array
    {
        $results = [];
        foreach ($this->literaryWorks as $work) {
            $results[] = $this->assignLiteraryWorkType($work);
        }
        return $results;
    }

    //Метод за добавяне на произведение
    public function addLiteraryWork(LiteraryWork $literaryWork): void
    {
        foreach ($this->literaryWorks as $work) {
            //Ако въведения ISBN вече съществува, хвърли грешка
            if ($work->getISBN() === $literaryWork->getISBN()) {
                throw new Exception('Вече съществува призведение с такъв ISBN');
            }
        }
        //Сторвам в сесията, за да направя данните персистънт
        $this->literaryWorks[] = $literaryWork;
        $_SESSION['literaryWorks'] = $this->literaryWorks;
    }

    //Метод за премахване на произведение (от цялата библиотека)
    public function removeLiteraryWork(string $ISBN): void
    {
        //Премахвам произведението от всички потребители за да не стои заето
        //Извличам го по върнатия ключ от въведения ISBN
        $this->removeLiteraryWorkFromLibraryUsers($this->literaryWorks[$this->getLiteraryWorkByISBN($ISBN)]);
        unset($this->literaryWorks[$this->getLiteraryWorkByISBN($ISBN)]);
        //реиндиксирам масива, защото ънсет само премахва елемента, но не преномерява ключовете
        $this->literaryWorks = array_values($this->literaryWorks);
        //Сторвам в сесията, за да направя данните персистънт
        $_SESSION['literaryWorks'] = $this->literaryWorks;
    }

    //Метод за вземане на всички потребители
    public function getLibraryUsers(): array
    {
        return $this->libraryUsers;
    }

    //Метод за вземане на потребител по номер на читателска карта
    public function getLibraryUser(string $libraryCardNumber): LibraryUser
    {
        foreach ($this->libraryUsers as $user) {
            if ($user->getLibraryCardNumber() === $libraryCardNumber) {
                return $user;
            }
        }
        //Ако не намери потребител, хвърли грешка
        throw new Exception('Няма читател с такъв номер на читателска карта');
    }

    //Метод за добавяне на потребител
    public function addLibraryUser(string $name): void
    {
        $libraryUser = new LibraryUser($name, $this->generateLibraryUserCode());
        //Сторвам в сесията, за да направя данните персистънт
        $this->libraryUsers[] = $libraryUser;
        $_SESSION['libraryUsers'] = $this->libraryUsers;
    }

    //Метод за генериране на номер на яитателка карта по определен патърн (LUXXXX)
    private function generateLibraryUserCode(): string
    {
        //Записвам всички (вече заети) номера на читателски карти в масив
        $existingCarnNumbers = [];
        foreach ($this->libraryUsers as $user) {
            $existingCarnNumbers[] = $user->getLibraryCardNumber();
        }

        //4 цифри са 10000 възможни комбинации, ако бъдат заети всички ще се хрърли грешка
        if (count($existingCarnNumbers) >= 10000) {
            throw new Exception("Library is full");
        }

        //Върти докато не намери уникален номер
        do {
            $randomDigits = rand(1000, 9999);
            $newCardNumber = "LU" . $randomDigits;
        } while (in_array($newCardNumber, $existingCarnNumbers));

        return $newCardNumber;
    }

    //Метод за намиране на произведения по заглавие, автор или ISBN
    //а.к.а. търсачката на библиотеката
    public function getLiteraryWorksByTitleOrAuthorOrISBN(string $search): array
    {
        $search = strtolower($search);
        $results = [];
        foreach ($this->literaryWorks as $work) {
            if (
                strpos(strtolower($work->getTitle()), $search) !== false ||
                strpos(strtolower($work->getAuthor()), $search) !== false ||
                strpos(strtolower($work->getISBN()), $search) !== false
            ) {
                $results[] = $this->assignLiteraryWorkType($work);
            }
        }
        return $results;
    }

    //Метод за заемане на произведение от потребител
    public function assignLiteraryWorkToLibraryUser(LibraryUser $user, string $ISBN): void
    {
        $work = $this->literaryWorks[$this->getLiteraryWorkByISBN($ISBN)];
        $user->borrowWork($work);
    }

    //Метод за връщане на произведение от потребител
    public function returnLiteraryWorkFromLibraryUser(LibraryUser $user, string $ISBN): void
    {
        $work = $this->literaryWorks[$this->getLiteraryWorkByISBN($ISBN)];
        $user->returnWork($work);
    }

    //Метод за премахване на произведение от всички потребители
    //(когато произведенеито е изтрито от библиотеката)
    private function removeLiteraryWorkFromLibraryUsers(LiteraryWork $work): void
    {
        foreach ($this->libraryUsers as $user) {
            $user->removeBorrowedWork($work);
        }
    }

    //Метод за асаинване на тип на произведението (книга, списание, вестник)
    private function assignLiteraryWorkType(LiteraryWork $work): array
    {
        $result = [
            'type' => '',
            'work' => $work,
        ];

        //тук добавям необходимите данни, спрямо типа на инстанцията
        if ($work instanceof Book) {
            $result['type'] = 'Book';
            $result['genre'] = $work->getGenre();
            $result['stock'] = $work->getStock();
        } else if ($work instanceof Magazine) {
            $result['type'] = 'Magazine';
            $result['issueDate'] = $work->getIssueDate();
        } else if ($work instanceof Newspaper) {
            $result['type'] = 'Newspaper';
            $result['isFree'] = $work->getIsFree();
        }

        return $result;
    }

    //Метод за намиране на произведение по ISBN
    private function getLiteraryWorkByISBN(string $ISBN)
    {
        foreach ($this->literaryWorks as $key => $work) {
            if ($work->getISBN() === $ISBN) {
                //връща ключа за по-точна справка с масива
                return $key;
            }
        }
        //Ако въведения ISBN не съществува, хвърли грешка
        throw new Exception('Не съществува призведение с такъв ISBN');
    }
}
