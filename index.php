<?php

require_once "config/database.php";

$pageTitle = "Beranda";
$activeMenu = "home";


/*
|--------------------------------------------------------------------------
| HELPER
|--------------------------------------------------------------------------
*/

function e($text)
{
    return htmlspecialchars(
        $text ?? '',
        ENT_QUOTES,
        'UTF-8'
    );
}


function getBeritaImage($item)
{
    $possibleKeys = [
        'gambar',
        'foto',
        'image',
        'gambar_berita',
        'thumbnail'
    ];

    foreach ($possibleKeys as $key) {

        if (
            isset($item[$key]) &&
            !empty($item[$key])
        ) {

            $image = trim($item[$key]);

            if (
                str_starts_with($image, 'http://') ||
                str_starts_with($image, 'https://')
            ) {
                return $image;
            }

            if (str_starts_with($image, '/')) {
                return $image;
            }

            return '/assets/images/berita/' . $image;
        }
    }

    return null;
}


/*
|--------------------------------------------------------------------------
| DATA PROFIL
|--------------------------------------------------------------------------
*/

$profil = [
    'nama_desa' => 'Sidowungu',
    'kecamatan' => 'Menganti',
    'kabupaten' => 'Gresik',
    'deskripsi' => 'Website resmi Desa Sidowungu sebagai media informasi dan pelayanan digital bagi masyarakat Desa Sidowungu.'
];


$profilQuery = $conn->query(
    "SELECT * FROM profil LIMIT 1"
);


if (
    $profilQuery &&
    $profilQuery->num_rows > 0
) {

    $profilDatabase = $profilQuery->fetch_assoc();

    $profil = array_merge(
        $profil,
        $profilDatabase
    );
}


/*
|--------------------------------------------------------------------------
| DATA BERITA
|--------------------------------------------------------------------------
*/

$beritaSemua = [];

$beritaQuery = $conn->query(
    "SELECT *
     FROM berita
     ORDER BY tanggal DESC, id DESC"
);


if (
    $beritaQuery &&
    $beritaQuery->num_rows > 0
) {

    while ($row = $beritaQuery->fetch_assoc()) {
        $beritaSemua[] = $row;
    }
}


$berita = array_slice(
    $beritaSemua,
    0,
    3
);


/*
|--------------------------------------------------------------------------
| FALLBACK BERITA
|--------------------------------------------------------------------------
*/

if (count($beritaSemua) === 0) {

    $beritaSemua = [

        [
            'id' => 1,
            'judul' => 'APBDes Desa Sidowungu TA 2025',
            'tanggal' => '2025-02-28',
            'isi' => 'Informasi APBDes Desa Sidowungu Tahun Anggaran 2025.'
        ],

        [
            'id' => 2,
            'judul' => 'Realisasi APBDes TA 2024',
            'tanggal' => '2025-02-28',
            'isi' => 'Informasi realisasi APBDes Desa Sidowungu.'
        ],

        [
            'id' => 3,
            'judul' => 'Selamat dan Sukses atas dilantiknya Bupati dan Wakil Bupati Gresik 2025–2030',
            'tanggal' => '2025-02-21',
            'isi' => 'Ucapan selamat dan sukses atas pelantikan Bupati dan Wakil Bupati Gresik periode 2025–2030.'
        ],

        [
            'id' => 4,
            'judul' => 'Terima kasih, Bu min',
            'tanggal' => '2025-02-21',
            'isi' => 'Informasi dan ucapan terima kasih kepada masyarakat Desa Sidowungu.'
        ],

        [
            'id' => 5,
            'judul' => 'Musdes Pembentukan Tim Penyusun RKP Desa Sidowungu TA 2025',
            'tanggal' => '2024-08-05',
            'isi' => 'Informasi kegiatan Musyawarah Desa Sidowungu.'
        ],

        [
            'id' => 6,
            'judul' => 'Mahasiswa KKN BKK 4 Universitas Airlangga Berikan Edukasi Gizi Seimbang di UPT SD Negeri 239 Gresik',
            'tanggal' => '2024-07-29',
            'isi' => 'Kegiatan mahasiswa KKN BKK 4 Universitas Airlangga memberikan edukasi gizi seimbang di UPT SD Negeri 239 Gresik.'
        ],

        [
            'id' => 7,
            'judul' => 'Penyaluran BLT DD bulan Juni 2024',
            'tanggal' => '2024-06-13',
            'isi' => 'Informasi penyaluran BLT Dana Desa bulan Juni 2024.'
        ]

    ];

    $berita = array_slice(
        $beritaSemua,
        0,
        3
    );
}


/*
|--------------------------------------------------------------------------
| DATA STATISTIK
|--------------------------------------------------------------------------
*/

$statistik = [];

$statistikQuery = $conn->query(
    "SELECT nama, nilai
     FROM statistik_ringkasan
     ORDER BY id ASC"
);


if (
    $statistikQuery &&
    $statistikQuery->num_rows > 0
) {

    while ($row = $statistikQuery->fetch_assoc()) {

        $statistik[
            strtoupper($row['nama'])
        ] = (int) $row['nilai'];

    }
}


$totalPenduduk =
    $statistik['TOTAL'] ?? 0;

$totalLaki =
    $statistik['LAKI-LAKI'] ?? 0;

$totalPerempuan =
    $statistik['PEREMPUAN'] ?? 0;


require_once "includes/header.php";

?>


<!-- =========================================================
     HERO SLIDESHOW
========================================================= -->

<style>

    .hero-slide {
        opacity: 0;
        transition: opacity 1.2s ease-in-out;
    }

    .hero-slide.active {
        opacity: 1;
    }

    .hero-dot {
        width: 9px;
        height: 9px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .45);
        transition: all .3s ease;
        border: none;
        cursor: pointer;
    }

    .hero-dot.active {
        width: 28px;
        background: #F59E0B;
    }

    .sidowungu-map {
        width: 100%;
        height: 240px;
        border-radius: 12px;
        overflow: hidden;
    }

    .youtube-brand {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all .2s ease;
        box-shadow: 0 2px 6px rgba(15, 23, 42, .08);
    }

    .youtube-brand:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(15, 23, 42, .12);
    }

    .article-modal {
        display: none;
    }

    .article-modal.show {
        display: flex;
    }

</style>


<section
    id="hero"
    class="
        relative
        min-h-[520px]
        sm:min-h-[530px]
        lg:min-h-[540px]
        flex
        items-center
        overflow-hidden
        bg-navy-900
    "
