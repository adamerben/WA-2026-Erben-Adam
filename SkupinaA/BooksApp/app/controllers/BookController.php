<?php
// Načtení modelu
require_once '../app/models/Book.php';

class BookController {

    // Výchozí metoda pro zobrazení úvodní stránky
    public function index() {
        require_once '../app/views/books/books_list.php';
    }

    // Metoda pro zobrazení formuláře pro přidání knihy
    public function create() {
        require_once '../app/views/books/book_create.php';
    }

    // NOVÁ METODA: Zpracování formuláře a uložení
    public function store() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // 1. Posbírání dat z formuláře
            $data = [
                'title'       => $_POST['title'] ?? '',
                'author'      => $_POST['author'] ?? '',
                'isbn'        => $_POST['isbn'] ?? '',
                'category'    => $_POST['category'] ?? '',
                'subcategory' => $_POST['subcategory'] ?? '',
                'year'        => $_POST['year'] ?? '',
                'price'       => $_POST['price'] ?? null,
                'link'        => $_POST['link'] ?? '',
                'description' => $_POST['description'] ?? ''
            ];

            // 2. Vytvoření instance modelu
            $bookModel = new Book();

            // 3. Volání metody pro uložení
            $success = $bookModel->create($data);

            if ($success) {
                // Přesměrování zpět na hlavní stránku po úspěšném uložení
                // Uprav cestu podle tvého routeru
                header('Location: /WA-2026-Erben-Adam/SkupinaA/BooksApp/public/index.php');
                exit;
            } else {
                echo "Došlo k chybě při ukládání do databáze.";
            }
        }
    }
}