# UAS_PEMWEB
LINK Akses Website : 
====================================
📖 UAS PEMROGRAMAN WEBSITE 📖
====================================
Nama : Hagai Kopusi Sinulingga
NIM  : 122140059
Kelas: RB
Matakuliah : Pemrograman Website

📚 README 📚 
Website ini merupakan website Sistem Manajemen Data Mahasiswa

📖 Deskripsi
Proyek ini adalah sistem manajemen data mahasiswa yang dibangun menggunakan PHP dan MySQL. Sistem ini memungkinkan pengguna untuk mendaftar, login, dan mengelola data mahasiswa, termasuk menambah, mengedit, menghapus, dan mencari data mahasiswa.

🚀 Fitur Utama
Registrasi Pengguna: Pengguna dapat mendaftar untuk membuat akun.
Login dan Logout: Pengguna dapat masuk ke sistem dan keluar dengan aman.
Manajemen Data Mahasiswa: Pengguna dapat menambah, mengedit, menghapus, dan mencari data mahasiswa.
Dashboard: Menampilkan statistik dan informasi terkait mahasiswa.

🛠️ Teknologi yang Digunakan
Bahasa Pemrograman: PHP
Database: MySQL
Frontend: HTML, CSS, JavaScript
Framework: Tidak ada (pure PHP)

📁 Struktur Proyek
/project-root
│
├── db.php               # Koneksi ke database
├── Mahasiswa.php        # Kelas untuk manajemen data mahasiswa
├── controller.php       # Logika pengendali untuk mengelola data mahasiswa
├── index.php            # Halaman utama untuk menambah data mahasiswa
├── dashboard.php        # Halaman dashboard untuk menampilkan statistik mahasiswa
├── login.php            # Halaman login pengguna
├── register.php         # Halaman registrasi pengguna
├── logout.php           # Halaman untuk logout pengguna
└── view_students.php     # Halaman untuk melihat data mahasiswa

📜 Penjelasan Kode

1. db.php
File ini berisi kode untuk menghubungkan aplikasi dengan database MySQL. Koneksi ini digunakan di seluruh aplikasi untuk melakukan operasi CRUD (Create, Read, Update, Delete).

2. Mahasiswa.php
Kelas ini berisi metode untuk mengelola data mahasiswa, termasuk:

addMahasiswa(): Menambahkan data mahasiswa baru ke database.
editMahasiswa(): Mengedit data mahasiswa yang sudah ada.
deleteMahasiswa(): Menghapus data mahasiswa dari database.
searchMahasiswa(): Mencari data mahasiswa berdasarkan NIM atau nama.
getAllMahasiswa(): Mengambil semua data mahasiswa dari database.
3. controller.php
File ini berfungsi sebagai pengendali logika untuk aplikasi. Di sini, saya mengambil data mahasiswa dari database dan menghitung statistik seperti jumlah total mahasiswa, jumlah mahasiswa berdasarkan gender, dan jumlah mahasiswa baru.

4. index.php
Halaman ini berisi form untuk menambah data mahasiswa. Form ini memiliki validasi menggunakan JavaScript untuk memastikan bahwa semua input yang diperlukan diisi dengan benar sebelum dikirim.

5. dashboard.php
Halaman ini menampilkan statistik mahasiswa dan memberikan akses ke fitur manajemen data mahasiswa. Pengguna dapat melihat jumlah total mahasiswa, jumlah mahasiswa berdasarkan gender, dan informasi lainnya.

6. login.php dan register.php
Halaman ini memungkinkan pengguna untuk mendaftar dan masuk ke sistem. Validasi dilakukan untuk memastikan bahwa username dan password memenuhi syarat yang ditentukan.

7. view_students.php
Halaman ini menampilkan daftar semua mahasiswa yang terdaftar di database. Pengguna dapat mencari mahasiswa berdasarkan NIM atau nama.
========================================================================================================================================
**PENJELASAN CODE : **
**1.1 Manipulasi DOM dengan JavaScript (15%)
Elemen Input dalam Form**
Dalam kode yang saya buat, terdapat form untuk input data mahasiswa yang memiliki beberapa elemen input. Berikut adalah elemen-elemen input yang digunakan:
Input Teks untuk Nama:
<div class="form-group">
    <label for="name">Nama:</label>
    <input type="text" id="name" name="name" required>
    <div class="error" id="nameError"></div>
