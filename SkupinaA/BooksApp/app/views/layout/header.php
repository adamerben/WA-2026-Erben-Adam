<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title><?= $pageTitle ?? 'Knihovna' ?></title>
</head>
<body class="bg-gray-100 text-gray-800 font-sans">
    <header class="bg-blue-600 text-white p-4 shadow-md">
        <div class="max-w-4xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Aplikace Knihovna</h1>
            <nav>
                <ul class="flex gap-4">
                    <li><a href="<?= BASE_URL ?>/index.php" class="hover:underline font-medium">Seznam knih</a></li>
                    <li><a href="<?= BASE_URL ?>/index.php?url=book/create" class="hover:underline font-medium">Přidat knihu</a></li>
                </ul>
            </nav>
        </div>
    </header>