>

    <div
        id="heroSlides"
        class="
            absolute
            inset-0
        "
    >

        <img
            src="/assets/images/hero/hero1.jpg"
            alt="Desa Sidowungu"
            class="
                hero-slide
                active
                absolute
                inset-0
                w-full
                h-full
                object-cover
            "
        >

        <img
            src="/assets/images/hero/hero2.jpg"
            alt="Desa Sidowungu"
            class="
                hero-slide
                absolute
                inset-0
                w-full
                h-full
                object-cover
            "
        >

        <img
            src="/assets/images/hero/hero3.jpg"
            alt="Desa Sidowungu"
            class="
                hero-slide
                absolute
                inset-0
                w-full
                h-full
                object-cover
            "
        >

        <img
            src="/assets/images/hero/hero4.png"
            alt="Desa Sidowungu"
            class="
                hero-slide
                absolute
                inset-0
                w-full
                h-full
                object-cover
            "
        >

    </div>


    <div
        class="
            absolute
            inset-0
            bg-gradient-to-r
            from-navy-950/95
            via-navy-900/75
            to-navy-900/30
            z-[1]
        "
    >
    </div>


    <div
        class="
            relative
            z-10
            max-w-7xl
            mx-auto
            px-4
            sm:px-6
            lg:px-8
            w-full
        "
    >

        <div class="max-w-3xl">

            <div
                class="
                    inline-flex
                    items-center
                    gap-2
                    bg-white/10
                    backdrop-blur-md
                    border
                    border-white/20
                    text-gold-400
                    text-xs
                    font-bold
                    px-4
                    py-2
                    rounded-full
                "
            >

                <span
                    class="
                        w-2
                        h-2
                        rounded-full
                        bg-gold-400
                    "
                >
                </span>

                WEBSITE RESMI DESA SIDOWUNGU

            </div>


            <h1
                class="
                    text-3xl
                    sm:text-4xl
                    lg:text-5xl
                    font-extrabold
                    text-white
                    leading-tight
                    mt-6
                "
            >

                Selamat Datang di

                <span class="text-gold-400">
                    Desa Sidowungu
                </span>

            </h1>


            <p
                class="
                    text-lg
                    text-slate-200
                    mt-6
                    leading-relaxed
                    max-w-2xl
                "
            >

                <?= e($profil['deskripsi']) ?>

            </p>


            <p
                class="
                    text-sm
                    text-slate-300
                    mt-3
                    max-w-2xl
                "
            >

                Kecamatan <?= e($profil['kecamatan']) ?>,
                Kabupaten <?= e($profil['kabupaten']) ?>.

            </p>


            <div
                class="
                    flex
                    flex-wrap
                    gap-3
                    mt-8
                "
            >

                <a
                    href="/profil/sejarah.php"
                    class="
                        bg-gold-500
                        hover:bg-gold-400
                        text-navy-950
                        font-bold
                        px-6
                        py-3.5
                        rounded-xl
                        transition
                    "
                >

                    Jelajahi Profil →

                </a>


            </div>

        </div>

    </div>


    <div
        id="heroDots"
        class="
            absolute
            bottom-8
            left-1/2
            -translate-x-1/2
            z-20
            flex
            gap-2
        "
    >

        <button
            type="button"
            class="hero-dot active"
            data-slide="0"
            aria-label="Foto 1"
        ></button>

        <button
            type="button"
            class="hero-dot"
            data-slide="1"
            aria-label="Foto 2"
        ></button>

        <button
            type="button"
            class="hero-dot"
            data-slide="2"
            aria-label="Foto 3"
        ></button>

        <button
            type="button"
            class="hero-dot"
            data-slide="3"
            aria-label="Foto 4"
        ></button>

    </div>

</section>


<!-- TENTANG KAMI -->
<section class="py-16  bg-slate-100">
    <div class="pl-4 lg:pl-8 lg:-translate-y-6">

        <div class="grid lg:grid-cols-2 gap-10 lg:gap-16 items-center">

<!-- Kiri: Penjelasan -->
<div class="pl-4 lg:pl-8 lg:-translate-y-6">
    <span class="inline-flex items-center gap-2 text-sm font-bold tracking-widest text-orange-500 uppercase mb-4">
        <span class="w-8 h-[2px] bg-orange-500"></span>
        Tentang Kami
    </span>

    <h2 class="text-3xl sm:text-[34px] font-extrabold text-slate-900 leading-tight mb-5">
        Mengenal Desa
        <span class="text-orange-500">Sidowungu</span>
    </h2>

<p class="text-slate-600 text-base sm:text-[16px] leading-relaxed text-justify mb-5">
    Desa Sidowungu merupakan salah satu desa yang berada di Kecamatan Menganti,
    Kabupaten Gresik, Jawa Timur. Desa ini terus berkembang dengan berbagai
    potensi, kegiatan, serta kehidupan masyarakat yang beragam.
</p>

<p class="text-slate-600 text-base sm:text-[16px] leading-relaxed text-justify mb-5">
    Salah satu potensi yang menjadi ciri khas Desa Sidowungu adalah usaha ayam.
    Banyak masyarakat Desa Sidowungu yang menjalankan usaha di bidang peternakan
    dan perdagangan ayam, sehingga desa ini sering dikenal sebagai desa yang
    memiliki banyak pengusaha ayam.
</p>

<p class="text-slate-600 text-base sm:text-[16px] leading-relaxed text-justify">
    Melalui website resmi ini, Pemerintah Desa Sidowungu menyediakan informasi
    mengenai profil desa, pelayanan, kegiatan, statistik, serta potensi UMKM
    yang ada di Desa Sidowungu.
</p>
</div>


<!-- Kanan: Foto -->
<div class="flex justify-center items-center">
    <div class="relative w-[360px] h-[380px]">

        <!-- Card Foto -->
        <div class="w-full h-full overflow-hidden rounded-2xl shadow-lg border border-slate-200">
            <img
                src="/assets/images/hero/hero4.png"
                alt="Desa Sidowungu"
                class="w-full h-full object-cover"
            >
        </div>

        <!-- Aksen pojok kanan atas -->
        <div class="absolute -top-3 -right-3
                    w-12 h-12
                    border-4 border-orange-400
                    rounded-2xl">
        </div>

        <!-- Aksen pojok kiri bawah -->
        <div class="absolute -bottom-3 -left-3
                    w-14 h-14
                    bg-orange-500
                    rounded-2xl">
        </div>

    </div>
</div>
            </div>

        </div>

    </div>
</section>

<!-- =========================================================
     STATISTIK
========================================================= -->

<section
    class="
        pt-10
        pb-20
        bg-white
    "
>

    <div
        class="
            max-w-7xl
            mx-auto
            px-4
            sm:px-6
            lg:px-8
        "
    >

        <div
            class="
                flex
                items-end
                justify-between
                gap-4
                mb-10
            "
        >

            <div>

                <span
                    class="
                        text-xs
                        font-bold
                        uppercase
                        tracking-widest
                        text-gold-500
                    "
                >

                    Statistik

                </span>


                <h2
                    class="
                        text-3xl
                        font-extrabold
                        text-navy-900
                        mt-1
                    "
                >

                    Jumlah Penduduk

                </h2>


                <p
                    class="
                        text-sm
                        text-slate-500
                        mt-2
                    "
                >

                    Data penduduk Desa Sidowungu

                </p>

            </div>


            <a
                href="/statistik/jenis-kelamin.php"
                class="
                    hidden
                    sm:inline-block
                    text-xs
                    font-bold
                    text-navy-700
                "
            >

                Lihat Statistik →

            </a>

        </div>


        <div
            class="
                grid
                sm:grid-cols-3
                gap-5
                mb-8
            "
        >

            <div
                class="
                    bg-navy-900
                    rounded-2xl
                    p-7
                    text-white
                "
            >

                <p class="text-xs text-slate-300">
                    Laki-laki
                </p>


                <p
                    class="
                        text-4xl
                        font-extrabold
                        text-gold-400
                        mt-2
                    "
                >

                    <?= number_format(
                        $totalLaki,
                        0,
                        ',',
                        '.'
                    ) ?>

                </p>

            </div>


            <div
                class="
                    bg-navy-900
                    rounded-2xl
                    p-7
                    text-white
                "
            >

                <p class="text-xs text-slate-300">
                    Perempuan
                </p>


                <p
                    class="
                        text-4xl
                        font-extrabold
                        text-gold-400
                        mt-2
                    "
                >

                    <?= number_format(
                        $totalPerempuan,
                        0,
                        ',',
                        '.'
                    ) ?>

                </p>

            </div>


            <div
                class="
                    bg-slate-50
                    border
                    border-slate-200
                    rounded-2xl
                    p-7
                "
            >

                <p class="text-xs text-slate-400">
                    Total Penduduk
                </p>


                <p
                    class="
                        text-4xl
                        font-extrabold
                        text-navy-900
                        mt-2
                    "
                >

                    <?= number_format(
                        $totalPenduduk,
                        0,
                        ',',
                        '.'
                    ) ?>

                </p>

            </div>

        </div>


        <div
            class="
                bg-slate-50
                border
                border-slate-200
                rounded-2xl
                p-6
                sm:p-8
            "
        >

            <div class="relative h-[380px]">

                <canvas id="populationChart"></canvas>

            </div>

        </div>

    </div>

</section>


<!-- =========================================================
     ARTIKEL
