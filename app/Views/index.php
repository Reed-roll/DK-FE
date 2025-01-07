<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DigitalKreator - Platform Kolaborasi Kreator Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
        }
    </style>
</head>
<body class="font-sans">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm fixed w-full z-50">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <a href="/" class="text-2xl font-bold text-indigo-600">DigitalKreator</a>
                <div class="hidden md:flex space-x-8">
                    <a href="#layanan" class="text-gray-600 hover:text-indigo-600">Layanan</a>
                    <a href="#cara-kerja" class="text-gray-600 hover:text-indigo-600">Cara Kerja</a>
                    <a href="/feed" class="text-gray-600 hover:text-indigo-600">Lihat Projek</a>
                </div>
                <div class="space-x-4">
                    <?php if (session()->get('logged_in')): ?>
                        <a href="/dashboard" class="text-gray-600 hover:text-indigo-600">Dashboard</a>
                        <a href="/logout" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                            Logout
                        </a>
                    <?php else: ?>
                        <a href="/login" class="text-gray-600 hover:text-indigo-600">Login</a>
                        <a href="/register" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                            Daftar
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-gradient pt-32 pb-20">
        <div class="container mx-auto px-4">
            <div class="text-center text-white">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    Temukan Kreator Digital Terbaik
                </h1>
                <p class="text-xl md:text-2xl mb-8 opacity-90">
                    Wujudkan ide kreatif Anda bersama para profesional
                </p>
                <div class="space-x-4">
                    <a href="/register" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold inline-block hover:bg-gray-100">
                        Mulai Sekarang
                    </a>
                    <a href="#cara-kerja" class="border border-white text-white px-8 py-3 rounded-lg font-semibold inline-block hover:bg-white hover:text-indigo-600">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="layanan" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Layanan Kami</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <!-- Logo Design -->
                <div class="p-6 border border-gray-200 rounded-lg text-center">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Desain Logo</h3>
                    <p class="text-gray-600">Jasa desain logo profesional untuk identitas brand Anda</p>
                </div>
                
                <!-- Banner Design -->
                <div class="p-6 border border-gray-200 rounded-lg text-center">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Desain Banner</h3>
                    <p class="text-gray-600">Banner menarik untuk sosial media dan marketing</p>
                </div>

                <!-- Video Editing -->
                <div class="p-6 border border-gray-200 rounded-lg text-center">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Editing Video</h3>
                    <p class="text-gray-600">Editing video profesional dan post-production</p>
                </div>
            </div>

            <!-- Feed Button -->
            <div class="text-center">
                <a href="/feed" class="inline-block bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-700">
                    Lihat Proyek Terbaru
                </a>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="cara-kerja" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Cara Kerja</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-600 rounded-full flex items-center justify-center text-white text-2xl mx-auto mb-4">1</div>
                    <h3 class="text-xl font-semibold mb-2">Hubungi Kreator</h3>
                    <p class="text-gray-600">Pilih dan diskusikan project Anda dengan kreator profesional</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-600 rounded-full flex items-center justify-center text-white text-2xl mx-auto mb-4">2</div>
                    <h3 class="text-xl font-semibold mb-2">Kelola Project</h3>
                    <p class="text-gray-600">Pantau perkembangan project dan berikan feedback</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-600 rounded-full flex items-center justify-center text-white text-2xl mx-auto mb-4">3</div>
                    <h3 class="text-xl font-semibold mb-2">Terima Hasil</h3>
                    <p class="text-gray-600">Dapatkan hasil project sesuai dengan kebutuhan Anda</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-gray-200">
        <div class="container mx-auto px-4 py-8">
            <div class="text-center text-gray-600">
                <p>&copy; <?= date('Y') ?> DigitalKreator. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>
</body>
</html>