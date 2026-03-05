<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <div>
            <h2>Přidat novou knihu</h2>
            <p>Zadejte informace o nové knize.</p>
        </div>

        <div>
            <form action="">
                <div>
                    <div>
                        <label for="title">Název knihy <span>*</span></label>
                        <input type="text" id="title" name="title" required>
                    </div>
                    <div>
                        <label for="author">Autor <span>*</span></label>
                        <input type="text" id="author" name="author" required>
                    </div>
                    <div>
                        <label for="category">Kategorie</label>
                        <input type="text" id="category" name="category">
                    </div>
                    <div>
                        <label for="subcategory">Podkategorie</label>
                        <input type="text" id="subcategory" name="subcategory">
                    </div>
                    <div>
                        <label for="year">Rok vydání</label>
                        <input type="number" id="year" name="year">
                    </div>
                    <div>
                        <button type="submit">Přidat knihu</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>