========================================================= -->

<section
    class="
        pt-10
        pb-20
        bg-slate-100
    "
>

    <div
        class="
            max-w-7xl
            mx-auto
            px-4
            sm:px-6
            lg:px-8
        "
    >

        <div
            class="
                flex
                items-end
                justify-between
                mb-10
            "
        >

            <div>

                <span
                    class="
                        text-xs
                        font-bold
                        uppercase
                        tracking-widest
                        text-gold-500
                    "
                >

                    Informasi Terbaru

                </span>


                <h2
                    class="
                        text-3xl
                        font-extrabold
                        text-navy-900
                        mt-1
                    "
                >

                    Artikel Terkini

                </h2>

            </div>


            <button
                type="button"
                onclick="openSemuaBerita()"
                class="
                    text-xs
                    font-bold
                    text-navy-700
                    hover:text-gold-500
                "
            >

                Lihat Semua →

            </button>

        </div>


        <div
            class="
                grid
                md:grid-cols-3
                gap-6
            "
        >

            <?php foreach ($berita as $item): ?>

                <?php
                $image = getBeritaImage($item);
                ?>

                <article
                    onclick='openBeritaDetail(
                        <?= json_encode(
                            $item['judul'],
                            JSON_HEX_TAG |
                            JSON_HEX_AMP |
                            JSON_HEX_APOS |
                            JSON_HEX_QUOT
                        ) ?>,
                        <?= json_encode(
                            $item['isi'],
                            JSON_HEX_TAG |
                            JSON_HEX_AMP |
                            JSON_HEX_APOS |
                            JSON_HEX_QUOT
                        ) ?>,
                        <?= json_encode(
                            date(
                                'd F Y',
                                strtotime(
                                    $item['tanggal']
                                )
                            )
                        ) ?>
                    )'
                    class="
                        bg-white
                        border
                        border-slate-200
                        rounded-2xl
                        overflow-hidden
                        shadow-sm
                        hover:shadow-lg
                        hover:-translate-y-1
                        transition
                        cursor-pointer
                    "
                >

                    <div
                        class="
                            h-44
                            bg-gradient-to-br
                            from-navy-900
                            to-slate-700
                            flex
                            items-center
                            justify-center
                            overflow-hidden
                        "
                    >

                        <?php if ($image): ?>

                            <img
                                src="<?= e($image) ?>"
                                alt="<?= e($item['judul']) ?>"
                                class="
                                    w-full
                                    h-full
                                    object-cover
                                "
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                            >


                            <div
                                class="
                                    hidden
                                    w-full
                                    h-full
                                    items-center
                                    justify-center
                                    text-5xl
                                "
                            >

                                📰

                            </div>


                        <?php else: ?>

                            <div class="text-5xl">

                                📰

                            </div>

                        <?php endif; ?>

                    </div>


                    <div class="p-6">

                        <span
                            class="
                                text-[10px]
                                uppercase
                                font-bold
                                text-gold-500
                            "
                        >

                            BERITA DESA

                        </span>


                        <h3
                            class="
                                text-lg
                                font-bold
                                text-navy-900
                                mt-2
                            "
                        >

                            <?= e($item['judul']) ?>

                        </h3>


                        <p
                            class="
                                text-sm
                                text-slate-500
                                mt-3
                                leading-relaxed
                            "
                        >

                            <?= e($item['isi']) ?>

                        </p>


                        <p
                            class="
                                text-[11px]
                                text-slate-400
                                mt-4
                            "
                        >

                            <?= date(
                                'd F Y',
                                strtotime(
                                    $item['tanggal']
                                )
                            ) ?>

                        </p>


                        <p
                            class="
                                text-xs
                                font-bold
                                text-navy-700
                                mt-4
                            "
                        >

                            Baca selengkapnya →

                        </p>

                    </div>

                </article>

            <?php endforeach; ?>

        </div>

    </div>

</section>


<!-- =========================================================
     AGENDA DESA
========================================================= -->

<section
    class="
        pt-8
        pb-14
        bg-white
    "
>

    <div
        class="
            max-w-7xl
            mx-auto
            px-4
            sm:px-6
            lg:px-8
        "
    >

        <div class="mb-7">

            <span
                class="
                    text-xs
                    font-bold
                    uppercase
                    tracking-widest
                    text-gold-500
                "
            >

                Kalender &amp; Agenda Desa

            </span>


            <h2
                class="
                    text-3xl
                    font-extrabold
                    text-navy-900
                    mt-1
                "
            >

                Agenda Desa

            </h2>

        </div>


        <div
            class="
                grid
                lg:grid-cols-3
                gap-5
            "
        >

            <div
                class="
                    lg:col-span-2
                    bg-slate-50
                    border
                    border-slate-200
                    rounded-2xl
                    overflow-hidden
                    shadow-sm
                "
            >

                <div
                    class="
                        px-5
                        py-3
                        border-b
                        border-slate-200
                        bg-white
                        flex
                        items-center
                        justify-between
                    "
                >

                    <h3
                        id="calendarMonthTitle"
                        class="
                            font-bold
                            text-sm
                            text-navy-900
                        "
                    >
                    </h3>


                    <div
                        class="
                            flex
                            items-center
                            gap-2
                        "
                    >

                        <button
                            type="button"
                            id="prevMonth"
                            class="
                                w-8
                                h-8
                                rounded-lg
                                border
                                border-slate-200
                                bg-white
                                flex
                                items-center
                                justify-center
                                text-slate-500
                            "
                        >

                            ‹

                        </button>


                        <button
                            type="button"
                            id="nextMonth"
                            class="
                                w-8
                                h-8
                                rounded-lg
                                border
                                border-slate-200
                                bg-white
                                flex
                                items-center
                                justify-center
                                text-slate-500
                            "
                        >

                            ›

                        </button>

                    </div>

                </div>


                <div
                    class="
                        grid
                        grid-cols-7
                        border-b
                        border-slate-200
                        bg-white
                    "
                >

                    <div class="py-2 text-center text-[9px] font-bold text-slate-400">
                        MIN
                    </div>

                    <div class="py-2 text-center text-[9px] font-bold text-slate-400">
                        SEN
                    </div>

                    <div class="py-2 text-center text-[9px] font-bold text-slate-400">
                        SEL
                    </div>

                    <div class="py-2 text-center text-[9px] font-bold text-slate-400">
                        RAB
                    </div>

                    <div class="py-2 text-center text-[9px] font-bold text-slate-400">
                        KAM
                    </div>

                    <div class="py-2 text-center text-[9px] font-bold text-slate-400">
                        JUM
                    </div>

                    <div class="py-2 text-center text-[9px] font-bold text-slate-400">
                        SAB
                    </div>

                </div>


                <div
                    id="calendarGrid"
                    class="
                        grid
                        grid-cols-7
                        bg-white
                    "
                >
                </div>

            </div>


            <div
                class="
                    bg-slate-50
                    border
                    border-slate-200
                    rounded-2xl
                    overflow-hidden
                    shadow-sm
                "
            >

                <div
                    class="
                        px-5
                        py-3
                        border-b
                        border-slate-200
                        bg-white
                    "
                >

                    <h3
                        class="
                            font-bold
                            text-sm
                            text-navy-900
                        "
                    >

                        Agenda Mendatang

                    </h3>

                </div>


                <div
                    id="upcomingAgenda"
                    class="min-h-[190px]"
                >
                </div>


                <div
                    class="
                        border-t
                        border-slate-200
                        px-5
                        py-3
                        text-center
                    "
                >

                    <button
                        type="button"
                        id="openAllAgenda"
                        class="
                            text-[11px]
                            font-bold
                            text-gold-600
                        "
                    >

                        Lihat Semua Agenda →

                    </button>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- =========================================================
     MODAL SEMUA AGENDA
========================================================= -->

<div
    id="semuaAgendaModal"
    class="
        article-modal
        fixed
        inset-0
        z-[120]
        bg-black/50
        backdrop-blur-sm
        items-center
        justify-center
        p-4
    "
