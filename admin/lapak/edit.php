<?php
require_once __DIR__ . '/../../config/database.php';


// ======================================================
// AMBIL ID LAPAK
// ======================================================

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header('Location: index.php');
    exit;
}


// ======================================================
// AMBIL DATA LAPAK
// ======================================================

$query_lapak = mysqli_query(
    $conn,
    "SELECT * FROM lapak WHERE id = $id LIMIT 1"
);

if (!$query_lapak || mysqli_num_rows($query_lapak) === 0) {
    header('Location: index.php');
    exit;
}

$lapak = mysqli_fetch_assoc($query_lapak);


// ======================================================
// FUNGSI UPLOAD FOTO
// ======================================================

function prosesUploadFoto($conn, $lapak_id, $files)
{
    $folder_foto = dirname(__DIR__, 2) . '/assets/images/lapak/';

    // Buat folder jika belum ada
    if (!is_dir($folder_foto)) {
        mkdir($folder_foto, 0777, true);
    }

    $hasil = [
        'berhasil' => 0,
        'gagal' => 0
    ];

    if (
        !isset($files['name']) ||
        !is_array($files['name'])
    ) {
        return $hasil;
    }

    $jumlah_foto = count($files['name']);

    // Cari urutan terakhir
    $query_urutan = mysqli_query(
        $conn,
        "SELECT MAX(urutan) AS urutan_terakhir
         FROM lapak_foto
         WHERE lapak_id = $lapak_id"
    );

    $data_urutan = mysqli_fetch_assoc($query_urutan);

    $urutan = !empty($data_urutan['urutan_terakhir'])
        ? (int) $data_urutan['urutan_terakhir'] + 1
        : 1;


    for ($i = 0; $i < $jumlah_foto; $i++) {

        // Tidak ada file
        if (
            !isset($files['error'][$i]) ||
            $files['error'][$i] === UPLOAD_ERR_NO_FILE
        ) {
            continue;
        }

        // Error upload
        if ($files['error'][$i] !== UPLOAD_ERR_OK) {
            $hasil['gagal']++;
            continue;
        }

        $tmp_name  = $files['tmp_name'][$i];
        $nama_asli = $files['name'][$i];
        $ukuran    = $files['size'][$i];

        // Maksimal 5 MB
        if ($ukuran > 5 * 1024 * 1024) {
            $hasil['gagal']++;
            continue;
        }

        // Pastikan benar-benar gambar
        $info_gambar = @getimagesize($tmp_name);

        if ($info_gambar === false) {
            $hasil['gagal']++;
            continue;
        }

        // Ekstensi
        $ekstensi = strtolower(
            pathinfo($nama_asli, PATHINFO_EXTENSION)
        );

        $ekstensi_diizinkan = [
            'jpg',
            'jpeg',
            'png',
            'webp'
        ];

        if (!in_array($ekstensi, $ekstensi_diizinkan, true)) {
            $hasil['gagal']++;
            continue;
        }

        // Nama file aman
        $nama_file =
            'lapak_' .
            $lapak_id .
            '_' .
            time() .
            '_' .
            $i .
            '.' .
            $ekstensi;

        $tujuan_file = $folder_foto . $nama_file;


        // Pindahkan file
        if (move_uploaded_file($tmp_name, $tujuan_file)) {

            $nama_file_db = mysqli_real_escape_string(
                $conn,
                $nama_file
            );

            mysqli_query(
                $conn,
                "INSERT INTO lapak_foto
                (lapak_id, nama_file, urutan)
                VALUES
                ($lapak_id, '$nama_file_db', $urutan)"
            );

            $urutan++;
            $hasil['berhasil']++;

        } else {

            $hasil['gagal']++;
        }
    }

    return $hasil;
}


