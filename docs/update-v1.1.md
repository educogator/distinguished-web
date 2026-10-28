# Kemas kini v1 → v1.1.0

Pakej baharu: `dist/mckk-ads-showcase-v1.1.0.zip`. Pakej asal v1.0.0 dan checksum asal
dikekalkan dalam `dist/` sebagai pilihan rollback. Tiada pemasangan produksi dibuat oleh Codex.

## Perubahan yang akan kelihatan

- Hero panorama dengan tipografi besar dan ruang putih; pilihan **Compact split** masih
  boleh dipilih melalui Customizer. Header lebih ringkas dan kekal mudah dicapai semasa scroll.
- Panel showcase utama lebih besar, kad bergambar, permukaan neutral dan footer gelap.
- Hero TIFF tidak lagi menjadi panel kosong. Imej JPEG/PNG/WebP/AVIF/GIF atau derivatif
  web yang sah digunakan; jika tiada, ilustrasi konsep CSS asli dipaparkan dengan label.
- Kad menggunakan featured image dahulu, kemudian imej perpustakaan serasi dalam kandungan
  asal. Tiada metadata featured image diubah; pilihan ini boleh dimatikan.
- Penemuan/kurasi kini menerima halaman dan pos, termasuk Visual Note-taking dan Apple Teacher.
- Related-content mengikut menu sedia ada, walaupun halaman mempunyai `parent=0`.
- Tajuk homepage kosong mendapat label antara muka; halaman editorial yang benar-benar
  kosong mendapat bantuan carian/navigasi tanpa kandungan rekaan.

Tiada aset Apple, logo baharu, projek pelajar rekaan atau migrasi pangkalan data disertakan.
Kandungan editor, URL, plugin, galeri, pautan sumber dan susunan kandungan asal dikekalkan.

## Langkah pemasangan melalui Dashboard

1. Buat sandaran database, uploads, tema v1 dan tetapan semasa. Simpan screenshot **Appearance
   > Customize** dan penetapan menu. Uji dahulu pada staging yang dibenarkan jika tersedia.
2. Muat turun **mckk-ads-showcase-v1.1.0.zip** daripada folder `dist` di cabang GitHub projek.
   Jangan gunakan “Code > Download ZIP”, kerana itu arkib seluruh repositori.
3. Buka **Appearance > Themes > Add New > Upload Theme**. Pilih ZIP v1.1.0 dan tekan
   **Install Now**. WordPress akan memaklumkan bahawa tema dengan folder sama sudah wujud.
4. Semak bahawa nama folder ialah **mckk-ads-showcase**, versi dipasang 1.0.0 dan versi
   dimuat naik 1.1.0. Pilih **Replace current with uploaded**.
5. Jika tema masih aktif, jangan tukar tema lain. Semak versi di Theme Details. Folder tema
   dan nama kunci tetapan dikekalkan, jadi logo, menu, footer, accent dan ID kurasi v1
   sepatutnya terus digunakan. Tiada rutin reset/migrasi dijalankan.
6. Buka **Appearance > Customize > Showcase presentation**. Pilih **Editorial panorama**
   atau **Compact split**. Anda boleh mematikan pratonton imej kandungan jika mahu memilih
   featured image secara manual.
7. Untuk hero foto sebenar, pilih imej **JPEG/PNG/WebP/AVIF** dalam perpustakaan. Pilihan
   semasa berformat TIFF tidak sesuai untuk semua pelayar. Tema memaparkan ilustrasi
   sementara tanpa menukar atau memadam fail TIFF tersebut.
8. Bersihkan cache plugin/CDN/pelayar. Semak homepage, Learning, Teaching, Environment,
   Showcase, Visual Note-taking dan Apple Teacher pada telefon/iPad/desktop.

## Tetapan/kandungan yang memerlukan tindakan editor

- Tajuk tapak awam masih **Under Maintenance!** dan tagline **We Create!**. Jika ini sementara,
  ubah sendiri melalui **Settings > General** atau **Customize > Site Identity** kepada
  identiti yang diluluskan sekolah. Kod tidak menimpa pilihan anda.
- Charging Room, iDisplay + Apple TV, Creative Studio dan Network tiada kandungan dalam
  respons awam ketika audit. Tambah kandungan yang diluluskan pada rekod sedia ada;
  jangan cipta halaman gantian atau tukar slug.
- Heading h2→h4/h5, alt kosong dan markup builder lama perlu disemak dalam editor/plugin.
  Tema tidak meneka penerangan gambar atau menulis semula kandungan secara automatik.
- Semak semula iframe Drive/YouTube, pautan muat turun dan plugin pada staging sebenar.
  Replay kandungan awam bukan pengganti database/plugin produksi.

## Rollback kemas kini

Upload semula `mckk-ads-showcase-v1.0.0.zip` melalui aliran **Replace current with uploaded**
untuk kembali ke kod v1. Jangan padam tema dahulu dan jangan restore database lama semata-mata
untuk menukar kod tema. Tetapan baharu v1.1 boleh kekal tersimpan; v1 tidak menggunakannya.
Cache perlu dibersihkan selepas rollback. Kekalkan salinan tetapan dan kerja editorial terkini.

Saiz keluaran: **96,729 bait**. SHA-256:

```text
6948138e50f984f30eb4e1b5bbcc888f08e0b5e9b038b48338335ac6a7de0583
```
