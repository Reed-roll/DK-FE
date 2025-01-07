<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="bg-white rounded-lg shadow p-6">
    <?php if (isset($error)): ?>
        <div class="text-red-600 mb-4"><?= $error ?></div>
    <?php else: ?>
        <!-- Creator Profile Header -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2"><?= $creator['name'] ?? 'Unknown Creator' ?></h2>
            <p class="text-gray-600"><?= $creator['role'] ?? '' ?></p>
        </div>

        <!-- Portfolio Grid -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-4">Portfolio</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php if (empty($portfolios)): ?>
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500">Belum ada portfolio yang tersedia</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($portfolios as $portfolio): ?>
                        <div class="border rounded-lg overflow-hidden">
                            <?php if ($portfolio['file_path']): ?>
                                <div class="aspect-w-16 aspect-h-9 bg-gray-100">
                                    <img src="<?= $baseURL . '/portfolio/image/' . basename($portfolio['file_path']) ?>" 
                                        alt="<?= $portfolio['title'] ?>" 
                                        class="object-cover w-full h-full">
                                </div>
                            <?php endif; ?>
                            <div class="p-4">
                                <h4 class="text-lg font-semibold"><?= $portfolio['title'] ?></h4>
                                <p class="text-gray-600 mt-1"><?= $portfolio['description'] ?></p>
                                <div class="mt-4 flex justify-between items-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <?= $portfolio['category'] ?>
                                    </span>
                                    <span class="text-gray-600">
                                        <svg class="w-5 h-5 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/>
                                        </svg>
                                        <?= $portfolio['likes'] ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <?php if (session()->get('role') === 'client'): ?>
            <div class="text-center">
                <a href="/project/create/<?= $creator['id'] ?>" 
                   class="inline-block bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                    Buat Project dengan Kreator Ini
                </a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>