// ======================================================
// HAPUS FOTO
// ======================================================

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['hapus_foto_id'])
) {

    $foto_id = (int) $_POST['hapus_foto_id'];

    // Ambil nama file foto
    $query_foto = mysqli_query(
        $conn,
        "SELECT *
         FROM lapak_foto
         WHERE id = $foto_id
         AND lapak_id = $id
         LIMIT 1"
    );

    if (
        $query_foto &&
        mysqli_num_rows($query_foto) > 0
    ) {

        $foto = mysqli_fetch_assoc($query_foto);

        $folder_foto =
            dirname(__DIR__, 2) .
            '/assets/images/lapak/';

        $file_foto =
            $folder_foto .
            $foto['nama_file'];

        // Hapus file
        if (file_exists($file_foto)) {
            unlink($file_foto);
        }

        // Hapus data database
        mysqli_query(
            $conn,
            "DELETE FROM lapak_foto
             WHERE id = $foto_id
             AND lapak_id = $id"
        );
    }

    header('Location: edit.php?id=' . $id . '&foto=hapus');
    exit;
}


// ======================================================
// UPDATE DATA
// ======================================================

$pesan_error = '';
$pesan_sukses = '';

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['simpan_data'])
) {

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


    if ($nama_usaha === '') {

        $pesan_error = 'Nama usaha wajib diisi.';

    } else {

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


        // Update data
        $sql_update = "UPDATE lapak SET

            nama_usaha = '$nama_usaha',
            jenis_usaha = '$jenis_usaha',
            kategori = '$kategori',
            produk_jasa = '$produk_jasa',
            deskripsi = '$deskripsi',
            alamat = '$alamat',
            no_whatsapp = '$no_whatsapp',
            jam_operasional = '$jam_operasional',
            link_maps = '$link_maps',
            status = '$status'

            WHERE id = $id";


        if (mysqli_query($conn, $sql_update)) {

            // Upload foto baru jika ada
            $hasil_upload = [
                'berhasil' => 0,
                'gagal' => 0
            ];

            if (
                isset($_FILES['foto']) &&
                isset($_FILES['foto']['name'])
            ) {

                $hasil_upload = prosesUploadFoto(
                    $conn,
                    $id,
                    $_FILES['foto']
                );
            }


            // Pesan
            if ($hasil_upload['berhasil'] > 0) {

                $pesan_sukses =
                    'Data berhasil diperbarui dan ' .
                    $hasil_upload['berhasil'] .
                    ' foto berhasil ditambahkan.';

            } else {

                $pesan_sukses =
                    'Data lapak berhasil diperbarui.';
            }


            // Refresh data
            $query_lapak = mysqli_query(
                $conn,
                "SELECT * FROM lapak
                 WHERE id = $id
                 LIMIT 1"
            );

            $lapak = mysqli_fetch_assoc($query_lapak);

        } else {

            $pesan_error =
                'Data gagal diperbarui. Silakan coba lagi.';
        }
    }
}


// ======================================================
// AMBIL FOTO YANG SUDAH ADA
// ======================================================

$query_foto = mysqli_query(
    $conn,
    "SELECT *
     FROM lapak_foto
     WHERE lapak_id = $id
     ORDER BY urutan ASC, id ASC"
);

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
        Edit Lapak - Admin Desa Sidowungu
    </title>


    <script src="https://cdn.tailwindcss.com"></script>


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

    </style>

</head>


<body class="bg-slate-100 min-h-screen">


<!-- NAVBAR -->

<nav class="bg-slate-950 text-white">

    <div class="max-w-5xl mx-auto px-6 py-4">

        <div class="flex items-center justify-between gap-4">

            <div>

                <p class="text-lg font-bold">
                    Admin Desa Sidowungu
                </p>

                <p class="text-xs text-slate-400 mt-1">
                    Edit Lapak
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


<!-- MAIN -->

