<?php
class Mahasiswa {
    private $conn; // Menyimpan koneksi database

    // Konstruktor untuk menginisialisasi koneksi database
    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Menambahkan data mahasiswa baru ke database
    public function addMahasiswa($nim, $name, $prodi, $gender, $dob, $password) {
        $userAgent = $_SERVER['HTTP_USER_AGENT']; // Mendapatkan informasi user agent
        $userIP = $_SERVER['REMOTE_ADDR']; // Mendapatkan alamat IP pengguna
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Menghash password

        // Menyiapkan statement SQL untuk memasukkan data mahasiswa
        $stmt = $this->conn->prepare("INSERT INTO mahasiswa (nim, nama, prodi, gender, dob, password, user_agent, ip_address) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $nim, $name, $prodi, $gender, $dob, $hashedPassword, $userAgent, $userIP);

        // Menjalankan statement dan mengembalikan hasil
        if ($stmt->execute()) {
            return true; // Berhasil menambahkan data
        } else {
            return $stmt->error; // Mengembalikan error jika gagal
        }
    }

    // Mengedit data mahasiswa yang sudah ada
    public function editMahasiswa($id, $nim, $name, $prodi, $gender) {
        $userAgent = $_SERVER['HTTP_USER_AGENT']; // Mendapatkan informasi user agent
        $userIP = $_SERVER['REMOTE_ADDR']; // Mendapatkan alamat IP pengguna

        // Menyiapkan statement SQL untuk memperbarui data mahasiswa
        $stmt = $this->conn->prepare("UPDATE mahasiswa SET nim = ?, nama = ?, prodi = ?, gender = ?, user_agent = ?, ip_address = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $nim, $name, $prodi, $gender, $userAgent, $userIP, $id);

        // Menjalankan statement dan mengembalikan hasil
        if ($stmt->execute()) {
            return true; // Berhasil mengedit data
        } else {
            return $stmt->error; // Mengembalikan error jika gagal
        }
    }

    // Menghapus data mahasiswa berdasarkan ID
    public function deleteMahasiswa($id) {
        // Menyiapkan statement SQL untuk menghapus data mahasiswa
        $stmt = $this->conn->prepare("DELETE FROM mahasiswa WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute(); // Mengembalikan hasil eksekusi
    }

    // Mencari mahasiswa berdasarkan NIM atau nama
    public function searchMahasiswa($searchTerm) {
        // Menyiapkan statement SQL untuk mencari mahasiswa
        $stmt = $this->conn->prepare("SELECT * FROM mahasiswa WHERE nim LIKE ? OR nama LIKE ?");
        $likeTerm = "%" . $searchTerm . "%"; // Menambahkan wildcard untuk pencarian
        $stmt->bind_param("ss", $likeTerm, $likeTerm);
        $stmt->execute();
        return $stmt->get_result(); // Mengembalikan hasil pencarian
    }

    // Mengambil semua data mahasiswa
    public function getAllMahasiswa() {
        return $this->conn->query("SELECT * FROM mahasiswa"); // Mengembalikan semua data mahasiswa
    }

    // Menetapkan cookie dengan nama dan nilai tertentu
    public function setCookieValue($name, $value, $expire = 3600) {
        setcookie($name, $value, time() + $expire, "/"); // Mengatur cookie
    }

    // Mengambil nilai cookie berdasarkan nama
    public function getCookieValue($name) {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null; // Mengembalikan nilai cookie jika ada
    }

    // Menghapus cookie berdasarkan nama
    public function deleteCookie($name) {
        if (isset($_COOKIE[$name])) {
            setcookie($name, '', time() - 3600, "/"); // Menghapus cookie
            unset($_COOKIE[$name]); // Menghapus dari array $_COOKIE
        }
    }
}
?>
