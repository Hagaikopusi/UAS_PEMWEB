<?php
require_once 'db.php'; // Menggunakan require_once untuk menghindari duplikasi koneksi database
require_once 'Mahasiswa.php'; // Menggunakan require_once untuk menghindari duplikasi kelas Mahasiswa

$mahasiswa = new Mahasiswa($conn); // Membuat objek Mahasiswa dengan koneksi database

// Proses pengiriman form untuk menambah atau mengedit data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action']; // Mendapatkan aksi yang diinginkan (add, edit, delete)

    if ($action === 'add') {
        // Mengambil data dari form untuk menambah mahasiswa
        $name = $_POST['name'];
        $nim = $_POST['nim'];
        $prodi = $_POST['prodi'];
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $password = $_POST['password'];

        // Memanggil metode addMahasiswa untuk menambahkan data
        $result = $mahasiswa->addMahasiswa($nim, $name, $prodi, $gender, $dob, $password);
        if ($result === true) {
            // Jika berhasil, set cookie untuk menyimpan NIM terakhir yang ditambahkan
            $mahasiswa->setCookieValue('lastAddedNIM', $nim);
            header("Location: " . $_SERVER['PHP_SELF']); // Redirect ke halaman yang sama
            exit;
        } else {
            // Menampilkan pesan error jika gagal
            echo "<script>alert('Error: " . $result . "');</script>";
        }
    } elseif ($action === 'edit') {
        // Mengambil data dari form untuk mengedit mahasiswa
        $id = $_POST['id'];
        $name = $_POST['name'];
        $nim = $_POST['nim'];
        $prodi = $_POST['prodi'];
        $gender = $_POST['gender'];

        // Memanggil metode editMahasiswa untuk memperbarui data
        $result = $mahasiswa->editMahasiswa($id, $nim, $name, $prodi, $gender);
        if ($result === true) {
            // Jika berhasil, set cookie untuk menyimpan NIM terakhir yang diedit
            $mahasiswa->setCookieValue('lastEditedNIM', $nim);
            echo "<script>alert('Data telah di edit.');</script>";
            header("Location: " . $_SERVER['PHP_SELF']); // Redirect ke halaman yang sama
            exit;
        } else {
            // Menampilkan pesan error jika gagal
            echo "<script>alert('Error: " . $result . "');</script>";
        }
    } elseif ($action === 'delete') {
        // Mengambil ID mahasiswa yang akan dihapus
        $id = $_POST['id'];
        if ($mahasiswa->deleteMahasiswa($id)) {
            header("Location: " . $_SERVER['PHP_SELF']); // Redirect ke halaman yang sama setelah penghapusan
            exit;
        } else {
            // Menampilkan pesan error jika gagal menghapus
            echo "<script>alert('Error: Could not delete the record.');</script>";
        }
    }
}

// Proses pencarian
$searchTerm = '';
if (isset($_POST['search'])) {
    $searchTerm = $_POST['searchTerm']; // Mengambil istilah pencarian dari form
    $result = $mahasiswa->searchMahasiswa($searchTerm); // Mencari mahasiswa berdasarkan istilah pencarian
} else {
    $result = $mahasiswa->getAllMahasiswa(); // Mengambil semua data mahasiswa jika tidak ada pencarian
}

// Ambil data mahasiswa untuk edit jika id diberikan
$studentToEdit = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit']; // Mengambil ID mahasiswa yang akan diedit dari URL
    $stmt = $conn->prepare("SELECT * FROM mahasiswa WHERE id = ?"); // Menyiapkan query untuk mengambil data mahasiswa
    $stmt->bind_param("i", $id); // Mengikat parameter ID
    $stmt->execute(); // Menjalankan query
    $resultEdit = $stmt->get_result(); // Mendapatkan hasil query
    $studentToEdit = $resultEdit->fetch_assoc(); // Mengambil data mahasiswa untuk diedit
    $stmt->close(); // Menutup statement
}
?>
