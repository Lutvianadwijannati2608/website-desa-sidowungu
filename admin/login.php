<?php

session_start();


// =====================================================
// CEK JIKA SUDAH LOGIN
// =====================================================

if (
    isset($_SESSION['admin_login']) &&
    $_SESSION['admin_login'] === true
) {

    header('Location: /admin/');
    exit;

}


// =====================================================
// PESAN ERROR
// =====================================================

$error = '';

if (
    isset($_GET['error']) &&
    $_GET['error'] === '1'
) {

    $error = 'Nama pengguna atau kata sandi salah.';

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login Admin - Desa Sidowungu</title>


    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>


    <!-- Font -->
    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >


    <style>

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .soft-grid {
            background-image:
                linear-gradient(
                    rgba(255,255,255,0.04) 1px,
                    transparent 1px
                ),
                linear-gradient(
                    90deg,
                    rgba(255,255,255,0.04) 1px,
                    transparent 1px
                );

            background-size: 40px 40px;
        }

    </style>

</head>


<body class="min-h-screen bg-slate-100">


<div class="min-h-screen flex items-center justify-center px-5 py-10">


    <!-- ================================================= -->
    <!-- CONTAINER -->
    <!-- ================================================= -->

    <div
        class="w-full max-w-5xl bg-white rounded-[32px] overflow-hidden shadow-2xl border border-slate-200 grid grid-cols-1 lg:grid-cols-2"
    >


        <!-- ================================================= -->
        <!-- LEFT PANEL -->
        <!-- ================================================= -->

        <div
            class="relative bg-slate-950 text-white p-8 md:p-12 flex flex-col justify-between overflow-hidden"
        >


            <!-- GRID DECORATION -->

            <div class="absolute inset-0 soft-grid"></div>


            <!-- DECORATIVE CIRCLE -->

            <div
                class="absolute -top-24 -right-24 w-64 h-64 rounded-full border border-white/10"
            ></div>


            <div
                class="absolute -bottom-32 -left-20 w-72 h-72 rounded-full border border-amber-500/10"
            ></div>


            <!-- CONTENT -->

            <div class="relative z-10">


                <!-- LOGO -->

                <div
                    class="w-16 h-16 rounded-2xl bg-white/10 border border-white/10 flex items-center justify-center shadow-lg"
                >

                    <span class="text-3xl">
                        🏛️
                    </span>

                </div>


                <!-- LABEL -->

                <p class="text-xs font-bold tracking-[0.2em] uppercase text-amber-400 mt-8">
                    Pemerintah Kabupaten Gresik
                </p>


                <!-- TITLE -->

                <h1 class="text-3xl md:text-4xl font-extrabold leading-tight mt-3">
                    Desa Sidowungu
                </h1>


                <p class="text-slate-400 mt-4 max-w-md leading-relaxed text-sm md:text-base">
                    Sistem administrasi digital untuk membantu pengelolaan
                    informasi dan layanan Desa Sidowungu.
                </p>


                <!-- DIVIDER -->

                <div class="w-16 h-1 bg-amber-500 rounded-full mt-8"></div>


                <!-- INFO -->

                <div class="mt-8 space-y-4">


                    <div class="flex items-start gap-3">

                        <div
                            class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center shrink-0"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 21s7-4.35 7-10A7 7 0 1 0 5 11c0 5.65 7 10 7 10Z"
                                />

                                <circle
                                    cx="12"
                                    cy="11"
                                    r="2.5"
                                />

                            </svg>

                        </div>


                        <div>

                            <p class="text-xs text-slate-500">
                                Wilayah
                            </p>

                            <p class="text-sm text-slate-200 mt-1">
                                Kecamatan Menganti, Kabupaten Gresik
                            </p>

                        </div>

                    </div>


                    <div class="flex items-start gap-3">

                        <div
                            class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center shrink-0"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 6v6l4 2"
                                />

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="9"
                                />

                            </svg>

                        </div>


                        <div>

                            <p class="text-xs text-slate-500">
                                Akses Admin
                            </p>

                            <p class="text-sm text-slate-200 mt-1">
                                Khusus pengelola website desa
                            </p>

                        </div>

                    </div>


                </div>

            </div>


            <!-- FOOTER LEFT -->

            <div class="relative z-10 mt-12">

                <p class="text-xs text-slate-500">
                    © <?= date('Y'); ?> Desa Sidowungu
                </p>

            </div>


        </div>



        <!-- ================================================= -->
        <!-- RIGHT PANEL -->
        <!-- ================================================= -->

        <div class="bg-white p-8 md:p-12 flex items-center">


            <div class="w-full max-w-md mx-auto">


                <!-- HEADER -->

                <div>

                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-amber-600">
                        Login Administrator
                    </p>

                    <h2 class="text-3xl font-extrabold text-slate-950 mt-2">
                        Selamat Datang
                    </h2>

                    <p class="text-sm text-slate-500 mt-3 leading-relaxed">
                        Masuk untuk mengelola informasi dan konten
                        website Desa Sidowungu.
                    </p>

                </div>


                <!-- ERROR -->

                <?php if ($error !== ''): ?>

                    <div
                        class="mt-6 px-4 py-3 rounded-2xl bg-red-50 border border-red-200 text-red-600 text-sm"
                    >
                        <?= htmlspecialchars($error); ?>
                    </div>

                <?php endif; ?>


                <!-- FORM -->

                <form
                    action="login-proses.php"
                    method="POST"
                    class="mt-8 space-y-5"
                >


                    <!-- USERNAME -->

                    <div>

                        <label
                            for="username"
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >
                            Nama Pengguna
                        </label>


                        <div class="relative">

                            <div
                                class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M20 21a8 8 0 0 0-16 0"
                                    />

                                    <circle
                                        cx="12"
                                        cy="7"
                                        r="4"
                                    />

                                </svg>

                            </div>


                            <input
                                type="text"
                                id="username"
                                name="username"
                                required
                                autocomplete="username"
                                placeholder="Masukkan nama pengguna"
                                class="w-full pl-12 pr-4 py-3.5 rounded-2xl border border-slate-200 bg-slate-50/70 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 focus:bg-white transition"
                            >

                        </div>

                    </div>



                    <!-- PASSWORD -->

                    <div>

                        <label
                            for="password"
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >
                            Kata Sandi
                        </label>


                        <div class="relative">


                            <div
                                class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >

                                    <rect
                                        x="4"
                                        y="10"
                                        width="16"
                                        height="11"
                                        rx="2"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        d="M8 10V7a4 4 0 0 1 8 0v3"
                                    />

                                </svg>

                            </div>


                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Masukkan kata sandi"
                                class="w-full pl-12 pr-14 py-3.5 rounded-2xl border border-slate-200 bg-slate-50/70 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 focus:bg-white transition"
                            >


                            <button
                                type="button"
                                onclick="togglePassword()"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 transition"
                                aria-label="Tampilkan kata sandi"
                            >

                                <svg
                                    id="eyeIcon"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"
                                    />

                                    <circle
                                        cx="12"
                                        cy="12"
                                        r="2.5"
                                    />

                                </svg>

                            </button>

                        </div>

                    </div>



                    <!-- OPTIONS -->

                    <div class="flex items-center justify-between">

                        <label class="flex items-center gap-2 text-sm text-slate-500 cursor-pointer">

                            <input
                                type="checkbox"
                                name="remember"
                                class="w-4 h-4 rounded border-slate-300 text-amber-600 focus:ring-amber-500"
                            >

                            Ingat saya

                        </label>


                        <span class="text-xs font-medium text-slate-400">
                            Admin Desa
                        </span>

                    </div>



                    <!-- BUTTON -->

                    <button
                        type="submit"
                        class="w-full py-3.5 rounded-2xl bg-slate-950 hover:bg-slate-800 text-white font-semibold text-sm transition shadow-lg shadow-slate-950/10"
                    >

                        <span class="flex items-center justify-center gap-2">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M10 17l5-5-5-5"
                                />

                                <path
                                    stroke-linecap="round"
                                    d="M15 12H3"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M21 19V5a2 2 0 0 0-2-2h-6"
                                />

                            </svg>

                            Masuk ke Dashboard

                        </span>

                    </button>


                </form>



                <!-- BACK -->

                <div class="text-center mt-7">

                    <a
                        href="/index.php"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-amber-600 transition"
                    >

                        <span>←</span>

                        Kembali ke Website Desa

                    </a>

                </div>


            </div>

        </div>


    </div>

</div>



<script>

function togglePassword() {

    const password =
        document.getElementById('password');

    const icon =
        document.getElementById('eyeIcon');


    if (password.type === 'password') {

        password.type = 'text';


        icon.innerHTML = `
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M3 3l18 18"
            />

            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M10.6 10.6a2 2 0 0 0 2.8 2.8"
            />

            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M9.9 4.3A9.8 9.8 0 0 1 12 4c6 0 9.5 6 9.5 6a18 18 0 0 1-2.1 2.8"
            />

            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M6.1 6.1C3.9 7.7 2.5 10 2.5 10s3.5 6 9.5 6c1.3 0 2.5-.3 3.5-.7"
            />
        `;

    } else {

        password.type = 'password';


        icon.innerHTML = `
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"
            />

            <circle
                cx="12"
                cy="12"
                r="2.5"
            />
        `;

    }

}

</script>


</body>
</html>