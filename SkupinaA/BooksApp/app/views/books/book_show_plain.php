<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail knihy</title>
</head>
<body>
    <header>
        <h1>Aplikace Knihovna</h1>
        <nav>
            <ul>
                <li><a href="<?= BASE_URL ?>/index.php">Zpět na seznam knih</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Detail knihy: <?= htmlspecialchars($book['title']) ?></h2>
        
        <div>
            <p><strong>Autor:</strong> <?= htmlspecialchars($book['author']) ?></p>
            <p><strong>Rok vydání:</strong> <?= htmlspecialchars($book['year']) ?></p>
            <p><strong>Cena:</strong> <?= htmlspecialchars($book['price'] ?? 'Neuvedena') ?> Kč</p>
            <p><strong>Kategorie:</strong> <?= htmlspecialchars($book['category'] ?? '') ?></p>
            <p><strong>Podkategorie:</strong> <?= htmlspecialchars($book['subcategory'] ?? '') ?></p>
            <p><strong>ISBN:</strong> <?= htmlspecialchars($book['isbn'] ?? '') ?></p>
            
            <p><strong>Popis:</strong></p>
            <p><?= nl2br(htmlspecialchars($book['description'] ?? '')) ?></p>
            
            <?php if (!empty($book['link'])): ?>
                <p><a href="<?= htmlspecialchars($book['link']) ?>" target="_blank">Externí odkaz na knihu</a></p>
            <?php endif; ?>
        </div>

        <div style="margin-top: 20px;">
            <a href="<?= BASE_URL ?>/index.php?url=book/edit/<?= $book['id'] ?>">Upravit tuto knihu</a> | 
            <a href="<?= BASE_URL ?>/index.php?url=book/delete/<?= $book['id'] ?>" onclick="return confirm('Opravdu chcete tuto knihu smazat?')">Smazat knihu</a>
        </div>
    </main>
</body>
</html>