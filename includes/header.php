<?php

$pageTitle = $pageTitle ?? 'Desa Sidowungu';
$activeMenu = $activeMenu ?? '';

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        <?= htmlspecialchars($pageTitle) ?> | Desa Sidowungu
    </title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >


    <script>

        tailwind.config = {

            theme: {

                extend: {

                    fontFamily: {

                        sans: [
                            '"Plus Jakarta Sans"',
                            'sans-serif'
                        ]

                    },


                    colors: {

                        navy: {

                            950: '#070E1A',
                            900: '#0B1324',
                            800: '#162038',
                            700: '#1E3A8A',
                            600: '#2563EB'

                        },


                        gold: {

                            500: '#D97706',
                            400: '#F59E0B',
                            100: '#FEF3C7'

                        }

                    }

                }

            }

        }

    </script>


    <style>

        html {

            scroll-behavior: smooth;

        }


        body {

            font-family: "Plus Jakarta Sans", sans-serif;

        }


        .dropdown-item {

            display: block;

            padding: 11px 14px;

            border-radius: 8px;

            color: #334155;

            font-size: 12px;

            font-weight: 600;

        }


        .dropdown-item:hover {

            background: #f8fafc;

            color: #0B1324;

        }


        .dropdown-desc {

            display: block;

            margin-top: 3px;

            color: #94a3b8;

            font-size: 10px;

            font-weight: 400;

        }


        /* =====================================================
           PAGE LOADING
        ===================================================== */

        #pageLoading {

            position: fixed;

            inset: 0;

            z-index: 99999;

            background: rgba(255, 255, 255, 0.96);

            display: flex;

            align-items: center;

            justify-content: center;

            opacity: 0;

            visibility: hidden;

            pointer-events: none;

            transition:
                opacity .65s ease,
                visibility .65s ease;

            backdrop-filter: blur(3px);

            -webkit-backdrop-filter: blur(3px);

        }


        #pageLoading.show {

            opacity: 1;

            visibility: visible;

            pointer-events: auto;

        }


        .loading-content {

            display: flex;

            flex-direction: column;

            align-items: center;

            justify-content: center;

            opacity: 0;

            transform:
                scale(.90);

        }


        #pageLoading.show .loading-content {

            animation:
                loadingAppear .7s
                cubic-bezier(.22, 1, .36, 1)
                forwards;

        }


        /* =====================================================
           LINGKARAN BESAR FULL 360
        ===================================================== */

        .loading-circle {

            width: 110px;

            height: 110px;

            border-radius: 50%;

            display: flex;

            align-items: center;

            justify-content: center;

            background:
                conic-gradient(
                    from 0deg,
                    #F59E0B,
                    #FBBF24,
                    #F59E0B,
                    #FEF3C7,
                    #F59E0B
                );

            position: relative;

            animation:
                circleSpin 1.8s
                cubic-bezier(.4, 0, .2, 1)
                infinite;

        }


        /* =====================================================
           BAGIAN DALAM LINGKARAN
        ===================================================== */

        .loading-circle::before {

            content: "";

            position: absolute;

            inset: 5px;

            border-radius: 50%;

            background:
                rgba(255, 255, 255, 0.97);

        }


        /* =====================================================
           AYAM
        ===================================================== */

        .loading-chicken {

            position: relative;

            z-index: 2;

            font-size: 42px;

            display: flex;

            align-items: center;

            justify-content: center;

            transform-origin: center;

            animation:
                chickenSmooth 1.8s
                cubic-bezier(.45, .05, .55, .95)
                infinite;

        }


        /* =====================================================
           TITIK-TITIK
        ===================================================== */

        .loading-dots {

            display: flex;

            gap: 7px;

            margin-top: 18px;

        }


        .loading-dots span {

            width: 7px;

            height: 7px;

            border-radius: 50%;

            background: #F59E0B;

            animation:
                dotPulse 1.3s
                ease-in-out
                infinite;

        }


        .loading-dots span:nth-child(1) {

            animation-delay: 0s;

        }


        .loading-dots span:nth-child(2) {

            animation-delay: .18s;

        }


        .loading-dots span:nth-child(3) {

            animation-delay: .36s;

        }


        /* =====================================================
           ANIMASI MUNCUL
        ===================================================== */

        @keyframes loadingAppear {

            0% {

                opacity: 0;

                transform:
                    scale(.85)
                    translateY(10px);

            }

            70% {

                opacity: 1;

                transform:
                    scale(1.03)
                    translateY(-2px);

            }

            100% {

                opacity: 1;

                transform:
                    scale(1)
                    translateY(0);

            }

        }


        /* =====================================================
           LINGKARAN BERPUTAR 360
        ===================================================== */

        @keyframes circleSpin {

            from {

                transform:
                    rotate(0deg);

            }

            to {

                transform:
                    rotate(360deg);

            }

        }


        /* =====================================================
           AYAM SMOOTH
        ===================================================== */

        @keyframes chickenSmooth {

            0%,
            100% {

                transform:
                    scale(1)
                    translateY(0)
                    rotate(0deg);

            }

            25% {

                transform:
                    scale(1.03)
                    translateY(-2px)
                    rotate(2deg);

            }

            50% {

                transform:
                    scale(1.07)
                    translateY(-3px)
                    rotate(0deg);

            }

            75% {

                transform:
                    scale(1.03)
                    translateY(-2px)
                    rotate(-2deg);

            }

        }


        /* =====================================================
           TITIK BERDENYUT
        ===================================================== */

        @keyframes dotPulse {

            0%,
            100% {

                opacity: .25;

                transform:
                    scale(.7)
                    translateY(0);

            }

            50% {

                opacity: 1;

                transform:
                    scale(1.15)
                    translateY(-2px);

            }

        }

    </style>

