<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="bg-white/70 backdrop-blur-lg rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-gray-100 p-8 animate-fadeIn">
    <div class="mb-8">
        <h2 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-red-600 to-orange-600">Portfolio Feed</h2>
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
                <div class="bg-white/50 backdrop-blur-sm border border-gray-100 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-200 transform hover:-translate-y-1">
                    <?php if ($portfolio['file_path']): ?>
                        <div class="aspect-w-16 aspect-h-9 bg-gray-100">
                            <img src="<?= $baseURL . '/portfolio/image/' . basename($portfolio['file_path']) ?>" 
                                alt="<?= $portfolio['title'] ?>" 
                                class="object-cover w-full h-48 rounded-t-xl">
                        </div>
                    <?php endif; ?>
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800"><?= $portfolio['title'] ?></h3>
                        <p class="text-gray-600 mt-2 text-sm"><?= $portfolio['description'] ?></p>
                        
                        <div class="mt-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gradient-to-r from-red-100 to-orange-100 text-red-600">
                                <?= $portfolio['category'] ?>
                            </span>
                        </div>

                        <div class="mt-4 flex items-center justify-between">
                            <a href="/feed/creator/<?= $portfolio['creator_id'] ?>" 
                               class="text-sm font-medium text-gray-600 hover:text-red-600 transition-colors">
                                <?= $portfolio['creator_name'] ?? $portfolio['creator_id'] ?>
                            </a>
                            <button class="flex items-center text-gray-600 hover:text-red-600 transition-colors duration-200">
                                <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/>
                                </svg>
                                <span class="text-sm"><?= $portfolio['likes'] ?? '0' ?></span>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
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