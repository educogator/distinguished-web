# Laporan validasi v1.1.0

28 Oktober 2026. Pakej baharu ialah tema yang sama (`mckk-ads-showcase`), bukan tema
anak atau rekod kandungan gantian. Produksi hanya dibaca melalui permintaan awam.

## Hasil ujian sebenar

| Pemeriksaan | Hasil | Skop |
| --- | --- | --- |
| Inventori awam | 31 URL diperiksa | 22 halaman + 9 pos; respons dalam public-url-inventory-v1.1.md |
| Media awam | 203 rekod metadata | Tiada media asal dibundel dalam ZIP |
| PHP lint | 29/29 fail tema lulus | PHP 8.4.24 tempatan |
| JavaScript / theme.json | Lulus | Node syntax check, parsing JSON dan rendering WordPress |
| WordPress Coding Standards | Lulus tanpa error/warning | Ruleset penuh, PHPCS 3.13.5 / WPCS 3.2.0 |
| Suite browser asas | 38/38 lulus | Responsif, axe, keyboard, media, carian, password, Gutenberg, no-JS/failure recovery |
| Mode konfigurasi | 4/4 lulus | Posts-on-front/pagination, lightbox off, fallback menu |
| Integrasi/pemeliharaan | 11/11 lulus | Hash post/meta, URL, Reading dan menu |
| Regresi khusus v1.1 | 11/11 lulus | Lookup pos, kurasi pos, preview tanpa featured image, opt-out, TIFF, menu dan sanitization |
| Replay kandungan awam | 5/5 viewport lulus | 360, 390, 768, 1024, 1440px; tiada overflow, imej kad rosak atau pelanggaran axe pada homepage |
| Replay senario tambahan | 3/3 lulus | Environment menu parent=0, halaman kosong, pos Visual Note-taking dan imej asal |
| Kemas kini ZIP v1→v1.1 | Lulus | Native WordPress upgrader tempatan; hash post/meta/theme mods/Reading/permalinks tidak berubah |
| Arkib | Lulus | CRC, root tunggal, semua fail tema, padanan source/installed dan SHA-256 |

WordPress ujian: 6.8.3 + SQLite integration rasmi (local-only). Chromium 154, Playwright
1.64.1 dan axe Playwright 4.14.0. Replay menggunakan database tempatan berasingan dengan
31 rekod `content.rendered` awam, metadata 203 media dan menu yang diperoleh daripada HTML.
Ia bukan eksport database, raw Gutenberg atau salinan plugin produksi. URL media asal
dikekalkan sebagai rujukan dan diperoleh melalui HTTPS yang disahkan untuk rendering.

`qa-public-replay-v1.1.json` mencatat 16 pratonton imej perpustakaan pada setiap viewport.
Grafik hero TIFF diganti pada lapisan persembahan dengan konsep berlabel; fail TIFF tidak
ditukar. Screenshot sebenar rendering tempatan berada dalam `previews-v1.1/`. Tiada aset
grafik/fon/stylesheet Apple dimasukkan ke tema. Grafik konsep ialah komponen CSS asli.

## Prestasi terkawal

Lighthouse 13.0.1 desktop pada fixture tempatan: **Performance 99, Accessibility 100,
Best Practices 100**; LCP **0.8s**, CLS **0.001**, TBT **0ms**. Nilai penuh disimpan dalam
`lighthouse-local-v1.1.json`. Ini bukan ukuran prestasi produksi atau INP lapangan; imej
sebenar, embed pihak ketiga, hosting dan cache boleh mengubah hasil. Tiada pengulangan
ujian dilakukan semata-mata untuk mendapatkan skor 100.

## Bukti pemeliharaan dan kemas kini

Kunci theme mods v1, folder tema dan menu locations tidak dinamakan semula. Ujian memasang
ZIP v1.0.0 kemudian menggantikannya dengan ZIP v1.1.0 menggunakan native upgrader pada
fixture tempatan. Hash lengkap post rows, post metadata, theme mods sedia ada, homepage,
Reading dan permalink settings dibandingkan sebelum/selepas dan kekal sama. Tiada hook
migrasi/activation yang menulis kandungan, mengubah pengguna atau mencipta halaman.

CSS/JS produksi masih sepadan byte-for-byte dengan release v1 pada masa audit; hash
disimpan dalam `production-asset-comparison-v1.json`. Tetapan logo, tajuk, tagline, quote
homepage dan menu semasa dihormati. PHP/server configuration/plugin settings tidak dibaca
melalui akses pentadbir dan tidak dianggap sudah disahkan.

## Had dan tindakan editor yang masih diperlukan

- Tajuk tapak “Under Maintenance!” ialah tetapan anda. Ubah manual jika tidak lagi sesuai.
- Empat halaman Environment kosong memerlukan kandungan sebenar yang diluluskan. Tema
  hanya menyediakan bantuan navigasi; ia tidak mencipta penerangan program atau imej bukti.
- Banyak imej legacy mempunyai alt kosong dan heading lama melompat h2→h4/h5. Semakan
  manusia/editor diperlukan; ujian axe homepage tidak membuktikan seluruh laman patuh AA.
- Plugin Elementor/shortcode, iframe Drive/YouTube, downloads, AR/ePub dan submissions perlu
  diperiksa pada staging dengan plugin sebenar. Tidak semua perkhidmatan luar diuji.
- Safari/iPad sebenar, Firefox/Edge, screen reader manusia dan prestasi produksi belum diuji.
- Chromium audit memerlukan replay melalui trust store sistem kerana CA proksi tidak
  dipercayai profil Chromium. TLS, checksum dan signature verification tidak dilumpuhkan.

Tiada pembetulan dalam laporan ini telah dipasang pada produksi. Ikuti `update-v1.1.md`
untuk pemasangan manual dan rollback menggunakan ZIP v1 yang dikekalkan.