>

    <div
        class="
            bg-white
            w-full
            max-w-2xl
            max-h-[88vh]
            rounded-2xl
            overflow-hidden
            shadow-2xl
        "
    >

        <div
            class="
                px-6
                py-5
                border-b
                border-slate-200
                flex
                items-center
                justify-between
            "
        >

            <div>

                <span
                    class="
                        text-[10px]
                        uppercase
                        font-bold
                        text-gold-500
                    "
                >

                    Kalender & Agenda Desa

                </span>


                <h3
                    class="
                        text-xl
                        font-extrabold
                        text-navy-900
                        mt-1
                    "
                >

                    Semua Agenda Desa

                </h3>

            </div>


            <button
                type="button"
                id="closeAllAgenda"
                class="
                    w-9
                    h-9
                    rounded-full
                    bg-slate-100
                    text-slate-600
                    flex
                    items-center
                    justify-center
                    text-xl
                "
            >

                ×

            </button>

        </div>


        <div
            id="allAgendaList"
            class="
                overflow-y-auto
                max-h-[72vh]
                px-6
            "
        >
        </div>

    </div>

</div>

<!-- KONTAK DESA -->
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Heading -->
        <div class="text-center mb-10">
            <span class="inline-flex items-center gap-2 text-sm font-bold tracking-widest text-orange-500 uppercase mb-3">
                <span class="w-8 h-[2px] bg-orange-500"></span>
                Hubungi Kami
                <span class="w-8 h-[2px] bg-orange-500"></span>
            </span>

            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">
                Kontak Desa <span class="text-orange-500">Sidowungu</span>
            </h2>

            <p class="mt-3 text-slate-600 max-w-2xl mx-auto">
                Informasi kontak dan pelayanan Pemerintah Desa Sidowungu
                yang dapat digunakan oleh masyarakat.
            </p>
        </div>

        <!-- Contact Cards -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">

<!-- Alamat -->
<a
    href="/index.php#peta-kantor"
    class="block bg-white rounded-2xl border border-slate-200 shadow-sm p-6 text-center
           hover:-translate-y-1 hover:shadow-lg transition duration-300"
>
    <div class="w-12 h-12 mx-auto mb-4 rounded-xl bg-orange-100
                flex items-center justify-center text-orange-500 text-2xl">
        📍
    </div>

    <h3 class="font-bold text-slate-900 mb-2">
        Alamat Kantor
    </h3>

    <p class="text-sm text-slate-600 leading-relaxed">
        Jln. Raya Sidowungu No. 50,
        Kecamatan Menganti, Kabupaten Gresik
    </p>
</a>

            <!-- Jam Pelayanan -->
<a
    href="#peta-kantor"
    class="block bg-white rounded-2xl border border-slate-200 shadow-sm p-6 text-center
           hover:-translate-y-1 hover:shadow-lg transition duration-300"
>
    <div class="w-12 h-12 mx-auto mb-4 rounded-xl bg-orange-100
                flex items-center justify-center text-orange-500 text-2xl">
        🕐
    </div>

    <h3 class="font-bold text-slate-900 mb-2">
        Jam Pelayanan
    </h3>

    <p class="text-sm text-slate-600 leading-relaxed">
        Senin–Jumat<br>
        08.00–15.00 WIB
    </p>
</a>

<!-- Telepon / WhatsApp -->
<?php if (!empty($kontakTelepon)): ?>

<a
    href="tel:<?= htmlspecialchars($kontakTelepon) ?>"
    class="block bg-white rounded-2xl border border-slate-200 shadow-sm p-6 text-center
           hover:-translate-y-1 hover:shadow-lg transition duration-300"
>
    <div class="w-12 h-12 mx-auto mb-4 rounded-xl bg-orange-100
                flex items-center justify-center text-orange-500 text-2xl">
        📞
    </div>

    <h3 class="font-bold text-slate-900 mb-2">
        Telepon / WhatsApp
    </h3>

    <p class="text-sm text-orange-500 font-semibold">
        <?= htmlspecialchars($kontakTelepon) ?>
    </p>
</a>

<?php else: ?>

<div
    class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 text-center
           hover:-translate-y-1 hover:shadow-lg transition duration-300 cursor-pointer"
>
    <div class="w-12 h-12 mx-auto mb-4 rounded-xl bg-orange-100
                flex items-center justify-center text-orange-500 text-2xl">
        📞
    </div>

    <h3 class="font-bold text-slate-900 mb-2">
        Telepon / WhatsApp
    </h3>

    <p class="text-sm text-slate-500">
        Nomor kontak belum tersedia
    </p>
</div>

<?php endif; ?>

<!-- Email -->
<?php if (!empty($kontakEmail)): ?>

<a
    href="mailto:<?= htmlspecialchars($kontakEmail) ?>"
    class="block bg-white rounded-2xl border border-slate-200 shadow-sm p-6 text-center
           hover:-translate-y-1 hover:shadow-lg transition duration-300"
>
    <div class="w-12 h-12 mx-auto mb-4 rounded-xl bg-orange-100
                flex items-center justify-center text-orange-500 text-2xl">
        ✉️
    </div>

    <h3 class="font-bold text-slate-900 mb-2">
        Email Desa
    </h3>

    <p class="text-sm text-orange-500 font-semibold break-all">
        <?= htmlspecialchars($kontakEmail) ?>
    </p>
</a>

<?php else: ?>

<div
    class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 text-center
           hover:-translate-y-1 hover:shadow-lg transition duration-300 cursor-pointer"
>
    <div class="w-12 h-12 mx-auto mb-4 rounded-xl bg-orange-100
                flex items-center justify-center text-orange-500 text-2xl">
        ✉️
    </div>

    <h3 class="font-bold text-slate-900 mb-2">
        Email Desa
    </h3>

    <p class="text-sm text-slate-500">
        Email desa belum tersedia
    </p>
</div>

<?php endif; ?>

    </div>
</section>


<!-- =========================================================
     MEDIA SOSIAL & PETA
========================================================= -->

<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
/>


<section
    class="
        pt-10
        pb-20
        bg-slate-100
    "
