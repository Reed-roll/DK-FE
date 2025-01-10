<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="bg-white/70 backdrop-blur-lg rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-gray-100 p-8 animate-fadeIn">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-red-600 to-orange-600">Project Saya</h2>
    </div>

    <!-- Project List -->
    <div class="space-y-6">
        <?php if (empty($projects)): ?>
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">Belum ada project yang aktif</p>
                <p class="text-gray-500 mt-2">Silahkan melihat profil kreator untuk membuat project baru</p>
            </div>
        <?php else: ?>
            <?php foreach ($projects as $project): ?>
                <div class="border border-gray-100 rounded-xl p-6 bg-white/50 backdrop-blur-sm hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800"><?= $project['title'] ?></h3>
                            <p class="text-gray-600 mt-2"><?= $project['description'] ?></p>
                            <div class="mt-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gradient-to-r from-red-100 to-orange-100 text-red-600">
                                    <?= $project['status'] ?>
                                </span>
                            </div>
                        </div>
                        <div class="text-sm font-medium text-gray-500">
                            Deadline: <?= date('d M Y', strtotime($project['deadline'])) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Browse Creators Button -->
        <div class="mt-8 text-center">
            <a href="/feed" 
               class="inline-block bg-gradient-to-r from-red-600 to-orange-600 text-white px-6 py-3 rounded-xl hover:opacity-90 transform transition-all duration-200 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 font-medium">
                Lihat Kreator
            </a>
        </div>
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