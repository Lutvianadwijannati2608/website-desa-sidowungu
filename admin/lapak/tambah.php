<?php
require_once __DIR__ . '/../../config/database.php';

$pesan_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil data form
    $nama_usaha      = trim($_POST['nama_usaha'] ?? '');
    $jenis_usaha     = trim($_POST['jenis_usaha'] ?? '');
    $kategori        = trim($_POST['kategori'] ?? '');
    $produk_jasa     = trim($_POST['produk_jasa'] ?? '');
    $deskripsi       = trim($_POST['deskripsi'] ?? '');
    $alamat          = trim($_POST['alamat'] ?? '');
    $no_whatsapp     = trim($_POST['no_whatsapp'] ?? '');
    $jam_operasional = trim($_POST['jam_operasional'] ?? '');
    $link_maps       = trim($_POST['link_maps'] ?? '');
    $status          = $_POST['status'] ?? 'Aktif';

    // Validasi nama usaha
    if ($nama_usaha === '') {

        $pesan_error = 'Nama usaha wajib diisi.';

    } else {

        // Amankan data
        $nama_usaha      = mysqli_real_escape_string($conn, $nama_usaha);
        $jenis_usaha     = mysqli_real_escape_string($conn, $jenis_usaha);
        $kategori        = mysqli_real_escape_string($conn, $kategori);
        $produk_jasa     = mysqli_real_escape_string($conn, $produk_jasa);
        $deskripsi       = mysqli_real_escape_string($conn, $deskripsi);
        $alamat          = mysqli_real_escape_string($conn, $alamat);
        $no_whatsapp     = mysqli_real_escape_string($conn, $no_whatsapp);
        $jam_operasional = mysqli_real_escape_string($conn, $jam_operasional);
        $link_maps       = mysqli_real_escape_string($conn, $link_maps);
        $status          = mysqli_real_escape_string($conn, $status);

        // Simpan data lapak
        $sql = "INSERT INTO lapak
                (
                    nama_usaha,
                    jenis_usaha,
                    kategori,
                    produk_jasa,
                    deskripsi,
                    alamat,
                    no_whatsapp,
                    jam_operasional,
                    link_maps,
                    status
                )
                VALUES
                (
                    '$nama_usaha',
                    '$jenis_usaha',
                    '$kategori',
                    '$produk_jasa',
                    '$deskripsi',
                    '$alamat',
                    '$no_whatsapp',
                    '$jam_operasional',
                    '$link_maps',
                    '$status'
                )";

        if (mysqli_query($conn, $sql)) {

            // Ambil ID lapak yang baru dibuat
            $lapak_id = mysqli_insert_id($conn);

            // Folder penyimpanan foto
            $folder_foto = dirname(__DIR__, 2) . '/assets/images/lapak/';

            // Buat folder jika belum ada
            if (!is_dir($folder_foto)) {
                mkdir($folder_foto, 0777, true);
            }

            // Proses beberapa foto
            if (
                isset($_FILES['foto']) &&
                isset($_FILES['foto']['name']) &&
                is_array($_FILES['foto']['name'])
            ) {

                $jumlah_foto = count($_FILES['foto']['name']);

                for ($i = 0; $i < $jumlah_foto; $i++) {

                    // Lewati kalau tidak ada file
                    if (
                        !isset($_FILES['foto']['error'][$i]) ||
                        $_FILES['foto']['error'][$i] === UPLOAD_ERR_NO_FILE
                    ) {
                        continue;
                    }

                    // Cek error upload
                    if ($_FILES['foto']['error'][$i] !== UPLOAD_ERR_OK) {
                        continue;
                    }

                    $tmp_name = $_FILES['foto']['tmp_name'][$i];
                    $nama_asli = $_FILES['foto']['name'][$i];
                    $ukuran = $_FILES['foto']['size'][$i];

                    // Maksimal 5 MB per foto
                    if ($ukuran > 5 * 1024 * 1024) {
                        continue;
                    }

                    // Cek apakah file benar-benar gambar
                    $info_gambar = @getimagesize($tmp_name);

                    if ($info_gambar === false) {
                        continue;
                    }

                    // Ambil ekstensi
                    $ekstensi = strtolower(
                        pathinfo($nama_asli, PATHINFO_EXTENSION)
                    );

                    // Ekstensi yang diperbolehkan
                    $ekstensi_diizinkan = ['jpg', 'jpeg', 'png', 'webp'];

                    if (!in_array($ekstensi, $ekstensi_diizinkan, true)) {
                        continue;
                    }

                    // Buat nama file unik
                    $nama_file = 'lapak_' . $lapak_id . '_' . time() . '_' . $i . '.' . $ekstensi;

                    $tujuan_file = $folder_foto . $nama_file;

                    // Pindahkan file
                    if (move_uploaded_file($tmp_name, $tujuan_file)) {

                        // Simpan nama file ke database
                        $nama_file_db = mysqli_real_escape_string(
                            $conn,
                            $nama_file
                        );

                        $urutan = $i + 1;

                        mysqli_query(
                            $conn,
                            "INSERT INTO lapak_foto
                            (lapak_id, nama_file, urutan)
                            VALUES
                            ($lapak_id, '$nama_file_db', $urutan)"
                        );
                    }
                }
            }

            // Kembali ke daftar
            header('Location: index.php?status=berhasil');
            exit;

        } else {

            $pesan_error = 'Data gagal disimpan. Silakan coba lagi.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Lapak - Admin Desa Sidowungu</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>

</head>


<body class="bg-slate-100 min-h-screen">


    <!-- Navbar -->
    <nav class="bg-slate-950 text-white">

        <div class="max-w-5xl mx-auto px-6 py-4">

            <div class="flex items-center justify-between gap-4">

                <div>

                    <p class="text-lg font-bold">
                        Admin Desa Sidowungu
                    </p>

                    <p class="text-xs text-slate-400 mt-1">
                        Tambah Lapak
                    </p>

                </div>


                <a
                    href="index.php"
                    class="bg-white/10 hover:bg-white/20 px-4 py-2 rounded-xl text-sm font-medium transition"
                >
                    Kembali
                </a>

            </div>

        </div>

    </nav>


    <!-- Main -->
    <main class="max-w-5xl mx-auto px-6 py-10">


        <!-- Header -->
        <div class="mb-8">

            <p class="text-sm font-semibold text-amber-600 mb-2">
                KELOLA LAPAK
            </p>

            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900">
                Tambah Lapak
            </h1>

            <p class="text-slate-500 mt-3">
                Tambahkan UMKM atau usaha baru ke website Desa Sidowungu.
            </p>

        </div>


        <!-- Error -->
        <?php if ($pesan_error !== ''): ?>

            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl">

                <?= htmlspecialchars($pesan_error); ?>

            </div>

        <?php endif; ?>


        <!-- Form -->
        <form
            action=""
            method="POST"
            enctype="multipart/form-data"
            class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8"
        >


            <!-- Informasi -->
            <div class="mb-8">

                <h2 class="text-xl font-bold text-slate-900">
                    Informasi Usaha
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Isi informasi dasar mengenai UMKM atau usaha.
                </p>

            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                <!-- Nama Usaha -->
                <div class="md:col-span-2">

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Nama Usaha <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        name="nama_usaha"
                        required
                        value="<?= htmlspecialchars($_POST['nama_usaha'] ?? ''); ?>"
                        placeholder="Contoh: Sofiana Ethnic"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                    >

                </div>


                <!-- Jenis Usaha -->
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Jenis Usaha
                    </label>

                    <input
                        type="text"
                        name="jenis_usaha"
                        value="<?= htmlspecialchars($_POST['jenis_usaha'] ?? ''); ?>"
                        placeholder="Contoh: Kerajinan Tangan"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                    >

                </div>


                <!-- Kategori -->
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Kategori
                    </label>

                    <select
                        name="kategori"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                    >

                        <option value="">
                            Pilih kategori
                        </option>

                        <option value="Makanan & Minuman"
                            <?= (($_POST['kategori'] ?? '') === 'Makanan & Minuman') ? 'selected' : ''; ?>>
                            Makanan & Minuman
                        </option>

                        <option value="Kerajinan & Fashion"
                            <?= (($_POST['kategori'] ?? '') === 'Kerajinan & Fashion') ? 'selected' : ''; ?>>
                            Kerajinan & Fashion
                        </option>

                        <option value="Perdagangan"
                            <?= (($_POST['kategori'] ?? '') === 'Perdagangan') ? 'selected' : ''; ?>>
                            Perdagangan
                        </option>

                        <option value="Jasa"
                            <?= (($_POST['kategori'] ?? '') === 'Jasa') ? 'selected' : ''; ?>>
                            Jasa
                        </option>

                        <option value="Peternakan & Unggas"
                            <?= (($_POST['kategori'] ?? '') === 'Peternakan & Unggas') ? 'selected' : ''; ?>>
                            Peternakan & Unggas
                        </option>

                        <option value="Lainnya"
                            <?= (($_POST['kategori'] ?? '') === 'Lainnya') ? 'selected' : ''; ?>>
                            Lainnya
                        </option>

                    </select>

                </div>


                <!-- Produk / Jasa -->
                <div class="md:col-span-2">

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Produk / Jasa
                    </label>

                    <textarea
                        name="produk_jasa"
                        rows="3"
                        placeholder="Contoh: Ayam pejantan, ayam joper, dan bebek"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 resize-none"
                    ><?= htmlspecialchars($_POST['produk_jasa'] ?? ''); ?></textarea>

                </div>


                <!-- Deskripsi -->
                <div class="md:col-span-2">

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Deskripsi Singkat
                    </label>

                    <textarea
                        name="deskripsi"
                        rows="3"
                        placeholder="Tuliskan deskripsi singkat usaha..."
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 resize-none"
                    ><?= htmlspecialchars($_POST['deskripsi'] ?? ''); ?></textarea>

                </div>


                <!-- Alamat -->
                <div class="md:col-span-2">

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Alamat
                    </label>

                    <textarea
                        name="alamat"
                        rows="3"
                        placeholder="Contoh: Sidowungu RT 02/RW 01, Menganti, Gresik"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 resize-none"
                    ><?= htmlspecialchars($_POST['alamat'] ?? ''); ?></textarea>

                </div>


                <!-- WhatsApp -->
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        No. WhatsApp / Telepon
                    </label>

                    <input
                        type="text"
                        name="no_whatsapp"
                        value="<?= htmlspecialchars($_POST['no_whatsapp'] ?? ''); ?>"
                        placeholder="Contoh: 081234567890"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                    >

                </div>


                <!-- Jam -->
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Jam Operasional
                    </label>

                    <input
                        type="text"
                        name="jam_operasional"
                        value="<?= htmlspecialchars($_POST['jam_operasional'] ?? ''); ?>"
                        placeholder="Contoh: Senin-Sabtu, 08.00-21.00"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                    >

                </div>


                <!-- Google Maps -->
                <div class="md:col-span-2">

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Link Google Maps
                    </label>

                    <input
                        type="url"
                        name="link_maps"
                        value="<?= htmlspecialchars($_POST['link_maps'] ?? ''); ?>"
                        placeholder="https://maps.app.goo.gl/..."
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                    >

                </div>


                <!-- Status -->
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Status
                    </label>

                    <select
                        name="status"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                    >

                        <option value="Aktif">
                            Aktif
                        </option>

                        <option value="Tidak Aktif">
                            Tidak Aktif
                        </option>

                    </select>

                </div>


                <!-- FOTO -->
                <div class="md:col-span-2">

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Foto Usaha
                    </label>

                    <div class="border-2 border-dashed border-slate-300 rounded-2xl p-6 hover:border-amber-500 transition">

                        <input
                            type="file"
                            name="foto[]"
                            id="foto"
                            accept="image/jpeg,image/png,image/webp"
                            multiple
                            class="block w-full text-sm text-slate-600
                                   file:mr-4 file:py-2.5 file:px-4
                                   file:rounded-xl file:border-0
                                   file:bg-slate-950 file:text-white
                                   file:font-semibold
                                   hover:file:bg-slate-800"
                        >

                        <p class="text-xs text-slate-400 mt-3">
                            Kamu bisa memilih beberapa foto sekaligus.
                            Format JPG, JPEG, PNG, atau WEBP. Maksimal 5 MB per foto.
                        </p>

                        <p
                            id="jumlah-foto"
                            class="text-sm font-semibold text-amber-600 mt-3"
                        ></p>

                    </div>

                </div>

            </div>


            <!-- Tombol -->
            <div class="mt-8 pt-6 border-t border-slate-200 flex flex-col sm:flex-row gap-3 justify-end">

                <a
                    href="index.php"
                    class="px-5 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold text-center transition"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="px-5 py-3 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold transition"
                >
                    Simpan Lapak
                </button>

            </div>

        </form>

    </main>


    <!-- Tampilkan jumlah foto yang dipilih -->
    <script>

        const inputFoto = document.getElementById('foto');
        const jumlahFoto = document.getElementById('jumlah-foto');

        inputFoto.addEventListener('change', function () {

            const jumlah = this.files.length;

            if (jumlah === 0) {

                jumlahFoto.textContent = '';

            } else if (jumlah === 1) {

                jumlahFoto.textContent = '1 foto dipilih';

            } else {

                jumlahFoto.textContent = jumlah + ' foto dipilih';

            }

        });

    </script>

</body>
</html>