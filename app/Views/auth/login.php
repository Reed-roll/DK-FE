<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DigitalKreator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50">
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md animate-fadeIn">
            <!-- Logo & Title -->
            <div class="text-center mb-10">
                <a href="/" class="text-4xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-red-600 to-orange-600 hover:opacity-80 transition-opacity">
                    DigitalKreator
                </a>
                <h2 class="mt-4 text-2xl font-semibold text-gray-800">Masuk ke akun Anda</h2>
            </div>

            <!-- Login Form -->
            <div class="bg-white/70 backdrop-blur-lg p-8 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-gray-100">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="bg-red-50 text-red-500 p-4 mb-6 rounded-xl border border-red-100 animate-fadeIn">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form action="/login" method="POST" class="space-y-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="email" required 
                            class="block w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50/50 focus:bg-white transition-all duration-200 outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" id="password" required 
                            class="block w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50/50 focus:bg-white transition-all duration-200 outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                    </div>

                    <button type="submit" 
                        class="w-full bg-gradient-to-r from-red-600 to-orange-600 text-white py-3 px-4 rounded-xl hover:opacity-90 transform transition-all duration-200 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 font-medium">
                        Login
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-gray-600">
                        Belum punya akun? 
                        <a href="/register" class="font-medium text-indigo-600 hover:text-purple-600 transition-colors duration-200">
                            Daftar disini
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>