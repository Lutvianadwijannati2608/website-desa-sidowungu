<?php

session_start();

if (
    !isset($_SESSION['admin_login']) ||
    $_SESSION['admin_login'] !== true
) {
    header('Location: /admin/login.php');
    exit;
}


require_once "../../config/database.php";


$pageTitle = "Tambah Agenda";


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


/*
|--------------------------------------------------------------------------
| DATA AWAL
|--------------------------------------------------------------------------
*/

$judul = '';
$tanggal = '';
$waktu = '';
$lokasi = '';
$deskripsi = '';
$status = 'Aktif';

$error = '';


/*
|--------------------------------------------------------------------------
| PROSES SIMPAN
|--------------------------------------------------------------------------
*/

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
) {

    $judul =
        trim(
            $_POST['judul'] ?? ''
        );


    $tanggal =
        trim(
            $_POST['tanggal'] ?? ''
        );


    $waktu =
        trim(
            $_POST['waktu'] ?? ''
        );


    $lokasi =
        trim(
            $_POST['lokasi'] ?? ''
        );


    $deskripsi =
        trim(
            $_POST['deskripsi'] ?? ''
        );


    $status =
        $_POST['status'] ?? 'Aktif';


    /*
    |--------------------------------------------------------------------------
    | VALIDASI
    |--------------------------------------------------------------------------
    */

    if (
        $judul === '' ||
        $tanggal === ''
    ) {

        $error =
            'Judul agenda dan tanggal wajib diisi.';

    }


    /*
    |--------------------------------------------------------------------------
    | VALIDASI STATUS
    |--------------------------------------------------------------------------
    */

    if (
        $error === '' &&
        !in_array(
            $status,
            [
                'Aktif',
                'Tidak Aktif'
            ],
            true
        )
    ) {

        $status = 'Aktif';

    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN KE DATABASE
    |--------------------------------------------------------------------------
    */

    if ($error === '') {

        $stmt =
            $conn->prepare(
                "INSERT INTO agenda
                (
                    judul,
                    tanggal,
                    waktu,
                    lokasi,
                    deskripsi,
                    status
                )
                VALUES
                (
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?
                )"
            );


        if ($stmt) {

            $stmt->bind_param(
                "ssssss",
                $judul,
                $tanggal,
                $waktu,
                $lokasi,
                $deskripsi,
                $status
            );


            if (
                $stmt->execute()
            ) {

                header(
                    'Location: index.php?success=tambah'
                );

                exit;

            } else {

                $error =
                    'Agenda gagal disimpan.';

            }


            $stmt->close();

        } else {

            $error =
                'Query database gagal dibuat.';

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
        <?= e($pageTitle) ?> - Admin Desa Sidowungu
    </title>


    <script
        src="https://cdn.tailwindcss.com"
    ></script>

</head>


<body
    class="bg-slate-100
           text-slate-800"
>


<!-- ===================================================== -->
<!-- HEADER -->
<!-- ===================================================== -->

<header
    class="text-white
           shadow-sm"
    style="background:#0f172a;"
>

    <div
        class="max-w-7xl
               mx-auto
               px-4
               sm:px-6
               lg:px-8"
    >

        <div
            class="h-20
                   flex
                   items-center
                   justify-between"
        >

            <div>

                <p
                    class="text-xs
                           text-amber-400
                           uppercase
                           tracking-widest
                           font-bold"
                >

                    Admin Desa

                </p>


                <h1
                    class="text-xl
                           sm:text-2xl
                           font-extrabold
                           mt-1"
                >

                    Tambah Agenda

                </h1>

            </div>


            <div
                class="flex
                       items-center
                       gap-3"
            >

                <a
                    href="index.php"
                    class="px-4
                           py-2
                           rounded-lg
                           bg-white/10
                           hover:bg-white/20
                           text-sm
                           font-semibold
                           transition"
                >

                    ← Kembali

                </a>


                <a
                    href="/admin/logout.php"
                    class="px-4
                           py-2
                           rounded-lg
                           bg-red-500
                           hover:bg-red-600
                           text-white
                           text-sm
                           font-semibold
                           transition"
                >

                    Logout

                </a>

            </div>

        </div>

    </div>

</header>



<!-- ===================================================== -->
<!-- CONTENT -->
<!-- ===================================================== -->

<main
    class="max-w-4xl
           mx-auto
           px-4
           sm:px-6
           lg:px-8
           py-10"
>


    <div
        class="mb-8"
    >

        <p
            class="text-xs
                   uppercase
                   tracking-widest
                   font-bold
                   text-amber-600"
        >

            Kalender & Agenda

        </p>


        <h2
            class="text-3xl
                   font-extrabold
                   text-slate-900
                   mt-1"
        >

            Tambah Agenda Desa

        </h2>


        <p
            class="text-sm
                   text-slate-500
                   mt-2"
        >

            Tambahkan agenda yang nantinya dapat ditampilkan
            pada kalender website Desa Sidowungu.

        </p>

    </div>



    <!-- =================================================
         ERROR
    ================================================== -->

    <?php if ($error !== ''): ?>

        <div
            class="mb-6
                   rounded-xl
                   border
                   border-red-200
                   bg-red-50
                   px-5
                   py-4
                   text-sm
                   text-red-700"
        >

            <?= e($error) ?>

        </div>

    <?php endif; ?>



    <!-- =================================================
         FORM
    ================================================== -->

    <form
        method="POST"
        action=""
        class="bg-white
               border
               border-slate-200
               rounded-2xl
               shadow-sm
               overflow-hidden"
    >


        <!-- FORM HEADER -->

        <div
            class="px-6
                   sm:px-8
                   py-5
                   border-b
                   border-slate-200
                   bg-slate-50"
        >

            <h3
                class="font-bold
                       text-slate-900"
            >

                Informasi Agenda

            </h3>


            <p
                class="text-xs
                       text-slate-500
                       mt-1"
            >

                Isi informasi agenda dengan lengkap.

            </p>

        </div>



        <!-- FORM BODY -->

        <div
            class="p-6
                   sm:p-8
                   space-y-6"
        >


            <!-- JUDUL -->

            <div>

                <label
                    for="judul"
                    class="block
                           text-sm
                           font-bold
                           text-slate-700
                           mb-2"
                >

                    Judul Agenda
                    <span class="text-red-500">*</span>

                </label>


                <input
                    type="text"
                    id="judul"
                    name="judul"
                    value="<?= e($judul) ?>"
                    placeholder="Contoh: Sedekah Bumi Desa Sidowungu"
                    required
                    class="w-full
                           px-4
                           py-3
                           rounded-xl
                           border
                           border-slate-300
                           focus:outline-none
                           focus:ring-2
                           focus:ring-slate-900/10
                           focus:border-slate-500
                           text-sm"
                >

            </div>



            <!-- TANGGAL + WAKTU -->

            <div
                class="grid
                       md:grid-cols-2
                       gap-5"
            >


                <!-- TANGGAL -->

                <div>

                    <label
                        for="tanggal"
                        class="block
                               text-sm
                               font-bold
                               text-slate-700
                               mb-2"
                    >

                        Tanggal
                        <span class="text-red-500">*</span>

                    </label>


                    <input
                        type="date"
                        id="tanggal"
                        name="tanggal"
                        value="<?= e($tanggal) ?>"
                        required
                        class="w-full
                               px-4
                               py-3
                               rounded-xl
                               border
                               border-slate-300
                               focus:outline-none
                               focus:ring-2
                               focus:ring-slate-900/10
                               focus:border-slate-500
                               text-sm"
                    >

                </div>



                <!-- WAKTU -->

                <div>

                    <label
                        for="waktu"
                        class="block
                               text-sm
                               font-bold
                               text-slate-700
                               mb-2"
                    >

                        Waktu

                    </label>


                    <input
                        type="text"
                        id="waktu"
                        name="waktu"
                        value="<?= e($waktu) ?>"
                        placeholder="Contoh: 08.00 WIB"
                        class="w-full
                               px-4
                               py-3
                               rounded-xl
                               border
                               border-slate-300
                               focus:outline-none
                               focus:ring-2
                               focus:ring-slate-900/10
                               focus:border-slate-500
                               text-sm"
                    >

                </div>

            </div>



            <!-- LOKASI -->

            <div>

                <label
                    for="lokasi"
                    class="block
                           text-sm
                           font-bold
                           text-slate-700
                           mb-2"
                >

                    Lokasi

                </label>


                <input
                    type="text"
                    id="lokasi"
                    name="lokasi"
                    value="<?= e($lokasi) ?>"
                    placeholder="Contoh: Balai Desa Sidowungu"
                    class="w-full
                           px-4
                           py-3
                           rounded-xl
                           border
                           border-slate-300
                           focus:outline-none
                           focus:ring-2
                           focus:ring-slate-900/10
                           focus:border-slate-500
                           text-sm"
                >

            </div>



            <!-- DESKRIPSI -->

            <div>

                <label
                    for="deskripsi"
                    class="block
                           text-sm
                           font-bold
                           text-slate-700
                           mb-2"
                >

                    Deskripsi Agenda

                </label>


                <textarea
                    id="deskripsi"
                    name="deskripsi"
                    rows="5"
                    placeholder="Tuliskan informasi atau keterangan tambahan mengenai agenda..."
                    class="w-full
                           px-4
                           py-3
                           rounded-xl
                           border
                           border-slate-300
                           focus:outline-none
                           focus:ring-2
                           focus:ring-slate-900/10
                           focus:border-slate-500
                           text-sm
                           resize-none"
                ><?= e($deskripsi) ?></textarea>

            </div>



            <!-- STATUS -->

            <div>

                <label
                    for="status"
                    class="block
                           text-sm
                           font-bold
                           text-slate-700
                           mb-2"
                >

                    Status

                </label>


                <select
                    id="status"
                    name="status"
                    class="w-full
                           px-4
                           py-3
                           rounded-xl
                           border
                           border-slate-300
                           focus:outline-none
                           focus:ring-2
                           focus:ring-slate-900/10
                           focus:border-slate-500
                           text-sm"
                >

                    <option
                        value="Aktif"
                        <?= $status === 'Aktif'
                            ? 'selected'
                            : ''
                        ?>
                    >

                        Aktif

                    </option>


                    <option
                        value="Tidak Aktif"
                        <?= $status === 'Tidak Aktif'
                            ? 'selected'
                            : ''
                        ?>
                    >

                        Tidak Aktif

                    </option>

                </select>


                <p
                    class="text-xs
                           text-slate-400
                           mt-2"
                >

                    Agenda dengan status Aktif dapat digunakan
                    untuk ditampilkan pada website.

                </p>

            </div>

        </div>



        <!-- FORM FOOTER -->

        <div
            class="px-6
                   sm:px-8
                   py-5
                   border-t
                   border-slate-200
                   bg-slate-50
                   flex
                   flex-col-reverse
                   sm:flex-row
                   sm:items-center
                   sm:justify-between
                   gap-3"
        >


            <a
                href="index.php"
                class="inline-flex
                       items-center
                       justify-center
                       px-5
                       py-3
                       rounded-xl
                       border
                       border-slate-300
                       bg-white
                       text-slate-700
                       text-sm
                       font-bold
                       hover:bg-slate-100
                       transition"
            >

                Batal

            </a>


            <button
                type="submit"
                class="inline-flex
                       items-center
                       justify-center
                       px-6
                       py-3
                       rounded-xl
                       bg-slate-900
                       hover:bg-slate-800
                       text-white
                       text-sm
                       font-bold
                       transition"
            >

                Simpan Agenda

            </button>

        </div>

    </form>

</main>


</body>

</html>