>

    <div
        class="
            max-w-7xl
            mx-auto
            px-4
            sm:px-6
            lg:px-8
        "
    >

        <div
            class="
                text-center
                mb-10
            "
        >

            <span
                class="
                    text-xs
                    uppercase
                    font-bold
                    tracking-widest
                    text-gold-500
                "
            >

                Informasi Desa

            </span>


            <h2
                class="
                    text-3xl
                    font-extrabold
                    text-navy-900
                    mt-1
                "
            >

                Media Sosial & Lokasi Desa

            </h2>


            <p
                class="
                    text-sm
                    text-slate-500
                    mt-2
                    max-w-2xl
                    mx-auto
                "
            >

                Temukan media sosial serta lokasi wilayah dan
                Kantor Desa Sidowungu dalam satu tempat.

            </p>

        </div>


        <div
            class="
                grid
                grid-cols-1
                md:grid-cols-2
                lg:grid-cols-3
                gap-6
            "
        >

            <!-- MEDIA SOSIAL -->

            <div
                class="
                    bg-white
                    border
                    border-slate-200
                    rounded-2xl
                    overflow-hidden
                    shadow-sm
                "
            >

                <div
                    class="
                        bg-gold-100
                        px-5
                        py-4
                        border-b
                        border-amber-100
                    "
                >

                    <div
                        class="
                            flex
                            items-center
                            gap-2
                        "
                    >

                        <span class="text-lg">
                            🌐
                        </span>


                        <h3
                            class="
                                font-bold
                                text-sm
                                text-amber-700
                            "
                        >

                            Media Sosial

                        </h3>

                    </div>

                </div>


                <div class="p-5">

                    <p
                        class="
                            text-xs
                            text-slate-500
                            leading-relaxed
                            mb-5
                        "
                    >

                        Ikuti informasi dan kegiatan terbaru
                        Desa Sidowungu melalui media sosial resmi.

                    </p>


                    <div
                        class="
                            flex
                            items-center
                            gap-4
                        "
                    >

                        <a
                            href="https://www.facebook.com/sidowungubisa"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="
                                w-12
                                h-12
                                rounded-xl
                                bg-[#1877F2]
                                flex
                                items-center
                                justify-center
                                text-white
                            "
                        >

                            <svg
                                class="w-7 h-7"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                            >

                                <path
                                    d="M13.5 21v-8h2.7l.4-3h-3.1V8.1c0-.9.3-1.5 1.6-1.5h1.7V3.9c-.3 0-1.4-.1-2.6-.1-2.6 0-4.4 1.6-4.4 4.5V10H7v3h2.8v8h3.7z"
                                />

                            </svg>

                        </a>


                        <a
                            href="https://www.youtube.com/@desasidowunguTV"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="youtube-brand"
                        >

                            <svg
                                width="38"
                                height="38"
                                viewBox="0 0 48 48"
                            >

                                <rect
                                    x="4"
                                    y="10"
                                    width="40"
                                    height="28"
                                    rx="8"
                                    fill="#FF0000"
                                />

                                <path
                                    d="M20 17.5L32 24L20 30.5V17.5Z"
                                    fill="#FFFFFF"
                                />

                            </svg>

                        </a>


                        <a
                            href="https://www.instagram.com/desa_sidowungu/"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="
                                w-12
                                h-12
                                rounded-xl
                                bg-gradient-to-tr
                                from-yellow-400
                                via-pink-500
                                to-purple-600
                                flex
                                items-center
                                justify-center
                                text-white
                            "
                        >

                            <svg
                                class="w-7 h-7"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >

                                <rect
                                    x="3"
                                    y="3"
                                    width="18"
                                    height="18"
                                    rx="5"
                                />

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="4"
                                />

                                <circle
                                    cx="17.5"
                                    cy="6.5"
                                    r="1"
                                    fill="currentColor"
                                    stroke="none"
                                />

                            </svg>

                        </a>

                    </div>

                </div>

            </div>


            <!-- PETA WILAYAH -->

            <div
                class="
                    bg-white
                    border
                    border-slate-200
                    rounded-2xl
                    overflow-hidden
                    shadow-sm
                "
            >

                <div
                    class="
                        bg-gold-100
                        px-5
                        py-4
                        border-b
                        border-amber-100
                    "
                >

                    <div
                        class="
                            flex
                            items-center
                            gap-2
                        "
                    >

                        <span class="text-lg">
                            📍
                        </span>


                        <h3
                            class="
                                font-bold
                                text-sm
                                text-amber-700
                            "
                        >

                            Peta Wilayah Desa

                        </h3>

                    </div>

                </div>


                <div class="p-4">

                    <div
                        id="mapWilayahSidowungu"
                        class="sidowungu-map"
                    >
                    </div>


                    <a
                        href="https://www.openstreetmap.org/?mlat=-7.2967&mlon=112.6061#map=15/-7.2967/112.6061"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="
                            inline-flex
                            items-center
                            gap-1.5
                            mt-3
                            text-xs
                            font-bold
                            text-navy-700
                        "
                    >

                        Buka peta

                        <span>↗</span>

                    </a>

                </div>

            </div>


            <!-- PETA KANTOR -->

<div
    id="peta-kantor"
    class="
        bg-white
        border
        border-slate-200
        rounded-2xl
        overflow-hidden
        shadow-sm
    "
            >

                <div
                    class="
                        bg-gold-100
                        px-5
                        py-4
                        border-b
                        border-amber-100
                    "
                >

                    <div
                        class="
                            flex
                            items-center
                            gap-2
                        "
                    >

                        <span class="text-lg">
                            📍
                        </span>


                        <h3
                            class="
                                font-bold
                                text-sm
                                text-amber-700
                            "
                        >

                            Peta Lokasi Kantor

                        </h3>

                    </div>

                </div>


                <div class="p-4">

                    <div
                        id="mapKantorSidowungu"
                        class="sidowungu-map"
                    >
                    </div>


                    <p
                        class="
                            text-xs
                            font-bold
                            text-navy-900
                            mt-3
                        "
                    >

                        Kantor Desa Sidowungu

                    </p>


                    <p
                        class="
                            text-[11px]
                            text-slate-500
                            mt-1
                            leading-relaxed
                        "
                    >

                        Jln. Raya Sidowungu No. 50,
                        Kec. Menganti, Kab. Gresik

                    </p>


                    <div
                        class="
                            flex
                            gap-2
                            mt-3
                        "
                    >

                        <a
                            href="https://www.google.com/maps/search/?api=1&query=Kantor+Desa+Sidowungu,+Jln.+Raya+Sidowungu+No.+50,+Gresik"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="
                                inline-flex
                                items-center
                                justify-center
                                px-3.5
                                py-2
                                rounded-lg
                                bg-emerald-500
                                text-white
                                text-[11px]
                                font-bold
                            "
                        >

                            Buka Peta

                        </a>


                        <a
                            href="/profil/geografis.php"
                            class="
                                inline-flex
                                items-center
                                justify-center
                                px-3.5
                                py-2
                                rounded-lg
                                bg-navy-900
                                text-white
                                text-[11px]
                                font-bold
                            "
                        >

                            Detail

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- =========================================================
     MODAL SEMUA BERITA
========================================================= -->

<div
    id="semuaBeritaModal"
    class="
        article-modal
        fixed
        inset-0
        z-[100]
        bg-black/50
        backdrop-blur-sm
        items-center
        justify-center
        p-4
    "
>

    <div
        class="
            bg-white
            w-full
            max-w-2xl
            max-h-[88vh]
            rounded-2xl
            overflow-hidden
            shadow-2xl
        "
    >

        <div
            class="
                bg-white
                border-b
                border-slate-200
                px-6
                py-5
                flex
                items-center
                justify-between
            "
        >

            <div>

                <span
                    class="
                        text-[10px]
                        uppercase
                        font-bold
                        text-gold-500
                    "
                >

                    Informasi Terbaru

                </span>


                <h3
                    class="
                        text-xl
                        font-extrabold
                        text-navy-900
                        mt-1
                    "
                >

                    Semua Artikel Desa

                </h3>

            </div>


            <button
                type="button"
                onclick="closeSemuaBerita()"
                class="
                    w-9
                    h-9
                    rounded-full
                    bg-slate-100
                    text-slate-600
                    flex
                    items-center
                    justify-center
                    text-xl
                "
            >

                ×

            </button>

        </div>


        <div
            class="
                overflow-y-auto
                max-h-[72vh]
                px-6
            "
        >

            <?php foreach ($beritaSemua as $item): ?>

                <?php
                $image = getBeritaImage($item);
                ?>

                <div
                    onclick='openBeritaDetail(
                        <?= json_encode(
                            $item['judul'],
                            JSON_HEX_TAG |
                            JSON_HEX_AMP |
                            JSON_HEX_APOS |
                            JSON_HEX_QUOT
                        ) ?>,
                        <?= json_encode(
                            $item['isi'],
                            JSON_HEX_TAG |
                            JSON_HEX_AMP |
                            JSON_HEX_APOS |
                            JSON_HEX_QUOT
                        ) ?>,
                        <?= json_encode(
                            date(
                                'd F Y',
                                strtotime(
                                    $item['tanggal']
                                )
                            )
                        ) ?>
                    )'
                    class="
                        flex
                        gap-4
                        py-4
                        border-b
                        border-slate-200
                        cursor-pointer
                        hover:bg-slate-50
                        -mx-2
                        px-2
                        rounded-lg
                    "
                >

                    <div
                        class="
                            w-16
                            h-16
                            rounded-lg
                            overflow-hidden
                            bg-slate-100
                            shrink-0
                            flex
                            items-center
                            justify-center
                        "
                    >

                        <?php if ($image): ?>

                            <img
                                src="<?= e($image) ?>"
                                alt="<?= e($item['judul']) ?>"
                                class="
                                    w-full
                                    h-full
                                    object-cover
                                "
                            >

                        <?php else: ?>

                            <span class="text-2xl">
                                📰
                            </span>

                        <?php endif; ?>

                    </div>


                    <div class="min-w-0">

                        <h4
                            class="
                                text-sm
                                sm:text-base
                                font-bold
                                text-slate-700
                                leading-snug
                            "
                        >

                            <?= e($item['judul']) ?>

                        </h4>


                        <p
                            class="
                                text-xs
                                text-slate-500
                                mt-2
                            "
                        >

                            📅

                            <?= date(
                                'd F Y',
                                strtotime(
                                    $item['tanggal']
                                )
                            ) ?>

                        </p>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

