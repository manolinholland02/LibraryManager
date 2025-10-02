<?php

require_once(__DIR__ . '/controller.php');

class LiteraryWorkController extends Controller
{
    public function index()
    {
        $literaryWorks = $this->library->getLiteraryWorks();
        require_once(__DIR__ . '/../views/library/literaryWork.php');
    }

    public function deleteLiteraryWork()
    {
        $this->library->removeLiteraryWork(htmlspecialchars($_POST['ISBN']));
        header('Location: /literaryWork');
        exit();
    }

    public function addLiteraryWork()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $object = null;
            $title = htmlspecialchars($_POST['title']);
            $author = htmlspecialchars($_POST['author']);
            $ISBN = htmlspecialchars($_POST['isbn']);

            try {
                switch ($_POST['type']) {
                    case '0':
                        $stock = intval($_POST['stock']);
                        $genre = htmlspecialchars($_POST['genre']);
                        $object = new Book($title, $author, $ISBN, $genre, $stock);
                        break;
                    case '1':
                        $issueDate = htmlspecialchars($_POST['issueDate']);
                        $object = new Magazine($title, $author, $ISBN, $issueDate);
                        break;
                    case '2':
                        $isFree = isset($_POST['isFree']) ? true : false;
                        $object = new Newspaper($title, $author, $ISBN, $isFree);
                        break;
                }

                if ($object) {
                    $this->library->addLiteraryWork($object);
                    header('Location: /literaryWork');
                    exit();
                }
            } catch (Exception $e) {
                $_SESSION['error_message'] = $e->getMessage();
                header('Location: /literaryWork');
                exit();
            }
        }
    }
}
