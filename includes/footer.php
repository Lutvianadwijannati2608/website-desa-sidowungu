<footer class="bg-navy-950 text-white">

    <div class="max-w-7xl mx-auto
                px-4 sm:px-6 lg:px-8
                py-12">


        <div class="grid md:grid-cols-3 gap-8">


            <div>

                <h3 class="text-xl
                           font-extrabold">

                    DESA SIDOWUNGU

                </h3>


                <p class="text-sm
                          text-slate-400
                          leading-relaxed
                          mt-3">

                    Website resmi Pemerintah
                    Desa Sidowungu,
                    Kecamatan Menganti,
                    Kabupaten Gresik.

                </p>

            </div>


            <div>

                <h4 class="font-bold
                           text-gold-400">

                    Kontak Desa

                </h4>


                <div class="mt-3
                            space-y-2
                            text-sm
                            text-slate-400">

                    <p>
                        Jln. Raya Sidowungu No. 50
                    </p>

                    <p>
                        Kecamatan Menganti,
                        Kabupaten Gresik
                    </p>

                    <p>
                        Telp. 0317917378
                    </p>

                    <p>
                        desa.sidowungu@gmail.com
                    </p>

                </div>

            </div>


            <div>

                <h4 class="font-bold
                           text-gold-400">

                    Navigasi

                </h4>


                <div class="mt-3
                            space-y-2
                            text-sm">

                    <a
                        href="/index.php"
                        class="block text-slate-400
                               hover:text-white"
                    >

                        Beranda

                    </a>


                    <a
                        href="/profil/sejarah.php"
                        class="block text-slate-400
                               hover:text-white"
                    >

                        Sejarah Desa

                    </a>


                    <a
                        href="/profil/visi-misi.php"
                        class="block text-slate-400
                               hover:text-white"
                    >

                        Visi dan Misi

                    </a>

                </div>

            </div>

        </div>


        <div class="border-t
                    border-slate-800
                    mt-10 pt-5
                    text-center">

            <p class="text-xs
                      text-slate-500">

                © <?= date('Y') ?>
                Pemerintah Desa Sidowungu.
                Semua hak dilindungi.

            </p>

        </div>

    </div>

</footer>


<!-- =====================================================
     PAGE LOADING SCRIPT
===================================================== -->

<script>

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            const loading =
                document.getElementById(
                    'pageLoading'
                );


            /*
            |--------------------------------------------------------------------------
            | HILANGKAN LOADING SETELAH HALAMAN SELESAI
            |--------------------------------------------------------------------------
            */

            window.addEventListener(
                'load',
                function () {

                    setTimeout(
                        function () {

                            if (loading) {

                                loading.classList.remove(
                                    'show'
                                );

                            }

                        },
                        300
                    );

                }
            );


            /*
            |--------------------------------------------------------------------------
            | LOADING SAAT PINDAH HALAMAN
            |--------------------------------------------------------------------------
            */

            const links =
                document.querySelectorAll(
                    'a[href]'
                );


            links.forEach(
                function (link) {

                    link.addEventListener(
                        'click',
                        function (event) {

                            const href =
                                link.getAttribute(
                                    'href'
                                );


                            /*
                            |--------------------------------------------------------------------------
                            | ABAIKAN LINK TERTENTU
                            |--------------------------------------------------------------------------
                            */

                            if (
                                !href ||
                                href === '#' ||
                                href.startsWith(
                                    'javascript:'
                                ) ||
                                href.startsWith(
                                    'mailto:'
                                ) ||
                                href.startsWith(
                                    'tel:'
                                ) ||
                                link.target === '_blank' ||
                                link.hasAttribute(
                                    'download'
                                )
                            ) {

                                return;

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | BUAT URL
                            |--------------------------------------------------------------------------
                            */

                            let url;

                            try {

                                url =
                                    new URL(
                                        href,
                                        window.location.href
                                    );

                            } catch (error) {

                                return;

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | ABAIKAN LINK KE BAGIAN TERTENTU
                            |
                            | Contoh:
                            | /index.php#peta-kantor
                            | #peta-kantor
                            |
                            | Link langsung dijalankan tanpa loading 700ms.
                            |--------------------------------------------------------------------------
                            */

                            if (url.hash) {

                                return;

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | ABAIKAN LINK EKSTERNAL
                            |--------------------------------------------------------------------------
                            */

                            if (
                                url.origin !==
                                window.location.origin
                            ) {

                                return;

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | TAMPILKAN LOADING
                            |--------------------------------------------------------------------------
                            */

                            event.preventDefault();

                            if (loading) {

                                loading.classList.add(
                                    'show'
                                );

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | PINDAH HALAMAN
                            |--------------------------------------------------------------------------
                            */

                            setTimeout(
                                function () {

                                    window.location.href =
                                        href;

                                },
                                700
                            );

                        }
                    );

                }
            );

        }
    );

</script>


</body>

</html>