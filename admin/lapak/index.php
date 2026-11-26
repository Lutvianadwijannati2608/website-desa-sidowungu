<?php
require_once __DIR__ . '/../../config/database.php';

// Ambil semua data lapak
$query = mysqli_query(
    $conn,
    "SELECT * FROM lapak ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kelola Lapak - Admin Desa Sidowungu</title>

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
        <div class="max-w-7xl mx-auto px-6 py-4">

            <div class="flex items-center justify-between gap-4">

                <div>
                    <p class="text-lg font-bold">
                        Admin Desa Sidowungu
                    </p>

                    <p class="text-xs text-slate-400 mt-1">
                        Kelola Lapak UMKM
                    </p>
                </div>

                <a
                    href="../index.php"
                    class="bg-white/10 hover:bg-white/20 px-4 py-2 rounded-xl text-sm font-medium transition"
                >
                    Dashboard
                </a>

            </div>

        </div>
    </nav>

    <!-- Main -->
    <main class="max-w-7xl mx-auto px-6 py-10">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-5 mb-8">

            <div>
                <p class="text-sm font-semibold text-amber-600 mb-2">
                    KELOLA LAPAK
                </p>

                <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900">
                    Daftar UMKM & Usaha
                </h1>

                <p class="text-slate-500 mt-3 max-w-2xl">
                    Kelola data UMKM dan usaha masyarakat Desa Sidowungu.
                    Tambahkan data baru kapan saja tanpa perlu mengubah kode website.
                </p>
            </div>

            <a
                href="tambah.php"
                class="inline-flex items-center justify-center bg-amber-600 hover:bg-amber-700 text-white px-5 py-3 rounded-xl text-sm font-semibold transition shadow-sm"
            >
                <span class="text-lg mr-2">＋</span>
                Tambah Lapak
            </a>

        </div>


        <!-- Konten -->
        <?php if (mysqli_num_rows($query) > 0): ?>

            <!-- Table Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="w-full min-w-[900px]">

                        <thead class="bg-slate-50 border-b border-slate-200">

                            <tr>

                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wide">
                                    No
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wide">
                                    Nama Usaha
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wide">
                                    Kategori
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wide">
                                    WhatsApp
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wide">
                                    Status
                                </th>

                                <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wide">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            <?php
                            $no = 1;

                            while ($lapak = mysqli_fetch_assoc($query)):
                            ?>

                                <tr class="hover:bg-slate-50 transition">

                                    <!-- No -->
                                    <td class="px-6 py-5 text-sm text-slate-500">
                                        <?= $no++; ?>
                                    </td>

                                    <!-- Nama -->
                                    <td class="px-6 py-5">

                                        <p class="font-semibold text-slate-900">
                                            <?= htmlspecialchars($lapak['nama_usaha']); ?>
                                        </p>

                                        <?php if (!empty($lapak['jenis_usaha'])): ?>

                                            <p class="text-xs text-slate-400 mt-1">
                                                <?= htmlspecialchars($lapak['jenis_usaha']); ?>
                                            </p>

                                        <?php endif; ?>

                                    </td>

                                    <!-- Kategori -->
                                    <td class="px-6 py-5">

                                        <?php if (!empty($lapak['kategori'])): ?>

                                            <span class="inline-flex bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-xs font-medium">
                                                <?= htmlspecialchars($lapak['kategori']); ?>
                                            </span>

                                        <?php else: ?>

                                            <span class="text-sm text-slate-400">
                                                —
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <!-- WhatsApp -->
                                    <td class="px-6 py-5 text-sm text-slate-600">

                                        <?php if (!empty($lapak['no_whatsapp'])): ?>

                                            <?= htmlspecialchars($lapak['no_whatsapp']); ?>

                                        <?php else: ?>

                                            <span class="text-slate-400">
                                                —
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-5">

                                        <?php if ($lapak['status'] === 'Aktif'): ?>

                                            <span class="inline-flex items-center gap-2 bg-green-50 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                                Aktif
                                            </span>

                                        <?php else: ?>

                                            <span class="inline-flex items-center gap-2 bg-slate-100 text-slate-500 px-3 py-1 rounded-full text-xs font-semibold">
                                                <span class="w-2 h-2 bg-slate-400 rounded-full"></span>
                                                Tidak Aktif
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <!-- Aksi -->
                                    <td class="px-6 py-5">

                                        <div class="flex items-center justify-center gap-2">

                                            <a
                                                href="edit.php?id=<?= $lapak['id']; ?>"
                                                class="px-3 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition"
                                            >
                                                Edit
                                            </a>

                                            <a
                                                href="hapus.php?id=<?= $lapak['id']; ?>"
                                                onclick="return confirm('Yakin ingin menghapus lapak ini?');"
                                                class="px-3 py-2 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 text-xs font-semibold transition"
                                            >
                                                Hapus
                                            </a>

                                        </div>

                                    </td>

                                </tr>

                            <?php endwhile; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        <?php else: ?>

            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-10 md:p-16 text-center">

                <div class="w-20 h-20 mx-auto rounded-2xl bg-amber-100 flex items-center justify-center text-4xl mb-6">
                    🏪
                </div>

                <h2 class="text-2xl font-bold text-slate-900">
                    Belum Ada Lapak
                </h2>

                <p class="text-slate-500 mt-3 max-w-md mx-auto leading-relaxed">
                    Saat ini belum ada data UMKM atau usaha yang ditambahkan.
                    Klik tombol di bawah untuk menambahkan lapak pertama.
                </p>

                <a
                    href="tambah.php"
                    class="inline-flex items-center mt-7 bg-amber-600 hover:bg-amber-700 text-white px-5 py-3 rounded-xl text-sm font-semibold transition"
                >
                    <span class="text-lg mr-2">＋</span>
                    Tambah Lapak Pertama
                </a>

            </div>

        <?php endif; ?>


        <!-- Footer info -->
        <div class="mt-6 flex flex-col md:flex-row md:items-center md:justify-between gap-3">

            <p class="text-xs text-slate-400">
                Data lapak tersimpan secara otomatis di database.
            </p>

            <a
                href="../../index.php"
                class="text-sm text-slate-600 hover:text-slate-900 font-medium"
            >
                ← Kembali ke Website
            </a>

        </div>

    </main>

</body>
</html>