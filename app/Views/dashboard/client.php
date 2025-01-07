<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Project Saya</h2>
    </div>

    <!-- Project List -->
    <div class="space-y-6">
        <?php if (empty($projects)): ?>
            <div class="text-center py-12">
                <p class="text-gray-500">Belum ada project yang aktif</p>
                <p class="text-gray-500 mt-2">Silahkan melihat profil kreator untuk membuat project baru</p>
            </div>
        <?php else: ?>
            <?php foreach ($projects as $project): ?>
                <div class="border rounded-lg p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold"><?= $project['title'] ?></h3>
                            <p class="text-gray-600 mt-1"><?= $project['description'] ?></p>
                            <div class="mt-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <?= $project['status'] ?>
                                </span>
                            </div>
                        </div>
                        <div class="text-sm text-gray-500">
                            Deadline: <?= date('d M Y', strtotime($project['deadline'])) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Browse Creators Button -->
        <div class="mt-6 text-center">
            <a href="/feed" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                Lihat Kreator
            </a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>