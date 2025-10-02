<?php

require_once(__DIR__ . '/controller.php');

class LibraryUserController extends Controller
{
    public function index()
    {
        $libraryUsers = $this->library->getLibraryUsers();
        require_once(__DIR__ . '/../views/library/libraryUser.php');
    }

    public function addLibraryUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $name = htmlspecialchars($_POST['name']);
                $this->library->addLibraryUser($name);
                header('Location: /libraryUser');
                exit();
            } catch (Exception $e) {
                $_SESSION['error_message'] = $e->getMessage();
                header('Location: /libraryUser');
                exit();
            }
        }
    }

    public function borrowWork()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $libraryUser = $this->library->getLibraryUser(htmlspecialchars($_POST['libraryCardNumber']));
                $this->library->assignLiteraryWorkToLibraryUser($libraryUser, htmlspecialchars($_POST['itemToBorrow']));
                header('Location: /libraryUser');
                exit();
            } catch (Exception $e) {
                $_SESSION['error_message'] = $e->getMessage();
                header('Location: /libraryUser');
                exit();
            }
        }
    }

    public function returnWork()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $libraryUser = $this->library->getLibraryUser(htmlspecialchars($_POST['libraryCardNumber']));
                $this->library->returnLiteraryWorkFromLibraryUser($libraryUser, htmlspecialchars($_POST['itemToReturn']));
                header('Location: /libraryUser');
                exit();
            } catch (Exception $e) {
                $_SESSION['error_message'] = $e->getMessage();
                header('Location: /libraryUser');
                exit();
            }
        }
    }
}
