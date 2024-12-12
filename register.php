<?php
include 'connect.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $contactNumber = $_POST['contact_number'];
    $address = $_POST['address'];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        die("Passwords do not match!");
    }

    // Hash the password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Insert data into the database
    $sql = "INSERT INTO User (First_Name, Last_Name, User_Email, Password_Hash, Contact_Num, Location)
            VALUES ('$name', '$surname', '$email', '$passwordHash', '$contactNumber', '$address')";

    if ($conn->query($sql) === TRUE) {
        // Get the newly created user's ID
        $user_id = $conn->insert_id;
        
        // Start session and store user ID
        session_start();
        $_SESSION['User_ID'] = $user_id;
        
        // Redirect to pet-reg.html after successful signup
        // Redirect to html/pet-reg.html after successful signup
header("Location: pet-reg.html");
exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

    // Close the database connection
    $conn->close();
}
?>
