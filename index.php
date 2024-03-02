<?php

class FormHandler {
    private $formData = array();

    public function __construct() {
        // Start session if not started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Initialize session if not set
        if (!isset($_SESSION['form_data'])) {
            $_SESSION['form_data'] = array();
        }

        // Retrieve data from session
        $this->formData = $_SESSION['form_data'];
    }

    public function handleFormSubmission($data) {
        // Check if form has been submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
            // Add new data to the array
            $this->formData[] = $data;

            // Save data back to session
            $_SESSION['form_data'] = $this->formData;

            // Redirect to a clean page to avoid duplicate submissions
            $this->redirect('index.php');
        }
    }

    public function displayFormData() {
        // Display the data saved in the session
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

    // Function to perform a redirect
    private function redirect($url) {
        header("Location: $url");
        exit();
    }
}

// Process the form if there is submitted data
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

    // Create FormHandler object
    $formHandler = new FormHandler();

    // Call the method to handle form data
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
    <!-- Display the saved data -->
    <?php
    $formHandler = new FormHandler();
    $formHandler->displayFormData();
    ?>

    <!-- Form to input data -->
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
