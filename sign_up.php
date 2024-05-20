<?php
session_start();
$host="127.0.0.1";
$username="root";
$password="Standard@13";
$dbname="Mylog";

$conn=mysqli_connect($host,$username,$password,$dbname);
if(!$conn){
    die("Connection failed" .mysqli_connect_error());
}

function SANITIZE($data){
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);
    return $data;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = SANITIZE($_POST["Name"]);
    $mobile_number = SANITIZE($_POST["numb"]);
    $password = SANITIZE($_POST["password"]);
    $confirm_password = SANITIZE($_POST["confirm_password"]);

    if (!preg_match("/^[a-zA-Z]*$/", $name)) {
        $error_message = "Invalid name format!";
    } elseif (!preg_match("/^[0-9]*$/", $mobile_number)) {
        $error_message = "Invalid mobile number format!";
    } elseif ($password != $confirm_password) {
        $error_message = "Passwords do not match!";
    } else {
        $query = "INSERT INTO users (user, password) VALUES ('$name', '$password')";
        if (mysqli_query($conn, $query)) {
            $_SESSION['user'] = $name;
            header("Location: login.php");
        } else {
            $error_message = "Error: " . mysqli_error($conn);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign_UP</title>
    <style>
        .error{
            color:black;
        }
        body{
            background-image:url("https://miro.medium.com/v2/resize:fit:1200/1*OGqgHK1soFSMpjeM8Fq00w.png");
            background-repeat:no-repeat;
            background-size: cover;
        }
        div{
            background-color:rgb(119, 5, 5);
            width:600px;
            height:160px;
            box-shadow:10px 10px 10px 10px black;
        }
        label{
            display: inline-block;
            width:300px;
        }
        form{
            color:aquamarine;
            font-size: 20px;
        }
        h1{
            margin-top:10%;
        }
        h2{
            color:antiquewhite
        }
    </style>
</head>
<body>
    <center>
        <h1>Sign Up</h1>
        <div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <br><label for="Name">Username:</label><input type="text" id="Name" name="Name" value="" required><br>
                <label for="numb">Mobile Number:</label><input type="text" id="numb" name="numb" value="" required><br>
                <label for="password">Password:</label><input type="password" id="password" name="password" value="" required><br>
                <label for="confirm_password">Confirm Password:</label><input type="password" id="confirm_password" name="confirm_password" value="" required><br>
                <input type="submit" value="Sign Up" style="width:100px">
            </form> 
        </div>
        <?php
        if (isset($error_message)) {
            echo '<p class="error">' . $error_message . '</p>';
        }
        ?>
    </center>
</body>
</html>