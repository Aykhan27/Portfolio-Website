<?php
    header('Content-Type: application/json');

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Retrieve form data
        $name = isset($_POST["name"]) ? $_POST["name"] : null;
        $email = isset($_POST["email"]) ? $_POST["email"] : null;
        $message = isset($_POST["message"]) ? $_POST["message"] : null;

        // Validate form data (you can add more validation as needed)
        if (empty($name) || empty($email) || empty($message)) {
            echo json_encode(array("success" => false, "message" => "Please fill in all fields."));
            exit;
        }

        // Here, you can perform database insertion or any other necessary processing
        // For example, you can use PDO to insert data into your database
        require 'config.php'; // Adjust this to match your database connection

        try {
            $stmt = $pdo->prepare("INSERT INTO contact (name, email, message) VALUES (:name, :email, :message)");
            $stmt->execute(array(
                'name' => $name,
                'email' => $email,
                'message' => $message
            ));

            echo json_encode(array("success" => true, "message" => "Data submitted successfully."));
        } catch (PDOException $e) {
            echo json_encode(array("success" => false, "message" => "Error: " . $e->getMessage()));
        }
    } else {
        echo json_encode(array("success" => false, "message" => "Invalid request"));
    }