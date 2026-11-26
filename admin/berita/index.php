<?php
session_start();

if (
    !isset($_SESSION['admin_login']) ||
    $_SESSION['admin_login'] !== true
) {
    header("Location: ../login.php");
    exit;
}

require_once "../../config/database.php";


// =====================================================
// DATA BERITA
// =====================================================

$berita = [];

$query = $conn->query(
    "SELECT *
     FROM berita
     ORDER BY tanggal DESC, id DESC"
);

if ($query) {

    while ($row = $query->fetch_assoc()) {

        $berita[] = $row;

    }

}


// =====================================================
// STATISTIK
// =====================================================

$totalBerita = count($berita);

$totalDibaca = 0;

foreach ($berita as $item) {

    $totalDibaca += (int) $item['dibaca'];

}


$success = $_GET['success'] ?? '';
$error = $_GET['error'] ?? '';

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
        Kelola Berita - Admin Desa Sidowungu
    </title>


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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        body {

            font-family:
                'Plus Jakarta Sans',
                Arial,
                sans-serif;

            background:
                #f8fafc;

            color:
                #0f172a;
        }


        /* =================================================
           NAVBAR
        ================================================= */

        .navbar {

            background:
                #0f172a;

            color:
                white;

            padding:
                18px 5%;

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap:
                20px;
        }


        .brand {

            display:
                flex;

            align-items:
                center;

            gap:
                12px;
        }


        .brand-icon {

            width:
                46px;

            height:
                46px;

            border-radius:
                14px;

            background:
                linear-gradient(
                    135deg,
                    #ec4899,
                    #db2777
                );

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            font-size:
                22px;
        }


        .brand h1 {

            font-size:
                18px;

            font-weight:
                800;
        }


        .brand p {

            font-size:
                11px;

            color:
                #94a3b8;

            margin-top:
                3px;
        }


        .nav-actions {

            display:
                flex;

            gap:
                8px;
        }


        .nav-btn {

            text-decoration:
                none;

            color:
                white;

            padding:
                10px 14px;

            border-radius:
                10px;

            font-size:
                12px;

            font-weight:
                700;
        }


        .dashboard-btn {

            background:
                #334155;
        }


        .dashboard-btn:hover {

            background:
                #475569;
        }


        .logout-btn {

            background:
                #dc2626;
        }


        .logout-btn:hover {

            background:
                #b91c1c;
        }


        /* =================================================
           CONTAINER
        ================================================= */

        .container {

            width:
                90%;

            max-width:
                1400px;

            margin:
                40px auto 60px;
        }


        /* =================================================
           HEADER
        ================================================= */

        .page-header {

            display:
                flex;

            justify-content:
                space-between;

            align-items:
                flex-end;

            gap:
                20px;

            margin-bottom:
                25px;

            flex-wrap:
                wrap;
        }


        .page-label {

            color:
                #ec4899;

            font-size:
                11px;

            font-weight:
                800;

            letter-spacing:
                1.5px;

            text-transform:
                uppercase;
        }


        .page-title {

            font-size:
                32px;

            font-weight:
                800;

            margin-top:
                7px;
        }


        .page-description {

            color:
                #64748b;

            font-size:
                13px;

            margin-top:
                7px;

            line-height:
                1.6;
        }


        .add-btn {

            text-decoration:
                none;

            color:
                white;

            background:
                linear-gradient(
                    135deg,
                    #ec4899,
                    #db2777
                );

            padding:
                13px 18px;

            border-radius:
                12px;

            font-size:
                12px;

            font-weight:
                800;
        }


        .add-btn:hover {

            opacity:
                .9;
        }


        /* =================================================
           ALERT
        ================================================= */

        .alert {

            margin-bottom:
                20px;

            padding:
                14px 16px;

            border-radius:
                12px;

            font-size:
                12px;

            font-weight:
                700;
        }


        .success {

            background:
                #ecfdf5;

            color:
                #166534;

            border:
                1px solid
                #bbf7d0;
        }


        .error {

            background:
                #fef2f2;

            color:
                #991b1b;

            border:
                1px solid
                #fecaca;
        }


        /* =================================================
           STATISTIK
        ================================================= */

        .stats {

            display:
                grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap:
                16px;

            margin-bottom:
                22px;
        }


        .stat-card {

            background:
                white;

            border:
                1px solid
                #e2e8f0;

            border-radius:
                16px;

            padding:
                20px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            box-shadow:
                0 5px 18px
                rgba(15, 23, 42, .04);
        }


        .stat-label {

            color:
                #64748b;

            font-size:
                11px;
        }


        .stat-value {

            font-size:
                28px;

            font-weight:
                800;

            margin-top:
                5px;
        }


        .stat-icon {

            width:
                52px;

            height:
                52px;

            border-radius:
                15px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            font-size:
                22px;

            background:
                #fdf2f8;
        }


        /* =================================================
           TABLE
        ================================================= */

        .table-card {

            background:
                white;

            border:
                1px solid
                #e2e8f0;

            border-radius:
                18px;

            overflow:
                hidden;

            box-shadow:
                0 7px 25px
                rgba(15, 23, 42, .05);
        }


        .table-top {

            padding:
                20px;

            border-bottom:
                1px solid
                #e2e8f0;

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;
        }


        .table-top h3 {

            font-size:
                16px;

            font-weight:
                800;
        }


        .table-count {

            background:
                #f1f5f9;

            padding:
                7px 11px;

            border-radius:
                8px;

            font-size:
                11px;

            font-weight:
                700;

            color:
                #475569;
        }


        .table-wrapper {

            overflow-x:
                auto;
        }


        table {

            width:
                100%;

            min-width:
                1050px;

            border-collapse:
                collapse;
        }


        th {

            background:
                #f8fafc;

            padding:
                14px 16px;

            color:
                #64748b;

            font-size:
                10px;

            text-transform:
                uppercase;

            letter-spacing:
                .5px;

            border-bottom:
                1px solid
                #e2e8f0;

            text-align:
                center;
        }


        td {

            padding:
                15px 16px;

            border-bottom:
                1px solid
                #f1f5f9;

            vertical-align:
                top;

            font-size:
                12px;
        }


        tbody tr:hover {

            background:
                #fdfbfe;
        }


        td:first-child {

            text-align:
                center;

            width:
                55px;

            color:
                #94a3b8;

            font-weight:
                700;
        }


        .news-image {

            width:
                85px;

            height:
                58px;

            border-radius:
                9px;

            object-fit:
                cover;

            background:
                #f1f5f9;
        }


        .news-title {

            max-width:
                330px;

            font-weight:
                800;

            color:
                #0f172a;

            line-height:
                1.45;
        }


        .news-excerpt {

            max-width:
                330px;

            margin-top:
                5px;

            color:
                #64748b;

            line-height:
                1.5;
        }


        .author {

            color:
                #475569;

            font-weight:
                600;
        }


        .date {

            white-space:
                nowrap;

            color:
                #475569;
        }


        .views {

            font-weight:
                700;

            color:
                #475569;

            text-align:
                center;
        }


        .actions {

            display:
                flex;

            justify-content:
                center;

            gap:
                7px;

            flex-wrap:
                nowrap;

            white-space:
                nowrap;
        }


        .action {

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            height:
                35px;

            padding:
                0 11px;

            border-radius:
                9px;

            text-decoration:
                none;

            font-size:
                11px;

            font-weight:
                800;
        }


        .edit {

            background:
                #eff6ff;

            color:
                #2563eb;
        }


        .edit:hover {

            background:
                #dbeafe;
        }


        .delete {

            background:
                #fef2f2;

            color:
                #dc2626;
        }


        .delete:hover {

            background:
                #fee2e2;
        }


        .empty {

            padding:
                60px 20px;

            text-align:
                center;

            color:
                #94a3b8;
        }


        .empty-icon {

            font-size:
                35px;

            margin-bottom:
                10px;
        }


        .empty h4 {

            color:
                #334155;

            font-size:
                15px;

            font-weight:
                800;
        }


        .empty p {

            margin-top:
                5px;

            font-size:
                12px;
        }


        /* =================================================
           RESPONSIVE
        ================================================= */

        @media (max-width: 700px) {

            .navbar {

                flex-direction:
                    column;

                align-items:
                    flex-start;
            }


            .nav-actions {

                width:
                    100%;
            }


            .nav-btn {

                flex:
                    1;

                text-align:
                    center;
            }


            .stats {

                grid-template-columns:
                    1fr;
            }


            .page-title {

                font-size:
                    27px;
            }


            .add-btn {

                width:
                    100%;

                text-align:
                    center;
            }

        }

    </style>