</div>


<!-- =========================================================
     MODAL DETAIL BERITA
========================================================= -->

<div
    id="beritaDetailModal"
    class="
        article-modal
        fixed
        inset-0
        z-[110]
        bg-black/50
        backdrop-blur-sm
        items-center
        justify-center
        p-4
    "
>

    <div
        class="
            bg-white
            w-full
            max-w-2xl
            max-h-[88vh]
            overflow-y-auto
            rounded-2xl
            shadow-2xl
        "
    >

        <div
            class="
                px-6
                py-5
                border-b
                border-slate-200
                flex
                items-start
                justify-between
                gap-4
            "
        >

            <div>

                <span
                    class="
                        text-[10px]
                        uppercase
                        font-bold
                        text-gold-500
                    "
                >

                    BERITA DESA

                </span>


                <h3
                    id="detailBeritaJudul"
                    class="
                        text-xl
                        sm:text-2xl
                        font-extrabold
                        text-navy-900
                        mt-1
                    "
                >

                    Judul Berita

                </h3>


                <p
                    id="detailBeritaTanggal"
                    class="
                        text-xs
                        text-slate-400
                        mt-2
                    "
                >

                    Tanggal

                </p>

            </div>


            <button
                type="button"
                onclick="closeBeritaDetail()"
                class="
                    w-9
                    h-9
                    shrink-0
                    rounded-full
                    bg-slate-100
                    text-slate-600
                    flex
                    items-center
                    justify-center
                    text-xl
                "
            >

                ×

            </button>

        </div>


        <div class="p-6">

            <div
                class="
                    bg-slate-50
                    border
                    border-slate-200
                    rounded-xl
                    p-5
                "
            >

                <p
                    id="detailBeritaIsi"
                    class="
                        text-sm
                        text-slate-600
                        leading-7
                        whitespace-pre-line
                    "
                >
                </p>

            </div>

        </div>

    </div>

</div>


<!-- =========================================================
     LEAFLET