</div>
Deskripsi: Ini adalah input teks yang digunakan untuk memasukkan nama mahasiswa. Elemen ini memiliki atribut required, yang berarti pengguna harus mengisi field ini sebelum mengirimkan form.
Manipulasi DOM: JavaScript digunakan untuk memvalidasi input ini, memastikan bahwa nama tidak kosong dan tidak mengandung angka.

**Input Teks untuk NIM:**
<div class="form-group">
    <label for="nim">NIM:</label>
    <input type="text" id="nim" name="nim" required>
    <div class="error" id="nimError"></div>
</div>

Deskripsi: Input ini juga merupakan input teks yang digunakan untuk memasukkan Nomor Induk Mahasiswa (NIM). Sama seperti nama, field ini juga wajib diisi.
Manipulasi DOM: JavaScript memvalidasi bahwa NIM tidak kosong dan memiliki panjang minimal 4 karakter.
========================================================================================================================================
**1.2 Event Handling (15%)
Penjelasan Event Handling dalam Kode**

Dalam kode yang saya buat, saya menggunakan event handling untuk menangani interaksi pengguna dengan form input mahasiswa. Event handling ini penting untuk memastikan bahwa data yang dimasukkan valid sebelum dikirim. Berikut adalah beberapa contoh event yang saya tangani:

Event submit pada Form

Deskripsi: Event ini terjadi ketika saya mengklik tombol submit pada form. Saya perlu menangani event ini untuk melakukan validasi sebelum form dikirim.
Implementasi:

document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault(); // Mencegah pengiriman form jika ada kesalahan
    const isNameValid = validateName();
    const isNimValid = validateNim();
    const isProdiValid = validateProdi();
    const isGenderValid = validateGender();

    if (isNameValid && isNimValid && isProdiValid && isGenderValid) {
        this.submit(); // Kirim form jika semua validasi berhasil
    }
});

Saya menggunakan event.preventDefault() untuk mencegah form dari pengiriman default jika ada kesalahan dalam input.
Kemudian, saya memanggil fungsi validasi untuk setiap elemen input.
Jika semua validasi berhasil, saya menggunakan this.submit() untuk mengirim form.

**berikut adalah contoh lengkap dari event handling yang saya terapkan dalam kode:**

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('studentForm');
    const name = document.getElementById('name');
    const nim = document.getElementById('nim');
    const prodi = document.getElementById('prodi');
    const gender = document.getElementsByName('gender');

    // Validasi dan event handling
    form.addEventListener('submit', function (e) {
        const validName = validateName();
        const validNim = validateNim();
        const validProdi = validateProdi();
        const validGender = validateGender();
        if (!validName || !validNim || !validProdi || !validGender) {
            e.preventDefault(); // Mencegah pengiriman form jika ada kesalahan
        }
    });

    // Event listeners untuk input
    name.addEventListener('input', validateName);
    nim.addEventListener('input', validateNim);
    prodi.addEventListener('input', validateProdi);
    [...gender].forEach(radio => radio.addEventListener('change', validateGender));
});

========================================================================================================================================
2.1 Pengelolaan Data dengan PHP (20%)
Penggunaan Metode POST
Saya menggunakan metode POST untuk mengirim data dari form input mahasiswa ke server. Contoh:

<form id="studentForm" method="POST">
    <button type="submit" class="btn">Submit</button>
</form>

Parsing Data dan Validasi Setelah data dikirim, saya mem-parsing data dari $_POST dan melakukan validasi:

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $nim = trim($_POST['nim']);
    $prodi = trim($_POST['prodi']);
    $gender = $_POST['gender'];

    // Validasi
    if (empty($name) || preg_match('/\d/', $name)) {
        echo "Nama tidak valid.";
    } elseif (empty($nim) || strlen($nim) < 4) {
        echo "NIM tidak valid.";
    } elseif (empty($prodi)) {
        echo "Prodi tidak boleh kosong.";
    } elseif (empty($gender)) {
        echo "Gender harus dipilih.";
    } else {
        // Simpan ke database
        $mahasiswa->addMahasiswa($nim, $name, $prodi, $gender);
    }
}

Menyimpan Data ke Basis Data
Saya menyimpan data mahasiswa ke database, termasuk informasi user agent dan IP address:

