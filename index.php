<?php

class FormHandler {
    private $formData = array();

    public function __construct() {
        // Start session if not started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['form_data'])) {
            $_SESSION['form_data'] = array();
        }

        $this->formData = $_SESSION['form_data'];
    }

    public function handleFormSubmission($data) {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
            // Add new data to the array
            $this->formData[] = $data;
            
            $_SESSION['form_data'] = $this->formData;
            $this->redirect('index.php');
        }
    }

    public function displayFormData() {
        if (!empty($this->formData)) {
            echo "<table>";
            echo "<thead><tr><th>Nama</th><th>Email</th><th>WhatsApp</th><th>Alamat</th></tr></thead>";
            echo "<tbody>";
            foreach ($this->formData as $data) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($data['nama']) . "</td>";
                echo "<td>" . htmlspecialchars($data['email']) . "</td>";
                echo "<td>" . htmlspecialchars($data['whatsapp']) . "</td>";
                echo "<td>" . htmlspecialchars($data['alamat']) . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<h2>Tidak Ada Data yang Disimpan</h2>";
        }
    }
    
    private function redirect($url) {
        header("Location: $url");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $nama = $_POST['nama'] ?? '';
    $email = $_POST['email'] ?? '';
    $whatsapp = $_POST['whatsapp'] ?? '';
    $alamat = $_POST['alamat'] ?? '';

    $data = array(
        'nama' => $nama,
        'email' => $email,
        'whatsapp' => $whatsapp,
        'alamat' => $alamat
    );
    
    $formHandler = new FormHandler();
    $formHandler->handleFormSubmission($data);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form PHP OOP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    
    <?php
    $formHandler = new FormHandler();
    $formHandler->displayFormData();
    ?>

    <h1>Form PHP OOP</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="nama">Nama:</label><br>
        <input type="text" id="nama" name="nama" required><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        
        <label for="whatsapp">Whatsapp:</label><br>
        <input type="text" id="whatsapp" name="whatsapp" required><br>
        
        <label for="alamat">Alamat:</label><br>
        <textarea id="alamat" name="alamat" required></textarea><br>
        
        <input type="submit" name="submit" value="Simpan">
    </form>
</body>
</html>
