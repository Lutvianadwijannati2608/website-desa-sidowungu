<?php

$pageTitle = "Data Jenis Kelamin";
$activeMenu = "statistik";

require_once "../config/database.php";
require_once "../includes/header.php";


/*
|--------------------------------------------------------------------------
| AMBIL DATA JENIS KELAMIN DARI DATABASE
|--------------------------------------------------------------------------
*/

$dataJenisKelamin = [];

$query = "
    SELECT
        kode,
        kelompok,
        jumlah,
        persentase,
        laki_laki,
        laki_laki_persen,
        perempuan,
        perempuan_persen
    FROM statistik_penduduk
    WHERE jenis_statistik = 'jenis_kelamin'
    ORDER BY kode ASC
";

$result = $conn->query($query);

if ($result) {

    while ($row = $result->fetch_assoc()) {

        $dataJenisKelamin[] = $row;

    }

}


/*
|--------------------------------------------------------------------------
| HITUNG TOTAL
|--------------------------------------------------------------------------
*/

$totalJumlah = 0;
$totalLaki = 0;
$totalPerempuan = 0;
$totalBelumMengisi = 0;

foreach ($dataJenisKelamin as $data) {

    $totalJumlah += (int) $data["jumlah"];

    $totalLaki += (int) $data["laki_laki"];

    $totalPerempuan += (int) $data["perempuan"];

    if (
        strtoupper(trim($data["kelompok"])) ===
        "BELUM MENGISI"
    ) {

        $totalBelumMengisi =
            (int) $data["jumlah"];

    }

}

?>


<style>

    .stat-page {
        background: #f8fafc;
    }


    .stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.05);
    }


    .stat-title {
        border-left: 6px solid #1e2a9a;
        padding-left: 18px;
    }


    .chart-box {
        position: relative;
        height: 600px;
    }


    .stat-table {
        width: 100%;
        border-collapse: collapse;
    }


    .stat-table th,
    .stat-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #e2e8f0;
    }


    .stat-table th {
        background: #0b1324;
        color: #ffffff;
        font-weight: 700;
    }


    .stat-table tbody tr:hover td {
        background: #f8fafc;
    }


    .btn-stat {
        padding: 9px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: 0.2s;
    }


    .btn-primary {
        background: #2563eb;
        color: white;
    }


    .btn-primary:hover {
        background: #1d4ed8;
    }


    .btn-secondary {
        background: white;
        color: #334155;
        border: 1px solid #cbd5e1;
    }


    .btn-secondary:hover {
        background: #f8fafc;
    }


    .btn-success {
        background: #16a34a;
        color: white;
    }


    .btn-success:hover {
        background: #15803d;
    }


    @media print {

        header,
        footer,
        .no-print {
            display: none !important;
        }

        .stat-card {
            box-shadow: none;
        }

    }

</style>



