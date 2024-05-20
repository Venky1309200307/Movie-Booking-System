<?php

$host="127.0.0.1";
$username="#username";#use your own username
$password="#password";#use your own password
$dbname="#dname";#use your own database name

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["quantity"]) && isset($_POST["date"])) {
        $quantity = $_POST["quantity"];
        $date = $_POST["date"];

        $stmt = $conn->prepare("INSERT INTO bookings (quantity, booking_date) VALUES (?, ?)");
        $stmt->bind_param("ss", $quantity, $date);

        if ($stmt->execute() === TRUE) {
            echo "<center><h2>Booking Details</h2></center>";   
            echo "<center>Quantity: $quantity</center><br>";
            echo "<center>Date: $date</center><br>";
            echo "<center>Booking successful!</center>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close statement
        $stmt->close();
    } else {
        echo "Please fill in all required fields.";
    }
} else {
    echo "Invalid request.";
}

// Close connection
$conn->close();
?>
