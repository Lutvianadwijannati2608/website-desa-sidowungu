<?php

$pageTitle = 'Struktur Organisasi';
$activeMenu = 'profil';

?>

<?php include __DIR__ . '/../includes/header.php'; ?>


<main>

    <!-- =====================================================
         HERO
    ===================================================== -->

    <section
        class="
            relative
            min-h-[355px]
            flex
            items-center
            overflow-hidden
        "
    >

        <img
            src="/assets/images/hero/hero1.jpg"
            alt="Pemerintah Desa Sidowungu"
            class="
                absolute
                inset-0
                w-full
                h-full
                object-cover
                object-center
            "
        >


        <div
            class="
                absolute
                inset-0
                bg-gradient-to-r
                from-navy-950/90
                via-navy-900/70
                to-navy-900/35
            "
        >
        </div>


        <div
            class="
                relative
                z-10
                max-w-7xl
                mx-auto
                w-full
                px-4
                sm:px-6
                lg:px-8
            "
        >

            <span
                class="
                    inline-block
                    text-xs
                    font-bold
                    uppercase
                    tracking-[0.18em]
                    text-gold-400
                "
            >

                PEMERINTAH DESA

            </span>


            <h1
                class="
                    text-3xl
                    sm:text-4xl
                    font-extrabold
                    text-white
                    mt-3
                    leading-tight
                "
            >

                Struktur Organisasi Desa Sidowungu

            </h1>


            <p
                class="
                    text-sm
                    sm:text-base
                    text-slate-200
                    mt-3
                    max-w-2xl
                    leading-relaxed
                "
            >

                Susunan perangkat Pemerintah Desa Sidowungu
                dalam mendukung penyelenggaraan pemerintahan
                dan pelayanan kepada masyarakat.

            </p>

        </div>

    </section>


    <!-- =====================================================
         ISI STRUKTUR
    ===================================================== -->

    <section class="bg-slate-50">

        <div
            class="
                max-w-7xl
                mx-auto
                px-6
                sm:px-8
                lg:px-10
                py-12
            "
        >


            <!-- =================================================
                 KEPALA DESA
            ================================================= -->

            <div class="mb-8">

                <p
                    class="
                        text-xs
                        font-bold
                        tracking-[0.15em]
                        text-amber-600
                        uppercase
                    "
                >

                    Pimpinan Desa

                </p>


                <h2
                    class="
                        text-2xl
                        md:text-3xl
                        font-bold
                        text-slate-950
                        mt-2
                    "
                >

                    Kepala Desa

                </h2>

            </div>


            <!-- KARTU KEPALA DESA -->

            <div
                class="
                    max-w-[280px]
                    mx-auto
                    mb-14
                "
            >

                <div
                    class="
                        bg-white
                        rounded-3xl
                        overflow-hidden
                        border
                        border-slate-200
                        shadow-sm
                        hover:shadow-lg
                        hover:-translate-y-1
                        transition-all
                        duration-300
                    "
                >

                    <div
                        class="
                            h-64
                            bg-slate-100
                            overflow-hidden
                        "
                    >

                        <img
                            src="/assets/images/profil/suedi.jpeg"
                            alt="Suedi - Kepala Desa"
                            class="
                                w-full
                                h-full
                                object-cover
                                object-center
                            "
                        >

                    </div>


                    <div class="p-5 text-center">

                        <p
                            class="
                                text-[10px]
                                font-semibold
                                text-amber-600
                                uppercase
                                tracking-widest
                            "
                        >

                            Kepala Desa

                        </p>


                        <h3
                            class="
                                text-xl
                                font-bold
                                text-slate-950
                                mt-1
                            "
                        >

                            Suedi

                        </h3>

                    </div>

                </div>

            </div>



            <!-- =================================================
                 PERANGKAT DESA
            ================================================= -->

            <div class="mb-8">

                <p
                    class="
                        text-xs
                        font-bold
                        tracking-[0.15em]
                        text-amber-600
                        uppercase
                    "
                >

                    Perangkat Desa

                </p>


                <h2
                    class="
                        text-2xl
                        md:text-3xl
                        font-bold
                        text-slate-950
                        mt-2
                    "
                >

                    Susunan Perangkat Desa

                </h2>

            </div>


            <?php

            $perangkat = [

                [
                    'nama' => 'Adi Siswanto',
                    'jabatan' => 'Sekretaris Desa',
                    'foto' => 'adi.jpeg'
                ],

                [
                    'nama' => 'Fitri Hani Halim',
                    'jabatan' => 'Kaur Keuangan',
                    'foto' => 'fitri.jpeg'
                ],

                [
                    'nama' => 'A Hasan Mangun Basuki',
                    'jabatan' => 'Kaur Perencanaan',
                    'foto' => 'hasan.jpeg'
                ],

                [
                    'nama' => 'Edi Sujiat',
                    'jabatan' => 'Kasi Pemerintahan',
                    'foto' => 'sujiat.jpeg'
                ],

                [
                    'nama' => 'Mukhamad Sugeng',
                    'jabatan' => 'Kasi Pelayanan',
                    'foto' => 'sugeng.jpeg'
                ],

                [
                    'nama' => 'Imam Hartoyo',
                    'jabatan' => 'Kasun Balong Dinding',
                    'foto' => 'imam.jpeg'
                ],

                [
                    'nama' => 'Rosyidin',
                    'jabatan' => 'Kasun Sidowungu',
                    'foto' => 'rasyidin.jpeg'
                ]

            ];

            ?>


            <!-- =================================================
                 GRID PERANGKAT
            ================================================= -->

            <div
                class="
                    grid
                    grid-cols-1
                    sm:grid-cols-2
                    lg:grid-cols-4
                    gap-x-6
                    gap-y-16
                    pb-16
                "
            >


                <?php foreach ($perangkat as $orang): ?>

                    <div
                        class="
                            bg-white
                            rounded-3xl
                            overflow-hidden
                            border
                            border-slate-200
                            shadow-sm
                            hover:shadow-lg
                            hover:-translate-y-1
                            transition-all
                            duration-300
                        "
                    >

                        <!-- FOTO -->

                        <div
                            class="
                                h-72
                                bg-slate-100
                                overflow-hidden
                            "
                        >

                            <img
                                src="/assets/images/profil/<?= htmlspecialchars($orang['foto']); ?>"
                                alt="<?= htmlspecialchars($orang['nama']); ?>"
                                class="
                                    w-full
                                    h-full
                                    object-cover
                                    object-center
                                "
                            >

                        </div>


                        <!-- DATA -->

                        <div class="p-5">

                            <p
                                class="
                                    text-[10px]
                                    font-semibold
                                    text-amber-600
                                    uppercase
                                    tracking-widest
                                    leading-relaxed
                                "
                            >

                                <?= htmlspecialchars(
                                    $orang['jabatan']
                                ); ?>

                            </p>


                            <h3
                                class="
                                    text-lg
                                    font-bold
                                    text-slate-950
                                    mt-1
                                    leading-tight
                                "
                            >

                                <?= htmlspecialchars(
                                    $orang['nama']
                                ); ?>

                            </h3>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        </div>

    </section>

</main>


<?php include __DIR__ . '/../includes/footer.php'; ?>