</head>


<body class="bg-slate-50 text-slate-800">


<!-- =====================================================
     PAGE LOADING
===================================================== -->

<div id="pageLoading">

    <div class="loading-content">

        <div class="loading-circle">

            <div class="loading-chicken">
                🐔
            </div>

        </div>


        <div class="loading-dots">

            <span></span>

            <span></span>

            <span></span>

        </div>

    </div>

</div>



<!-- ===================================================== -->
<!-- TOP BAR -->
<!-- ===================================================== -->

<div class="bg-navy-950
            text-slate-300
            text-xs
            border-b
            border-slate-800">

    <div class="max-w-7xl mx-auto
                px-4 sm:px-6 lg:px-8
                h-10
                flex items-center
                justify-between">

        <span class="hidden sm:inline">

            ● Pelayanan Kantor Desa:
            Senin–Jumat (08.00–15.00 WIB)

        </span>


        <span class="text-slate-400">

            Kecamatan Menganti · Kabupaten Gresik

        </span>

    </div>

</div>



<!-- ===================================================== -->
<!-- NAVBAR -->
<!-- ===================================================== -->

<header class="sticky top-0 z-50
               bg-white/95
               backdrop-blur-md
               border-b
               border-slate-200
               shadow-sm">


    <div class="max-w-7xl mx-auto
                px-4 sm:px-6 lg:px-8
                min-h-[78px]
                flex items-center
                justify-between
                gap-5">


        <!-- LOGO -->

        <a href="/index.php"
           class="flex items-center gap-3 shrink-0">


            <div class="w-11 h-11
                        rounded-xl
                        bg-navy-900
                        border-b-2
                        border-gold-500
                        flex items-center
                        justify-center
                        text-xl">

                🏛️

            </div>


            <div>

                <p class="text-[9px]
                          font-bold
                          uppercase
                          tracking-widest
                          text-gold-500">

                    Pemerintah Kabupaten Gresik

                </p>


                <h1 class="text-lg
                           font-extrabold
                           text-navy-900">

                    DESA SIDOWUNGU

                </h1>


                <p class="text-[10px]
                          text-slate-500">

                    Kecamatan Menganti

                </p>

            </div>

        </a>



        <!-- ================================================= -->
        <!-- DESKTOP MENU -->
        <!-- ================================================= -->

        <nav class="hidden xl:flex
                    items-center gap-6
                    text-xs
                    font-bold
                    text-slate-600">


            <!-- BERANDA -->

            <a href="/index.php"
               class="py-2
                      <?= $activeMenu === 'home'
                          ? 'text-navy-900 border-b-2 border-gold-500'
                          : 'hover:text-navy-700' ?>">

                BERANDA

            </a>



            <!-- ================================================= -->
            <!-- PROFIL -->
            <!-- ================================================= -->

            <div class="relative group">


                <button
                    class="py-2
                           flex items-center gap-1
                           <?= $activeMenu === 'profil'
                               ? 'text-navy-900'
                               : 'hover:text-navy-700' ?>">

                    PROFIL

                    <span class="text-[9px]">
                        ▼
                    </span>

                </button>


                <div class="absolute
                            top-full
                            left-1/2
                            -translate-x-1/2
                            mt-2
                            w-64
                            bg-white
                            rounded-xl
                            border
                            border-slate-200
                            shadow-xl
                            p-2
                            opacity-0
                            invisible
                            translate-y-2
                            group-hover:opacity-100
                            group-hover:visible
                            group-hover:translate-y-0
                            transition-all
                            duration-200">


                    <a href="/profil/sejarah.php"
                       class="dropdown-item">

                        Sejarah Desa

                        <span class="dropdown-desc">
                            Sejarah dan asal mula Sidowungu
                        </span>

                    </a>


                    <a href="/profil/geografis.php"
                       class="dropdown-item">

                        Geografis

                        <span class="dropdown-desc">
                            Wilayah Desa Sidowungu
                        </span>

                    </a>


                    <a href="/profil/struktur.php"
                       class="dropdown-item">

                        Struktur Organisasi

                        <span class="dropdown-desc">
                            Pemerintah Desa
                        </span>

                    </a>


                    <a href="/profil/visi-misi.php"
                       class="dropdown-item">

                        Visi dan Misi

                        <span class="dropdown-desc">
                            Arah pembangunan desa
                        </span>

                    </a>

                </div>

            </div>



            <!-- ================================================= -->
            <!-- STATISTIK DESA -->
            <!-- ================================================= -->

            <div class="relative group">


                <button
                    class="py-2
                           flex items-center gap-1
                           <?= $activeMenu === 'statistik'
                               ? 'text-navy-900'
                               : 'hover:text-navy-700' ?>">

                    STATISTIK DESA

                    <span class="text-[9px]">
                        ▼
                    </span>

                </button>


                <div class="absolute
                            top-full
                            left-1/2
                            -translate-x-1/2
                            mt-2
                            w-72
                            bg-white
                            rounded-xl
                            border
                            border-slate-200
                            shadow-xl
                            p-2
                            opacity-0
                            invisible
                            translate-y-2
                            group-hover:opacity-100
                            group-hover:visible
                            group-hover:translate-y-0
                            transition-all
                            duration-200">


                    <a href="/statistik/pendidikan-kk.php"
                       class="dropdown-item">

                        Data Pendidikan dalam KK

                        <span class="dropdown-desc">
                            Pendidikan penduduk dalam kartu keluarga
                        </span>

                    </a>


                    <a href="/statistik/pendidikan-tempuh.php"
                       class="dropdown-item">

                        Data Pendidikan Ditempuh

                        <span class="dropdown-desc">
                            Pendidikan yang sedang ditempuh
                        </span>

                    </a>


                    <a href="/statistik/pekerjaan.php"
                       class="dropdown-item">

                        Data Pekerjaan

                        <span class="dropdown-desc">
                            Statistik pekerjaan penduduk
                        </span>

                    </a>


                    <a href="/statistik/agama.php"
                       class="dropdown-item">

                        Data Agama

                        <span class="dropdown-desc">
                            Statistik agama penduduk
                        </span>

                    </a>


                    <a href="/statistik/jenis-kelamin.php"
                       class="dropdown-item">

                        Data Jenis Kelamin

                        <span class="dropdown-desc">
                            Statistik laki-laki dan perempuan
                        </span>

                    </a>


                    <a href="/statistik/golongan-darah.php"
                       class="dropdown-item">

                        Data Golongan Darah

                        <span class="dropdown-desc">
                            Statistik golongan darah penduduk
                        </span>

                    </a>


                </div>

            </div>



            <!-- ================================================= -->
            <!-- LAPAK -->
            <!-- ================================================= -->

            <a href="/lapak.php"
               class="py-2
                      <?= $activeMenu === 'lapak'
                          ? 'text-navy-900 border-b-2 border-gold-500'
                          : 'hover:text-navy-700' ?>">

                LAPAK

            </a>


            <!-- ================================================= -->
            <!-- ADMIN -->
            <!-- ================================================= -->

