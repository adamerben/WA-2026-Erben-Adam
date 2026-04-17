<?php 
$pageTitle = "Upravit knihu";
require_once '../app/views/layout/header.php'; 
?>
    <main class="max-w-3xl mx-auto mt-8 p-6 md:p-8 bg-white rounded-lg shadow-md border border-gray-200">
        <div class="mb-6 border-b pb-4">
            <h2 class="text-2xl font-bold text-gray-800">Upravit knihu</h2>
            <p class="text-gray-500 mt-1">Upravujete data pro knihu: <strong class="text-blue-600"><?= htmlspecialchars($book['title']) ?></strong></p>
        </div>
        
        <form action="<?= BASE_URL ?>/index.php?url=book/update/<?= htmlspecialchars($book['id']) ?>" method="post" enctype="multipart/form-data" class="space-y-5">
            
            <div>
                <label for="id_display" class="block text-sm font-medium text-gray-700 mb-1">ID v databázi (nelze měnit)</label>
                <input type="text" id="id_display" value="<?= htmlspecialchars($book['id']) ?>" readonly class="w-full md:w-1/3 bg-gray-100 border border-gray-300 text-gray-500 rounded-md p-2.5 cursor-not-allowed">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Název knihy <span class="text-red-500">*</span></label>
                    <input type="text" id="title" name="title" value="<?= htmlspecialchars($book['title']) ?>" required class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>
                <div>
                    <label for="author" class="block text-sm font-medium text-gray-700 mb-1">Autor <span class="text-red-500">*</span></label>
                    <input type="text" id="author" name="author" value="<?= htmlspecialchars($book['author']) ?>" required class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label for="isbn" class="block text-sm font-medium text-gray-700 mb-1">ISBN</label>
                    <input type="text" id="isbn" name="isbn" value="<?= htmlspecialchars($book['isbn'] ?? '') ?>" class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Kategorie </label>
                    <input type="text" id="category" name="category" value="<?= htmlspecialchars($book['category'] ?? '') ?>" class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>
                <div>
                    <label for="subcategory" class="block text-sm font-medium text-gray-700 mb-1">Podkategorie </label>
                    <input type="text" id="subcategory" name="subcategory" value="<?= htmlspecialchars($book['subcategory'] ?? '') ?>" class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Rok vydání <span class="text-red-500">*</span></label>
                    <input type="number" id="year" name="year" value="<?= htmlspecialchars($book['year'] ?? '') ?>" required class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Cena knihy (Kč)</label>
                    <input type="number" id="price" name="price" step="0.5" value="<?= htmlspecialchars($book['price'] ?? '') ?>" class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>
            </div>

            <div>
                <label for="link" class="block text-sm font-medium text-gray-700 mb-1">Odkaz</label>
                <input type="text" id="link" name="link" value="<?= htmlspecialchars($book['link'] ?? '') ?>" class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-blue-500 outline-none transition">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Popis knihy</label>
                <textarea id="description" name="description" rows="5" class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-blue-500 outline-none transition"><?= htmlspecialchars($book['description'] ?? '') ?></textarea>
            </div>    
            
            <div class="pt-4 mt-2 border-t flex justify-end">
                <button type="submit" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded shadow transition duration-200">
                    Uložit změny
                </button>
            </div>
        </form>
    </main>
<?php include __DIR__ . '/../layout/footer.php'; ?>