<?php 
$pageTitle = "Přidat novou knihu";
require_once '../app/views/layout/header.php'; 
?>
    <main class="max-w-3xl mx-auto mt-8 p-6 md:p-8 bg-white rounded-lg shadow-md border border-gray-200">
        <div class="mb-6 border-b pb-4">
            <h2 class="text-2xl font-bold text-gray-800">Přidat novou knihu</h2>
            <p class="text-gray-500 mt-1">Vyplňte údaje a uložte knihu do databáze.</p>
        </div>
        
        <form action="<?= BASE_URL ?>/index.php?url=book/store" method="post" enctype="multipart/form-data" class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Název knihy <span class="text-red-500">*</span></label>
                    <input type="text" id="title" name="title" required class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>
                <div>
                    <label for="author" class="block text-sm font-medium text-gray-700 mb-1">Autor <span class="text-red-500">*</span></label>
                    <input type="text" id="author" name="author" placeholder="Příjmení Jméno" required class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label for="isbn" class="block text-sm font-medium text-gray-700 mb-1">ISBN</label>
                    <input type="text" id="isbn" name="isbn" class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>
            <div>
                <label for="category">Kategorie *</label>
                <!-- ZMĚNA: Použití select místo input a iterace přes $categories -->
                <select id="category" name="category" required>
                    <option value="">-- Vyberte kategorii --</option>
                    
                    <?php foreach ($categories as $cat): ?>
                        <!-- Do value ukládáme ID kategorie (to se odešle do DB), ale uživateli zobrazíme název -->
                        <option value="<?= htmlspecialchars($cat['id']) ?>">
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                    
                </select>
            </div>
                <div>
                    <label for="subcategory" class="block text-sm font-medium text-gray-700 mb-1">Podkategorie</label>
                    <input type="text" id="subcategory" name="subcategory" class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Rok vydání <span class="text-red-500">*</span></label>
                    <input type="number" id="year" name="year" required class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Cena knihy (Kč)</label>
                    <input type="number" id="price" name="price" step="0.5" class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>
            </div>

            <div>
                <label for="link" class="block text-sm font-medium text-gray-700 mb-1">Externí odkaz</label>
                <input type="text" id="link" name="link" class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-blue-500 outline-none transition">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Popis knihy</label>
                <textarea id="description" name="description" rows="4" class="w-full border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-blue-500 outline-none transition"></textarea>
            </div>    
            
            <div class="pt-4 mt-2 border-t flex justify-end">
                <button type="submit" class="w-full md:w-auto bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded shadow transition duration-200">
                    Uložit knihu
                </button>
            </div>
        </form>
    </main>
<?php include __DIR__ . '/../layout/footer.php'; ?>