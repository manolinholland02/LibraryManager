<?php

require_once(__DIR__ . '/controller.php');

class LibraryController extends Controller
{
    public function index()
    {
        require_once(__DIR__ . '/../views/library/index.php');
    }

    public function search()
    {
        $searchResults = [];

        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            $searchResults = $this->library->getLiteraryWorksByTitleOrAuthorOrISBN($search);
        }

        require_once(__DIR__ . '/../views/library/index.php');
    }
}