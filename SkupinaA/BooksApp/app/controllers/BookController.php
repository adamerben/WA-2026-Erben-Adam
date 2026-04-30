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
    // Zobrazení formuláře pro přidání knihy
    public function create() {
        // Kontrola přihlášení (pokud ji už máte zavedenou)
        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro přidání knihy se musíte nejprve přihlásit.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        // ZMĚNA: Načtení databáze a nového modelu Category
        require_once '../app/models/Database.php';
        require_once '../app/models/Category.php';

        $database = new Database();
        $db = $database->getConnection();

        // ZMĚNA: Získání seznamu kategorií
        $categoryModel = new Category($db);
        $categories = $categoryModel->getAllCategories();

        // V šabloně book_create.php nyní budeme mít k dispozici pole $categories
        require_once '../app/views/books/book_create.php';
    }

    // NOVÁ METODA: Zpracování formuláře a uložení
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // !!! ZMĚNA: ZDE PŘIDÁME KONTROLU PŘIHLÁŠENÍ ---
            if (!isset($_SESSION['user_id'])) {
                $this->addErrorMessage('Pro uložení knihy musíte být přihlášeni.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/login');
                exit;
            }
            $userId = $_SESSION['user_id'];
            // ---------------------------------------

            // 1. Získání a očištění textových dat
            $title = htmlspecialchars($_POST['title'] ?? '');
            $author = htmlspecialchars($_POST['author'] ?? '');
            $isbn = htmlspecialchars($_POST['isbn'] ?? '');
            // 🛡️ ZMĚNA: Kategorie k nám nyní chodí jako číslo (ID z value atributu selectu)
            $category = (int)($_POST['category'] ?? 0);
            $subcategory = htmlspecialchars($_POST['subcategory'] ?? '');
            $year = (int)($_POST['year'] ?? 0);
            $price = (float)($_POST['price'] ?? 0);
            $link = htmlspecialchars($_POST['link'] ?? '');
            $description = htmlspecialchars($_POST['description'] ?? '');

            // Zpracování nahraných souborů
            $uploadedImages = $this->processImageUploads();

            // 2. Komunikace s databází a modelem
            require_once '../app/models/Database.php';
            require_once '../app/models/Book.php';

            $database = new Database();
            $db = $database->getConnection();

            $bookModel = new Book($db);
            
            // !!! ZMĚNA: ZDE PŘIDÁME $userId jako poslední argument volání metody
            $isSaved = $bookModel->create(
                $title, $author, $category, $subcategory, 
                $year, $price, $isbn, $description, $link, $uploadedImages,
                $userId // PŘEDÁVÁME ID UŽIVATELE
            );

            // 3. Vyhodnocení výsledku a přesměrování
            if ($isSaved) {
                $this->addSuccessMessage('Kniha byla úspěšně uložena.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            } else {
                $this->addErrorMessage('Nepodařilo se uložit knihu do databáze.');
            }
            
        } else {
            $this->addNoticeMessage('Pro přidání knihy je nutné odeslat formulář.');
        }
    }

    // Zobrazení detailu jedné konkrétní knihy
    public function show($id = null) {
        // Kontrola, zda bylo předáno ID
        if (!$id) {
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Získání dat o knize z databáze
        $bookModel = new Book();
        $book = $bookModel->getById($id);

        // Pokud kniha v databázi neexistuje, vrátíme se na seznam
        if (!$book) {
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Načtení šablony pro zobrazení detailu
        require_once '../app/views/books/book_show.php';
    }

        // 3. Smazání existující knihy
    public function delete($id = null) {
        // 🔒 ZMĚNA: Kontrola autentizace. 
        // Pouze přihlášený uživatel může iniciovat proces mazání.
        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro smazání knihy se musíte nejprve přihlásit.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        // Kontrola, zda bylo v URL předáno ID
        if (!$id) {
            $this->addErrorMessage('Nebylo zadáno ID knihy ke smazání.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Načtení potřebných tříd a spojení s databází
        require_once '../app/models/Database.php';
        require_once '../app/models/Book.php';

        $database = new Database();
        $db = $database->getConnection();
        $bookModel = new Book($db);

        // 🛡️ ZMĚNA: Kontrola autorizace (vlastnictví).
        // Nejdříve musíme knihu načíst, abychom zjistili, kdo ji vytvořil.
        $book = $bookModel->getById($id);

        if (!$book) {
            $this->addErrorMessage('Kniha nebyla nalezena, pravděpodobně již byla smazána.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Ověříme, zda je aktuálně přihlášený uživatel autorem záznamu.
        if ($book['created_by'] !== $_SESSION['user_id']) {
            $this->addErrorMessage('Nemáte oprávnění smazat tuto knihu, protože nejste jejím autorem.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // 🛡️ ZMĚNA: Teprve po úspěšném ověření totožnosti provedeme samotné smazání.
        $isDeleted = $bookModel->delete($id);

        // Vyhodnocení výsledku a přesměrování s notifikací
        if ($isDeleted) {
            $this->addSuccessMessage('Kniha byla trvale smazána z databáze.');
        } else {
            $this->addErrorMessage('Nastala chyba. Knihu se nepodařilo smazat.');
        }

        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }


        // 4. Zobrazení formuláře pro úpravu existující knihy
    public function edit($id = null) {
        // 🔒 !!! ZMĚNA: Kontrola, zda je uživatel přihlášen. 
        // Pokud není, nepustíme ho ani k načítání dat z DB.
        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro úpravu knihy se musíte nejprve přihlásit.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }
        
        
        // Kontrola, zda bylo v URL vůbec předáno nějaké ID
        if (!$id) {
            // Vyvolání červené notifikace pro kritickou chybu
            $this->addErrorMessage('Nebylo zadáno ID knihy k úpravě.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Načtení potřebných tříd a spojení s databází
        require_once '../app/models/Database.php';
        require_once '../app/models/Book.php';

        $database = new Database();
        $db = $database->getConnection();

        // Získání dat o konkrétní knize
        $bookModel = new Book($db);
        $book = $bookModel->getById($id); // Proměnná $book nyní obsahuje asociativní pole dat

        // Bezpečnostní kontrola: Zda kniha s daným ID vůbec existuje
        if (!$book) {
            // Pokud knihu někdo mezitím smazal, nebo uživatel zadal do URL neexistující ID
            $this->addErrorMessage('Požadovaná kniha nebyla v databázi nalezena.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // 🛡️ !!! ZMĚNA: Kontrola vlastnictví (Autorizace).
        // Ověříme, zda ID přihlášeného uživatele odpovídá ID autora uloženého u knihy.
        if ($book['created_by'] !== $_SESSION['user_id']) {
            $this->addErrorMessage('Nemáte oprávnění upravovat tuto knihu, protože nejste jejím autorem.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Pokud je vše v pořádku, načte se připravený soubor s HTML formulářem pro úpravy.
        // Šablona bude mít automaticky přístup k proměnné $book.
        require_once '../app/views/books/book_edit.php';
    }

        // 5. Zpracování dat odeslaných z editačního formuláře
    public function update($id = null) {
        // Zabezpečení: Je k dispozici ID a byl odeslán formulář?
        if (!$id) {
            $this->addErrorMessage('Nebylo zadáno ID knihy k aktualizaci.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // 🔒 ZMĚNA: Kontrola, zda je uživatel vůbec přihlášen.
            if (!isset($_SESSION['user_id'])) {
                $this->addErrorMessage('Pro uložení změn se musíte nejprve přihlásit.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/login');
                exit;
            }

            // 🛡️ ZMĚNA: Komunikaci s databází jsme museli přesunout nahoru.
            // Musíme totiž nejprve zjistit, čí ta kniha vlastně je, než cokoli změníme.
            require_once '../app/models/Database.php';
            require_once '../app/models/Book.php';

            $database = new Database();
            $db = $database->getConnection();
            $bookModel = new Book($db);

            $book = $bookModel->getById($id);

            // 🛡️ ZMĚNA: Kontrola vlastnictví (Autorizace) - "Skutečná zeď".
            // Pokud kniha neexistuje, nebo ID autora nesouhlasí s přihlášeným uživatelem, je nutné ukládání přerušit.
            if (!$book || $book['created_by'] !== $_SESSION['user_id']) {
                $this->addErrorMessage('Nemáte oprávnění ukládat změny u této knihy, protože nejste jejím autorem.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            }

            // --- POKUD KONTROLY PROŠLY, POKRAČUJEME VE ZPRACOVÁNÍ DAT ---

            // 1. Získání a očištění textových dat
            $title = htmlspecialchars($_POST['title'] ?? '');
            $author = htmlspecialchars($_POST['author'] ?? '');
            $isbn = htmlspecialchars($_POST['isbn'] ?? '');
            $category = htmlspecialchars($_POST['category'] ?? '');
            $subcategory = htmlspecialchars($_POST['subcategory'] ?? '');
            
            // Přetypování číselných hodnot
            $year = (int)($_POST['year'] ?? 0);
            $price = (float)($_POST['price'] ?? 0);
            
            $link = htmlspecialchars($_POST['link'] ?? '');
            $description = htmlspecialchars($_POST['description'] ?? '');

            // Zavolání metody, která zpracuje soubory v $_FILES
            $uploadedImages = $this->processImageUploads();

            // 3. Volání updatu nad modelem
            // (Objekt $bookModel už máme vytvořený nahoře, takže ho jen použijeme)
            $isUpdated = $bookModel->update(
                $id, $title, $author, $category, $subcategory, 
                $year, $price, $isbn, $description, $link, $uploadedImages
            );

            // 4. Vyhodnocení výsledku a přesměrování
            if ($isUpdated) {
                // Vyvolání zelené notifikace o úspěchu
                $this->addSuccessMessage('Kniha byla úspěšně upravena.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            } else {
                // Vyvolání červené chybové notifikace
                $this->addErrorMessage('Nastala chyba. Změny se nepodařilo uložit.');
            }
            
        } else {
            // Pokud by někdo zkusil přistoupit na URL napřímo bez odeslání formuláře (žlutá notifikace)
            $this->addNoticeMessage('Pro úpravu knihy je nutné odeslat formulář.');
        }
    }
}