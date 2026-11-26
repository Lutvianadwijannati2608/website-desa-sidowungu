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


$error = '';


// =====================================================
// PROSES TAMBAH
// =====================================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $judul =
        trim($_POST['judul'] ?? '');

    $penulis =
        trim($_POST['penulis'] ?? 'Admin Desa');

    $isi =
        trim($_POST['isi'] ?? '');

    $gambar =
        trim($_POST['gambar'] ?? '');

    $tanggal =
        $_POST['tanggal'] ?? '';


    if (
        empty($judul) ||
        empty($isi) ||
        empty($tanggal)
    ) {

        $error =
            'Judul, isi, dan tanggal wajib diisi.';

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO berita
            (
                judul,
                penulis,
                isi,
                gambar,
                tanggal
            )
            VALUES
            (?, ?, ?, ?, ?)"
        );


        $stmt->bind_param(
            "sssss",
            $judul,
            $penulis,
            $isi,
            $gambar,
            $tanggal
        );


        if ($stmt->execute()) {

            header(
                "Location: index.php?success=tambah"
            );

            exit;

        } else {

            $error =
                'Berita gagal ditambahkan.';
        }

    }

}

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
        Tambah Berita - Admin Desa Sidowungu
    </title>


    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >


    <style>

        * {
            box-sizing:
                border-box;

            margin:
                0;

            padding:
                0;
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


        .navbar {

            background:
                #0f172a;

            color:
                white;

            padding:
                18px 5%;

            display:
                flex;

            justify-content:
                space-between;

            align-items:
                center;
        }


        .brand {

            font-size:
                18px;

            font-weight:
                800;
        }


        .navbar a {

            color:
                white;

            text-decoration:
                none;

            background:
                #334155;

            padding:
                10px 14px;

            border-radius:
                10px;

            font-size:
                12px;

            font-weight:
                700;
        }


        .container {

            width:
                90%;

            max-width:
                900px;

            margin:
                40px auto 60px;
        }


        .card {

            background:
                white;

            border:
                1px solid
                #e2e8f0;

            border-radius:
                18px;

            padding:
                28px;

            box-shadow:
                0 8px 25px
                rgba(15,23,42,.05);
        }


        h2 {

            font-size:
                28px;

            font-weight:
                800;

            margin-bottom:
                8px;
        }


        .subtitle {

            color:
                #64748b;

            font-size:
                13px;

            margin-bottom:
                25px;
        }


        .form-group {

            margin-bottom:
                20px;
        }


        label {

            display:
                block;

            font-size:
                12px;

            font-weight:
                800;

            margin-bottom:
                8px;
        }


        input,
        textarea {

            width:
                100%;

            border:
                1px solid
                #cbd5e1;

            border-radius:
                10px;

            padding:
                12px 14px;

            font-family:
                inherit;

            font-size:
                13px;

            outline:
                none;
        }


        input:focus,
        textarea:focus {

            border-color:
                #ec4899;

            box-shadow:
                0 0 0 3px
                rgba(236,72,153,.10);
        }


        textarea {

            min-height:
                280px;

            resize:
                vertical;

            line-height:
                1.7;
        }


        .help {

            margin-top:
                6px;

            color:
                #94a3b8;

            font-size:
                11px;

            line-height:
                1.5;
        }


        .error {

            background:
                #fef2f2;

            border:
                1px solid
                #fecaca;

            color:
                #991b1b;

            padding:
                12px;

            border-radius:
                10px;

            font-size:
                12px;

            margin-bottom:
                20px;
        }


        .actions {

            display:
                flex;

            justify-content:
                flex-end;

            gap:
                10px;

            margin-top:
                25px;
        }


        .btn {

            text-decoration:
                none;

            border:
                none;

            padding:
                12px 18px;

            border-radius:
                10px;

            font-family:
                inherit;

            font-size:
                12px;

            font-weight:
                800;

            cursor:
                pointer;
        }


        .cancel {

            background:
                #f1f5f9;

            color:
                #475569;
        }


        .save {

            background:
                #ec4899;

            color:
                white;
        }


        .save:hover {

            background:
                #db2777;
        }


        @media (max-width: 600px) {

            .actions {

                flex-direction:
                    column;
            }


            .btn {

                width:
                    100%;

                text-align:
                    center;
            }

        }

    </style>

</head>


<body>


<nav class="navbar">

    <div class="brand">
        Admin Desa Sidowungu
    </div>


    <a href="index.php">
        Kembali
    </a>

</nav>



<main class="container">

    <section class="card">

        <h2>
            Tambah Berita
        </h2>


        <p class="subtitle">
            Tambahkan artikel atau informasi terbaru Desa Sidowungu.
        </p>


        <?php if (!empty($error)): ?>

            <div class="error">
                <?= htmlspecialchars(
                    $error,
                    ENT_QUOTES,
                    'UTF-8'
                ); ?>
            </div>

        <?php endif; ?>


        <form
            method="POST"
        >


            <!-- JUDUL -->

            <div class="form-group">

                <label>
                    Judul Berita *
                </label>


                <input
                    type="text"
                    name="judul"
                    placeholder="Masukkan judul berita"
                    value="<?= htmlspecialchars(
                        $_POST['judul'] ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    ); ?>"
                    required
                >

            </div>



            <!-- PENULIS -->

            <div class="form-group">

                <label>
                    Penulis
                </label>


                <input
                    type="text"
                    name="penulis"
                    value="<?= htmlspecialchars(
                        $_POST['penulis'] ??
                        'Admin Desa',
                        ENT_QUOTES,
                        'UTF-8'
                    ); ?>"
                >

            </div>



            <!-- TANGGAL -->

            <div class="form-group">

                <label>
                    Tanggal *
                </label>


                <input
                    type="date"
                    name="tanggal"
                    value="<?= htmlspecialchars(
                        $_POST['tanggal'] ??
                        date('Y-m-d'),
                        ENT_QUOTES,
                        'UTF-8'
                    ); ?>"
                    required
                >

            </div>



            <!-- GAMBAR -->

            <div class="form-group">

                <label>
                    URL Gambar
                </label>


                <input
                    type="text"
                    name="gambar"
                    placeholder="https://contoh.com/gambar.jpg"
                    value="<?= htmlspecialchars(
                        $_POST['gambar'] ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    ); ?>"
                >


                <p class="help">

                    Masukkan URL gambar yang akan ditampilkan pada berita.

                </p>

            </div>



            <!-- ISI -->

            <div class="form-group">

                <label>
                    Isi Berita *
                </label>


                <textarea
                    name="isi"
                    placeholder="Tuliskan isi berita..."
                    required
                ><?= htmlspecialchars(
                    $_POST['isi'] ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                ); ?></textarea>

            </div>



            <!-- BUTTON -->

            <div class="actions">

                <a
                    href="index.php"
                    class="btn cancel"
                >
                    Batal
                </a>


                <button
                    type="submit"
                    class="btn save"
                >
                    Simpan Berita
                </button>

            </div>


        </form>

    </section>

</main>

</body>

</html>