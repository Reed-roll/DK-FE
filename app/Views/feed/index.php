<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="bg-white rounded-lg shadow p-6">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Portfolio Feed</h2>
    </div>

    <!-- Portfolio Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php 
        $portfolioData = json_decode($debug['response'], true);
        if (empty($portfolioData)): 
        ?>
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500">Belum ada portfolio yang tersedia</p>
            </div>
        <?php else: ?>
            <?php foreach ($portfolioData as $portfolio): ?>
                <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                    <?php if ($portfolio['file_path']): ?>
                        <div class="aspect-w-16 aspect-h-9 bg-gray-100">
                            <img src="<?= $baseURL . '/portfolio/image/' . basename($portfolio['file_path']) ?>" 
                                alt="<?= $portfolio['title'] ?>" 
                                class="object-cover w-full h-48">
                        </div>
                    <?php endif; ?>
                    <div class="p-4">
                        <h3 class="text-lg font-medium text-gray-900"><?= $portfolio['title'] ?></h3>
                        <p class="text-gray-600 mt-1 text-sm"><?= $portfolio['description'] ?></p>
                        
                        <div class="mt-3">
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                <?= $portfolio['category'] ?>
                            </span>
                        </div>

                        <div class="mt-4 flex items-center justify-between">
                            <a href="/feed/creator/<?= $portfolio['creator_id'] ?>" 
                               class="text-sm text-gray-600 hover:text-indigo-600">
                                <?= $portfolio['creator_name'] ?? $portfolio['creator_id'] ?>
                            </a>
                            <div class="flex items-center gap-1">
                                <button class="text-gray-500 hover:text-indigo-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                    </svg>
                                </button>
                                <span class="text-sm text-gray-600"><?= $portfolio['likes'] ?? '0' ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>