<main class="stat-page">


    <!-- ================================================= -->
    <!-- HEADER -->
    <!-- ================================================= -->

    <section class="bg-white
                    border-b
                    border-slate-200
                    py-12">


        <div class="max-w-7xl
                    mx-auto
                    px-4 sm:px-6 lg:px-8">


            <div class="stat-title">


                <p class="text-xs
                          font-bold
                          uppercase
                          tracking-[0.18em]
                          text-gold-500">

                    STATISTIK DESA

                </p>


                <h1 class="text-3xl
                           sm:text-4xl
                           font-extrabold
                           text-navy-900
                           mt-2">

                    Data Jenis Kelamin

                </h1>


                <p class="text-sm
                          sm:text-base
                          text-slate-500
                          mt-3
                          max-w-3xl">

                    Jumlah penduduk berdasarkan
                    jenis kelamin di Desa Sidowungu.

                </p>

            </div>

        </div>

    </section>



    <!-- ================================================= -->
    <!-- CONTENT -->
    <!-- ================================================= -->

    <section class="py-14">


        <div class="max-w-7xl
                    mx-auto
                    px-4 sm:px-6 lg:px-8">


            <!-- BUTTON -->

            <div class="flex flex-wrap
                        gap-2
                        no-print
                        mb-5">


                <button
                    onclick="showChart('bar')"
                    class="btn-stat btn-primary">

                    Bar Graph

                </button>


                <button
                    onclick="showChart('doughnut')"
                    class="btn-stat btn-secondary">

                    Pie Chart

                </button>


                <button
                    onclick="window.print()"
                    class="btn-stat btn-primary">

                    🖨 Cetak

                </button>


                <button
                    onclick="downloadCSV()"
                    class="btn-stat btn-success">

                    ↓ Unduh

                </button>

            </div>



            <!-- RINGKASAN -->

            <div class="grid
                        sm:grid-cols-2
                        lg:grid-cols-4
                        gap-5
                        mb-6">


                <div class="stat-card p-6">

                    <p class="text-xs
                              text-slate-400
                              font-semibold">

                        Total Penduduk

                    </p>


                    <p class="text-3xl
                              font-extrabold
                              text-navy-900
                              mt-2">

                        <?= number_format(
                            $totalJumlah,
                            0,
                            ',',
                            '.'
                        ) ?>

                    </p>

                </div>



                <div class="stat-card p-6">

                    <p class="text-xs
                              text-slate-400
                              font-semibold">

                        Laki-laki

                    </p>


                    <p class="text-3xl
                              font-extrabold
                              text-navy-900
                              mt-2">

                        <?= number_format(
                            $totalLaki,
                            0,
                            ',',
                            '.'
                        ) ?>

                    </p>

                </div>



                <div class="stat-card p-6">

                    <p class="text-xs
                              text-slate-400
                              font-semibold">

                        Perempuan

                    </p>


                    <p class="text-3xl
                              font-extrabold
                              text-navy-900
                              mt-2">

                        <?= number_format(
                            $totalPerempuan,
                            0,
                            ',',
                            '.'
                        ) ?>

                    </p>

                </div>



                <div class="stat-card p-6">

                    <p class="text-xs
                              text-slate-400
                              font-semibold">

                        Belum Mengisi

                    </p>


                    <p class="text-3xl
                              font-extrabold
                              text-navy-900
                              mt-2">

                        <?= number_format(
                            $totalBelumMengisi,
                            0,
                            ',',
                            '.'
                        ) ?>

                    </p>

                </div>

            </div>



            <!-- ================================================= -->
            <!-- CHART -->
            <!-- ================================================= -->

            <div class="stat-card
                        p-6 sm:p-8
                        mb-6">


                <div class="mb-5">


                    <p class="text-xs
                              uppercase
                              font-bold
                              tracking-wider
                              text-gold-500">

                        GRAFIK

                    </p>


                    <h2 class="text-xl
                               font-extrabold
                               text-navy-900
                               mt-1">

                        Distribusi Jenis Kelamin

                    </h2>

                </div>


                <div class="chart-box">

                    <canvas id="jenisKelaminChart"></canvas>

                </div>

            </div>



            <!-- ================================================= -->
            <!-- TABLE -->
            <!-- ================================================= -->

            <div class="stat-card
                        overflow-hidden">


                <div class="px-6 py-5
                            border-b
                            border-slate-200">


                    <h2 class="text-xl
                               font-extrabold
                               text-navy-900">

                        Tabel Jenis Kelamin

                    </h2>


                    <p class="text-xs
                              text-slate-400
                              mt-1">

                        Data diambil dari database
                        Desa Sidowungu.

                    </p>

                </div>


                <div class="overflow-x-auto">


                    <table class="stat-table">


                        <thead>

                            <tr>

                                <th rowspan="2">
                                    Kode
                                </th>

                                <th rowspan="2">
                                    Kelompok
                                </th>

                                <th colspan="2"
                                    class="text-center">

                                    Jumlah

                                </th>

                                <th colspan="2"
                                    class="text-center">

                                    Laki-laki

                                </th>

                                <th colspan="2"
                                    class="text-center">

                                    Perempuan

                                </th>

                            </tr>


                            <tr>

                                <th class="text-right">
                                    n
                                </th>

                                <th class="text-right">
                                    %
                                </th>

                                <th class="text-right">
                                    n
                                </th>

                                <th class="text-right">
                                    %
                                </th>

                                <th class="text-right">
                                    n
                                </th>

                                <th class="text-right">
                                    %
                                </th>

                            </tr>

                        </thead>


                        <tbody>


                            <?php foreach ($dataJenisKelamin as $data): ?>


                                <tr>


                                    <td class="text-slate-500">

                                        <?= htmlspecialchars(
                                            $data["kode"]
                                        ) ?>

                                    </td>


                                    <td class="font-medium
                                               text-slate-700">

                                        <?= htmlspecialchars(
                                            $data["kelompok"]
                                        ) ?>

                                    </td>


                                    <td class="text-right
                                               font-semibold
                                               text-slate-800">

                                        <?= number_format(
                                            $data["jumlah"],
                                            0,
                                            ',',
                                            '.'
                                        ) ?>

                                    </td>


                                    <td class="text-right
                                               text-slate-500">

                                        <?= number_format(
                                            $data["persentase"],
                                            2,
                                            ',',
                                            '.'
                                        ) ?>%

                                    </td>


                                    <td class="text-right">

                                        <?= number_format(
                                            $data["laki_laki"],
                                            0,
                                            ',',
                                            '.'
                                        ) ?>

                                    </td>


                                    <td class="text-right
                                               text-slate-500">

                                        <?= number_format(
                                            $data["laki_laki_persen"],
                                            2,
                                            ',',
                                            '.'
                                        ) ?>%

                                    </td>


                                    <td class="text-right">

                                        <?= number_format(
                                            $data["perempuan"],
                                            0,
                                            ',',
                                            '.'
                                        ) ?>

                                    </td>


                                    <td class="text-right
                                               text-slate-500">

                                        <?= number_format(
                                            $data["perempuan_persen"],
                                            2,
                                            ',',
                                            '.'
                                        ) ?>%

                                    </td>


                                </tr>


                            <?php endforeach; ?>


                            <!-- JUMLAH -->

                            <tr class="bg-slate-50 font-bold">


                                <td></td>


                                <td class="text-navy-900">

                                    JUMLAH

                                </td>


                                <td class="text-right
                                           text-navy-900">

                                    7.645

                                </td>


                                <td class="text-right">

                                    100,00%

                                </td>


                                <td class="text-right
                                           text-navy-900">

                                    3.866

                                </td>


                                <td class="text-right">

                                    50,57%

                                </td>


                                <td class="text-right
                                           text-navy-900">

                                    3.779

                                </td>


                                <td class="text-right">

                                    49,43%

                                </td>

                            </tr>


                            <!-- BELUM MENGISI -->

                            <tr>


                                <td></td>


                                <td class="font-medium">

                                    BELUM MENGISI

                                </td>


                                <td class="text-right">

                                    0

                                </td>


                                <td class="text-right">

                                    0,00%

                                </td>


                                <td class="text-right">

                                    0

                                </td>


                                <td class="text-right">

                                    0,00%

                                </td>


                                <td class="text-right">

                                    0

                                </td>


                                <td class="text-right">

                                    0,00%

                                </td>

                            </tr>


                            <!-- TOTAL -->

                            <tr class="bg-navy-900
                                       text-white
                                       font-bold">


                                <td></td>


                                <td>

                                    TOTAL

                                </td>


                                <td class="text-right">

                                    7.645

                                </td>


                                <td class="text-right">

                                    100,00%

                                </td>


                                <td class="text-right">

                                    3.866

                                </td>


                                <td class="text-right">

                                    50,57%

                                </td>


                                <td class="text-right">

                                    3.779

                                </td>


                                <td class="text-right">

                                    49,43%

                                </td>

                            </tr>


                        </tbody>

                    </table>

                </div>

            </div>


        </div>

    </section>

