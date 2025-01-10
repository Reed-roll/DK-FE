<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DigitalKreator - Platform Kolaborasi Kreator Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #dc2626 0%, #ea580c 100%);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body class="font-sans">
    <nav class="bg-white/70 backdrop-blur-lg shadow-sm fixed w-full z-50">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <a href="/" class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-red-600 to-orange-600">DigitalKreator</a>
                <div class="hidden md:flex space-x-8">
                    <a href="#layanan" class="text-gray-600 hover:text-red-600 transition-colors">Layanan</a>
                    <a href="#cara-kerja" class="text-gray-600 hover:text-red-600 transition-colors">Cara Kerja</a>
                    <a href="/feed" class="text-gray-600 hover:text-red-600 transition-colors">Lihat Projek</a>
                </div>
                <div class="space-x-4">
                    <?php if (session()->get('logged_in')): ?>
                        <a href="/dashboard" class="text-gray-600 hover:text-red-600 transition-colors">Dashboard</a>
                        <a href="/logout" class="bg-gradient-to-r from-red-600 to-orange-600 text-white px-4 py-2 rounded-xl hover:opacity-90 transition-all duration-200">
                            Logout
                        </a>
                    <?php else: ?>
                        <a href="/login" class="text-gray-600 hover:text-red-600 transition-colors">Login</a>
                        <a href="/register" class="bg-gradient-to-r from-red-600 to-orange-600 text-white px-4 py-2 rounded-xl hover:opacity-90 transition-all duration-200">
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
            <div class="text-center text-white animate-fadeIn">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    Find the Best Digital Creators Here
                </h1>
                <p class="text-xl md:text-2xl mb-8 opacity-90">
                    Bring your creative ideas to life with our professional creators
                </p>
                <div class="space-x-4">
                    <a href="/register" class="bg-white text-red-600 px-8 py-3 rounded-xl font-semibold inline-block hover:bg-gray-100 transition-all duration-200 transform hover:-translate-y-0.5">
                        Start Now
                    </a>
                    <a href="#cara-kerja" class="border border-white text-white px-8 py-3 rounded-xl font-semibold inline-block hover:bg-white hover:text-red-600 transition-all duration-200">
                        Explore
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="layanan" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 bg-clip-text text-transparent bg-gradient-to-r from-red-600 to-orange-600">Our Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <!-- Service cards with updated styling -->
                <div class="p-6 bg-white/70 backdrop-blur-lg rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-gray-100 text-center hover:transform hover:-translate-y-1 transition-all duration-200">
                    <div class="w-16 h-16 bg-gradient-to-r from-red-100 to-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-800">Logo Design</h3>
                    <p class="text-gray-600">Professional Logo Design Service for Your Brand Identity</p>
                </div>
                <!-- Repeat similar styling for other service cards -->
                <div class="p-6 bg-white/70 backdrop-blur-lg rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-gray-100 text-center hover:transform hover:-translate-y-1 transition-all duration-200">
                    <div class="w-16 h-16 bg-gradient-to-r from-red-100 to-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-800">Banner Design</h3>
                    <p class="text-gray-600">Personal Banners for Social Media and Marketing</p>
                </div>
                <div class="p-6 bg-white/70 backdrop-blur-lg rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-gray-100 text-center hover:transform hover:-translate-y-1 transition-all duration-200">
                    <div class="w-16 h-16 bg-gradient-to-r from-red-100 to-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-800">Video Editing</h3>
                    <p class="text-gray-600">Professional Video Editing and Post-production</p>
                </div>
            </div>

            <!-- Feed Button -->
            <div class="text-center">
                <a href="/feed" class="inline-block bg-gradient-to-r from-red-600 to-orange-600 text-white px-8 py-3 rounded-xl font-semibold hover:opacity-90 transition-all duration-200 transform hover:-translate-y-0.5">
                    See New Projects
                </a>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="cara-kerja" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 bg-clip-text text-transparent bg-gradient-to-r from-red-600 to-orange-600">Cara Kerja</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step cards with updated styling -->
                <div class="text-center bg-white/70 backdrop-blur-lg p-6 rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-gray-100 hover:transform hover:-translate-y-1 transition-all duration-200">
                    <div class="w-16 h-16 bg-gradient-to-r from-red-600 to-orange-600 rounded-full flex items-center justify-center text-white text-2xl mx-auto mb-4">1</div>
                    <h3 class="text-xl font-semibold mb-2">Contact a Creator</h3>
                    <p class="text-gray-600">Choose and discuss your project with professional creators</p>
                </div>
                <!-- Repeat similar styling for other step cards -->
                <div class="text-center bg-white/70 backdrop-blur-lg p-6 rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-gray-100 hover:transform hover:-translate-y-1 transition-all duration-200">
                    <div class="w-16 h-16 bg-gradient-to-r from-red-600 to-orange-600 rounded-full flex items-center justify-center text-white text-2xl mx-auto mb-4">2</div>
                    <h3 class="text-xl font-semibold mb-2">Manage Projects</h3>
                    <p class="text-gray-600">Monitor project progress and provide feedback</p>
                </div>
                <div class="text-center bg-white/70 backdrop-blur-lg p-6 rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-gray-100 hover:transform hover:-translate-y-1 transition-all duration-200">
                    <div class="w-16 h-16 bg-gradient-to-r from-red-600 to-orange-600 rounded-full flex items-center justify-center text-white text-2xl mx-auto mb-4">3</div>
                    <h3 class="text-xl font-semibold mb-2">Receive Results</h3>
                    <p class="text-gray-600">Get project results according to your needs</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-gray-200">
        <div class="container mx-auto px-4 py-8">
            <div class="text-center text-gray-600">
                <p>&copy; <?= date('Y') ?> DigitalKreator. Copyright Protected.</p>
            </div>
        </div>
    </footer>
</body>
</html>