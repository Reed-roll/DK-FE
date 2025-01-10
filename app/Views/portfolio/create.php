<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="bg-white/70 backdrop-blur-lg rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-gray-100 p-8 animate-fadeIn">
    <div class="mb-8">
        <h2 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-red-600 to-orange-600">Create Portfolio</h2>
    </div>

    <?php if (session()->has('error')): ?>
        <div class="bg-red-50 text-red-500 p-4 rounded-xl border border-red-100 animate-fadeIn mb-6">
            <?= session()->get('error') ?>
        </div>
    <?php endif; ?>

    <form action="/portfolio/create" method="POST" enctype="multipart/form-data" class="space-y-6">
        <?= csrf_field() ?>
        
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
            <input type="text" 
                   name="title" 
                   id="title" 
                   value="<?= old('title') ?>"
                   class="block w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50/50 focus:bg-white transition-all duration-200 outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500" 
                   required>
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" 
                      id="description" 
                      rows="3" 
                      class="block w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50/50 focus:bg-white transition-all duration-200 outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500" 
                      required><?= old('description') ?></textarea>
        </div>

        <div>
            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
            <input type="text" 
                   name="category" 
                   id="category" 
                   value="<?= old('category') ?>"
                   class="block w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50/50 focus:bg-white transition-all duration-200 outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500" 
                   required>
        </div>

        <div>
            <label for="portfolio_file" class="block text-sm font-medium text-gray-700 mb-1">Portfolio File</label>
            <input type="file" 
                   name="portfolio_file" 
                   id="portfolio_file" 
                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-gradient-to-r file:from-red-50 file:to-orange-50 file:text-red-600 hover:file:bg-gradient-to-r hover:file:from-red-100 hover:file:to-orange-100 transition-all duration-200" 
                   accept="image/*"
                   required>
            <p class="mt-1 text-sm text-gray-500">Upload your portfolio file (image only)</p>
        </div>

        <div class="flex justify-end">
            <button type="submit" 
                    class="bg-gradient-to-r from-red-600 to-orange-600 text-white px-6 py-3 rounded-xl hover:opacity-90 transform transition-all duration-200 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 font-medium">
                Create Portfolio
            </button>
        </div>
    </form>
</div>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn {
    animation: fadeIn 0.5s ease-out;
}
</style>
<?= $this->endSection() ?>