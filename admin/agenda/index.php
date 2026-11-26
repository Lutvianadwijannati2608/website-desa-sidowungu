<?php
session_start();

if (!isset($_SESSION['admin_login']) || $_SESSION['admin_login'] !== true) {
    header("Location: ../login.php");
    exit;
}

require_once "../../config/database.php";


// =====================================================
// AMBIL DATA AGENDA
// =====================================================

$query = "
    SELECT *
    FROM agenda
    ORDER BY tanggal ASC, id ASC
";

$result = $conn->query($query);


// =====================================================
// HITUNG STATISTIK
// =====================================================

$totalAgenda = 0;
$agendaAktif = 0;
$agendaNonAktif = 0;

$agendaRows = [];

if ($result) {

    while ($row = $result->fetch_assoc()) {

        $agendaRows[] = $row;

        $totalAgenda++;

        if ($row['status'] === 'Aktif') {
            $agendaAktif++;
        } else {
            $agendaNonAktif++;
        }
    }
}


// =====================================================
// NOTIFIKASI
// =====================================================

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
        Kelola Agenda Desa - Admin
    </title>


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

            box-shadow:
                0 4px 18px
                rgba(15, 23, 42, 0.12);
        }


        .brand {

            display:
                flex;

            align-items:
                center;

            gap:
                13px;
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

            box-shadow:
                0 8px 20px
                rgba(236, 72, 153, 0.25);
        }


        .brand-text h1 {

            font-size:
                19px;

            font-weight:
                800;

            letter-spacing:
                -0.3px;
        }


        .brand-text p {

            color:
                #94a3b8;

            font-size:
                11px;

            margin-top:
                3px;
        }


        .navbar-actions {

            display:
                flex;

            align-items:
                center;

            gap:
                10px;
        }


        .nav-btn {

            text-decoration:
                none;

            color:
                white;

            padding:
                10px 15px;

            border-radius:
                10px;

            font-size:
                13px;

            font-weight:
                700;

            transition:
                0.2s ease;
        }


        .nav-dashboard {

            background:
                #334155;
        }


        .nav-dashboard:hover {

            background:
                #475569;
        }


        .nav-logout {

            background:
                #dc2626;
        }


        .nav-logout:hover {

            background:
                #b91c1c;
        }


        /* =================================================
           MAIN
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
           PAGE HEADER
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
                28px;

            flex-wrap:
                wrap;
        }


        .page-heading small {

            display:
                inline-flex;

            align-items:
                center;

            gap:
                7px;

            color:
                #ec4899;

            font-size:
                11px;

            font-weight:
                800;

            text-transform:
                uppercase;

            letter-spacing:
                1.5px;

            margin-bottom:
                8px;
        }


        .page-heading small::before {

            content:
                "";

            width:
                7px;

            height:
                7px;

            border-radius:
                50%;

            background:
                #ec4899;
        }


        .page-heading h2 {

            font-size:
                32px;

            font-weight:
                800;

            letter-spacing:
                -1px;

            color:
                #0f172a;
        }


        .page-heading p {

            margin-top:
                8px;

            max-width:
                700px;

            color:
                #64748b;

            font-size:
                13px;

            line-height:
                1.7;
        }


        .btn-add {

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            gap:
                8px;

            background:
                linear-gradient(
                    135deg,
                    #ec4899,
                    #db2777
                );

            color:
                white;

            text-decoration:
                none;

            border:
                none;

            border-radius:
                12px;

            padding:
                13px 19px;

            font-size:
                13px;

            font-weight:
                800;

            box-shadow:
                0 8px 20px
                rgba(236, 72, 153, 0.22);

            transition:
                0.2s ease;
        }


        .btn-add:hover {

            transform:
                translateY(-2px);

            box-shadow:
                0 12px 25px
                rgba(236, 72, 153, 0.28);
        }


        /* =================================================
           ALERT
        ================================================= */

        .alert {

            display:
                flex;

            align-items:
                center;

            gap:
                12px;

            padding:
                14px 17px;

            border-radius:
                12px;

            margin-bottom:
                22px;

            font-size:
                13px;

            font-weight:
                600;
        }


        .alert-icon {

            width:
                28px;

            height:
                28px;

            border-radius:
                50%;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            font-size:
                14px;

            flex-shrink:
                0;
        }


        .alert-success {

            background:
                #ecfdf5;

            color:
                #166534;

            border:
                1px solid
                #bbf7d0;
        }


        .alert-success .alert-icon {

            background:
                #dcfce7;
        }


        .alert-error {

            background:
                #fef2f2;

            color:
                #991b1b;

            border:
                1px solid
                #fecaca;
        }


        .alert-error .alert-icon {

            background:
                #fee2e2;
        }


        /* =================================================
           STATISTIC CARDS
        ================================================= */

        .stats-grid {

            display:
                grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap:
                16px;

            margin-bottom:
                24px;
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

            box-shadow:
                0 5px 20px
                rgba(15, 23, 42, 0.04);

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;
        }


        .stat-label {

            color:
                #64748b;

            font-size:
                12px;

            font-weight:
                600;
        }


        .stat-number {

            margin-top:
                7px;

            font-size:
                28px;

            line-height:
                1;

            font-weight:
                800;

            color:
                #0f172a;
        }


        .stat-description {

            margin-top:
                6px;

            font-size:
                11px;

            color:
                #94a3b8;
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
        }


        .stat-pink {

            background:
                #fdf2f8;
        }


        .stat-green {

            background:
                #ecfdf5;
        }


        .stat-red {

            background:
                #fef2f2;
        }


        /* =================================================
           TABLE CARD
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
                rgba(15, 23, 42, 0.05);
        }


        .table-header {

            padding:
                19px 22px;

            border-bottom:
                1px solid
                #e2e8f0;

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap:
                15px;
        }


        .table-title h3 {

            font-size:
                16px;

            font-weight:
                800;

            color:
                #0f172a;
        }


        .table-title p {

            margin-top:
                4px;

            color:
                #94a3b8;

            font-size:
                11px;
        }


        .table-count {

            padding:
                7px 11px;

            border-radius:
                8px;

            background:
                #f1f5f9;

            color:
                #475569;

            font-size:
                11px;

            font-weight:
                700;
        }


        .table-wrapper {

            overflow-x:
                auto;
        }


        table {

            width:
                100%;

            border-collapse:
                collapse;

            min-width:
                1050px;
        }


        thead {

            background:
                #f8fafc;
        }


        th {

            padding:
                14px 16px;

            border-bottom:
                1px solid
                #e2e8f0;

            color:
                #64748b;

            text-align:
                center;

            font-size:
                11px;

            text-transform:
                uppercase;

            letter-spacing:
                0.5px;

            font-weight:
                800;

            white-space:
                nowrap;
        }


        td {

            padding:
                16px;

            border-bottom:
                1px solid
                #f1f5f9;

            vertical-align:
                top;

            font-size:
                13px;

            color:
                #334155;
        }


        tbody tr {

            transition:
                0.2s ease;
        }


        tbody tr:hover {

            background:
                #fdfbfe;
        }


        tbody tr:last-child td {

            border-bottom:
                none;
        }


        /* =================================================
           ALIGNMENT PER KOLOM
        ================================================= */

        th:first-child,
        td:first-child {

            text-align:
                center;

            width:
                60px;
        }


        th:nth-child(3),
        td:nth-child(3) {

            text-align:
                center;

            min-width:
                145px;
        }


        th:nth-child(4),
        td:nth-child(4) {

            text-align:
                center;

            min-width:
                145px;
        }


        th:nth-child(6),
        td:nth-child(6) {

            text-align:
                center;

            min-width:
                110px;
        }


        th:last-child,
        td:last-child {

            text-align:
                center;

            min-width:
                165px;
        }


        .number-cell {

            color:
                #94a3b8;

            font-weight:
                700;
        }


        /* =================================================
           AGENDA
        ================================================= */

        .agenda-title {

            font-size:
                13px;

            font-weight:
                800;

            color:
                #0f172a;

            line-height:
                1.45;

            max-width:
                310px;
        }


        .agenda-description {

            margin-top:
                7px;

            color:
                #64748b;

            font-size:
                11px;

            line-height:
                1.55;

            max-width:
                340px;
        }


        .date-badge {

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            gap:
                7px;

            white-space:
                nowrap;

            font-weight:
                700;

            color:
                #334155;
        }


        .date-icon {

            width:
                28px;

            height:
                28px;

            border-radius:
                8px;

            background:
                #fdf2f8;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            font-size:
                13px;
        }


        .time-text {

            color:
                #475569;

            font-weight:
                600;
        }


        .location-text {

            color:
                #475569;

            line-height:
                1.5;

            max-width:
                220px;

            margin:
                0 auto;
        }


        /* =================================================
           STATUS
        ================================================= */

        .status {

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            gap:
                6px;

            padding:
                7px 10px;

            border-radius:
                999px;

            font-size:
                11px;

            font-weight:
                800;

            white-space:
                nowrap;
        }


        .status::before {

            content:
                "";

            width:
                6px;

            height:
                6px;

            border-radius:
                50%;
        }


        .status-aktif {

            background:
                #ecfdf5;

            color:
                #15803d;
        }


        .status-aktif::before {

            background:
                #22c55e;
        }


        .status-nonaktif {

            background:
                #fef2f2;

            color:
                #b91c1c;
        }


        .status-nonaktif::before {

            background:
                #ef4444;
        }


        /* =================================================
           ACTION
        ================================================= */

        .action-group {

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            gap:
                8px;

            flex-wrap:
                nowrap;

            white-space:
                nowrap;
        }


        .action-btn {

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            gap:
                5px;

            padding:
                8px 12px;

            min-width:
                66px;

            height:
                36px;

            border-radius:
                9px;

            text-decoration:
                none;

            font-size:
                11px;

            font-weight:
                800;

            transition:
                0.2s ease;

            white-space:
                nowrap;
        }


        .edit-btn {

            background:
                #eff6ff;

            color:
                #2563eb;
        }


        .edit-btn:hover {

            background:
                #dbeafe;

            transform:
                translateY(-1px);
        }


        .delete-btn {

            background:
                #fef2f2;

            color:
                #dc2626;
        }


        .delete-btn:hover {

            background:
                #fee2e2;

            transform:
                translateY(-1px);
        }


        /* =================================================
           EMPTY STATE
        ================================================= */

        .empty-state {

            text-align:
                center;

            padding:
                65px 20px;
        }


        .empty-icon {

            width:
                70px;

            height:
                70px;

            border-radius:
                20px;

            background:
                #f8fafc;

            border:
                1px solid
                #e2e8f0;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            font-size:
                30px;

            margin:
                0 auto 16px;
        }


        .empty-state h4 {

            font-size:
                16px;

            font-weight:
                800;

            color:
                #0f172a;
        }


        .empty-state p {

            margin-top:
                6px;

            color:
                #94a3b8;

            font-size:
                12px;
        }


        /* =================================================
           FOOTER
        ================================================= */

        .footer {

            text-align:
                center;

            padding:
                10px 20px 30px;

            color:
                #94a3b8;

            font-size:
                11px;
        }


        /* =================================================
           RESPONSIVE
        ================================================= */

        @media (max-width: 900px) {

            .stats-grid {

                grid-template-columns:
                    1fr;
            }

        }


        @media (max-width: 650px) {

            .navbar {

                padding:
                    16px 20px;

                align-items:
                    flex-start;

                flex-direction:
                    column;
            }


            .navbar-actions {

                width:
                    100%;
            }


            .nav-btn {

                flex:
                    1;

                text-align:
                    center;
            }


            .container {

                width:
                    94%;

                margin-top:
                    25px;
            }


            .page-heading h2 {

                font-size:
                    26px;
            }


            .btn-add {

                width:
                    100%;
            }


            .page-header {

                align-items:
                    stretch;
            }


            .table-header {

                align-items:
                    flex-start;

                flex-direction:
                    column;
            }

        }

    </style>

