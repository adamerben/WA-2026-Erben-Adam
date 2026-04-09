<?php 
$pageTitle = "Detail knihy";
require_once '../app/views/layout/header.php'; 
?>
    <main class="max-w-4xl mx-auto mt-8 p-6 md:p-8 bg-white rounded-lg shadow-md border border-gray-200">
        
        <div class="mb-6 pb-4 border-b flex flex-col md:flex-row md:justify-between md:items-end gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-800"><?= htmlspecialchars($book['title']) ?></h2>
                <p class="text-xl text-blue-600 mt-1"><?= htmlspecialchars($book['author']) ?></p>
            </div>
            
            <div class="flex gap-3">
                <a href="<?= BASE_URL ?>/index.php?url=book/edit/<?= $book['id'] ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow transition">
                    ✏️ Upravit
                </a>
                <a href="<?= BASE_URL ?>/index.php?url=book/delete/<?= $book['id'] ?>" onclick="return confirm('Opravdu chcete tuto knihu smazat?')" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow transition">
                    🗑️ Smazat
                </a>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 mb-8">
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                <p class="text-sm text-gray-500 uppercase tracking-wide">Základní informace</p>
                <ul class="mt-2 space-y-2">
                    <li><span class="font-semibold text-gray-700 w-32 inline-block">Rok vydání:</span> <?= htmlspecialchars($book['release_year'] ?? 'Neuveden') ?></li>
                    <li><span class="font-semibold text-gray-700 w-32 inline-block">ISBN:</span> <?= htmlspecialchars($book['isbn'] ?? 'Neuvedeno') ?></li>
                    <li><span class="font-semibold text-gray-700 w-32 inline-block">Cena:</span> <span class="text-green-600 font-bold"><?= htmlspecialchars($book['price'] ?? 'Neuvedena') ?> Kč</span></li>
                </ul>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                <p class="text-sm text-gray-500 uppercase tracking-wide">Kategorizace</p>
                <ul class="mt-2 space-y-2">
                    <li><span class="font-semibold text-gray-700 w-32 inline-block">Kategorie:</span> <?= htmlspecialchars($book['category'] ?? 'Neuvedena') ?></li>
                    <li><span class="font-semibold text-gray-700 w-32 inline-block">Podkategorie:</span> <?= htmlspecialchars($book['subcategory'] ?? 'Neuvedena') ?></li>
                    <?php if (!empty($book['link'])): ?>
                        <li class="pt-2">
                            <a href="<?= htmlspecialchars($book['link']) ?>" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline font-medium">
                                🔗 Otevřít externí odkaz
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <div>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Popis knihy</h3>
            <div class="bg-gray-50 p-5 rounded-lg border border-gray-200 text-gray-700 leading-relaxed">
                <?php if (!empty($book['description'])): ?>
                    <?= nl2br(htmlspecialchars($book['description'])) ?>
                <?php else: ?>
                    <p class="italic text-gray-400">Tato kniha zatím nemá žádný popis.</p>
                <?php endif; ?>
            </div>
        </div>

    </main>
<?php include __DIR__ . '/../layout/footer.php'; ?>