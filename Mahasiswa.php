<?php
class Mahasiswa {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

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

    public function editMahasiswa($id, $nim, $name, $prodi, $gender) {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $userIP = $_SERVER['REMOTE_ADDR'];

        $stmt = $this->conn->prepare("UPDATE mahasiswa SET nim = ?, nama = ?, prodi = ?, gender = ?, user_agent = ?, ip_address = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $nim, $name, $prodi, $gender, $userAgent, $userIP, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return $stmt->error;
        }
    }

    public function deleteMahasiswa($id) {
        $stmt = $this->conn->prepare("DELETE FROM mahasiswa WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function searchMahasiswa($searchTerm) {
        $stmt = $this->conn->prepare("SELECT * FROM mahasiswa WHERE nim LIKE ? OR nama LIKE ?");
        $likeTerm = "%" . $searchTerm . "%";
        $stmt->bind_param("ss", $likeTerm, $likeTerm);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getAllMahasiswa() {
        return $this->conn->query("SELECT * FROM mahasiswa");
    }

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
}
?>