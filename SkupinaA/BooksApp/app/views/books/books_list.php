<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Knihovna - Seznam knih</title>
</head>

<body class="bg-gray-100 text-gray-800 font-sans p-6">
    <header class="bg-blue-600 text-white p-6 rounded-lg shadow-md mb-6">
        <h1 class="text-3xl font-bold mb-4">Aplikace Knihovna</h1>

        <nav>
            <ul class="flex space-x-4">
                <li><a href="<?= BASE_URL ?>/index.php" class="bg-blue-800 hover:bg-blue-700 px-4 py-2 rounded transition">Seznam knih (Domů)</a></li>
                <li><a href="<?= BASE_URL ?>/index.php?url=book/create" class="bg-green-600 hover:bg-green-500 px-4 py-2 rounded transition">Přidat novou knihu</a></li>
            </ul>
        </nav>
    </header>

    <main class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold border-b pb-2 mb-4">Dostupné knihy</h2>

        <?php if (empty($books)): ?>
            <p class="text-gray-500 italic">V databázi se zatím nenachází žádné knihy.</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-2 px-4 border-b text-left text-gray-600">ID</th>
                            <th class="py-2 px-4 border-b text-left text-gray-600">Název knihy</th>
                            <th class="py-2 px-4 border-b text-left text-gray-600">Autor</th>
                            <th class="py-2 px-4 border-b text-left text-gray-600">Rok vydání</th>
                            <th class="py-2 px-4 border-b text-left text-gray-600">Cena</th>
                            <th class="py-2 px-4 border-b text-left text-gray-600">Akce</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($books as $book): ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($book['id']) ?></td>
                                <td class="py-2 px-4 border-b font-medium"><?= htmlspecialchars($book['title'] ?? '') ?></td>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($book['author'] ?? '') ?></td>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($book['release_year'] ?? '') ?></td>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($book['price'] ?? '') ?> Kč</td>
                                <td class="py-2 px-4 border-b space-x-2">
                                    <a href="<?= BASE_URL ?>/index.php?url=book/show/<?= $book['id'] ?>" class="text-blue-500 hover:underline">Detail</a>
                                    <a href="<?= BASE_URL ?>/index.php?url=book/edit/<?= $book['id'] ?>" class="text-orange-500 hover:underline">Upravit</a>
                                    <a href="<?= BASE_URL ?>/index.php?url=book/delete/<?= $book['id'] ?>" class="text-red-500 hover:underline" onclick="return confirm('Opravdu chcete tuto knihu smazat?')">Smazat</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </main>

<?php include __DIR__ . '/../layout/footer.php'; ?>