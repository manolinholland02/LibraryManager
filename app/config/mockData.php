<?php
//Клас с методи за записване на първиначална (мок) дата за книги, списания и вестници
//Датата е генерирана с ГПТ, аз толкова книги не знам :)
class MockData
{
    public function LoadBooksData(): array
    {
        return [
            new Book("To Kill a Mockingbird", "Harper Lee", "978-0-06-112008-4", "Fiction", 10),
            new Book("1984", "George Orwell", "978-0-452-28423-4", "Dystopian", 20),
            new Book("The Great Gatsby", "F. Scott Fitzgerald", "978-0-7432-7356-5", "Classic", 30),
            new Book("Pride and Prejudice", "Jane Austen", "978-0-14-143951-8", "Romance", 40),
            new Book("The Catcher in the Rye", "J.D. Salinger", "978-0-316-76948-0", "Literary Fiction", 50),
            new Book("Moby Dick", "Herman Melville", "978-0-14-243724-7", "Adventure", 60),
            new Book("War and Peace", "Leo Tolstoy", "978-0-14-303999-0", "Historical Fiction", 70),
            new Book("Crime and Punishment", "Fyodor Dostoevsky", "978-0-14-305814-4", "Psychological Fiction", 80),
            new Book("The Lord of the Rings", "J.R.R. Tolkien", "978-0-618-00222-8", "Fantasy", 90),
            new Book("Harry Potter and the Sorcerer's Stone", "J.K. Rowling", "978-0-590-35340-3", "Fantasy", 100)
        ];
    }

    public function LoadMagazinesData(): array
    {
        return [
            new Magazine("National Geographic", "Susan Goldberg", "978-1-4262-1580-4", "June 2024"),
            new Magazine("TIME", "Edward Felsenthal", "978-1-683-30100-3", "May 2023"),
            new Magazine("The New Yorker", "David Remnick", "978-1-593-85230-0", "April 2022"),
            new Magazine("Vogue", "Anna Wintour", "978-1-5247-6104-3", "March 2024"),
            new Magazine("Forbes", "Steve Forbes", "978-0-07-139481-4", "July 2022"),
            new Magazine("Scientific American", "Laura Helmuth", "978-1-615-27372-8", "August 2023"),
            new Magazine("Wired", "Nicholas Thompson", "978-0-553-80467-0", "September 2024"),
            new Magazine("The Economist", "Zanny Minton Beddoes", "978-0-521-84293-1", "October 2022"),
            new Magazine("Bloomberg Businessweek", "Megan Murphy", "978-0-473-09384-5", "November 2023"),
            new Magazine("Vanity Fair", "Radhika Jones", "978-0-385-52097-4", "December 2024")
        ];
    }

    public function LoadNewspaperData(): array
    {
        return [
            new Newspaper("The New York Times", "A.G. Sulzberger", "978-0-06-123400-2", true),
            new Newspaper("The Washington Post", "Fred Ryan", "978-0-07-142421-4", false),
            new Newspaper("The Guardian", "Katharine Viner", "978-0-7432-7357-2", true),
            new Newspaper("The Wall Street Journal", "Matt Murray", "978-1-59240-013-3", false),
            new Newspaper("Los Angeles Times", "Norman Pearlstine", "978-0-345-39180-1", true),
            new Newspaper("Chicago Tribune", "Bruce Dold", "978-0-307-26398-8", false),
            new Newspaper("The Times", "John Witherow", "978-1-526-62597-0", true),
            new Newspaper("The Daily Telegraph", "Chris Evans", "978-0-09-951165-6", false),
            new Newspaper("Financial Times", "Roula Khalaf", "978-1-86197-928-1", true),
            new Newspaper("USA Today", "Nicole Carroll", "978-0-06-112006-0", false)
        ];
    }

    public function LoadLibraryUsers(): array
    {
        return [
            new LibraryUser("John Doe", "LU1001"),
            new LibraryUser("Bob Smith", "LU1002"),
            new LibraryUser("Manol Draganov", "LU1003"),
            new LibraryUser("Khamzat Chimaev", "LU1004")
        ];
    }
}
