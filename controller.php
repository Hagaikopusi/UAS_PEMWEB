<?php
require_once 'db.php'; // Menggunakan require_once untuk menghindari duplikasi
require_once 'Mahasiswa.php'; // Menggunakan require_once untuk menghindari duplikasi

$mahasiswa = new Mahasiswa($conn);

// Proses pengiriman form untuk menambah atau mengedit data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'add') {
        $name = $_POST['name'];
        $nim = $_POST['nim'];
        $prodi = $_POST['prodi'];
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $password = $_POST['password'];

        // Memperbaiki kesalahan penulisan di sini
        $result = $mahasiswa->addMahasiswa($nim, $name, $prodi, $gender, $dob, $password);
        if ($result === true) {
            $mahasiswa->setCookieValue('lastAddedNIM', $nim);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "<script>alert('Error: " . $result . "');</script>";
        }
    } elseif ($action === 'edit') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $nim = $_POST['nim'];
        $prodi = $_POST['prodi'];
        $gender = $_POST['gender'];

        $result = $mahasiswa->editMahasiswa($id, $nim, $name, $prodi, $gender);
        if ($result === true) {
            $mahasiswa->setCookieValue('lastEditedNIM', $nim);
            echo "<script>alert('Data telah di edit.');</script>";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "<script>alert('Error: " . $result . "');</script>";
        }
    } elseif ($action === 'delete') {
        $id = $_POST['id'];
        if ($mahasiswa->deleteMahasiswa($id)) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "<script>alert('Error: Could not delete the record.');</script>";
        }
    }
}

// Proses pencarian
$searchTerm = '';
if (isset($_POST['search'])) {
    $searchTerm = $_POST['searchTerm'];
    $result = $mahasiswa->searchMahasiswa($searchTerm);
} else {
    $result = $mahasiswa->getAllMahasiswa();
}

// Ambil data mahasiswa untuk edit jika id diberikan
$studentToEdit = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM mahasiswa WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultEdit = $stmt->get_result();
    $studentToEdit = $resultEdit->fetch_assoc();
    $stmt->close();
}
?>