<main class="max-w-5xl mx-auto px-6 py-10">


    <!-- HEADER -->

    <div class="mb-8">

        <p class="text-sm font-semibold text-amber-600 mb-2">
            KELOLA LAPAK
        </p>

        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900">
            Edit Lapak
        </h1>

        <p class="text-slate-500 mt-3">
            Perbarui informasi dan foto usaha.
        </p>

    </div>


    <!-- PESAN -->

    <?php if ($pesan_error !== ''): ?>

        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl">

            <?= htmlspecialchars($pesan_error); ?>

        </div>

    <?php endif; ?>


    <?php if ($pesan_sukses !== ''): ?>

        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-xl">

            <?= htmlspecialchars($pesan_sukses); ?>

        </div>

    <?php endif; ?>


    <!-- INFORMASI USAHA -->

    <form
        action=""
        method="POST"
        enctype="multipart/form-data"
        class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8"
    >


        <h2 class="text-xl font-bold text-slate-900">
            Informasi Usaha
        </h2>

        <p class="text-sm text-slate-500 mt-1 mb-7">
            Ubah informasi yang diperlukan.
        </p>


        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


            <!-- NAMA -->

            <div class="md:col-span-2">

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Nama Usaha
                </label>

                <input
                    type="text"
                    name="nama_usaha"
                    required
                    value="<?= htmlspecialchars($lapak['nama_usaha']); ?>"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500"
                >

            </div>


            <!-- JENIS -->

            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Jenis Usaha
                </label>

                <input
                    type="text"
                    name="jenis_usaha"
                    value="<?= htmlspecialchars($lapak['jenis_usaha']); ?>"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500"
                >

            </div>


            <!-- KATEGORI -->

            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Kategori
                </label>

                <select
                    name="kategori"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-amber-500"
                >

                    <option value="">
                        Pilih kategori
                    </option>

                    <?php
                    $daftar_kategori = [
                        'Makanan & Minuman',
                        'Kerajinan & Fashion',
                        'Perdagangan',
                        'Jasa',
                        'Peternakan & Unggas',
                        'Lainnya'
                    ];
                    ?>

                    <?php foreach ($daftar_kategori as $kategori): ?>

                        <option
                            value="<?= htmlspecialchars($kategori); ?>"
                            <?= ($lapak['kategori'] === $kategori) ? 'selected' : ''; ?>
                        >
                            <?= htmlspecialchars($kategori); ?>
                        </option>

                    <?php endforeach; ?>

                </select>

            </div>


            <!-- PRODUK -->

            <div class="md:col-span-2">

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Produk / Jasa
                </label>

                <textarea
                    name="produk_jasa"
                    rows="3"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500 resize-none"
                ><?= htmlspecialchars($lapak['produk_jasa']); ?></textarea>

            </div>


            <!-- DESKRIPSI -->

            <div class="md:col-span-2">

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Deskripsi Singkat
                </label>

                <textarea
                    name="deskripsi"
                    rows="3"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500 resize-none"
                ><?= htmlspecialchars($lapak['deskripsi']); ?></textarea>

            </div>


            <!-- ALAMAT -->

            <div class="md:col-span-2">

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Alamat
                </label>

                <textarea
                    name="alamat"
                    rows="3"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500 resize-none"
                ><?= htmlspecialchars($lapak['alamat']); ?></textarea>

            </div>


            <!-- WHATSAPP -->

            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    No. WhatsApp / Telepon
                </label>

                <input
                    type="text"
                    name="no_whatsapp"
                    value="<?= htmlspecialchars($lapak['no_whatsapp']); ?>"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500"
                >

            </div>


            <!-- JAM -->

            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Jam Operasional
                </label>

                <input
                    type="text"
                    name="jam_operasional"
                    value="<?= htmlspecialchars($lapak['jam_operasional']); ?>"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500"
                >

            </div>


            <!-- MAPS -->

            <div class="md:col-span-2">

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Link Google Maps
                </label>

                <input
                    type="url"
                    name="link_maps"
                    value="<?= htmlspecialchars($lapak['link_maps']); ?>"
                    placeholder="https://maps.app.goo.gl/..."
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500"
                >

            </div>


            <!-- STATUS -->

            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Status
                </label>

                <select
                    name="status"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-amber-500"
                >

                    <option
                        value="Aktif"
                        <?= ($lapak['status'] === 'Aktif') ? 'selected' : ''; ?>
                    >
                        Aktif
                    </option>

                    <option
                        value="Tidak Aktif"
                        <?= ($lapak['status'] === 'Tidak Aktif') ? 'selected' : ''; ?>
                    >
                        Tidak Aktif
                    </option>

                </select>

            </div>


        </div>


        <!-- FOTO BARU -->

        <div class="mt-10 pt-8 border-t border-slate-200">

            <h2 class="text-xl font-bold text-slate-900">
                Tambah Foto
            </h2>

            <p class="text-sm text-slate-500 mt-1 mb-5">
                Tambahkan satu atau beberapa foto baru.
            </p>


            <div class="border-2 border-dashed border-slate-300 rounded-2xl p-6">

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
                    JPG, JPEG, PNG, atau WEBP. Maksimal 5 MB per foto.
                </p>


                <p
                    id="jumlah-foto"
                    class="text-sm font-semibold text-amber-600 mt-3"
                ></p>

            </div>

        </div>


        <!-- FOTO LAMA -->

        <div class="mt-10 pt-8 border-t border-slate-200">

            <h2 class="text-xl font-bold text-slate-900">
                Foto yang Tersimpan
            </h2>

            <p class="text-sm text-slate-500 mt-1 mb-5">
                Foto yang sudah ada pada lapak ini.
            </p>


            <?php if (mysqli_num_rows($query_foto) > 0): ?>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-5">

                    <?php while ($foto = mysqli_fetch_assoc($query_foto)): ?>

                        <div class="bg-slate-50 rounded-2xl border border-slate-200 overflow-hidden">

                            <img
                                src="../../assets/images/lapak/<?= htmlspecialchars($foto['nama_file']); ?>"
                                alt="Foto <?= htmlspecialchars($lapak['nama_usaha']); ?>"
                                class="w-full h-40 object-cover"
                            >


                            <div class="p-3">

                                <p class="text-xs text-slate-400 mb-3">
                                    Foto <?= (int) $foto['urutan']; ?>
                                </p>


                                <form
                                    method="POST"
                                    action=""
                                    onsubmit="return confirm('Yakin ingin menghapus foto ini?');"
                                >

                                    <input
                                        type="hidden"
                                        name="hapus_foto_id"
                                        value="<?= (int) $foto['id']; ?>"
                                    >

                                    <button
                                        type="submit"
                                        class="w-full px-3 py-2 rounded-xl bg-red-50 hover:bg-red-100 text-red-600 text-xs font-semibold transition"
                                    >
                                        Hapus Foto
                                    </button>

                                </form>

                            </div>

                        </div>

                    <?php endwhile; ?>

                </div>

            <?php else: ?>

                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-8 text-center">

                    <div class="text-3xl mb-3">
                        🖼️
                    </div>

                    <p class="font-semibold text-slate-700">
                        Belum ada foto
                    </p>

                    <p class="text-sm text-slate-400 mt-1">
                        Tambahkan foto melalui bagian "Tambah Foto".
                    </p>

                </div>

            <?php endif; ?>

        </div>


        <!-- BUTTON -->

        <div class="mt-10 pt-6 border-t border-slate-200 flex flex-col sm:flex-row gap-3 justify-end">

            <a
                href="index.php"
                class="px-5 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold text-center transition"
            >
                Batal
            </a>


            <button
                type="submit"
                name="simpan_data"
                class="px-5 py-3 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold transition"
            >
                Simpan Perubahan
            </button>

        </div>

    </form>

</main>


<!-- JUMLAH FOTO -->

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