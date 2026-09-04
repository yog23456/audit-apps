<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Audit Finance System</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Tailwind CSS (Local & CDN Fallback for smooth rendering) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eef6fc',
                            100: '#d8ebf8',
                            500: '#005691',
                            600: '#00487a',
                            700: '#003a63',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #003a63 50%, #005691 100%);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">

    <!-- Background Pattern Decorative Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full bg-blue-400/20 blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 rounded-full bg-indigo-500/20 blur-3xl"></div>
    </div>

    <!-- Login Container -->
    <div class="relative w-full max-w-[420px] glass-card rounded-3xl p-8 sm:p-10 border border-white/40 shadow-2xl transition-all">
        
        <!-- Header / Logo -->
        <div class="flex flex-col items-center text-center mb-8">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-brand-600 to-brand-500 text-white flex items-center justify-center text-3xl font-extrabold shadow-lg shadow-brand-500/30 mb-4 transform hover:scale-105 transition-transform">
                <i class="bi bi-shield-check"></i>
            </div>
            <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Audit Finance</h1>
            <p class="text-xs text-gray-500 font-medium mt-1">Sistem Tracking Anomali & Rekap Audit</p>
        </div>

        <!-- Flash Alert Error -->
        <?php if ($this->session->flashdata('error')): ?>
            <div class="bg-rose-50 border border-rose-200 rounded-2xl p-4 mb-6 text-xs text-rose-700 flex items-center gap-3 shadow-sm animate-fade-in">
                <div class="w-7 h-7 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center shrink-0 font-bold text-sm">
                    <i class="bi bi-exclamation-lg"></i>
                </div>
                <div class="font-medium leading-relaxed"><?= htmlspecialchars($this->session->flashdata('error')) ?></div>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form action="<?= site_url('login/process') ?>" method="post" class="space-y-5">
            
            <!-- Username Input -->
            <div>
                <label for="username" class="block text-xs font-semibold text-gray-700 mb-2">Username</label>
                <div class="relative flex items-center">
                    <div class="absolute left-3.5 text-gray-400 text-base pointer-events-none flex items-center justify-center">
                        <i class="bi bi-person"></i>
                    </div>
                    <input type="text" name="username" id="username" required autofocus placeholder="Masukkan username"
                           class="w-full pl-11 pr-4 py-3 bg-gray-50/80 border border-gray-200/90 rounded-2xl text-xs text-gray-800 placeholder-gray-400 font-medium focus:outline-none focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-500/10 transition-all shadow-xs">
                </div>
            </div>

            <!-- Password Input -->
            <div>
                <label for="password" class="block text-xs font-semibold text-gray-700 mb-2">Password</label>
                <div class="relative flex items-center">
                    <div class="absolute left-3.5 text-gray-400 text-base pointer-events-none flex items-center justify-center">
                        <i class="bi bi-lock"></i>
                    </div>
                    <input type="password" name="password" id="password" required placeholder="Masukkan password"
                           class="w-full pl-11 pr-4 py-3 bg-gray-50/80 border border-gray-200/90 rounded-2xl text-xs text-gray-800 placeholder-gray-400 font-medium focus:outline-none focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-500/10 transition-all shadow-xs">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-3">
                <button type="submit" class="w-full bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-600 hover:to-brand-700 text-white font-bold py-3.5 px-5 rounded-2xl text-xs shadow-lg shadow-brand-500/30 hover:shadow-brand-500/50 transition-all cursor-pointer flex items-center justify-center gap-2 group">
                    <span>Masuk ke Dashboard</span>
                    <i class="bi bi-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                </button>
            </div>

        </form>

        <!-- Footer -->
        <div class="mt-8 pt-6 border-t border-gray-100 text-center">
            <p class="text-[11px] text-gray-400 font-medium">© 2026 Audit Finance System. All Rights Reserved.</p>
        </div>

    </div>

</body>
</html>
