<?php
require_once __DIR__ . '/config/database.php';

// Ambil semua lapak aktif
$query = mysqli_query(
    $conn,
    "SELECT * FROM lapak
     WHERE status = 'Aktif'
     ORDER BY id DESC"
);

$total_lapak = mysqli_num_rows($query);


// Fungsi WhatsApp
function linkWhatsapp($nomor)
{
    if (empty($nomor)) {
        return '#';
    }

    $nomor = preg_replace('/[^0-9]/', '', $nomor);

    // 08xxx -> 628xxx
    if (substr($nomor, 0, 1) === '0') {
        $nomor = '62' . substr($nomor, 1);
    }

    return 'https://wa.me/' . $nomor;
}
?>

<?php include __DIR__ . '/includes/header.php'; ?>


<!-- ===================================================== -->
<!-- HERO LAPAK -->
<!-- ===================================================== -->

<section class="relative w-full overflow-hidden bg-slate-900">

    <img
        src="/assets/images/hero/hero6.png"
        alt="Lapak UMKM Produk Lokal Desa Sidowungu"
        class="
            absolute
            inset-0
            w-full
            h-full
            object-cover
            object-[center_18%]
        "
    >

    <!-- Overlay -->
    <div class="absolute inset-0 bg-gradient-to-r from-slate-950/90 via-slate-900/65 to-slate-900/20"></div>


    <!-- HERO CONTENT -->
    <div
        class="
            relative
            z-10
            min-h-[355px]
            sm:min-h-[390px]
            lg:min-h-[430px]
            flex
            items-center
        "
    >

        <div class="max-w-7xl mx-auto w-full px-6 sm:px-8 lg:px-10">

            <div class="max-w-3xl">

                <!-- LABEL -->

                <p
                    class="
                        text-xs
                        md:text-sm
                        font-bold
                        tracking-[0.16em]
                        text-amber-400
                        uppercase
                    "
                >
                    LAPAK DESA
                </p>


                <!-- TITLE -->

                <h1
                    class="
                        text-3xl
                        sm:text-4xl
                        lg:text-5xl
                        font-extrabold
                        text-white
                        mt-3
                        leading-tight
                    "
                >
                    Lapak UMKM Desa Sidowungu
                </h1>


                <!-- DESCRIPTION -->

                <p
                    class="
                        text-slate-200
                        text-sm
                        sm:text-base
                        lg:text-lg
                        mt-4
                        max-w-2xl
                        leading-relaxed
                    "
                >
                    Temukan berbagai usaha, produk, dan jasa masyarakat
                    Desa Sidowungu.
                </p>

            </div>

        </div>

    </div>

</section>



<!-- ===================================================== -->
<!-- DAFTAR LAPAK -->
<!-- ===================================================== -->

