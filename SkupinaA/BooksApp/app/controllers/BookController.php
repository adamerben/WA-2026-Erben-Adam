<?php
// Načtení modelu
require_once '../app/models/Book.php';

class BookController
{

    // Výchozí metoda pro zobrazení úvodní stránky
    // Výchozí metoda pro zobrazení úvodní stránky
    public function index()
    {
        // Vytvoření instance modelu
        $bookModel = new Book();

        // Získání všech knih a uložení do proměnné $books
        $books = $bookModel->getAll();

        // Načtení šablony (šablona automaticky uvidí proměnnou $books)
        require_once '../app/views/books/books_list.php';
    }

    // 1. Zobrazení formuláře pro přidání nové knihy
    public function create()
    {
        // Zde se pouze načte (vloží) připravený soubor s HTML formulářem
        require_once '../app/views/books/book_create.php';
    }

    // NOVÁ METODA: Zpracování formuláře a uložení
    public function store()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // 1. Posbírání dat z formuláře
            $data = [
                'title' => $_POST['title'] ?? '',
                'author' => $_POST['author'] ?? '',
                'isbn' => $_POST['isbn'] ?? '',
                'category' => $_POST['category'] ?? '',
                'subcategory' => $_POST['subcategory'] ?? '',
                'year' => $_POST['year'] ?? '',
                'price' => $_POST['price'] ?? null,
                'link' => $_POST['link'] ?? '',
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

    // 3. Smazání existující knihy
    public function delete($id = null)
    {
        // Kontrola, zda bylo v URL předáno ID
        if (!$id) {
            // $this->addErrorMessage('Nebylo zadáno ID knihy ke smazání.'); 
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // ZDE BYLY SMAZÁNY ŘÁDKY O DATABASE.PHP

        // Inicializace modelu a zavolání metody pro smazání
        $bookModel = new Book(); // Už žádné předávání $db !
        $isDeleted = $bookModel->delete($id);

        // Vyhodnocení výsledku a přesměrování s notifikací
        if ($isDeleted) {
            // $this->addSuccessMessage('Kniha byla trvale smazána z databáze.');
        } else {
            // $this->addErrorMessage('Nastala chyba. Knihu se nepodařilo smazat.');
        }

        // Vždy následuje návrat na seznam knih
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }


    // 4. Zobrazení formuláře pro úpravu existující knihy
    public function edit($id = null)
    {
        // Kontrola, zda bylo v URL vůbec předáno nějaké ID
        if (!$id) {
            // Vyvolání červené notifikace pro kritickou chybu
            // $this->addErrorMessage('Nebylo zadáno ID knihy k úpravě.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Načtení potřebných tříd a spojení s databází
        require_once '../app/models/Book.php';

        // Získání dat o konkrétní knize
        $bookModel = new Book();
        $book = $bookModel->getById($id); // Proměnná $book nyní obsahuje asociativní pole dat

        // Bezpečnostní kontrola: Zda kniha s daným ID vůbec existuje
        if (!$book) {
            // Pokud knihu někdo mezitím smazal, nebo uživatel zadal do URL neexistující ID
            // $this->addErrorMessage('Požadovaná kniha nebyla v databázi nalezena.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Pokud je vše v pořádku, načte se připravený soubor s HTML formulářem pro úpravy.
        // Šablona bude mít automaticky přístup k proměnné $book.
        require_once '../app/views/books/book_edit.php';
    }

    // 5. Zpracování dat odeslaných z editačního formuláře
    public function update($id = null)
    {
        // Zabezpečení: Je k dispozici ID a byl odeslán formulář?
        if (!$id) {
            // $this->addErrorMessage('Nebylo zadáno ID knihy k aktualizaci.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // 1. Získání a očištění textových dat
            $title = htmlspecialchars($_POST['title'] ?? '');
            $author = htmlspecialchars($_POST['author'] ?? '');
            $isbn = htmlspecialchars($_POST['isbn'] ?? '');
            $category = htmlspecialchars($_POST['category'] ?? '');
            $subcategory = htmlspecialchars($_POST['subcategory'] ?? '');

            // Přetypování číselných hodnot
            $year = (int) ($_POST['year'] ?? 0);
            $price = (float) ($_POST['price'] ?? 0);

            $link = htmlspecialchars($_POST['link'] ?? '');
            $description = htmlspecialchars($_POST['description'] ?? '');

            // Prozatímní zástupce pro obrázky
            $uploadedImages = [];

            // 2. Komunikace s databází a modelem
            require_once '../app/models/Book.php';

            // 3. Volání updatu nad modelem
            $bookModel = new Book();
            $isUpdated = $bookModel->update(
                $id,
                $title,
                $author,
                $category,
                $subcategory,
                $year,
                $price,
                $isbn,
                $description,
                $link,
                $uploadedImages
            );

            // 4. Vyhodnocení výsledku a přesměrování
            if ($isUpdated) {
                // Vyvolání zelené notifikace o úspěchu
                // $this->addSuccessMessage('Kniha byla úspěšně upravena.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            } else {
                // Vyvolání červené chybové notifikace
                // $this->addErrorMessage('Nastala chyba. Změny se nepodařilo uložit.');
            }

        } else {
            // Pokud by někdo zkusil přistoupit na URL napřímo bez odeslání formuláře (žlutá notifikace)
            // $this->addNoticeMessage('Pro úpravu knihy je nutné odeslat formulář.');
        }
    }
}