<?php
// Get form data
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];

// Azure MySQL Database configuration
$server = "drivingrange-server.postgres.database.azure.com";
$username = "kipxnnskfp@drivingrange-server.postgres.database.azure.com";
$password = "4XD84T22D11ZS57S";
$database = "drivingrange-server";

try {
    // Connect to Azure MySQL Database
    $conn = new PDO("mysql:host=$server;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create a new table (if not exists) to store form submissions
    $sql = "CREATE TABLE IF NOT EXISTS registrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        firstName VARCHAR(50) NOT NULL,
        lastName VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL
    )";

    $conn->exec($sql);

    // Insert the form data into the table
    $stmt = $conn->prepare("INSERT INTO registrations (firstName, lastName, email) VALUES (:fname, :lname, :email)");
    $stmt->bindParam(':fname', $fname);
    $stmt->bindParam(':lname', $lname);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Redirect the user back to the homepage after submission
    header("Location: index.html");
    exit();
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