</head>


<body>


<header class="navbar">

    <div class="brand">

        <div class="brand-icon">
            📰
        </div>


        <div>

            <h1>
                Admin Desa Sidowungu
            </h1>

            <p>
                Panel Pengelolaan Website Desa
            </p>

        </div>

    </div>


    <div class="nav-actions">

        <a
            href="../index.php"
            class="nav-btn dashboard-btn"
        >
            Dashboard
        </a>


        <a
            href="../logout.php"
            class="nav-btn logout-btn"
            onclick="return confirm('Apakah Anda yakin ingin logout?')"
        >
            Logout
        </a>

    </div>

</header>



<main class="container">


    <!-- HEADER -->

    <div class="page-header">

        <div>

            <div class="page-label">
                Manajemen Informasi
            </div>


            <h2 class="page-title">
                Kelola Berita
            </h2>


            <p class="page-description">

                Kelola artikel dan informasi terbaru
                Desa Sidowungu yang ditampilkan pada website.

            </p>

        </div>


        <a
            href="tambah.php"
            class="add-btn"
        >
            ＋ Tambah Berita
        </a>

    </div>



    <!-- ALERT -->

    <?php if ($success === 'tambah'): ?>

        <div class="alert success">
            ✓ Berita berhasil ditambahkan.
        </div>

    <?php elseif ($success === 'edit'): ?>

        <div class="alert success">
            ✓ Berita berhasil diperbarui.
        </div>

    <?php elseif ($success === 'hapus'): ?>

        <div class="alert success">
            ✓ Berita berhasil dihapus.
        </div>

    <?php endif; ?>


    <?php if ($error === 'hapus'): ?>

        <div class="alert error">
            ✕ Berita gagal dihapus.
        </div>

    <?php endif; ?>



    <!-- STATISTIK -->

    <div class="stats">


        <div class="stat-card">

            <div>

                <div class="stat-label">
                    Total Berita
                </div>

                <div class="stat-value">
                    <?= $totalBerita; ?>
                </div>

            </div>


            <div class="stat-icon">
                📰
            </div>

        </div>


        <div class="stat-card">

            <div>

                <div class="stat-label">
                    Total Dibaca
                </div>

                <div class="stat-value">
                    <?= number_format(
                        $totalDibaca,
                        0,
                        ',',
                        '.'
                    ); ?>
                </div>

            </div>


            <div class="stat-icon">
                👁️
            </div>

        </div>


    </div>



    <!-- TABLE -->

    <section class="table-card">


        <div class="table-top">

            <div>

                <h3>
                    Daftar Berita
                </h3>

            </div>


            <div class="table-count">

                <?= $totalBerita; ?> Berita

            </div>

        </div>


        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>
                            No
                        </th>

                        <th>
                            Gambar
                        </th>

                        <th>
                            Berita
                        </th>

                        <th>
                            Penulis
                        </th>

                        <th>
                            Tanggal
                        </th>

                        <th>
                            Dibaca
                        </th>

                        <th>
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>


                    <?php if (
                        count($berita) > 0
                    ): ?>


                        <?php
                        $no = 1;
                        ?>


                        <?php foreach (
                            $berita
                            as $item
                        ): ?>


                            <?php

                            $gambar =
                                trim(
                                    $item['gambar'] ?? ''
                                );

                            ?>


                            <tr>


                                <!-- NO -->

                                <td>

                                    <?= $no++; ?>

                                </td>



                                <!-- GAMBAR -->

                                <td>

                                    <?php if (
                                        !empty(
                                            $gambar
                                        )
                                    ): ?>

                                        <img
                                            src="<?= htmlspecialchars(
                                                $gambar,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"
                                            alt="<?= htmlspecialchars(
                                                $item['judul'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"
                                            class="news-image"
                                            onerror="this.style.display='none';"
                                        >

                                    <?php else: ?>

                                        <div
                                            class="news-image
                                                   flex
                                                   items-center
                                                   justify-center"
                                        >
                                            📰
                                        </div>

                                    <?php endif; ?>

                                </td>



                                <!-- BERITA -->

                                <td>

                                    <div class="news-title">

                                        <?= htmlspecialchars(
                                            $item['judul'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>

                                    </div>


                                    <div class="news-excerpt">

                                        <?= htmlspecialchars(
                                            mb_strimwidth(
                                                strip_tags(
                                                    $item['isi']
                                                ),
                                                0,
                                                110,
                                                '...'
                                            ),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>

                                    </div>

                                </td>



                                <!-- PENULIS -->

                                <td>

                                    <div class="author">

                                        <?= htmlspecialchars(
                                            $item['penulis'] ??
                                            'Admin Desa',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>

                                    </div>

                                </td>



                                <!-- TANGGAL -->

                                <td>

                                    <div class="date">

                                        <?= date(
                                            'd M Y',
                                            strtotime(
                                                $item['tanggal']
                                            )
                                        ); ?>

                                    </div>

                                </td>



                                <!-- DIBACA -->

                                <td>

                                    <div class="views">

                                        <?= number_format(
                                            (int) $item['dibaca'],
                                            0,
                                            ',',
                                            '.'
                                        ); ?>

                                    </div>

                                </td>



                                <!-- AKSI -->

                                <td>

                                    <div class="actions">


                                        <a
                                            href="edit.php?id=<?= $item['id']; ?>"
                                            class="action edit"
                                        >
                                            ✏️ Edit
                                        </a>


                                        <a
                                            href="hapus.php?id=<?= $item['id']; ?>"
                                            class="action delete"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')"
                                        >
                                            🗑️ Hapus
                                        </a>


                                    </div>

                                </td>


                            </tr>


                        <?php endforeach; ?>


                    <?php else: ?>


                        <tr>

                            <td colspan="7">

                                <div class="empty">

                                    <div class="empty-icon">
                                        📰
                                    </div>


                                    <h4>
                                        Belum Ada Berita
                                    </h4>


                                    <p>
                                        Silakan tambahkan berita pertama.
                                    </p>

                                </div>

                            </td>

                        </tr>


                    <?php endif; ?>


                </tbody>

            </table>

        </div>

    </section>


</main>

</body>

</html>