========================================================= -->

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        /*
        |--------------------------------------------------------------------------
        | MAP WILAYAH
        |--------------------------------------------------------------------------
        */

        const SIDOWUNGU_CENTER = [
            -7.2967,
            112.6061
        ];


        const wilayahMap = L.map(
            'mapWilayahSidowungu',
            {
                scrollWheelZoom: false,
                zoomControl: true
            }
        ).setView(
            SIDOWUNGU_CENTER,
            15
        );


        L.tileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            {
                maxZoom: 19,
                attribution:
                    '&copy; OpenStreetMap contributors'
            }
        ).addTo(
            wilayahMap
        );


        /*
        |--------------------------------------------------------------------------
        | BATAS DESA SIDOWUNGU
        |--------------------------------------------------------------------------
        */

        const sidowunguBoundary = [

            /* titik paling atas */
            [-7.28470, 112.60610],

            /* sisi kanan atas */
            [-7.28590, 112.60770],
            [-7.28780, 112.60950],
            [-7.29080, 112.61080],

            /* sisi kanan tengah */
            [-7.29550, 112.61220],
            [-7.29980, 112.61200],
            [-7.30350, 112.61080],

            /* sisi kanan bawah */
            [-7.30680, 112.61000],

            /* bagian bawah */
            [-7.30480, 112.60600],
            [-7.30280, 112.60200],
            [-7.29980, 112.59820],

            /* sisi kiri bawah */
            [-7.29650, 112.59600],
            [-7.29400, 112.59850],

            /* sisi kiri tengah */
            [-7.29180, 112.60150],
            [-7.28880, 112.60380],

            /* sisi kiri atas */
            [-7.28670, 112.60520],

            /* kembali ke titik atas */
            [-7.28470, 112.60610]

        ];


        const sidowunguArea = L.polygon(
            sidowunguBoundary,
            {
                color: '#ff0000',
                weight: 3,
                fillColor: '#8b80c8',
                fillOpacity: 0.35
            }
        ).addTo(
            wilayahMap
        );


        sidowunguArea.bindPopup(
            '<strong>Desa Sidowungu</strong><br>' +
            'Kecamatan Menganti, Kabupaten Gresik'
        );


        wilayahMap.fitBounds(
            sidowunguArea.getBounds(),
            {
                padding: [
                    12,
                    12
                ]
            }
        );


        /*
        |--------------------------------------------------------------------------
        | MAP KANTOR DESA
        |--------------------------------------------------------------------------
        */

        const kantorMap = L.map(
            'mapKantorSidowungu',
            {
                scrollWheelZoom: false,
                zoomControl: true
            }
        ).setView(
            SIDOWUNGU_CENTER,
            15
        );


        L.tileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            {
                maxZoom: 19,
                attribution:
                    '&copy; OpenStreetMap contributors'
            }
        ).addTo(
            kantorMap
        );


        const kantorIcon = L.divIcon({

            className: '',

            html: `
                <div style="
                    width:40px;
                    height:40px;
                    background:#3B82F6;
                    border:4px solid #FFFFFF;
                    border-radius:50% 50% 50% 0;
                    transform:rotate(-45deg);
                    box-shadow:0 3px 10px rgba(0,0,0,.30);
                    position:relative;
                ">
                    <div style="
                        width:12px;
                        height:12px;
                        background:#FFFFFF;
                        border-radius:50%;
                        position:absolute;
                        top:10px;
                        left:10px;
                    "></div>
                </div>
            `,

            iconSize: [
                40,
                40
            ],

            iconAnchor: [
                20,
                40
            ],

            popupAnchor: [
                0,
                -36
            ]

        });


        const kantorMarker = L.marker(
            SIDOWUNGU_CENTER,
            {
                icon: kantorIcon
            }
        ).addTo(
            kantorMap
        );


        kantorMarker.bindPopup(
            '<strong>Kantor Desa Sidowungu</strong><br>' +
            'Jln. Raya Sidowungu No. 50<br>' +
            'Kec. Menganti, Kab. Gresik'
        );


        setTimeout(
            function () {

                wilayahMap.invalidateSize();
                kantorMap.invalidateSize();

            },
            500
        );


        /*
        |--------------------------------------------------------------------------
        | MODAL BERITA
        |--------------------------------------------------------------------------
        */

        window.openSemuaBerita = function () {

            const modal =
                document.getElementById(
                    'semuaBeritaModal'
                );


            modal.classList.add(
                'show'
            );


            document.body.classList.add(
                'overflow-hidden'
            );

        };


        window.closeSemuaBerita = function () {

            const modal =
                document.getElementById(
                    'semuaBeritaModal'
                );


            modal.classList.remove(
                'show'
            );


            document.body.classList.remove(
                'overflow-hidden'
            );

        };


        window.openBeritaDetail = function (
            judul,
            isi,
            tanggal
        ) {

            document.getElementById(
                'detailBeritaJudul'
            ).textContent = judul;


            document.getElementById(
                'detailBeritaTanggal'
            ).textContent = tanggal;


            document.getElementById(
                'detailBeritaIsi'
            ).textContent = isi;


            const modal =
                document.getElementById(
                    'beritaDetailModal'
                );


            modal.classList.add(
                'show'
            );


            document.body.classList.add(
                'overflow-hidden'
            );

        };


        window.closeBeritaDetail = function () {

            const modal =
                document.getElementById(
                    'beritaDetailModal'
                );


            modal.classList.remove(
                'show'
            );


            document.body.classList.remove(
                'overflow-hidden'
            );

        };


        /*
        |--------------------------------------------------------------------------
        | AGENDA
        |--------------------------------------------------------------------------
        */

        const agendaData = {

            '2026-02-28': {

                title:
                    'Realisasi APBDes & Penetapan Anggaran Desa (Perkiraan akhir Februari)',

                time:
                    'Perkiraan akhir Februari',

                location:
                    'Pemerintah Desa Sidowungu'

            },


            '2026-08-17': {

                title:
                    'Peringatan Hari Kemerdekaan & Rangkaian 17 Agustusan',

                time:
                    'Seharian',

                location:
                    'Wilayah Desa Sidowungu'

            },


            '2026-08-31': {

                title:
                    'Musyawarah Dusun (Musdus) RKPDes — Perkiraan akhir Agustus',

                time:
                    'Perkiraan akhir Agustus',

                location:
                    'Wilayah Dusun Desa Sidowungu'

            },


            '2026-09-13': {

                title:
                    'Sedekah Bumi & Karnaval Dusun Balong Dinding',

                time:
                    'Seharian',

                location:
                    'Dusun Balong Dinding, Sidowungu'

            },


            '2026-09-18': {

                title:
                    'Sedekah Bumi Desa Sidowungu (Mboro) & Grebek Ayam',

                time:
                    'Seharian',

                location:
                    'Mboro / Desa Sidowungu'

            },


            '2026-09-19': {

                title:
                    'Sedekah Bumi Desa Sidowungu (Mboro) & Grebek Ayam',

                time:
                    'Seharian',

                location:
                    'Mboro / Desa Sidowungu'

            },


            '2026-09-20': {

                title:
                    'Puncak Sedekah Bumi Desa Sidowungu (Mboro)',

                time:
                    'Seharian',

                location:
                    'Mboro / Desa Sidowungu'

            }

        };


        const monthNames = [

            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'

        ];


        /*
        |--------------------------------------------------------------------------
        | MULAI DARI AGUSTUS 2026
        |--------------------------------------------------------------------------
        */

        let currentDate = new Date();


        const monthTitle =
            document.getElementById(
                'calendarMonthTitle'
            );


        const calendarGrid =
            document.getElementById(
                'calendarGrid'
            );


        const upcomingAgenda =
            document.getElementById(
                'upcomingAgenda'
            );


        const prevMonth =
            document.getElementById(
                'prevMonth'
            );


        const nextMonth =
            document.getElementById(
                'nextMonth'
            );


        const allAgendaButton =
            document.getElementById(
                'openAllAgenda'
            );


        const allAgendaModal =
            document.getElementById(
                'semuaAgendaModal'
            );


        const closeAllAgenda =
            document.getElementById(
                'closeAllAgenda'
            );


        const allAgendaList =
            document.getElementById(
                'allAgendaList'
            );


        function makeDateKey(
            year,
            month,
            day
        ) {

            return (
                year +
                '-' +
                String(month + 1).padStart(
                    2,
                    '0'
                ) +
                '-' +
                String(day).padStart(
                    2,
                    '0'
                )
            );

        }


        function renderCalendar()
        {

            const year =
                currentDate.getFullYear();

            const month =
                currentDate.getMonth();


            monthTitle.textContent =
                monthNames[month] +
                ' ' +
                year;


            calendarGrid.innerHTML = '';


            const firstDay =
                new Date(
                    year,
                    month,
                    1
                ).getDay();


            const totalDays =
                new Date(
                    year,
                    month + 1,
                    0
                ).getDate();


            for (
                let i = 0;
                i < firstDay;
                i++
            ) {

                const empty =
                    document.createElement('div');


                empty.style.height =
                    '58px';

                empty.style.borderBottom =
                    '1px solid #f1f5f9';

                empty.style.borderRight =
                    '1px solid #f1f5f9';


                calendarGrid.appendChild(
                    empty
                );

            }


            for (
                let day = 1;
                day <= totalDays;
                day++
            ) {

                const dateKey =
                    makeDateKey(
                        year,
                        month,
                        day
                    );


                const agenda =
                    agendaData[dateKey];


                const cell =
                    document.createElement(
                        'div'
                    );


                cell.style.height =
                    '58px';

                cell.style.borderBottom =
                    '1px solid #f1f5f9';

                cell.style.borderRight =
                    '1px solid #f1f5f9';

                cell.style.padding =
                    '8px';

                cell.style.background =
                    '#ffffff';


                const number =
                    document.createElement(
                        'div'
                    );


                number.textContent =
                    day;

                number.style.fontSize =
                    '11px';

                number.style.fontWeight =
                    '600';

                number.style.color =
                    '#475569';

                number.style.width =
                    '24px';

                number.style.height =
                    '24px';

                number.style.display =
                    'flex';

                number.style.alignItems =
                    'center';

                number.style.justifyContent =
                    'center';


                const today =
                    new Date();


                if (
                    day === today.getDate() &&
                    month === today.getMonth() &&
                    year === today.getFullYear()
                ) {

                    number.style.background =
                        '#0f172a';

                    number.style.color =
                        '#ffffff';

                    number.style.borderRadius =
                        '50%';

                }


                cell.appendChild(
                    number
                );


                if (agenda) {

                    const dot =
                        document.createElement(
                            'span'
                        );


                    dot.style.display =
                        'block';

                    dot.style.width =
                        '7px';

                    dot.style.height =
                        '7px';

                    dot.style.background =
                        '#ef4444';

                    dot.style.borderRadius =
                        '50%';

                    dot.style.marginTop =
                        '3px';


                    cell.style.cursor =
                        'pointer';

                    cell.style.background =
                        '#fffdf7';


                    cell.addEventListener(
                        'mouseenter',
                        function () {

                            cell.style.background =
                                '#fff7ed';

                        }
                    );


                    cell.addEventListener(
                        'mouseleave',
                        function () {

                            cell.style.background =
                                '#fffdf7';

                        }
                    );


                    cell.addEventListener(
                        'click',
                        function () {

                            showAgenda(
                                dateKey
                            );

                        }
                    );


                    cell.appendChild(
                        dot
                    );

                }


                calendarGrid.appendChild(
                    cell
                );

            }

        }


        function renderUpcomingAgenda()
        {

            const today =
                new Date();

            today.setHours(
                0,
                0,
                0,
                0
            );


            const upcoming =
                Object.entries(
                    agendaData
                )
                .filter(
                    function (item) {

                        const date =
                            new Date(
                                item[0] +
                                'T00:00:00'
                            );


                        return date >= today;

                    }
                )
                .sort(
                    function (a, b) {

                        return a[0].localeCompare(
                            b[0]
                        );

                    }
                );


            if (upcoming.length === 0) {

                upcomingAgenda.innerHTML = `

                    <div
                        style="
                            min-height:190px;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            padding:20px;
                            text-align:center;
                            color:#94a3b8;
                            font-size:12px;
                        "
                    >

                        Belum ada agenda mendatang.

                    </div>

                `;

                return;
            }


            const dateKey =
                upcoming[0][0];

            const agenda =
                upcoming[0][1];


            const date =
                new Date(
                    dateKey +
                    'T00:00:00'
                );


            const formattedDate =
                date.toLocaleDateString(
                    'id-ID',
                    {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    }
                );


            upcomingAgenda.innerHTML = `

                <div
                    style="
                        padding:20px;
                    "
                >

                    <div
                        style="
                            display:inline-block;
                            padding:5px 10px;
                            border-radius:999px;
                            background:#fff7ed;
                            color:#d97706;
                            font-size:10px;
                            font-weight:700;
                        "
                    >

                        ${formattedDate}

                    </div>


                    <h4
                        style="
                            margin-top:12px;
                            color:#0f172a;
                            font-size:14px;
                            font-weight:700;
                        "
                    >

                        ${agenda.title}

                    </h4>


                    <p
                        style="
                            margin-top:8px;
                            color:#64748b;
                            font-size:12px;
                        "
                    >

                        🕐 ${agenda.time}

                    </p>


                    <p
                        style="
                            margin-top:4px;
                            color:#64748b;
                            font-size:12px;
                        "
                    >

                        📍 ${agenda.location}

                    </p>

                </div>

            `;

        }


        function showAgenda(dateKey)
        {

            const agenda =
                agendaData[dateKey];


            if (!agenda) {
                return;
            }


            const date =
                new Date(
                    dateKey +
                    'T00:00:00'
                );


            const formattedDate =
                date.toLocaleDateString(
                    'id-ID',
                    {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    }
                );


            upcomingAgenda.innerHTML = `

                <div
                    style="
                        padding:20px;
                    "
                >

                    <div
                        style="
                            display:inline-block;
                            padding:5px 10px;
                            border-radius:999px;
                            background:#fff7ed;
                            color:#d97706;
                            font-size:10px;
                            font-weight:700;
                        "
                    >

                        ${formattedDate}

                    </div>


                    <h4
                        style="
                            margin-top:12px;
                            color:#0f172a;
                            font-size:14px;
                            font-weight:700;
                        "
                    >

                        ${agenda.title}

                    </h4>


                    <p
                        style="
                            margin-top:8px;
                            color:#64748b;
                            font-size:12px;
                        "
                    >

                        🕐 ${agenda.time}

                    </p>


                    <p
                        style="
                            margin-top:4px;
                            color:#64748b;
                            font-size:12px;
                        "
                    >

                        📍 ${agenda.location}

                    </p>

                </div>

            `;

        }


        function renderAllAgenda()
        {

            const agendaList =
                Object.entries(
                    agendaData
                )
                .sort(function (a, b) {

                    return a[0].localeCompare(
                        b[0]
                    );

                });


            if (agendaList.length === 0) {

                allAgendaList.innerHTML = `

                    <div
                        style="
                            padding:60px 20px;
                            text-align:center;
                            color:#94a3b8;
                            font-size:14px;
                        "
                    >

                        Belum ada agenda desa.

                    </div>

                `;

                return;
            }


            allAgendaList.innerHTML = '';


            agendaList.forEach(
                function (item) {

                    const dateKey =
                        item[0];

                    const agenda =
                        item[1];


                    const date =
                        new Date(
                            dateKey +
                            'T00:00:00'
                        );


                    const formattedDate =
                        date.toLocaleDateString(
                            'id-ID',
                            {
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric'
                            }
                        );


                    allAgendaList.innerHTML += `

                        <div
                            style="
                                padding:20px 0;
                                border-bottom:1px solid #e2e8f0;
                            "
                        >

                            <div
                                style="
                                    font-size:10px;
                                    font-weight:700;
                                    text-transform:uppercase;
                                    letter-spacing:.08em;
                                    color:#d97706;
                                "
                            >

                                ${formattedDate}

                            </div>


                            <h4
                                style="
                                    margin-top:8px;
                                    font-size:15px;
                                    font-weight:700;
                                    color:#0f172a;
                                "
                            >

                                ${agenda.title}

                            </h4>


                            <p
                                style="
                                    margin-top:8px;
                                    font-size:12px;
                                    color:#64748b;
                                "
                            >

                                🕐 ${agenda.time}

                            </p>


                            <p
                                style="
                                    margin-top:4px;
                                    font-size:12px;
                                    color:#64748b;
                                "
                            >

                                📍 ${agenda.location}

                            </p>

                        </div>

                    `;

                }
            );

        }


        prevMonth.addEventListener(
            'click',
            function () {

                currentDate.setMonth(
                    currentDate.getMonth() - 1
                );

                renderCalendar();

            }
        );


        nextMonth.addEventListener(
            'click',
            function () {

                currentDate.setMonth(
                    currentDate.getMonth() + 1
                );

                renderCalendar();

            }
        );


        allAgendaButton.addEventListener(
            'click',
            function () {

                renderAllAgenda();

                allAgendaModal.classList.add(
                    'show'
                );

                document.body.classList.add(
                    'overflow-hidden'
                );

            }
        );


        closeAllAgenda.addEventListener(
            'click',
            function () {

                allAgendaModal.classList.remove(
                    'show'
                );

                document.body.classList.remove(
                    'overflow-hidden'
                );

            }
        );


        allAgendaModal.addEventListener(
            'click',
            function (event) {

                if (
                    event.target === allAgendaModal
                ) {

                    allAgendaModal.classList.remove(
                        'show'
                    );

                    document.body.classList.remove(
                        'overflow-hidden'
                    );

                }

            }
        );


        document.getElementById(
            'semuaBeritaModal'
        ).addEventListener(
            'click',
            function (event) {

                if (event.target === this) {
                    closeSemuaBerita();
                }

            }
        );


        document.getElementById(
            'beritaDetailModal'
        ).addEventListener(
            'click',
            function (event) {

                if (event.target === this) {
                    closeBeritaDetail();
                }

            }
        );


        document.addEventListener(
            'keydown',
            function (event) {

                if (event.key === 'Escape') {

                    closeSemuaBerita();

                    closeBeritaDetail();

                    allAgendaModal.classList.remove(
                        'show'
                    );

                    document.body.classList.remove(
                        'overflow-hidden'
                    );

                }

            }
        );


        renderCalendar();

        renderUpcomingAgenda();

    }

);