</main>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>

const jenisKelaminLabels = [

    <?php foreach ($dataJenisKelamin as $data): ?>

        <?= json_encode(
            $data["kelompok"]
        ) ?>,

    <?php endforeach; ?>

];


const jenisKelaminValues = [

    <?php foreach ($dataJenisKelamin as $data): ?>

        <?= (int) $data["jumlah"] ?>,

    <?php endforeach; ?>

];


const canvas =
    document.getElementById(
        "jenisKelaminChart"
    );


let jenisKelaminChart;


function createChart(type)
{

    if (jenisKelaminChart) {

        jenisKelaminChart.destroy();

    }


    jenisKelaminChart = new Chart(

        canvas,

        {

            type: type,

            data: {

                labels: jenisKelaminLabels,

                datasets: [

                    {

                        label: "Jumlah Penduduk",

                        data: jenisKelaminValues,

                        borderWidth: 1

                    }

                ]

            },


            options: {

                responsive: true,

                maintainAspectRatio: false,


                plugins: {

                    legend: {

                        display:
                            type === "doughnut",

                        position: "bottom"

                    }

                },


                scales:

                    type === "bar"

                    ? {

                        y: {

                            beginAtZero: true,

                            ticks: {

                                precision: 0

                            }

                        }

                    }

                    : {}

            }

        }

    );

}


function showChart(type)
{

    createChart(type);

}


function downloadCSV()
{

    let csv =
        "Kode,Kelompok,Jumlah,Persentase,Laki-laki,Persentase Laki-laki,Perempuan,Persentase Perempuan\n";


    <?php foreach ($dataJenisKelamin as $data): ?>

        csv +=

            <?= json_encode(
                $data["kode"] . "," .
                $data["kelompok"] . "," .
                $data["jumlah"] . "," .
                $data["persentase"] . "," .
                $data["laki_laki"] . "," .
                $data["laki_laki_persen"] . "," .
                $data["perempuan"] . "," .
                $data["perempuan_persen"] . "\n"
            ) ?>;

    <?php endforeach; ?>


    const blob =
        new Blob(
            [csv],
            {
                type:
                    "text/csv;charset=utf-8;"
            }
        );


    const url =
        URL.createObjectURL(blob);


    const link =
        document.createElement("a");


    link.href = url;


    link.download =
        "data-jenis-kelamin-desa-sidowungu.csv";


    document.body.appendChild(link);

    link.click();

    document.body.removeChild(link);


    URL.revokeObjectURL(url);

}


createChart("bar");

</script>


<?php require_once "../includes/footer.php"; ?>