<?php if ($activeMenu === "home"): ?>

<a href="/admin/login.php"
   class="inline-flex
          items-center
          justify-center
          px-3
          py-2
          rounded-lg
          bg-navy-900
          text-white
          hover:bg-navy-800
          transition">
    ADMIN
</a>

<?php endif; ?>

            </a>

        </nav>



        <!-- MOBILE BUTTON -->

        <button
            onclick="toggleMobileMenu()"
            class="xl:hidden
                   w-10 h-10
                   rounded-lg
                   border
                   border-slate-200">

            ☰

        </button>

    </div>



    <!-- ================================================= -->
    <!-- MOBILE MENU -->
    <!-- ================================================= -->

    <div id="mobileMenu"
         class="hidden
                xl:hidden
                border-t
                border-slate-200
                bg-white
                px-4 py-4">


        <a href="/index.php"
           class="block px-4 py-3
                  rounded-lg
                  hover:bg-slate-100
                  font-semibold">

            BERANDA

        </a>



        <!-- PROFIL -->

        <button
            onclick="toggleProfilMobile()"
            class="w-full
                   flex justify-between
                   px-4 py-3
                   rounded-lg
                   hover:bg-slate-100
                   font-semibold">

            PROFIL

            <span>▼</span>

        </button>


        <div id="profilMobile"
             class="hidden ml-4">


            <a href="/profil/sejarah.php"
               class="block px-4 py-2
                      text-sm text-slate-600">

                Sejarah Desa

            </a>


            <a href="/profil/geografis.php"
               class="block px-4 py-2
                      text-sm text-slate-600">

                Geografis

            </a>


            <a href="/profil/struktur.php"
               class="block px-4 py-2
                      text-sm text-slate-600">

                Struktur Organisasi

            </a>


            <a href="/profil/visi-misi.php"
               class="block px-4 py-2
                      text-sm text-slate-600">

                Visi dan Misi

            </a>

        </div>



        <!-- STATISTIK -->

        <button
            onclick="toggleStatistikMobile()"
            class="w-full
                   flex justify-between
                   px-4 py-3
                   rounded-lg
                   hover:bg-slate-100
                   font-semibold">

            STATISTIK DESA

            <span>▼</span>

        </button>


        <div id="statistikMobile"
             class="hidden ml-4">


            <a href="/statistik/pendidikan-kk.php"
               class="block px-4 py-2
                      text-sm text-slate-600">

                Data Pendidikan dalam KK

            </a>


            <a href="/statistik/pendidikan-tempuh.php"
               class="block px-4 py-2
                      text-sm text-slate-600">

                Data Pendidikan Ditempuh

            </a>


            <a href="/statistik/pekerjaan.php"
               class="block px-4 py-2
                      text-sm text-slate-600">

                Data Pekerjaan

            </a>


            <a href="/statistik/agama.php"
               class="block px-4 py-2
                      text-sm text-slate-600">

                Data Agama

            </a>


            <a href="/statistik/jenis-kelamin.php"
               class="block px-4 py-2
                      text-sm text-slate-600">

                Data Jenis Kelamin

            </a>


            <a href="/statistik/golongan-darah.php"
               class="block px-4 py-2
                      text-sm text-slate-600">

                Data Golongan Darah

            </a>

        </div>



        <!-- LAPAK -->

        <a href="/lapak.php"
           class="block px-4 py-3
                  rounded-lg
                  hover:bg-slate-100
                  font-semibold">

            LAPAK

        </a>


        <!-- ADMIN -->

        <a href="/admin/login.php"
           class="block mt-2 px-4 py-3
                  rounded-lg
                  bg-navy-900
                  text-white
                  text-center
                  font-semibold
                  hover:bg-navy-800
                  transition">

            ADMIN

        </a>

    </div>

</header>


<script>

    function toggleMobileMenu()
    {

        document
            .getElementById('mobileMenu')
            .classList.toggle('hidden');

    }


    function toggleProfilMobile()
    {

        document
            .getElementById('profilMobile')
            .classList.toggle('hidden');

    }


    function toggleStatistikMobile()
    {

        document
            .getElementById('statistikMobile')
            .classList.toggle('hidden');

    }

</script>