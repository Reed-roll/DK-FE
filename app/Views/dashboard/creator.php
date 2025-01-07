<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<!-- Edit Portfolio Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Portfolio</h3>
            <form id="editForm" class="space-y-4">
                <input type="hidden" id="editPortfolioId" name="id">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Judul</label>
                    <input type="text" id="editTitle" name="title" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea id="editDescription" name="description" rows="3" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select id="editCategory" name="category" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="desain logo">Desain Logo</option>
                        <option value="banner">Banner</option>
                        <option value="video">Video</option>
                        <option value="gambar">Gambar</option>
                    </select>
                </div>

                <div class="mt-4 flex justify-end space-x-3">
                    <button type="button" onclick="closeEditModal()" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Dashboard Creator</h2>
        <a href="/portfolio/create" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
            Tambah Portfolio
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Portfolio Section -->
    <div class="mt-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Portfolio Saya</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php 
            $portfolioData = json_decode($debug['response'], true);
            $hasUserPortfolios = false;
            
            if (!empty($portfolioData)): 
                foreach ($portfolioData as $portfolio):
                    if($portfolio['creator_id'] == session()->get('user_id')):
                        $hasUserPortfolios = true;
            ?>
                        <div class="border rounded-lg overflow-hidden bg-white">
                            <?php if ($portfolio['file_path']): ?>
                                <div class="aspect-w-16 aspect-h-9 bg-gray-100">
                                    <img src="<?= $baseURL . '/portfolio/image/' . basename($portfolio['file_path']) ?>" 
                                         alt="<?= esc($portfolio['title']) ?>" 
                                         class="object-cover w-full h-full">
                                </div>
                            <?php endif; ?>
                            <div class="p-4">
                                <h4 class="text-lg font-semibold text-gray-900"><?= esc($portfolio['title']) ?></h4>
                                <p class="text-gray-600 mt-1"><?= esc($portfolio['description']) ?></p>
                                <div class="mt-4 flex justify-between items-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <?= esc($portfolio['category']) ?>
                                    </span>
                                    <span class="text-sm text-gray-500">
                                        <?= $portfolio['likes'] ?> likes
                                    </span>
                                </div>
                                <div class="mt-4 flex justify-end space-x-2">
                                    <button onclick="openEditModal(<?= htmlspecialchars(json_encode($portfolio)) ?>)" 
                                            class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm">
                                        Edit
                                    </button>
                                    <button onclick="deletePortfolio(<?= $portfolio['id'] ?>)" 
                                            class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endif;
                endforeach;
            endif;
            
            if (!$hasUserPortfolios): ?>
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500">Belum ada portfolio yang tersedia</p>
                    <p class="text-gray-500 mt-2">Klik tombol "Tambah Portfolio" untuk membuat portfolio baru</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function openEditModal(portfolio) {
    document.getElementById('editPortfolioId').value = portfolio.id;
    document.getElementById('editTitle').value = portfolio.title;
    document.getElementById('editDescription').value = portfolio.description;
    document.getElementById('editCategory').value = portfolio.category;
    
    document.getElementById('editModal').classList.remove('hidden');

    // Update form action
    document.getElementById('editForm').action = `/portfolio/update/${portfolio.id}`;
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

function deletePortfolio(id) {
    if (confirm('Apakah Anda yakin ingin menghapus portfolio ini?')) {
        window.location.href = `/dashboard/deletePortfolio/${id}`;
    }
}

document.getElementById('editForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const portfolioId = document.getElementById('editPortfolioId').value;
    
    // Convert FormData to URLSearchParams for application/x-www-form-urlencoded
    const params = new URLSearchParams();
    for (const pair of formData) {
        params.append(pair[0], pair[1]);
    }
    
    fetch(`/dashboard/updatePortfolio/${portfolioId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: params
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeEditModal();
            window.location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memperbarui portfolio');
    });
});

// Close modal when clicking outside
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});

// Prevent modal close when clicking inside the form
document.querySelector('#editModal > div').addEventListener('click', function(e) {
    e.stopPropagation();
});
</script>
<?= $this->endSection() ?>