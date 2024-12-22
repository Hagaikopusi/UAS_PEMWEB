<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Validasi username dan password
    if (strlen($username) <= 3) {
        echo "<script>alert('Username harus lebih dari 3 karakter.');</script>";
    } elseif (strlen($password) < 6) {
        echo "<script>alert('Password harus terdiri dari minimal 6 karakter.');</script>";
    } else {
        // Cek apakah username sudah ada
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Username sudah terdaftar.');</script>";
        } else {
            // Insert ke database
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hashedPassword);

            if ($stmt->execute()) {
                echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href='login.php';</script>";
            } else {
                echo "<script>alert('Error: " . $stmt->error . "');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-image: url('https://www.itera.ac.id/wp-content/uploads/2020/01/3.jpg');
            background-size: cover; 
            background-position-y: -200px; 
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 97%;
            max-width: 400px;
        }
        .logo {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem;
        }
        .logo img {
            width: 100px;
            height: 100px;
        }
        h2 {
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
        }
        input[type="text"], input[type="password"] {
            width: 93%;
            padding: 0.75rem;
            margin: 5px 0 15px 0;
            border: 1px solid #cbd5e0; /* Gray-300 */
            border-radius: 0.375rem;
            outline: none;
        }
        input:focus {
            border: 2px solid #3182ce; /* Blue-500 */
        }
        button {
            width: 100%;
            background-color: #3182ce; /* Blue-600 */
            color: white;
            padding: 0.75rem; /* Increased padding for better button size */
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 1rem; /* Increased font size */
            transition: background-color 0.3s; /* Smooth transition */
        }
        button:hover {
            background-color: #2b6cb0; /* Blue-700 */
        }
        .footer {
            text-align: center;
            color: #718096; /* Gray-600 */
            margin-top: 1.5rem;
        }
        .footer a {
            color: #3182ce; /* Blue-600 */
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .requirements {
            color: red; /* Warna merah untuk syarat */
            font-size: 0.9rem;
            display: none; /* Sembunyikan secara default */
            margin-top: -0.5rem;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="logo">
        <img alt="Logo universitas" src="https://www.unukaltim.ac.id/wp-content/uploads/2019/12/graduate-icon-png-28-2.png"/>
    </div>
    <h2>Registrasi</h2>
    <form method="POST" onsubmit="return validateForm()">
        <input type="text" name="username" id="username" placeholder="Username" required oninput="showRequirements()">
        <div class="requirements" id="usernameRequirements">Username harus lebih dari 3 karakter.</div>
        <input type="password" name="password" id="password" placeholder="Password" required oninput="showRequirements()">
        <div class="requirements" id="passwordRequirements">Password harus terdiri dari minimal 6 karakter.</div>
        <button type="submit">Daftar</button>
    </form>
    <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
</div>

<script>
    function showRequirements() {
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        // Tampilkan syarat untuk username
        const usernameRequirements = document.getElementById('usernameRequirements');
        usernameRequirements.style.display = username.length <= 3 ? 'block' : 'none';

        // Tampilkan syarat untuk password
        const passwordRequirements = document.getElementById('passwordRequirements');
        passwordRequirements.style.display = password.length < 6 ? 'block' : 'none';
    }

    function validateForm() {
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        // Validasi username
        if (username.length <= 3) {
            alert("Username harus lebih dari 3 karakter.");
            return false;
        }

        // Validasi password
        if (password.length < 6) {
            alert("Password harus terdiri dari minimal 6 karakter.");
            return false;
        }

        // Jika semua validasi lulus
        return true;
    }
</script>

</body>
</html>

<?php
$conn->close();
?>