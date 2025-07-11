# Forge\Uiunit Library for CodeIgniter 4

`Forge\Uiunit` adalah library modular untuk CodeIgniter 4 yang menyediakan antarmuka pengguna (UI) berbasis Bootstrap 5, dengan dukungan **sidebar dinamis**, **accordion list**, dan **layout yang dapat diperluas**. Cocok digunakan untuk membangun aplikasi dokumentasi, platform pembelajaran, dashboard admin, maupun sistem navigasi bertingkat.

---

## ✨ Fitur Utama

- ✅ Layout responsif berbasis **Bootstrap 5**
- ✅ Sidebar kiri dan kanan (opsional dan fleksibel)
- ✅ Sistem layout berbasis `extend()` dan `section()` khas CodeIgniter 4
- ✅ Komponen `ListGroupCell` untuk menampilkan menu nested (accordion)
- ✅ Dukungan warna berbeda untuk setiap level menu
- ✅ Sistem manajemen state accordion melalui `AccordionState`
- ✅ Perintah Artisan (`ui:init`) untuk inisialisasi file asset
- ✅ Konfigurasi routing bawaan

---

## 📦 Instalasi

Instal library ini melalui Composer:

```bash
composer require uiforge/uiunit
````

> Anda juga bisa menjalankan perintah berikut untuk menginisialisasi file asset (jika tersedia):

```bash
php spark uiunit:init
```

---

## 🗂️ Struktur Library

```
vendor/uiforge/uiunit/src/
├── Cells/
│   ├── ListGroupCell.php      ← Komponen Cell (logika)
│   └── list_group.php         ← View Cell (tampilan HTML)
├── Commands/
│   └── UiInit.php             ← Perintah spark `uiunit:init`
├── Config/
│   └── Routes.php             ← Routing tambahan (opsional)
├── Controllers/
│   └── AccordionState.php     ← Menyimpan dan menerapkan state accordion
├── Views/
│   └── layout.php             ← Layout HTML utama
└── README.md
```

---

## 📐 Section yang Didukung Layout

Layout `Views/layout.php` mendukung berbagai `section` modular berikut:

| Section        | Fungsi                                                       |
| -------------- | ------------------------------------------------------------ |
| `title`        | Judul halaman `<title>`                                      |
| `description`  | Meta deskripsi untuk SEO                                     |
| `keywords`     | Meta keywords untuk SEO                                      |
| `head`         | Tambahan konten dalam `<head>` (CSS, meta tambahan, dll.)    |
| `scripts`      | Tambahan JavaScript di akhir halaman                         |
| `brand`        | Komponen brand/logo (navbar dan sidebar)                     |
| `navbar`       | Konten navigasi utama (dalam navbar)                         |
| `firstSidebar` | Sidebar kiri (dengan dukungan offcanvas & responsive toggle) |
| `lastSidebar`  | Sidebar kanan (opsional, dengan toggle offcanvas)            |
| `content`      | Konten utama halaman (dalam `<main>`)                        |
| `footer`       | Footer halaman                                               |

Sidebar dapat diatur dengan parameter:

```php
$sidebar = [
    'first' => true,   // Aktifkan sidebar kiri
    'last'  => false   // Nonaktifkan sidebar kanan
];
```

---

## 🚀 Contoh Penggunaan

### 1. Controller

```php
use Forge\Uiunit\Controllers\AccordionState;

class Home extends BaseController
{
    protected AccordionState $accordionState;

    public function __construct()
    {
        $this->accordionState = new AccordionState();
    }

    public function index(): string
    {
        $items = [ /* Struktur nested array menu */ ];

        $this->accordionState->apply($items);

        return view('welcome_message', [
            'items'           => $items,
            'colors'          => ['#F5B8BB', '#BDD4FC', '#95D6AD', '#DBA3EA'],
            'accordionState'  => $this->accordionState->get(),
            'sidebar'         => ['first' => true, 'last' => false]
        ]);
    }
}
```

---

### 2. View (`welcome_message.php`)

```php
<?= $this->extend('Forge\Uiunit\Views\layout') ?>

<?= $this->section('firstSidebar') ?>
    <?= view_cell('Forge\Uiunit\Cells\ListGroupCell', [
        'items'  => $items ?? [],
        'colors' => $colors ?? []
    ]) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <section class="vh-100 border-bottom">Konten halaman...</section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script src="/assets/forge/js/index.js"></script>
<?= $this->endSection() ?>
```

---

## 🎨 Warna dan Hierarki Menu

Gunakan properti `colors` untuk memberi warna berbeda di setiap tingkat menu accordion:

```php
'colors' => ['#F5B8BB', '#BDD4FC', '#95D6AD', '#DBA3EA']
```

* Level 1 → Warna 1
* Level 2 → Warna 2
* Dst...

Jika jumlah level lebih banyak dari jumlah warna, warna akan diulang (cycled).

---

## 📝 Lisensi

Library ini dirilis dengan lisensi **MIT**. Bebas digunakan untuk proyek pribadi maupun komersial.

---

## 🙏 Terima Kasih

Terima kasih telah menggunakan `Forge\Uiunit`. Semoga library ini membantu Anda membangun antarmuka pengguna yang elegan, dinamis, dan fleksibel menggunakan CodeIgniter 4.
