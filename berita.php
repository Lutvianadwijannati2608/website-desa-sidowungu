<?php

require_once "config/database.php";

$pageTitle = "Artikel Desa";
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
   AMBIL SEMUA BERITA
===================================================== */

$berita = [];

$query = $conn->query("
    SELECT *
    FROM berita
    ORDER BY tanggal DESC, id DESC
");

if ($query && $query->num_rows > 0) {

    while ($row = $query->fetch_assoc()) {

        $berita[] = $row;

    }

}


/* =====================================================
   HEADER
===================================================== */

require_once "includes/header.php";

?>


<!-- =====================================================
     HERO ARTIKEL
===================================================== -->

<section class="bg-slate-50 py-20">

    <div class="max-w-7xl
                mx-auto
                px-4
                sm:px-6
                lg:px-8">

        <div class="max-w-3xl">

            <span class="text-xs
                         font-bold
                         uppercase
                         tracking-widest
                         text-gold-500">

                INFORMASI TERBARU

            </span>


            <h1 class="text-4xl
                       md:text-5xl
                       font-extrabold
                       text-navy-900
                       mt-3">

                Artikel Desa

            </h1>


            <p class="text-slate-500
                      mt-5
                      text-lg
                      leading-relaxed">

                Kumpulan informasi, kegiatan, dan berita terbaru
                Desa Sidowungu yang dapat diakses oleh masyarakat.

            </p>

        </div>

    </div>

</section>



<!-- =====================================================
     DAFTAR ARTIKEL
===================================================== -->

<section class="py-20 bg-white">

    <div class="max-w-7xl
                mx-auto
                px-4
                sm:px-6
                lg:px-8">


        <?php if (count($berita) > 0): ?>


            <div class="grid
                        sm:grid-cols-2
                        lg:grid-cols-3
                        gap-8">


                <?php foreach ($berita as $item): ?>


                    <article class="bg-white
                                    border
                                    border-slate-200
                                    rounded-2xl
                                    overflow-hidden
                                    shadow-sm
                                    hover:shadow-xl
                                    hover:-translate-y-1
                                    transition
                                    duration-300
                                    flex
                                    flex-col">


                        <!-- =================================
                             GAMBAR
                        ================================== -->

                        <?php if (!empty($item['gambar'])): ?>

                            <div class="h-52
                                        bg-slate-100
                                        overflow-hidden">

                                <img
                                    src="<?= e($item['gambar']) ?>"
                                    alt="<?= e($item['judul']) ?>"
                                    class="w-full
                                           h-full
                                           object-cover
                                           hover:scale-105
                                           transition
                                           duration-500"
                                    loading="lazy"
                                >

                            </div>

                        <?php else: ?>

                            <div class="h-52
                                        bg-gradient-to-br
                                        from-navy-900
                                        to-slate-700
                                        flex
                                        items-center
                                        justify-center">

                                <div class="text-center">

                                    <div class="text-5xl mb-2">
                                        📰
                                    </div>

                                    <p class="text-white
                                              text-sm
                                              font-semibold">

                                        Berita Desa

                                    </p>

                                </div>

                            </div>

                        <?php endif; ?>


                        <!-- =================================
                             KONTEN
                        ================================== -->

                        <div class="p-6
                                    flex
                                    flex-col
                                    flex-1">


                            <span class="text-[10px]
                                         uppercase
                                         font-bold
                                         tracking-widest
                                         text-gold-500">

                                BERITA DESA

                            </span>


                            <h2 class="text-xl
                                       font-bold
                                       text-navy-900
                                       mt-2
                                       leading-snug">

                                <?= e($item['judul']) ?>

                            </h2>


                            <!-- AUTHOR + TANGGAL -->

                            <div class="mt-4
                                        flex
                                        flex-wrap
                                        items-center
                                        gap-3
                                        text-xs
                                        text-slate-500">

                                <span>

                                    👤
                                    <?= e($item['penulis']) ?>

                                </span>


                                <span class="text-slate-300">
                                    •
                                </span>


                                <span>

                                    📅
                                    <?= formatTanggalIndonesia(
                                        $item['tanggal']
                                    ) ?>

                                </span>

                            </div>


                            <!-- EXCERPT -->

                            <p class="text-sm
                                      text-slate-500
                                      mt-4
                                      leading-relaxed">

                                <?php

                                $excerpt = strip_tags(
                                    $item['isi']
                                );

                                $excerpt = preg_replace(
                                    '/\s+/',
                                    ' ',
                                    $excerpt
                                );

                                if (strlen($excerpt) > 150) {
                                    $excerpt = substr(
                                        $excerpt,
                                        0,
                                        150
                                    ) . '...';
                                }

                                ?>

                                <?= e($excerpt) ?>

                            </p>


                            <!-- VIEW -->

                            <div class="mt-4
                                        text-xs
                                        text-slate-400">

                                👁
                                <?= number_format(
                                    (int) $item['dibaca'],
                                    0,
                                    ',',
                                    '.'
                                ) ?>
                                kali dibaca

                            </div>


                            <!-- BUTTON -->

                            <div class="mt-auto pt-6">

                                <a
                                    href="/berita-detail.php?id=<?= (int) $item['id'] ?>"
                                    class="inline-flex
                                           items-center
                                           justify-center
                                           w-full
                                           px-4
                                           py-3
                                           rounded-xl
                                           bg-navy-900
                                           text-white
                                           text-sm
                                           font-semibold
                                           hover:bg-navy-800
                                           transition">

                                    Baca Selengkapnya

                                    <span class="ml-2">
                                        →
                                    </span>

                                </a>

                            </div>


                        </div>


                    </article>


                <?php endforeach; ?>


            </div>


        <?php else: ?>


            <!-- =================================
                 EMPTY STATE
            ================================== -->

            <div class="text-center
                        py-20">

                <div class="text-6xl mb-5">
                    📰
                </div>


                <h2 class="text-2xl
                           font-bold
                           text-navy-900">

                    Belum Ada Artikel

                </h2>


                <p class="text-slate-500
                          mt-2">

                    Belum ada artikel yang tersedia saat ini.

                </p>

            </div>


        <?php endif; ?>


    </div>

</section>



<!-- =====================================================
     KEMBALI KE BERANDA
===================================================== -->

<section class="py-12
                bg-slate-50">

    <div class="max-w-7xl
                mx-auto
                px-4
                sm:px-6
                lg:px-8">

        <a
            href="/index.php"
            class="inline-flex
                   items-center
                   text-sm
                   font-semibold
                   text-navy-900
                   hover:text-gold-500
                   transition">

            ← Kembali ke Beranda

        </a>

    </div>

</section>



<?php

require_once "includes/footer.php";

?>