</script>


<!-- =========================================================
     HERO SLIDESHOW
========================================================= -->

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const slides =
            document.querySelectorAll(
                '.hero-slide'
            );


        const dots =
            document.querySelectorAll(
                '.hero-dot'
            );


        let currentSlide = 0;


        function showSlide(index)
        {

            slides.forEach(
                function (slide, i) {

                    slide.classList.toggle(
                        'active',
                        i === index
                    );

                }
            );


            dots.forEach(
                function (dot, i) {

                    dot.classList.toggle(
                        'active',
                        i === index
                    );

                }
            );

        }


        function nextSlide()
        {

            currentSlide =
                (currentSlide + 1) %
                slides.length;


            showSlide(
                currentSlide
            );

        }


        dots.forEach(
            function (dot, index) {

                dot.addEventListener(
                    'click',
                    function () {

                        currentSlide =
                            index;

                        showSlide(
                            currentSlide
                        );

                    }
                );

            }
        );


        if (slides.length > 0) {

            showSlide(
                currentSlide
            );


            setInterval(
                nextSlide,
                5000
            );

        }

    }

);

</script>


<!-- =========================================================
     CHART JS
========================================================= -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>

const populationLabels = [
    "LAKI-LAKI",
    "PEREMPUAN",
    "TOTAL"
];


const populationData = [
    <?= $totalLaki ?>,
    <?= $totalPerempuan ?>,
    <?= $totalPenduduk ?>
];


const populationCanvas =
    document.getElementById(
        'populationChart'
    );


new Chart(
    populationCanvas,
    {

        type: 'bar',

        data: {

            labels: populationLabels,

            datasets: [
                {
                    label: 'Populasi',
                    data: populationData,
                    borderWidth: 1
                }
            ]

        },


        options: {

            responsive: true,

            maintainAspectRatio: false,


            plugins: {

                legend: {
                    display: false
                },


                tooltip: {

                    callbacks: {

                        label: function (context)
                        {

                            return ' Populasi: ' +
                                context.raw.toLocaleString(
                                    'id-ID'
                                );

                        }

                    }

                }

            },


            scales: {

                y: {

                    beginAtZero: true,

                    ticks: {

                        precision: 0,

                        callback: function (value)
                        {

                            return value.toLocaleString(
                                'id-ID'
                            );

                        }

                    }

                }

            }

        }

    }
);


</script>


<?php

require_once "includes/footer.php";