<section class="bg-slate-50">

    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10 py-10 md:py-12">


        <!-- JUDUL + FILTER -->
        <div class="mb-7">

            <h2 class="text-xl md:text-2xl font-bold text-slate-950 mb-4">
                Daftar UMKM & Usaha
            </h2>


            <div class="flex flex-col md:flex-row gap-3">

                <!-- KATEGORI -->
                <select
                    id="filterKategori"
                    class="w-full md:w-[32%] px-4 py-3 rounded-xl border border-slate-300 bg-white text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                >

                    <option value="semua">
                        Semua Kategori
                    </option>

                    <option value="Makanan & Minuman">
                        Makanan & Minuman
                    </option>

                    <option value="Kerajinan & Fashion">
                        Kerajinan & Fashion
                    </option>

                    <option value="Perdagangan">
                        Perdagangan
                    </option>

                    <option value="Jasa">
                        Jasa
                    </option>

                    <option value="Peternakan & Unggas">
                        Peternakan & Unggas
                    </option>

                    <option value="Lainnya">
                        Lainnya
                    </option>

                </select>


                <!-- PENCARIAN -->
                <input
                    type="text"
                    id="searchLapak"
                    placeholder="Cari Produk / UMKM"
                    class="flex-1 px-4 py-3 rounded-xl border border-slate-300 bg-white text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                >


                <!-- TOMBOL CARI -->
                <button
                    type="button"
                    id="btnCari"
                    class="px-6 py-3 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold transition"
                >
                    Cari
                </button>

            </div>

        </div>



        <?php if ($total_lapak > 0): ?>


            <!-- ================================================= -->
            <!-- GRID LAPAK -->
            <!-- ================================================= -->

            <div
                id="gridLapak"
                class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 items-stretch"
            >

                <?php while ($lapak = mysqli_fetch_assoc($query)): ?>

                    <?php

                    // Ambil semua foto untuk lapak ini
                    $query_foto = mysqli_query(
                        $conn,
                        "SELECT *
                         FROM lapak_foto
                         WHERE lapak_id = " . (int)$lapak['id'] . "
                         ORDER BY urutan ASC, id ASC"
                    );

                    $foto_lapak = [];

                    while ($foto = mysqli_fetch_assoc($query_foto)) {
                        $foto_lapak[] = $foto;
                    }


                    // Data untuk pencarian
                    $data_search = strtolower(
                        ($lapak['nama_usaha'] ?? '') . ' ' .
                        ($lapak['produk_jasa'] ?? '') . ' ' .
                        ($lapak['jenis_usaha'] ?? '') . ' ' .
                        ($lapak['kategori'] ?? '')
                    );

                    ?>


                    <!-- ================================================= -->
                    <!-- CARD LAPAK -->
                    <!-- ================================================= -->

                    <article
                        data-kategori="<?= htmlspecialchars($lapak['kategori'] ?? ''); ?>"
                        data-search="<?= htmlspecialchars($data_search); ?>"
                        class="lapak-card h-full bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col"
                    >


                        <!-- ================= FOTO ================= -->

                        <div class="relative h-52 bg-gradient-to-br from-slate-950 via-slate-900 to-slate-800 overflow-hidden">


                            <!-- KATEGORI -->
                            <?php if (!empty($lapak['kategori'])): ?>

                                <div class="absolute top-3 left-3 z-20">

                                    <span class="inline-flex px-3 py-1.5 rounded-full bg-white text-slate-800 text-[10px] font-semibold shadow-sm">
                                        <?= htmlspecialchars($lapak['kategori']); ?>
                                    </span>

                                </div>

                            <?php endif; ?>


                            <?php if (count($foto_lapak) > 0): ?>


                                <!-- GALLERY -->

                                <div
                                    class="gallery w-full h-full relative"
                                    data-gallery="<?= (int)$lapak['id']; ?>"
                                >


                                    <?php foreach ($foto_lapak as $index => $foto): ?>

                                        <img
                                            src="assets/images/lapak/<?= htmlspecialchars($foto['nama_file']); ?>"
                                            alt="<?= htmlspecialchars($lapak['nama_usaha']); ?>"
                                            class="gallery-slide absolute inset-0 w-full h-full object-cover transition-opacity duration-300 <?= $index === 0 ? 'opacity-100' : 'opacity-0'; ?>"
                                            data-index="<?= $index; ?>"
                                        >

                                    <?php endforeach; ?>


                                    <?php if (count($foto_lapak) > 1): ?>


                                        <!-- PREV -->

                                        <button
                                            type="button"
                                            class="gallery-prev absolute left-3 top-1/2 -translate-y-1/2 z-10 w-9 h-9 rounded-full bg-black/45 hover:bg-black/65 text-white flex items-center justify-center transition"
                                            data-gallery="<?= (int)$lapak['id']; ?>"
                                            aria-label="Foto sebelumnya"
                                        >
                                            ‹
                                        </button>


                                        <!-- NEXT -->

                                        <button
                                            type="button"
                                            class="gallery-next absolute right-3 top-1/2 -translate-y-1/2 z-10 w-9 h-9 rounded-full bg-black/45 hover:bg-black/65 text-white flex items-center justify-center transition"
                                            data-gallery="<?= (int)$lapak['id']; ?>"
                                            aria-label="Foto berikutnya"
                                        >
                                            ›
                                        </button>


                                        <!-- DOT -->

                                        <div class="absolute bottom-3 left-1/2 -translate-x-1/2 z-10 flex gap-1.5">

                                            <?php foreach ($foto_lapak as $index => $foto): ?>

                                                <button
                                                    type="button"
                                                    class="gallery-dot w-2 h-2 rounded-full <?= $index === 0 ? 'bg-white' : 'bg-white/40'; ?>"
                                                    data-gallery="<?= (int)$lapak['id']; ?>"
                                                    data-index="<?= $index; ?>"
                                                    aria-label="Foto <?= $index + 1; ?>"
                                                ></button>

                                            <?php endforeach; ?>

                                        </div>


                                        <!-- JUMLAH FOTO -->

                                        <div class="absolute top-3 right-3 z-10 bg-black/45 text-white text-[11px] px-2.5 py-1 rounded-full">
                                            <?= count($foto_lapak); ?> foto
                                        </div>

                                    <?php endif; ?>


                                </div>


                            <?php else: ?>


                                <!-- PLACEHOLDER -->

                                <div class="w-full h-full flex items-center justify-center">

                                    <div class="text-center">

                                        <div class="w-14 h-14 mx-auto rounded-2xl bg-white/10 border border-white/10 flex items-center justify-center mb-2">

                                            <span class="text-2xl">
                                                🏪
                                            </span>

                                        </div>

                                        <p class="text-white/60 text-[11px] uppercase tracking-[0.18em]">
                                            Foto Usaha
                                        </p>

                                    </div>

                                </div>


                            <?php endif; ?>


                        </div>



                        <!-- ================= CONTENT ================= -->

                        <div class="p-5 flex flex-col flex-1">


                            <!-- JENIS USAHA -->

                            <?php if (!empty($lapak['jenis_usaha'])): ?>

                                <p class="text-[10px] font-semibold text-amber-600 uppercase tracking-widest">

                                    <?= htmlspecialchars($lapak['jenis_usaha']); ?>

                                </p>

                            <?php endif; ?>


                            <!-- NAMA -->

                            <h3 class="text-xl md:text-[22px] font-bold text-slate-950 mt-1 leading-tight">

                                <?= htmlspecialchars($lapak['nama_usaha']); ?>

                            </h3>


                            <!-- PRODUK -->

                            <?php if (!empty($lapak['produk_jasa'])): ?>

                                <p class="text-sm text-slate-600 mt-2 leading-relaxed">

                                    <?= htmlspecialchars($lapak['produk_jasa']); ?>

                                </p>

                            <?php endif; ?>


                            <!-- DESKRIPSI -->

                            <?php if (!empty($lapak['deskripsi'])): ?>

                                <p class="text-xs text-slate-500 mt-3 leading-relaxed line-clamp-3">

                                    <?= htmlspecialchars($lapak['deskripsi']); ?>

                                </p>

                            <?php endif; ?>


                            <!-- JAM -->

                            <?php if (!empty($lapak['jam_operasional'])): ?>

                                <div class="flex items-center gap-2 mt-4 text-xs text-slate-500">

                                    <span>
                                        🕐
                                    </span>

                                    <span>
                                        <?= htmlspecialchars($lapak['jam_operasional']); ?>
                                    </span>

                                </div>

                            <?php endif; ?>


                            <!-- ================= BUTTON ================= -->

                            <div class="grid grid-cols-2 gap-3 mt-auto pt-5">


                                <!-- WHATSAPP -->

                                <?php if (!empty($lapak['no_whatsapp'])): ?>

                                    <a
                                        href="<?= htmlspecialchars(linkWhatsapp($lapak['no_whatsapp'])); ?>"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-green-600 hover:bg-green-700 text-white text-sm font-semibold transition"
                                    >

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="w-4 h-4"
                                            viewBox="0 0 24 24"
                                            fill="currentColor"
                                        >
                                            <path d="M20.52 3.48A11.86 11.86 0 0 0 12.04 0C5.52 0 .22 5.3.22 11.82c0 2.08.54 4.11 1.57 5.9L.13 24l6.42-1.68a11.8 11.8 0 0 0 5.49 1.36h.01c6.52 0 11.82-5.3 11.82-11.82 0-3.16-1.23-6.13-3.35-8.38ZM12.05 21.7h-.01a9.84 9.84 0 0 1-5.01-1.37l-.36-.22-3.81.99 1.02-3.71-.24-.38a9.82 9.82 0 0 1-1.51-5.2C2.13 6.39 6.54 1.98 12.05 1.98c2.67 0 5.17 1.04 7.05 2.92a9.89 9.89 0 0 1 2.92 7.06c0 5.51-4.41 9.92-9.97 9.92Zm5.45-7.43c-.3-.15-1.78-.88-2.05-.98-.28-.1-.48-.15-.68.15-.2.3-.78.98-.96 1.18-.18.2-.35.23-.65.08-.3-.15-1.27-.47-2.42-1.49-.9-.8-1.5-1.79-1.67-2.09-.18-.3-.02-.46.13-.61.13-.13.3-.35.45-.53.15-.18.2-.3.3-.5.1-.2.05-.38-.03-.53-.08-.15-.68-1.64-.93-2.25-.25-.6-.5-.52-.68-.53h-.58c-.2 0-.53.08-.8.38-.28.3-1.05 1.03-1.05 2.5s1.08 2.9 1.23 3.1c.15.2 2.12 3.24 5.14 4.54.72.31 1.28.49 1.72.63.72.23 1.38.2 1.9.12.58-.09 1.78-.73 2.03-1.43.25-.7.25-1.3.18-1.43-.08-.13-.28-.2-.58-.35Z"/>
                                        </svg>

                                        WhatsApp

                                    </a>

                                <?php else: ?>

                                    <div class="px-4 py-3 rounded-xl bg-slate-100 text-slate-400 text-sm font-semibold text-center">
                                        WhatsApp
                                    </div>

                                <?php endif; ?>


                                <!-- GOOGLE MAPS -->

                                <?php if (!empty($lapak['link_maps'])): ?>

                                    <a
                                        href="<?= htmlspecialchars($lapak['link_maps']); ?>"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold transition"
                                    >

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="w-4 h-4"
                                            viewBox="0 0 24 24"
                                            fill="currentColor"
                                        >
                                            <path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7Zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5Z"/>
                                        </svg>

                                        Google Maps

                                    </a>

                                <?php else: ?>

                                    <div class="px-4 py-3 rounded-xl bg-slate-100 text-slate-400 text-sm font-semibold text-center">
                                        Google Maps
                                    </div>

                                <?php endif; ?>


                            </div>

                        </div>

                    </article>

                <?php endwhile; ?>

            </div>


            <!-- TIDAK ADA HASIL -->
            <div
                id="hasilKosong"
                class="hidden max-w-xl mx-auto bg-white border border-slate-200 rounded-2xl p-10 text-center mt-6"
            >

                <div class="w-14 h-14 mx-auto rounded-2xl bg-slate-100 flex items-center justify-center text-2xl mb-5">
                    🔎
                </div>

                <h2 class="text-xl font-bold text-slate-950">
                    UMKM Tidak Ditemukan
                </h2>

                <p class="text-sm text-slate-500 mt-3">
                    Coba gunakan kata kunci lain atau pilih kategori yang berbeda.
                </p>

            </div>


        <?php else: ?>


            <!-- ================================================= -->
            <!-- EMPTY STATE -->
            <!-- ================================================= -->

            <div class="max-w-xl mx-auto bg-white border border-slate-200 rounded-2xl p-10 text-center">

                <div class="w-14 h-14 mx-auto rounded-2xl bg-slate-100 flex items-center justify-center text-2xl mb-5">
                    🏪
                </div>

                <h2 class="text-xl font-bold text-slate-950">
                    Belum Ada UMKM
                </h2>

                <p class="text-sm text-slate-500 mt-3">
                    Data UMKM dan usaha masyarakat akan ditampilkan
                    di halaman ini setelah ditambahkan oleh admin.
                </p>

            </div>


        <?php endif; ?>


    </div>

