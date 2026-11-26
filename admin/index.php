<?php
require_once __DIR__ . '/../config/database.php';

// ================================
// AMBIL JUMLAH LAPAK
// ================================

$queryLapak = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM lapak"
);

$dataLapak = mysqli_fetch_assoc(
    $queryLapak
);

$total_lapak =
    $dataLapak['total'];


// ================================
// AMBIL JUMLAH AGENDA AKTIF
// ================================

$queryAgenda = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM agenda
     WHERE status = 'Aktif'"
);

$dataAgenda = mysqli_fetch_assoc(
    $queryAgenda
);

$total_agenda =
    $dataAgenda['total'];


// ================================
// AMBIL JUMLAH BERITA
// ================================

$queryBerita = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM berita"
);

$dataBerita = mysqli_fetch_assoc(
    $queryBerita
);

$total_berita =
    $dataBerita['total'];

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Dashboard Admin - Desa Sidowungu
    </title>


    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>


    <!-- Google Font -->
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

            font-family:
                'Plus Jakarta Sans',
                sans-serif;

        }

    </style>

</head>


<body class="bg-slate-100 min-h-screen">


    <!-- =====================================================
         NAVBAR
    ====================================================== -->

    <nav class="bg-slate-950 text-white">

        <div class="max-w-7xl mx-auto px-6 py-4">

            <div
                class="
                    flex
                    items-center
                    justify-between
                    gap-4
                "
            >


                <!-- BRAND -->

                <div>

                    <h1 class="text-lg font-bold">

                        Admin Desa Sidowungu

                    </h1>


                    <p
                        class="
                            text-xs
                            text-slate-400
                            mt-1
                        "
                    >

                        Panel Pengelolaan Website Desa

                    </p>

                </div>



                <!-- KEMBALI WEBSITE -->

                <a
                    href="../index.php"
                    class="
                        bg-white/10
                        hover:bg-white/20
                        px-4
                        py-2
                        rounded-xl
                        text-sm
                        font-medium
                        transition
                    "
                >

                    Kembali ke Website

                </a>


            </div>

        </div>

    </nav>



    <!-- =====================================================
         MAIN CONTENT
    ====================================================== -->

    <main
        class="
            max-w-7xl
            mx-auto
            px-6
            py-10
        "
    >


        <!-- =================================================
             HEADER
        ================================================== -->

        <div class="mb-8">


            <p
                class="
                    text-sm
                    font-semibold
                    text-amber-600
                    mb-2
                "
            >

                DASHBOARD ADMIN

            </p>


            <h2
                class="
                    text-3xl
                    md:text-4xl
                    font-extrabold
                    text-slate-900
                "
            >

                Selamat Datang di Panel Admin

            </h2>


            <p
                class="
                    text-slate-500
                    mt-3
                    max-w-2xl
                "
            >

                Kelola informasi Lapak UMKM,
                usaha masyarakat, agenda,
                serta berita Desa Sidowungu
                dengan mudah melalui halaman admin.

            </p>


        </div>



        <!-- =================================================
             STATISTIK
        ================================================== -->

        <div
            class="
                grid
                grid-cols-1
                md:grid-cols-2
                xl:grid-cols-4
                gap-5
                mb-8
            "
        >


            <!-- =============================================
                 TOTAL LAPAK
            ============================================== -->

            <div
                class="
                    bg-white
                    rounded-2xl
                    p-6
                    shadow-sm
                    border
                    border-slate-200
                "
            >

                <div
                    class="
                        flex
                        items-center
                        justify-between
                    "
                >


                    <div>

                        <p class="text-sm text-slate-500">

                            Total Lapak

                        </p>


                        <h3
                            class="
                                text-4xl
                                font-extrabold
                                text-slate-900
                                mt-2
                            "
                        >

                            <?= $total_lapak; ?>

                        </h3>


                        <p
                            class="
                                text-xs
                                text-slate-400
                                mt-2
                            "
                        >

                            UMKM / usaha terdaftar

                        </p>

                    </div>


                    <div
                        class="
                            w-14
                            h-14
                            rounded-2xl
                            bg-amber-100
                            flex
                            items-center
                            justify-center
                            text-2xl
                        "
                    >

                        🏪

                    </div>


                </div>

            </div>



            <!-- =============================================
                 TOTAL AGENDA
            ============================================== -->

            <div
                class="
                    bg-white
                    rounded-2xl
                    p-6
                    shadow-sm
                    border
                    border-slate-200
                "
            >

                <div
                    class="
                        flex
                        items-center
                        justify-between
                    "
                >


                    <div>

                        <p class="text-sm text-slate-500">

                            Total Agenda

                        </p>


                        <h3
                            class="
                                text-4xl
                                font-extrabold
                                text-slate-900
                                mt-2
                            "
                        >

                            <?= $total_agenda; ?>

                        </h3>


                        <p
                            class="
                                text-xs
                                text-slate-400
                                mt-2
                            "
                        >

                            Agenda aktif

                        </p>

                    </div>


                    <div
                        class="
                            w-14
                            h-14
                            rounded-2xl
                            bg-blue-100
                            flex
                            items-center
                            justify-center
                            text-2xl
                        "
                    >

                        📅

                    </div>


                </div>

            </div>



            <!-- =============================================
                 TOTAL BERITA
            ============================================== -->

            <div
                class="
                    bg-white
                    rounded-2xl
                    p-6
                    shadow-sm
                    border
                    border-slate-200
                "
            >

                <div
                    class="
                        flex
                        items-center
                        justify-between
                    "
                >


                    <div>

                        <p class="text-sm text-slate-500">

                            Total Berita

                        </p>


                        <h3
                            class="
                                text-4xl
                                font-extrabold
                                text-slate-900
                                mt-2
                            "
                        >

                            <?= $total_berita; ?>

                        </h3>


                        <p
                            class="
                                text-xs
                                text-slate-400
                                mt-2
                            "
                        >

                            Artikel tersimpan

                        </p>

                    </div>


                    <div
                        class="
                            w-14
                            h-14
                            rounded-2xl
                            bg-pink-100
                            flex
                            items-center
                            justify-center
                            text-2xl
                        "
                    >

                        📰

                    </div>


                </div>

            </div>



            <!-- =============================================
                 STATUS WEBSITE
            ============================================== -->

            <div
                class="
                    bg-white
                    rounded-2xl
                    p-6
                    shadow-sm
                    border
                    border-slate-200
                "
            >

                <div
                    class="
                        flex
                        items-center
                        justify-between
                    "
                >


                    <div>

                        <p class="text-sm text-slate-500">

                            Status Website

                        </p>


                        <h3
                            class="
                                text-xl
                                font-bold
                                text-slate-900
                                mt-2
                            "
                        >

                            Aktif

                        </h3>


                        <p
                            class="
                                text-xs
                                text-green-600
                                mt-2
                            "
                        >

                            ● Sistem berjalan dengan baik

                        </p>

                    </div>


                    <div
                        class="
                            w-14
                            h-14
                            rounded-2xl
                            bg-green-100
                            flex
                            items-center
                            justify-center
                            text-2xl
                        "
                    >

                        ✓

                    </div>


                </div>

            </div>


        </div>



        <!-- =================================================
             MENU UTAMA
        ================================================== -->

        <div
            class="
                grid
                grid-cols-1
                lg:grid-cols-3
                gap-6
            "
        >


            <!-- =============================================
                 KELOLA LAPAK
            ============================================== -->

            <div
                class="
                    bg-white
                    rounded-2xl
                    p-7
                    md:p-8
                    shadow-sm
                    border
                    border-slate-200
                "
            >

                <div
                    class="
                        flex
                        flex-col
                        gap-6
                    "
                >


                    <div>


                        <div
                            class="
                                w-14
                                h-14
                                rounded-2xl
                                bg-slate-950
                                text-white
                                flex
                                items-center
                                justify-center
                                text-2xl
                                mb-5
                            "
                        >

                            🏪

                        </div>


                        <h3
                            class="
                                text-2xl
                                font-bold
                                text-slate-900
                            "
                        >

                            Kelola Lapak

                        </h3>


                        <p
                            class="
                                text-sm
                                text-slate-500
                                mt-2
                                leading-relaxed
                            "
                        >

                            Kelola data UMKM dan usaha
                            masyarakat Desa Sidowungu.
                            Kamu dapat menambahkan,
                            mengubah, menghapus, serta
                            mengelola informasi lapak.

                        </p>

                    </div>


                    <a
                        href="lapak/index.php"
                        class="
                            inline-flex
                            items-center
                            justify-center
                            bg-slate-950
                            hover:bg-slate-800
                            text-white
                            px-6
                            py-3
                            rounded-xl
                            text-sm
                            font-semibold
                            transition
                        "
                    >

                        Kelola Lapak

                        <span class="ml-2">
                            →
                        </span>

                    </a>


                </div>

            </div>



            <!-- =============================================
                 KELOLA AGENDA
            ============================================== -->

            <div
                class="
                    bg-white
                    rounded-2xl
                    p-7
                    md:p-8
                    shadow-sm
                    border
                    border-slate-200
                "
            >

                <div
                    class="
                        flex
                        flex-col
                        gap-6
                    "
                >


                    <div>


                        <div
                            class="
                                w-14
                                h-14
                                rounded-2xl
                                bg-blue-600
                                text-white
                                flex
                                items-center
                                justify-center
                                text-2xl
                                mb-5
                            "
                        >

                            📅

                        </div>


                        <h3
                            class="
                                text-2xl
                                font-bold
                                text-slate-900
                            "
                        >

                            Kelola Agenda

                        </h3>


                        <p
                            class="
                                text-sm
                                text-slate-500
                                mt-2
                                leading-relaxed
                            "
                        >

                            Kelola agenda dan kegiatan
                            Desa Sidowungu. Tambahkan,
                            ubah, hapus, serta atur status
                            agenda yang akan ditampilkan
                            pada website.

                        </p>

                    </div>


                    <a
                        href="agenda/index.php"
                        class="
                            inline-flex
                            items-center
                            justify-center
                            bg-blue-600
                            hover:bg-blue-700
                            text-white
                            px-6
                            py-3
                            rounded-xl
                            text-sm
                            font-semibold
                            transition
                        "
                    >

                        Kelola Agenda

                        <span class="ml-2">
                            →
                        </span>

                    </a>


                </div>

            </div>



            <!-- =============================================
                 KELOLA BERITA
            ============================================== -->

            <div
                class="
                    bg-white
                    rounded-2xl
                    p-7
                    md:p-8
                    shadow-sm
                    border
                    border-slate-200
                "
            >

                <div
                    class="
                        flex
                        flex-col
                        gap-6
                    "
                >


                    <div>


                        <div
                            class="
                                w-14
                                h-14
                                rounded-2xl
                                bg-pink-600
                                text-white
                                flex
                                items-center
                                justify-center
                                text-2xl
                                mb-5
                            "
                        >

                            📰

                        </div>


                        <h3
                            class="
                                text-2xl
                                font-bold
                                text-slate-900
                            "
                        >

                            Kelola Berita

                        </h3>


                        <p
                            class="
                                text-sm
                                text-slate-500
                                mt-2
                                leading-relaxed
                            "
                        >

                            Kelola artikel dan informasi
                            terbaru Desa Sidowungu.
                            Kamu dapat menambahkan,
                            mengubah, dan menghapus
                            berita yang ditampilkan
                            pada website.

                        </p>

                    </div>


                    <a
                        href="berita/index.php"
                        class="
                            inline-flex
                            items-center
                            justify-center
                            bg-pink-600
                            hover:bg-pink-700
                            text-white
                            px-6
                            py-3
                            rounded-xl
                            text-sm
                            font-semibold
                            transition
                        "
                    >

                        Kelola Berita

                        <span class="ml-2">
                            →
                        </span>

                    </a>


                </div>

            </div>


        </div>



        <!-- =================================================
             INFORMASI
        ================================================== -->

        <div
            class="
                mt-8
                grid
                grid-cols-1
                lg:grid-cols-3
                gap-6
            "
        >


            <!-- INFO LAPAK -->

            <div
                class="
                    bg-slate-950
                    rounded-2xl
                    p-6
                    md:p-8
                    text-white
                "
            >

                <p
                    class="
                        text-sm
                        font-semibold
                        text-amber-400
                        mb-2
                    "
                >

                    INFORMASI LAPAK

                </p>


                <h3 class="text-xl font-bold">

                    Pengelolaan Lapak Desa

                </h3>


                <p
                    class="
                        text-sm
                        text-slate-300
                        mt-3
                        leading-relaxed
                    "
                >

                    Data Lapak tersimpan di database
                    sehingga dapat ditambahkan,
                    diperbarui, dan dihapus kapan saja
                    melalui halaman Kelola Lapak.

                </p>

            </div>



            <!-- INFO AGENDA -->

            <div
                class="
                    bg-blue-950
                    rounded-2xl
                    p-6
                    md:p-8
                    text-white
                "
            >

                <p
                    class="
                        text-sm
                        font-semibold
                        text-blue-300
                        mb-2
                    "
                >

                    INFORMASI AGENDA

                </p>


                <h3 class="text-xl font-bold">

                    Pengelolaan Agenda Desa

                </h3>


                <p
                    class="
                        text-sm
                        text-blue-100
                        mt-3
                        leading-relaxed
                    "
                >

                    Agenda yang ditambahkan melalui
                    halaman Kelola Agenda akan tersimpan
                    di database dan digunakan pada
                    bagian Agenda Desa di website.

                </p>

            </div>



            <!-- INFO BERITA -->

            <div
                class="
                    bg-pink-950
                    rounded-2xl
                    p-6
                    md:p-8
                    text-white
                "
            >

                <p
                    class="
                        text-sm
                        font-semibold
                        text-pink-300
                        mb-2
                    "
                >

                    INFORMASI BERITA

                </p>


                <h3 class="text-xl font-bold">

                    Pengelolaan Berita Desa

                </h3>


                <p
                    class="
                        text-sm
                        text-pink-100
                        mt-3
                        leading-relaxed
                    "
                >

                    Berita dapat ditambahkan,
                    diperbarui, dan dihapus melalui
                    halaman Kelola Berita.
                    Perubahan akan langsung digunakan
                    pada website Desa Sidowungu.

                </p>

            </div>


        </div>


    </main>


</body>

</html>