</head>


<body>


    <!-- =====================================================
         NAVBAR
    ====================================================== -->

    <header class="navbar">


        <div class="brand">

            <div class="brand-icon">
                📅
            </div>


            <div class="brand-text">

                <h1>
                    Admin Desa Sidowungu
                </h1>

                <p>
                    Panel Pengelolaan Website Desa
                </p>

            </div>

        </div>


        <div class="navbar-actions">

            <a
                href="../index.php"
                class="nav-btn nav-dashboard"
            >
                Dashboard
            </a>


            <a
                href="../logout.php"
                class="nav-btn nav-logout"
                onclick="
                    return confirm(
                        'Apakah Anda yakin ingin logout?'
                    )
                "
            >
                Logout
            </a>

        </div>

    </header>



    <!-- =====================================================
         MAIN
    ===================================================== -->

    <main class="container">


        <!-- =================================================
             PAGE HEADER
        ================================================== -->

        <div class="page-header">


            <div class="page-heading">

                <small>
                    Manajemen Kegiatan Desa
                </small>


                <h2>
                    Kelola Agenda Desa
                </h2>


                <p>

                    Kelola seluruh agenda dan kegiatan
                    Desa Sidowungu yang akan ditampilkan
                    kepada masyarakat melalui website.

                </p>

            </div>


            <a
                href="tambah.php"
                class="btn-add"
            >

                <span>
                    ＋
                </span>

                Tambah Agenda

            </a>


        </div>



        <!-- =================================================
             ALERT
        ================================================== -->

        <?php if ($success === 'tambah'): ?>

            <div class="alert alert-success">

                <div class="alert-icon">
                    ✓
                </div>

                <div>
                    Agenda berhasil ditambahkan.
                </div>

            </div>

        <?php elseif ($success === 'edit'): ?>

            <div class="alert alert-success">

                <div class="alert-icon">
                    ✓
                </div>

                <div>
                    Agenda berhasil diperbarui.
                </div>

            </div>

        <?php elseif ($success === 'hapus'): ?>

            <div class="alert alert-success">

                <div class="alert-icon">
                    ✓
                </div>

                <div>
                    Agenda berhasil dihapus.
                </div>

            </div>

        <?php endif; ?>


        <?php if ($error === 'hapus'): ?>

            <div class="alert alert-error">

                <div class="alert-icon">
                    !
                </div>

                <div>
                    Agenda gagal dihapus.
                </div>

            </div>

        <?php elseif ($error === 'notfound'): ?>

            <div class="alert alert-error">

                <div class="alert-icon">
                    !
                </div>

                <div>
                    Data agenda tidak ditemukan.
                </div>

            </div>

        <?php endif; ?>



        <!-- =================================================
             STATISTICS
        ================================================== -->

        <div class="stats-grid">


            <!-- TOTAL -->

            <div class="stat-card">

                <div>

                    <div class="stat-label">
                        Total Agenda
                    </div>

                    <div class="stat-number">
                        <?= $totalAgenda; ?>
                    </div>

                    <div class="stat-description">
                        Semua agenda tersimpan
                    </div>

                </div>

                <div class="stat-icon stat-pink">
                    📅
                </div>

            </div>



            <!-- AKTIF -->

            <div class="stat-card">

                <div>

                    <div class="stat-label">
                        Agenda Aktif
                    </div>

                    <div class="stat-number">
                        <?= $agendaAktif; ?>
                    </div>

                    <div class="stat-description">
                        Ditampilkan di website
                    </div>

                </div>

                <div class="stat-icon stat-green">
                    ✓
                </div>

            </div>



            <!-- NON AKTIF -->

            <div class="stat-card">

                <div>

                    <div class="stat-label">
                        Tidak Aktif
                    </div>

                    <div class="stat-number">
                        <?= $agendaNonAktif; ?>
                    </div>

                    <div class="stat-description">
                        Tidak ditampilkan
                    </div>

                </div>

                <div class="stat-icon stat-red">
                    —
                </div>

            </div>


        </div>



        <!-- =================================================
             TABLE
        ================================================== -->

        <section class="table-card">


            <!-- TABLE HEADER -->

            <div class="table-header">


                <div class="table-title">

                    <h3>
                        Daftar Agenda
                    </h3>

                    <p>
                        Data agenda Desa Sidowungu
                    </p>

                </div>


                <div class="table-count">

                    <?= $totalAgenda; ?> Agenda

                </div>


            </div>



            <!-- TABLE -->

            <div class="table-wrapper">


                <table>


                    <thead>

                        <tr>

                            <th>
                                No
                            </th>

                            <th>
                                Agenda
                            </th>

                            <th>
                                Tanggal
                            </th>

                            <th>
                                Waktu
                            </th>

                            <th>
                                Lokasi
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Aksi
                            </th>

                        </tr>

                    </thead>



                    <tbody>


                        <?php if (count($agendaRows) > 0): ?>


                            <?php
                            $no = 1;
                            ?>


                            <?php foreach ($agendaRows as $row): ?>


                                <tr>


                                    <!-- NO -->

                                    <td class="number-cell">

                                        <?= $no++; ?>

                                    </td>



                                    <!-- AGENDA -->

                                    <td>

                                        <div class="agenda-title">

                                            <?= htmlspecialchars(
                                                $row['judul']
                                            ); ?>

                                        </div>


                                        <?php if (!empty($row['deskripsi'])): ?>

                                            <div class="agenda-description">

                                                <?= htmlspecialchars(
                                                    mb_strimwidth(
                                                        $row['deskripsi'],
                                                        0,
                                                        120,
                                                        '...'
                                                    )
                                                ); ?>

                                            </div>

                                        <?php endif; ?>

                                    </td>



                                    <!-- TANGGAL -->

                                    <td>

                                        <div class="date-badge">

                                            <div class="date-icon">
                                                📅
                                            </div>

                                            <span>

                                                <?= date(
                                                    'd M Y',
                                                    strtotime(
                                                        $row['tanggal']
                                                    )
                                                ); ?>

                                            </span>

                                        </div>

                                    </td>



                                    <!-- WAKTU -->

                                    <td>

                                        <span class="time-text">

                                            <?= !empty($row['waktu'])
                                                ? htmlspecialchars(
                                                    $row['waktu']
                                                )
                                                : '-';
                                            ?>

                                        </span>

                                    </td>



                                    <!-- LOKASI -->

                                    <td>

                                        <div class="location-text">

                                            <?= !empty($row['lokasi'])
                                                ? htmlspecialchars(
                                                    $row['lokasi']
                                                )
                                                : '-';
                                            ?>

                                        </div>

                                    </td>



                                    <!-- STATUS -->

                                    <td>

                                        <?php if (
                                            $row['status'] === 'Aktif'
                                        ): ?>

                                            <span
                                                class="
                                                    status
                                                    status-aktif
                                                "
                                            >

                                                Aktif

                                            </span>

                                        <?php else: ?>

                                            <span
                                                class="
                                                    status
                                                    status-nonaktif
                                                "
                                            >

                                                Tidak Aktif

                                            </span>

                                        <?php endif; ?>

                                    </td>



                                    <!-- AKSI -->

                                    <td>

                                        <div class="action-group">


                                            <a
                                                href="edit.php?id=<?= $row['id']; ?>"
                                                class="
                                                    action-btn
                                                    edit-btn
                                                "
                                            >

                                                ✏️ Edit

                                            </a>



                                            <a
                                                href="hapus.php?id=<?= $row['id']; ?>"
                                                class="
                                                    action-btn
                                                    delete-btn
                                                "
                                                onclick="
                                                    return confirm(
                                                        'Apakah Anda yakin ingin menghapus agenda ini?'
                                                    )
                                                "
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

                                    <div class="empty-state">

                                        <div class="empty-icon">
                                            📅
                                        </div>


                                        <h4>
                                            Belum Ada Agenda
                                        </h4>


                                        <p>
                                            Silakan tambahkan agenda
                                            pertama Desa Sidowungu.
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



    <!-- =====================================================
         FOOTER
    ====================================================== -->

    <footer class="footer">

        © 2026 Pemerintah Desa Sidowungu ·
        Kecamatan Menganti · Kabupaten Gresik

    </footer>


</body>

</html>