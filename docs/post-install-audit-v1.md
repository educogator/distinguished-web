# Audit selepas pemasangan v1

Tarikh: 28 Oktober 2026. Laman: https://distinguished.mckk.edu.my/.
Semua pemeriksaan produksi menggunakan GET/HEAD awam sahaja. Tiada log masuk, pangkalan
data, pentadbiran, penukaran tetapan atau pemasangan dilakukan pada produksi.

## Bukti semasa

Berbeza daripada audit awal, laman, REST API awam dan sitemap kini boleh dicapai (HTTP
200). API mendedahkan 22 halaman diterbitkan dan 9 pos diterbitkan dalam satu halaman
keputusan setiap jenis. Homepage memaut ke halaman ID 2, slug `sample-page`, dengan tajuk
kosong. Kandungan awam semasanya ialah petikan Steve Jobs. Ia dikekalkan; kandungan lama
yang tiada dalam respons semasa tidak dipulihkan atau dianggap selamat dipadam.

HTML mengesahkan tema `mckk-ads-showcase` versi 1.0.0. Tajuk tapak kini “Under Maintenance!”,
tagline “We Create!”, dan logo media perpustakaan wujud. Ini tetapan pentadbir, bukan teks
yang akan diganti oleh kod tema. PHP dilaporkan melalui header sebagai 8.4.27; versi
WordPress sebenar dan plugin aktif tidak boleh dipastikan hanya daripada pemerhatian ini.

## Penemuan dan tindakan

| Penemuan disahkan | Kesan | Pembetulan / tindakan |
| --- | --- | --- |
| Hero menggunakan `IMG_6730-2.tif` | Chromium gagal menyahkod imej; panel hero kelihatan kosong | Terima format web/derivatif yang disokong sahaja; paparkan ilustrasi konsep jika tiada; cadangkan admin memilih JPEG/PNG/WebP/AVIF |
| Visual Note-taking dan Apple Teacher ialah **pos** | Lookup v1 hanya halaman; pautan hilang dari penemuan/kurasi | Cari halaman dan pos awam, gunakan permalink sebenar |
| Kesemua 22 halaman mempunyai `featured_media=0` | Kad teks kosong walaupun kandungan mempunyai imej | Pratonton media perpustakaan pertama yang serasi dalam kandungan; pilihan untuk mematikannya |
| Tajuk halaman depan kosong | Elemen `<h2>` kosong | Tajuk antara muka “Our story” sebagai fallback, tanpa menulis rekod halaman |
| Environment mempunyai item menu tetapi `parent=0` bagi semua halaman | Hubungan pangkalan data tidak mencerminkan submenu; related-content v1 tidak menemui hubungan | Guna hubungan menu sedia ada untuk anak/adik menu; fallback hierarki asal jika perlu |
| Charging Room, iDisplay + Apple TV, Creative Studio, Network kosong dalam respons awam | Tiada kandungan editorial untuk direka-reka | Kekalkan URL dan halaman; ilustrasi dekoratif sahaja pada kad; catat untuk tindakan editor |
| Markup Elementor/legacy, heading h2→h5 dan banyak alt kosong | Isu semantik kandungan tidak boleh dibaiki secara selamat hanya dengan tema | Sokong layout/iframe legacy; jangan ubah HTML atau meneka alt; perlukan semakan editor/plugin |

Creative Week 2 ditemui pada `/creative-week-2/` (ID 1879). Showcase, Sharing dan Repository
ialah halaman sedia ada. Menu awam mempunyai kumpulan Learning, Teaching, Environment dan
Showcase. Visual Note-taking mempunyai pos ID 172; Apple Teacher pos ID 304. Pautan asal
dikekalkan, termasuk slug yang berbeza daripada tajuk paparan.

## Rujukan reka bentuk

https://www.apple.com/my/education/ juga dicapai melalui HTTPS (HTTP 200). Struktur semasa
menggunakan hero editorial besar, seksyen berjarak luas, panel media, kad berkumpulan,
dan perbezaan permukaan putih/neutral/gelap. Tema mengambil prinsip susun atur ini dengan
identiti merah/emas MCKK, font sistem dan markup sendiri. Tiada CSS, foto, video, fon,
ikon jenama, logo atau teks pemasaran Apple disalin ke pakej tema.

## Kaedah dan had

Chromium tidak mempercayai CA proksi persekitaran. Verifikasi TLS tidak dilumpuhkan:
HTML/aset diperoleh melalui Python urllib dengan trust store sistem dan dipenuhi kepada
pelayar melalui replay GET tempatan. Screenshot audit ialah replay aset awam yang disahkan,
bukan sesi pentadbir atau bukti pengalaman rangkaian semua pengguna. Iframe pihak ketiga
tidak diuji secara menyeluruh. REST `content.rendered` bukan eksport Gutenberg/raw editor
atau staging pangkalan data; keserasian plugin masih memerlukan staging yang dibenarkan.

Sebanyak 203 rekod metadata media awam turut diperiksa; fail asal tidak diimport ke tema. Perbandingan hash CSS/JS produksi dengan release v1 direkodkan dalam `production-asset-comparison-v1.json`.

CSS dan JavaScript awam sepadan dengan release v1.0.0. Perubahan yang kelihatan adalah pada tetapan/kandungan/menu; sumber PHP produksi tidak diperiksa. Kemaskini v1.1 tidak cuba menimpa tajuk tapak atau mengembalikan kandungan homepage terdahulu.
