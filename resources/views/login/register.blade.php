<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $setting->app_name ?? 'App' }} | {{ $title ?? 'Daftar' }}</title>

    <!-- Favicon -->
    <link href="{{ $setting->logo ? asset('storage/' . $setting->logo) : asset('niceadmin/img/laravel.png') }}"
        rel="icon">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 antialiased selection:bg-brand-500 selection:text-white">

    <div class="min-h-screen flex">
        <!-- Left Side: Visual / Branding (Hidden on mobile) -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-brand-900 overflow-hidden items-center justify-center">
            <!-- Abstract Background Image -->
            <img src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=2564&auto=format&fit=crop"
                class="absolute inset-0 w-full h-full object-cover opacity-40 mix-blend-overlay" alt="Background">

            <!-- Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-br from-brand-600/80 to-brand-900/90"></div>

            <!-- Branding Content -->
            <div class="relative z-10 p-12 text-center text-white max-w-lg">
                <div class="mb-8 flex justify-center">
                    @if ($setting->logo)
                        <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo" class="h-24 drop-shadow-2xl">
                    @else
                        <div
                            class="w-24 h-24 bg-white rounded-3xl flex items-center justify-center text-brand-600 font-bold text-4xl shadow-2xl">
                            {{ substr($setting->app_name ?? 'A', 0, 1) }}
                        </div>
                    @endif
                </div>
                <h1 class="text-4xl font-extrabold tracking-tight mb-4">{{ $setting->app_name ?? 'RekrutMudah' }}</h1>
                <p class="text-brand-100 text-lg font-light leading-relaxed">
                    Daftar sekarang dan mulai perjalanan karir Anda bersama kami. Temukan lowongan terbaik dan lamar dengan mudah.
                </p>
            </div>
        </div>

        <!-- Right Side: Register Form -->
        <div
            class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 md:p-16 bg-white shadow-2xl lg:shadow-none z-10 relative">

            <!-- Mobile Logo (Visible only on small screens) -->
            <div class="absolute top-8 left-8 lg:hidden flex items-center gap-3">
                @if ($setting->logo)
                    <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo" class="h-8">
                @else
                    <div
                        class="w-8 h-8 bg-brand-600 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                        {{ substr($setting->app_name ?? 'A', 0, 1) }}
                    </div>
                @endif
                <span class="font-bold text-gray-800">{{ $setting->app_name }}</span>
            </div>

            <div class="w-full max-w-md mt-10 lg:mt-0">

                <div class="mb-10 text-left">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Daftar Akun Pelamar 📝</h2>
                    <p class="text-gray-500">Isi formulir di bawah untuk membuat akun pelamar.</p>
                </div>

                <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
                    @csrf

                    <!-- Name Input -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input id="name" name="name" type="text" required
                                value="{{ old('name') }}"
                                class="pl-11 w-full px-4 py-3.5 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-brand-500/20 focus:border-brand-500 focus:bg-white transition-all outline-none"
                                placeholder="Nama Lengkap Anda">
                        </div>
                    </div>

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </div>
                            <input id="email" name="email" type="email" required
                                value="{{ old('email') }}"
                                class="pl-11 w-full px-4 py-3.5 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-brand-500/20 focus:border-brand-500 focus:bg-white transition-all outline-none"
                                placeholder="email@contoh.com">
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input id="password" name="password" type="password" required minlength="8"
                                class="pl-11 w-full px-4 py-3.5 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-brand-500/20 focus:border-brand-500 focus:bg-white transition-all outline-none"
                                placeholder="Minimal 8 karakter">
                        </div>
                    </div>

                    <!-- Confirm Password Input -->
                    <div>
                        <label for="passwordconfirm" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input id="passwordconfirm" name="passwordconfirm" type="password" required
                                class="pl-11 w-full px-4 py-3.5 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-brand-500/20 focus:border-brand-500 focus:bg-white transition-all outline-none"
                                placeholder="Ulangi password Anda">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-brand-500/30 text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-all transform hover:-translate-y-0.5 duration-200">
                        Daftar Sekarang
                    </button>

                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-600 mb-2">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="font-semibold text-brand-600 hover:text-brand-700 transition-colors">Masuk di sini</a>
                        </p>
                        <p class="text-xs text-gray-400 font-medium">
                            {{ $setting->copyright ?? '© ' . date('Y') . ' All rights reserved.' }}
                        </p>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // SweetAlert Notifications Logic
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        let flashSuccess = "{{ session('success') ?? '' }}";
        if (flashSuccess) {
            Toast.fire({
                icon: "success",
                title: flashSuccess
            });
        }

        let flashError = "{{ session('error') ?? '' }}";
        let errors = @json($errors->all());

        if (flashError) {
            Toast.fire({
                icon: "error",
                title: flashError
            });
        } else if (errors.length > 0) {
            Toast.fire({
                icon: "error",
                title: errors[0]
            });
        }
    </script>
</body>

</html>