public function addMahasiswa($nim, $name, $prodi, $gender) {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $userIP = $_SERVER['REMOTE_ADDR'];
    $stmt = $this->conn->prepare("INSERT INTO mahasiswa (nim, nama, prodi, gender, user_agent, ip_address) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nim, $name, $prodi, $gender, $userAgent, $userIP);
    $stmt->execute();
}
========================================================================================================================================
2.2 Objek PHP Berbasis OOP (10%)
Kelas Mahasiswa
Saya membuat kelas Mahasiswa dengan dua metode utama:

addMahasiswa(): Menambahkan data mahasiswa.
editMahasiswa(): Mengedit data mahasiswa.

class Mahasiswa {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function addMahasiswa($nim, $name, $prodi, $gender) {
        // Simpan data ke database
    }

    public function editMahasiswa($id, $nim, $name, $prodi, $gender) {
        // Edit data mahasiswa
    }
}

========================================================================================================================================
3.1 Pembuatan Tabel Database (5%)
Dalam proyek ini, saya membuat tabel mahasiswa di database untuk menyimpan data mahasiswa. Berikut adalah contoh SQL untuk membuat tabel tersebut:

CREATE TABLE mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(20) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    prodi VARCHAR(50) NOT NULL,
    gender ENUM('Laki-laki', 'Perempuan') NOT NULL,
    dob DATE,
    password VARCHAR(255),
    user_agent VARCHAR(255),
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

Deskripsi: Tabel ini menyimpan informasi seperti NIM, nama, program studi, gender, tanggal lahir, password, user agent, dan alamat IP

========================================================================================================================================
3.2 Konfigurasi Koneksi Database (5%)
Saya mengonfigurasi koneksi ke database menggunakan file db.php. Berikut adalah contoh kode untuk menghubungkan ke database MySQL:

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'hagaikop_universitas';

$conn = new mysqli($host, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

Deskripsi: Kode ini menginisialisasi koneksi ke database dan memeriksa apakah koneksi berhasil.

========================================================================================================================================
3.3 Manipulasi Data pada Database (10%)
Dalam kelas Mahasiswa, saya melakukan berbagai operasi untuk manipulasi data pada database, termasuk menambah, mengedit, dan menghapus data mahasiswa. Berikut adalah contoh metode dalam kelas Mahasiswa:

**Menambah Data Mahasiswa**
public function addMahasiswa($nim, $name, $prodi, $gender, $dob, $password) {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $userIP = $_SERVER['REMOTE_ADDR'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $this->conn->prepare("INSERT INTO mahasiswa (nim, nama, prodi, gender, dob, password, user_agent, ip_address) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $nim, $name, $prodi, $gender, $dob, $hashedPassword, $userAgent, $userIP);

    if ($stmt->execute()) {
        return true;
    } else {
        return $stmt->error;
    }
}


**Mengedit Data Mahasiswa**
public function editMahasiswa($id, $nim, $name, $prodi, $gender) {
    $stmt = $this->conn->prepare("UPDATE mahasiswa SET nim = ?, nama = ?, prodi = ?, gender = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $nim, $name, $prodi, $gender, $id);

    if ($stmt->execute()) {
        return true;
    } else {
        return $stmt->error;
    }
}


**Menghapus Data Mahasiswa**

public function deleteMahasiswa($id) {
    $stmt = $this->conn->prepare("DELETE FROM mahasiswa WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

========================================================================================================================================
4.1 State Management dengan Session (10%)
Menggunakan session_start()
Saya menggunakan session_start() untuk memulai sesi di PHP. Ini memungkinkan saya untuk menyimpan informasi pengguna selama sesi mereka aktif.

session_start(); // Memulai sesi
Menyimpan Informasi Pengguna ke dalam Session
Setelah pengguna berhasil login, saya menyimpan informasi pengguna ke dalam session. Contoh:

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $_SESSION['user_id'] = $user['id']; // Menyimpan ID pengguna
    $_SESSION['username'] = $user['username']; // Menyimpan username
    header("Location: dashboard.php");
    exit;
}

Deskripsi: Dengan menyimpan informasi pengguna dalam session, saya dapat mengaksesnya di halaman lain selama sesi pengguna aktif.

========================================================================================================================================
4.2 Pengelolaan State dengan Cookie dan Browser Storage (10%)
Fungsi untuk Menetapkan, Mendapatkan, dan Menghapus Cookie
Saya membuat fungsi untuk mengelola cookie di PHP. Berikut adalah contoh fungsi untuk menetapkan, mendapatkan, dan menghapus cookie:

public function setCookieValue($name, $value, $expire = 3600) {
    setcookie($name, $value, time() + $expire, "/");
}

public function getCookieValue($name) {
    return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
}

public function deleteCookie($name) {
    if (isset($_COOKIE[$name])) {
        setcookie($name, '', time() - 3600, "/");
        unset($_COOKIE[$name]);
    }
}
Deskripsi:
setCookieValue(): Menetapkan cookie dengan nama dan nilai tertentu.
getCookieValue(): Mengambil nilai cookie berdasarkan nama.
deleteCookie(): Menghapus cookie dengan nama tertentu.

Menggunakan Browser Storage untuk Menyimpan Informasi Secara Lokal
Saya juga menggunakan browser storage (localStorage) di JavaScript untuk menyimpan informasi secara lokal di sisi klien. Contoh:

// Menyimpan data ke localStorage
localStorage.setItem('username', 'JohnDoe');

// Mengambil data dari localStorage
const username = localStorage.getItem('username');

// Menghapus data dari localStorage
localStorage.removeItem('username');
Deskripsi: Dengan menggunakan localStorage, saya dapat menyimpan informasi pengguna di browser mereka, yang tetap ada meskipun mereka menutup tab atau browser.

========================================================================================================================================
Bagian Bonus: Hosting Aplikasi Web (Bobot: 20%)

1. Langkah-langkah untuk Meng-host Aplikasi Web (5%)
Untuk meng-host aplikasi web saya, berikut adalah langkah-langkah yang saya lakukan:

Persiapkan Kode: Pertama, saya memastikan semua kode aplikasi berfungsi dengan baik di lingkungan lokal. Saya melakukan pengujian untuk memastikan tidak ada bug yang tersisa.
Pilih JagoanHosting: Saya mengunjungi situs JagoanHosting dan memilih paket hosting yang sesuai dengan kebutuhan aplikasi saya. Saya memilih paket yang terjangkau dan memiliki fitur yang cukup.
Upload Kode: Saya menggunakan FTP (File Transfer Protocol) untuk mengunggah semua file aplikasi ke direktori publik di JagoanHosting, biasanya di folder public_html.
Konfigurasi Database:
Saya membuat database baru melalui cPanel JagoanHosting.
Selanjutnya, saya mengimpor struktur dan data yang diperlukan ke dalam database menggunakan phpMyAdmin yang disediakan.
Uji Aplikasi: Setelah semua file diunggah dan database dikonfigurasi, saya mengakses aplikasi melalui browser untuk memastikan semuanya berjalan dengan baik.


2. Penyedia Hosting Web yang Paling Cocok (5%)
Saya memilih JagoanHosting karena beberapa alasan:

Harga Terjangkau: JagoanHosting menawarkan paket hosting dengan harga yang kompetitif, sangat cocok untuk mahasiswa seperti saya yang memiliki anggaran terbatas.
Layanan Pelanggan: Mereka memiliki dukungan pelanggan yang responsif dan siap membantu jika saya mengalami masalah.
Fitur Lengkap: JagoanHosting menyediakan berbagai fitur seperti cPanel, instalasi CMS satu klik, dan keamanan yang baik, yang sangat membantu dalam pengelolaan aplikasi saya.

![image](https://github.com/user-attachments/assets/8aca8ccd-aca2-4db5-af81-515993274d6f)

3. Memastikan Keamanan Aplikasi Web (5%)
Untuk memastikan keamanan aplikasi web saya, saya melakukan beberapa langkah:

HTTPS: Saya menggunakan SSL yang disediakan oleh JagoanHosting untuk mengenkripsi data yang ditransfer antara server dan klien. Ini penting untuk melindungi informasi pengguna.
Validasi Input: Saya melakukan validasi input di sisi server untuk mencegah serangan seperti SQL injection dan Cross-Site Scripting (XSS).
Backup Rutin: Saya mengatur sistem backup otomatis yang disediakan oleh JagoanHosting untuk database dan file penting, sehingga data saya dapat dipulihkan jika terjadi masalah.

4. Konfigurasi Server untuk Mendukung Aplikasi Web (5%)
Dalam hal konfigurasi server, saya memanfaatkan fitur yang disediakan oleh JagoanHosting:

Web Server: JagoanHosting menggunakan server Apache yang umum digunakan dan mendukung PHP, sehingga sangat cocok untuk aplikasi saya.
Database: Saya mengonfigurasi MySQL yang disediakan oleh JagoanHosting untuk menyimpan data aplikasi.
Firewall: JagoanHosting memiliki sistem keamanan yang baik, termasuk firewall untuk melindungi server dari serangan.
Pembaruan Rutin: Saya memastikan bahwa semua perangkat lunak server diperbarui secara berkala untuk mengatasi kerentanan keamanan.
