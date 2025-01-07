<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="bg-white rounded-lg shadow p-6">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Create Portfolio</h2>
    </div>

    <?php if (session()->has('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?= session()->get('error') ?>
        </div>
    <?php endif; ?>

    <form action="/portfolio/create" method="POST" enctype="multipart/form-data" class="space-y-6">
        <?= csrf_field() ?>
        
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" 
                   name="title" 
                   id="title" 
                   value="<?= old('title') ?>"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                   required>
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" 
                      id="description" 
                      rows="3" 
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                      required><?= old('description') ?></textarea>
        </div>

        <div>
            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
            <input type="text" 
                   name="category" 
                   id="category" 
                   value="<?= old('category') ?>"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                   required>
        </div>

        <div>
            <label for="portfolio_file" class="block text-sm font-medium text-gray-700">Portfolio File</label>
            <input type="file" 
                   name="portfolio_file" 
                   id="portfolio_file" 
                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" 
                   accept="image/*"
                   required>
            <p class="mt-1 text-sm text-gray-500">Upload your portfolio file (image only)</p>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                Create Portfolio
            </button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>