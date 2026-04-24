<?php 
$pageTitle = "Seznam knih";
require_once '../app/views/layout/header.php'; 
?>
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
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($book['year'] ?? '') ?></td>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($book['price'] ?? '') ?> Kč</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-3 text-sm">
                                        
                                        <a href="<?= BASE_URL ?>/index.php?url=book/show/<?= $book['id'] ?>" class="text-blue-400 hover:text-white transition-colors underline decoration-blue-800 underline-offset-4">Detail</a>
                                        
                                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $book['created_by']): ?>
                                            <a href="<?= BASE_URL ?>/index.php?url=book/edit/<?= $book['id'] ?>" class="text-emerald-400 hover:text-white transition-colors underline decoration-emerald-800 underline-offset-4">Upravit</a>
                                            <a href="<?= BASE_URL ?>/index.php?url=book/delete/<?= $book['id'] ?>" onclick="return confirm('Opravdu chcete tuto knihu smazat?')" class="text-rose-400 hover:text-white transition-colors underline decoration-rose-800 underline-offset-4">Smazat</a>
                                        <?php endif; ?>
                                        
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </main>

<?php include __DIR__ . '/../layout/footer.php'; ?>