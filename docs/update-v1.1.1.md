# Kemas kini Home — v1.1.1

Disediakan 1 November 2026. Tema dikemas kini dalam repositori dan WordPress ujian tempatan sahaja.

## Perubahan

- Hero: **Vision → Teaching → Learning → Showcase**. Vision menjadi butang utama.
- Semakan REST awam pada 1 November masih menemui 22 halaman, tanpa slug `vision`.
  Andaian sementara: Vision menuju `#homepage-story-title`, bahagian **Our story**
  yang sedia ada pada Home statik. Tajuk sasaran mempunyai ruang skrol untuk header melekat.
  Jika halaman/pos awam tanpa kata laluan dengan slug `vision` diterbitkan, tema akan
  memilih permalink WordPress sebenar secara automatik. Tiada halaman atau URL direka.
- Semua pratonton kad Home memenuhi bingkai tanpa padding. Imej menggunakan crop tengah
  (`object-fit: cover`), termasuk kad showcase utama yang lebih besar dan kad blog.
  Fail media asal serta paparan penuh dalam artikel kekal.
- Elips ilustrasi CSS kini mengandungi **Create with iPad**, responsif mengikut saiz grafik.
  Teks setara disediakan untuk pembaca skrin di kapsyen hero. Label ilustrasi konsep dikekalkan.
- Versi aset dinaikkan kepada 1.1.1 untuk pembaharuan cache. Folder dan kunci tetapan tema sama.

## Keputusan semakan

- PHP: **29/29** fail lulus; JavaScript dan JSON sah.
- WordPress Coding Standards: **0 ralat, 0 amaran**.
- Suite pelayar Chromium: **38/38 lulus**, termasuk navigasi papan kekunci, tanpa JS,
  galeri, carian, halaman artikel dan zum 200%. Rekod: `qa-browser-v1.1.1.json`.
- Integrasi: **11/11 lulus**; regresi v1.1: **11/11 lulus**.
- Replay kandungan awam: **5 lebar** (360, 390, 768, 1024, 1440px), susunan empat butang
  tepat, pautan Vision sah, teks elips hadir, setiap imej kad memenuhi lebar/tinggi bingkai
  dalam toleransi 2px dan menggunakan crop tengah; **0 pelanggaran axe**, tiada limpahan
  mendatar atau imej kad rosak. Tiga senario halaman sedia ada turut lulus.
- Klik Vision disahkan menatal ke tajuk Our story di bawah header melekat.
- Pemasangan ZIP melalui pemasang tema WordPress tempatan berjaya. Snapshot sejurus
  sebelum/selepas naik taraf mengesahkan baris kandungan, metadata, tetapan tema,
  Reading dan permalink kekal. Ujian integrasi lain menggunakan rekod fixture sementara.
- Arkib: CRC sah, **38 fail**, satu folder akar `mckk-ads-showcase/`; semua kandungan
  sepadan bait demi bait dengan sumber dan tema yang benar-benar dipasang secara tempatan.

## ZIP

`dist/mckk-ads-showcase-v1.1.1.zip` — **97,899 bait**.

SHA-256:

```text
d6b3cea20e51f8e2b9ed5961c91a431b7c5f49ad24dfa354848b913d0d9787ad
```

## Pemasangan

1. Simpan sandaran tema aktif dan tetapan; cuba pada staging dahulu.
2. Di WordPress: **Appearance → Themes → Add New → Upload Theme**.
3. Pilih `mckk-ads-showcase-v1.1.1.zip`, kemudian **Install Now**.
4. Jika WordPress mengesan tema yang sama, pilih **Replace current with uploaded**.
5. Kosongkan cache WordPress/CDN/pelayar dan semak empat butang serta kad Home.
6. Untuk kembali ke versi lama, muat naik ZIP v1.1.0 dengan cara sama. Pemulihan tema
   tidak memerlukan penggantian database kandungan.

## Had pengesahan

Ujian menggunakan WordPress 6.8.3, PHP 8.4.24 dan SQLite tempatan, bukan database produksi.
Safari sebenar, peranti iOS, MySQL produksi dan pembaca skrin manual belum diuji.
Pemasang tempatan memberi amaran sambungan ke WordPress.org untuk semakan kemas kini;
pemasangan ZIP setempat berjaya dan fail yang dipasang telah dibandingkan dengan arkib.
Lighthouse tidak diulang untuk perubahan paparan kecil ini. Pratonton menggunakan replay
kandungan awam audit sebelumnya; ia bukan bukti bahawa laman produksi sudah dikemas kini.

Salinan ZIP bukan GitHub tersedia di `/workspace/artifacts/mckk-ads-showcase-v1.1.1.zip`.
Pengesahan fail tidak mengesahkan perkhidmatan muat turun Codex: masalah “Could not download
artifact” yang dilaporkan sebelum ini tidak boleh disahkan selesai dari terminal.
