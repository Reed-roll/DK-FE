<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - DigitalKreator</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md">
            <!-- Logo & Title -->
            <div class="text-center mb-8">
                <a href="/" class="text-3xl font-bold text-indigo-600">DigitalKreator</a>
                <h2 class="mt-2 text-2xl font-bold text-gray-900">Buat akun baru</h2>
            </div>

            <!-- Register Form -->
            <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="bg-red-50 text-red-500 p-4 mb-4 rounded-lg">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form action="/register" method="POST">
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" name="name" id="name" required 
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" required 
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" id="password" required 
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700">Daftar Sebagai</label>
                            <select name="role" id="role" required 
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="client">Client</option>
                                <option value="creator">Kreator</option>
                            </select>
                        </div>

                        <button type="submit" 
                            class="w-full bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Daftar
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center text-sm">
                    <p class="text-gray-600">
                        Sudah punya akun? 
                        <a href="/login" class="text-indigo-600 hover:text-indigo-500">Login disini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>