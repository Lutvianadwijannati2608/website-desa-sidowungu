<?php

$pageTitle = "Geografis Desa";
$activeMenu = "profil";

require_once "../config/database.php";
require_once "../includes/header.php";

?>

<main>

    <!-- HERO -->
    <section class="relative min-h-[355px] flex items-center overflow-hidden">

        <img
            src="/assets/images/hero/hero5.jpeg"
            alt="Wilayah Desa Sidowungu"
            class="
                absolute
                inset-0
                w-full
                h-full
                object-cover
                object-[center_37%]
            "
        >

        <div class="absolute inset-0
                    bg-gradient-to-r
                    from-navy-950/90
                    via-navy-900/70
                    to-navy-900/35">
        </div>

        <div class="relative z-10
                    max-w-7xl mx-auto
                    w-full
                    px-4 sm:px-6 lg:px-8">

            <span class="inline-block
                         text-xs
                         font-bold
                         uppercase
                         tracking-[0.18em]
                         text-gold-400">

                PROFIL DESA

            </span>

            <h2 class="text-3xl
                       sm:text-4xl
                       font-extrabold
                       text-white
                       mt-3">

                Geografis Desa

            </h2>

            <p class="text-sm sm:text-base
                      text-slate-200
                      mt-3
                      max-w-xl
                      leading-relaxed">

                Informasi wilayah dan lokasi
                Desa Sidowungu.

            </p>

        </div>

    </section>


    <!-- CONTENT -->
    <section class="py-14 bg-slate-50">

        <div class="max-w-6xl mx-auto
                    px-4 sm:px-6 lg:px-8">

            <div class="bg-white
                        border border-slate-200
                        rounded-2xl
                        shadow-sm
                        p-8 sm:p-10 lg:p-12">

                <div class="border-b
                            border-slate-200
                            pb-5
                            mb-8">

                    <span class="text-[11px]
                                 font-bold
                                 uppercase
                                 tracking-[0.15em]
                                 text-gold-500">

                        WILAYAH DESA

                    </span>

                    <h3 class="text-2xl
                               sm:text-3xl
                               font-extrabold
                               text-navy-900
                               mt-2">

                        Desa Sidowungu

                    </h3>

                    <p class="text-sm
                              text-slate-500
                              mt-2">

                        Kecamatan Menganti, Kabupaten Gresik,
                        Provinsi Jawa Timur.

                    </p>

                </div>


                <!-- DATA WILAYAH -->

                <div class="grid sm:grid-cols-2
                            gap-5">


                    <div class="rounded-xl
                                border border-slate-200
                                bg-slate-50
                                p-5">

                        <p class="text-[11px]
                                  uppercase
                                  font-bold
                                  tracking-wider
                                  text-slate-400">

                            Desa

                        </p>

                        <p class="text-base
                                  font-bold
                                  text-navy-900
                                  mt-2">

                            Sidowungu

                        </p>

                    </div>


                    <div class="rounded-xl
                                border border-slate-200
                                bg-slate-50
                                p-5">

                        <p class="text-[11px]
                                  uppercase
                                  font-bold
                                  tracking-wider
                                  text-slate-400">

                            Kecamatan

                        </p>

                        <p class="text-base
                                  font-bold
                                  text-navy-900
                                  mt-2">

                            Menganti

                        </p>

                    </div>


                    <div class="rounded-xl
                                border border-slate-200
                                bg-slate-50
                                p-5">

                        <p class="text-[11px]
                                  uppercase
                                  font-bold
                                  tracking-wider
                                  text-slate-400">

                            Kabupaten

                        </p>

                        <p class="text-base
                                  font-bold
                                  text-navy-900
                                  mt-2">

                            Gresik

                        </p>

                    </div>


                    <div class="rounded-xl
                                border border-slate-200
                                bg-slate-50
                                p-5">

                        <p class="text-[11px]
                                  uppercase
                                  font-bold
                                  tracking-wider
                                  text-slate-400">

                            Kode Pos

                        </p>

                        <p class="text-base
                                  font-bold
                                  text-navy-900
                                  mt-2">

                            61174

                        </p>

                    </div>


                </div>


                <!-- ALAMAT -->

                <div class="mt-8
                            rounded-xl
                            border border-slate-200
                            p-6">

                    <div class="flex
                                items-start
                                gap-4">

                        <div class="w-11 h-11
                                    shrink-0
                                    rounded-xl
                                    bg-navy-900
                                    text-gold-400
                                    flex items-center
                                    justify-center">

                            📍

                        </div>


                        <div>

                            <p class="text-xs
                                      uppercase
                                      tracking-wider
                                      font-bold
                                      text-gold-500">

                                Lokasi Kantor Desa

                            </p>


                            <p class="text-sm
                                      text-slate-600
                                      mt-2
                                      leading-6">

                                Jln. Raya Sidowungu No. 50,
                                Desa Sidowungu,
                                Kecamatan Menganti,
                                Kabupaten Gresik.

                            </p>


                            <a
                                href="https://www.google.com/maps/search/?api=1&query=Desa+Sidowungu,+Kecamatan+Menganti,+Kabupaten+Gresik"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex
                                       mt-4
                                       bg-navy-900
                                       hover:bg-navy-700
                                       text-white
                                       text-xs
                                       font-bold
                                       px-4 py-2.5
                                       rounded-lg">

                                Buka Peta Wilayah →

                            </a>

                        </div>

                    </div>

                </div>


            </div>

        </div>

    </section>

</main>


<?php require_once "../includes/footer.php"; ?>