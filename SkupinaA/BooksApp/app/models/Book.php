<?php

class Book {
    private $db;

    public function __construct() {
        // Zde si uprav údaje podle svého lokálního serveru (XAMPP/MAMP)
        $host = '127.0.0.1';
        $dbname = 'WA_2026_AE_01'; // Zadej název své databáze
        $user = 'root';          // Výchozí XAMPP uživatel
        $pass = '';              // Výchozí XAMPP heslo (prázdné)

        try {
            $this->db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
            // Nastavení vyhazování výjimek při chybě databáze
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Chyba připojení k databázi: " . $e->getMessage());
        }
    }

    // Metoda pro získání existujícího připojení k DB
    public function getConnection() {
        return $this->db;
    }

    // Metoda pro uložení knihy do DB
        public function create(
        string $title,
        string $author,
        string $category,
        string $subcategory,
        int $year,
        float $price,
        string $isbn,
        string $description,
        string $link,
        array $images,
        int $userId // !!! ZMĚNA: NOVÝ PARAMETR PRO ID UŽIVATELE
    ): bool {
        // !!! ZMĚNA: Přidali jsme created_by do INSERT i VALUES
        $sql = "INSERT INTO books (title, author, category, subcategory, year, price, isbn, description, link, images, created_by)
                VALUES (:title, :author, :category, :subcategory, :year, :price, :isbn, :description, :link, :images, :created_by)";
        
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':title' => $title,
            ':author' => $author,
            ':category' => $category,
            ':subcategory' => $subcategory ?: null,
            ':year' => $year,
            ':price' => $price,
            ':isbn' => $isbn,
            ':description' => $description,
            ':link' => $link,
            ':images' => json_encode($images),
            ':created_by' => $userId // !!! ZMĚNA: Předání ID do databáze
        ]);
    }

        // Získání jedné konkrétní knihy podle jejího ID
    public function getById($id) {
        $sql = "SELECT * FROM books WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        // Používá se fetch() místo fetchAll(), protože očekáváme maximálně jeden výsledek.
        // Vrátí asociativní pole s daty knihy, nebo false, pokud kniha neexistuje.
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Aktualizace existující knihy
    public function update(
        $id, $title, $author, $category, $subcategory, 
        $year, $price, $isbn, $description, $link, $images = []
    ) {
        $sql = "UPDATE books 
                SET title = :title, 
                    author = :author, 
                    category = :category, 
                    subcategory = :subcategory, 
                    year = :year, 
                    price = :price, 
                    isbn = :isbn, 
                    description = :description, 
                    link = :link
                WHERE id = :id";
                
        $stmt = $this->db->prepare($sql);

        // Parametrů je stejné množství jako u create, navíc je pouze :id
        return $stmt->execute([
            ':id' => $id,
            ':title' => $title,
            ':author' => $author,
            ':category' => $category,
            ':subcategory' => $subcategory ?: null,
            ':year' => $year,
            ':price' => $price,
            ':isbn' => $isbn,
            ':description' => $description,
            ':link' => $link
        ]);
    }

        // Trvalé smazání knihy z databáze
    public function delete($id) {
        $sql = "DELETE FROM books WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        // Vrací true při úspěchu, false při chybě
        return $stmt->execute([':id' => $id]);
    }

    // Získání všech knih z databáze
    public function getAll() {
        $sql = "SELECT * FROM books";
        $stmt = $this->db->query($sql);
        
        // Vrátí pole všech knih jako asociativní pole
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}