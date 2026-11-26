<?php

require_once "config/database.php";

$pageTitle = "Detail Artikel";
$activeMenu = "berita";


/* =====================================================
   HELPER
===================================================== */

function e($text)
{
    return htmlspecialchars(
        $text ?? '',
        ENT_QUOTES,
        'UTF-8'
    );
}


/* =====================================================
   FORMAT TANGGAL INDONESIA
===================================================== */

function formatTanggalIndonesia($tanggal)
{
    $bulan = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];

    $timestamp = strtotime($tanggal);

    if (!$timestamp) {
        return $tanggal;
    }

    $hari = date('d', $timestamp);
    $bulanAngka = (int) date('m', $timestamp);
    $tahun = date('Y', $timestamp);

    return $hari . ' ' . $bulan[$bulanAngka] . ' ' . $tahun;
}


/* =====================================================
   AMBIL ID ARTIKEL
===================================================== */

$id = isset($_GET['id'])
    ? (int) $_GET['id']
    : 0;


/* =====================================================
   VALIDASI ID
===================================================== */

if ($id <= 0) {

    header("Location: /berita.php");
    exit;

}


/* =====================================================
   TAMBAH JUMLAH DIBACA
===================================================== */

$updateView = $conn->query("
    UPDATE berita
    SET dibaca = dibaca + 1
    WHERE id = $id
");


/* =====================================================
   AMBIL DATA ARTIKEL
===================================================== */

$berita = null;

$query = $conn->query("
    SELECT *
    FROM berita
    WHERE id = $id
    LIMIT 1
");

if ($query && $query->num_rows > 0) {

    $berita = $query->fetch_assoc();

}


/* =====================================================
   JIKA ARTIKEL TIDAK DITEMUKAN
===================================================== */

if (!$berita) {

    http_response_code(404);

    require_once "includes/header.php";

    ?>

    <section class="py-24 bg-slate-50">

        <div class="max-w-3xl
                    mx-auto
                    px-4
                    text-center">

            <div class="text-6xl mb-6">
                📰
            </div>


            <h1 class="text-3xl
                       font-extrabold
                       text-navy-900">

                Artikel Tidak Ditemukan

            </h1>


            <p class="text-slate-500
                      mt-3">

                Artikel yang kamu cari tidak tersedia.

            </p>


            <a
                href="/berita.php"
                class="inline-flex
                       items-center
                       mt-8
                       px-6
                       py-3
                       rounded-xl
                       bg-navy-900
                       text-white
                       font-semibold
                       hover:bg-navy-800
                       transition">

                ← Kembali ke Artikel

            </a>

        </div>

    </section>

    <?php

    require_once "includes/footer.php";

    exit;

}


/* =====================================================
   HEADER
===================================================== */

require_once "includes/header.php";

?>


<!-- =====================================================
     DETAIL ARTIKEL
===================================================== -->

<section class="bg-slate-50 py-16">

    <div class="max-w-5xl
                mx-auto
                px-4
                sm:px-6
                lg:px-8">


        <!-- KEMBALI -->

        <a
            href="/berita.php"
            class="inline-flex
                   items-center
                   text-sm
                   font-semibold
                   text-slate-500
                   hover:text-navy-900
                   transition
                   mb-8">

            ← Kembali ke Semua Artikel

        </a>



        <!-- =================================================
             ARTIKEL
        ================================================== -->

        <article class="bg-white
                        rounded-3xl
                        border
                        border-slate-200
                        shadow-sm
                        overflow-hidden">


            <!-- =================================================
                 HEADER ARTIKEL
            ================================================== -->

            <div class="p-7
                        sm:p-10
                        lg:p-12">


                <!-- LABEL -->

                <span class="inline-flex
                             items-center
                             px-3
                             py-1
                             rounded-full
                             bg-amber-50
                             text-amber-600
                             text-xs
                             font-bold
                             uppercase
                             tracking-widest">

                    BERITA DESA

                </span>


                <!-- JUDUL -->

                <h1 class="text-3xl
                           sm:text-4xl
                           lg:text-5xl
                           font-extrabold
                           text-navy-900
                           leading-tight
                           mt-5">

                    <?= e($berita['judul']) ?>

                </h1>


                <!-- =================================================
                     META
                ================================================== -->

                <div class="flex
                            flex-wrap
                            items-center
                            gap-x-6
                            gap-y-3
                            mt-6
                            text-sm
                            text-slate-500">


                    <!-- PENULIS -->

                    <div class="flex items-center gap-2">

                        <span class="text-base">
                            👤
                        </span>

                        <span>

                            <?= e(
                                $berita['penulis']
                                ?: 'Admin Desa'
                            ) ?>

                        </span>

                    </div>


                    <!-- TANGGAL -->

                    <div class="flex items-center gap-2">

                        <span class="text-base">
                            📅
                        </span>

                        <span>

                            <?= formatTanggalIndonesia(
                                $berita['tanggal']
                            ) ?>

                        </span>

                    </div>


                    <!-- DIBACA -->

                    <div class="flex items-center gap-2">

                        <span class="text-base">
                            👁
                        </span>

                        <span>

                            <?= number_format(
                                (int) $berita['dibaca'],
                                0,
                                ',',
                                '.'
                            ) ?>

                            kali dibaca

                        </span>

                    </div>


                </div>


            </div>



            <!-- =================================================
                 GAMBAR UTAMA
            ================================================== -->

            <?php if (!empty($berita['gambar'])): ?>


                <div class="w-full
                            bg-slate-100
                            overflow-hidden">

                    <img
                        src="<?= e($berita['gambar']) ?>"
                        alt="<?= e($berita['judul']) ?>"
                        class="w-full
                               max-h-[650px]
                               object-cover"
                    >

                </div>


            <?php else: ?>


                <!-- PLACEHOLDER UNTUK ARTIKEL TANPA GAMBAR -->

                <div class="w-full
                            h-80
                            sm:h-[420px]
                            bg-gradient-to-br
                            from-navy-900
                            to-slate-700
                            flex
                            items-center
                            justify-center">

                    <div class="text-center">

                        <div class="text-7xl
                                    sm:text-8xl
                                    mb-4">

                            📰

                        </div>


                        <p class="text-white
                                  font-semibold
                                  text-lg">

                            Berita Desa

                        </p>

                    </div>

                </div>


            <?php endif; ?>



            <!-- =================================================
                 ISI ARTIKEL
            ================================================== -->

            <div class="px-7
                        sm:px-10
                        lg:px-12
                        py-10
                        sm:py-12">


                <div class="max-w-4xl
                            mx-auto">


                    <div class="text-slate-700
                                text-base
                                sm:text-lg
                                leading-8">


                        <?php

                        /*
                        |--------------------------------------------------
                        | Pecah isi berdasarkan baris kosong
                        |--------------------------------------------------
                        */

                        $isiParagraph = preg_split(
                            "/\r\n|\r|\n/",
                            $berita['isi']
                        );


                        foreach ($isiParagraph as $paragraph):

                            $paragraph = trim($paragraph);

                            if ($paragraph === '') {
                                continue;
                            }

                        ?>

                            <p class="mb-6">

                                <?= nl2br(
                                    e($paragraph)
                                ) ?>

                            </p>

                        <?php endforeach; ?>


                    </div>


                </div>


            </div>



            <!-- =================================================
                 FOOTER ARTIKEL
            ================================================== -->

            <div class="border-t
                        border-slate-200
                        px-7
                        sm:px-10
                        lg:px-12
                        py-6
                        bg-slate-50">


                <div class="max-w-4xl
                            mx-auto
                            flex
                            flex-col
                            sm:flex-row
                            items-start
                            sm:items-center
                            justify-between
                            gap-4">


                    <div class="text-sm
                                text-slate-500">

                        <span class="font-semibold
                                     text-navy-900">

                            Desa Sidowungu

                        </span>

                        · Informasi Desa

                    </div>


                    <a
                        href="/berita.php"
                        class="inline-flex
                               items-center
                               px-5
                               py-2.5
                               rounded-xl
                               bg-navy-900
                               text-white
                               text-sm
                               font-semibold
                               hover:bg-navy-800
                               transition">

                        ← Semua Artikel

                    </a>


                </div>


            </div>


        </article>


    </div>

</section>



<?php

require_once "includes/footer.php";

?>