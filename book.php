<?php
if (!isset($_COOKIE['user'])) {
    header("Location: login.php");
    exit();
}
$host="127.0.0.1";
$username="#username";#use your own username
$password="#password";#use your own password
$dbname="#dname";#use your own database name

$mysqli = new mysqli($host,$username,$password,$dbname);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
$user_id = $_COOKIE['user'];
$movie_id = $_POST['movie_id']; 

$stmt = $mysqli->prepare("INSERT INTO bookings (user_id, movie_id) VALUES (?, ?)");
$stmt->bind_param("ii", $user_id, $movie_id);


if ($stmt->execute()) {
    echo "Booking successful!";
} else {
    echo "Error booking ticket: " . $stmt->error;
}

$stmt->close();
$mysqli->close();
?>