</section>



<!-- ===================================================== -->
<!-- GALLERY + FILTER SCRIPT -->
<!-- ===================================================== -->

<script>

document.addEventListener('DOMContentLoaded', function () {


    /* ==================================================
       GALLERY
       ================================================== */

    const galleries = {};


    document.querySelectorAll('.gallery').forEach(function (gallery) {

        const id = gallery.dataset.gallery;

        const slides = gallery.querySelectorAll('.gallery-slide');

        const dots = gallery.querySelectorAll('.gallery-dot');


        galleries[id] = {

            index: 0,

            slides: slides,

            dots: dots

        };


        function tampilkanFoto(index) {

            if (slides.length === 0) {
                return;
            }


            if (index < 0) {
                index = slides.length - 1;
            }


            if (index >= slides.length) {
                index = 0;
            }


            galleries[id].index = index;


            slides.forEach(function (slide, i) {

                if (i === index) {

                    slide.classList.remove('opacity-0');

                    slide.classList.add('opacity-100');

                } else {

                    slide.classList.remove('opacity-100');

                    slide.classList.add('opacity-0');

                }

            });


            dots.forEach(function (dot, i) {

                if (i === index) {

                    dot.classList.remove('bg-white/40');

                    dot.classList.add('bg-white');

                } else {

                    dot.classList.remove('bg-white');

                    dot.classList.add('bg-white/40');

                }

            });

        }


        gallery.querySelectorAll('.gallery-prev').forEach(function (button) {

            button.addEventListener('click', function () {

                tampilkanFoto(
                    galleries[id].index - 1
                );

            });

        });


        gallery.querySelectorAll('.gallery-next').forEach(function (button) {

            button.addEventListener('click', function () {

                tampilkanFoto(
                    galleries[id].index + 1
                );

            });

        });


        dots.forEach(function (dot) {

            dot.addEventListener('click', function () {

                tampilkanFoto(
                    parseInt(dot.dataset.index)
                );

            });

        });

    });



    /* ==================================================
       FILTER + PENCARIAN
       ================================================== */

    const kategori = document.getElementById('filterKategori');

    const pencarian = document.getElementById('searchLapak');

    const tombolCari = document.getElementById('btnCari');

    const kartu = document.querySelectorAll('.lapak-card');

    const hasilKosong = document.getElementById('hasilKosong');


    function filterLapak() {

        const kategoriDipilih =
            kategori.value.toLowerCase();

        const keyword =
            pencarian.value.toLowerCase().trim();


        let jumlahTampil = 0;


        kartu.forEach(function (card) {

            const kategoriCard =
                (card.dataset.kategori || '').toLowerCase();

            const dataSearch =
                (card.dataset.search || '').toLowerCase();


            const cocokKategori =
                kategoriDipilih === 'semua' ||
                kategoriCard === kategoriDipilih;


            const cocokPencarian =
                keyword === '' ||
                dataSearch.includes(keyword);


            if (cocokKategori && cocokPencarian) {

                card.style.display = '';

                jumlahTampil++;

            } else {

                card.style.display = 'none';

            }

        });


        if (hasilKosong) {

            if (jumlahTampil === 0) {

                hasilKosong.classList.remove('hidden');

            } else {

                hasilKosong.classList.add('hidden');

            }

        }

    }


    // Tombol Cari
    if (tombolCari) {

        tombolCari.addEventListener(
            'click',
            filterLapak
        );

    }


    // Tekan Enter
    if (pencarian) {

        pencarian.addEventListener(
            'keydown',
            function (event) {

                if (event.key === 'Enter') {

                    filterLapak();

                }

            }
        );

    }


    // Ganti kategori
    if (kategori) {

        kategori.addEventListener(
            'change',
            filterLapak
        );

    }


});

</script>


<?php include __DIR__ . '/includes/footer.php'; ?>