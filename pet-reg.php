<?php
session_start();

// Include the database connection file
include 'connect.php';

// Check if the user is logged in
if (!isset($_SESSION['User_ID'])) {
    die("You must be logged in to register a pet.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $petName = trim($_POST['pet_name']);
    $category = $_POST['category'];
    $age = intval($_POST['age']);
    $description = isset($_POST['description']) ? trim($_POST['description']) : null;
    $sex = $_POST['sex'];

    // Validate photo upload
    $photo = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $photo = file_get_contents($_FILES['photo']['tmp_name']);
    }

    // Input validation
    if (empty($petName) || empty($category) || empty($age) || empty($sex)) {
        die("All required fields must be filled out.");
    }

    // Get the logged-in user's ID
    $userID = $_SESSION['User_ID'];

    // Use prepared statements to insert data securely
    $stmt = $conn->prepare("INSERT INTO Pet (User_ID, Pet_Name, Category, Age, Description, Sex, Photo) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ississb", $userID, $petName, $category, $age, $description, $sex, $photo);

    if ($stmt->execute()) {
        echo "Pet registered successfully!";
        header("Location: pet-profile.php"); // Redirect to a pet profile page or dashboard
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    die("Invalid request method.");
}
?>