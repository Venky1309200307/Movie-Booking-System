<?php
session_start();
$host="127.0.0.1";
$username="#username";#use your own username
$password="#password";#use your own password
$dbname="#dname";#use your own database name
$conn=mysqli_connect($host,$username,$password,$dbname);
if(!$conn){
    die("Connection failed" .mysqli_connect_error());
}

if (isset($_COOKIE['user'])) {
    $_SESSION['user'] = $_COOKIE['user'];
    header("Location: home_after.php");
    exit(); 
}

function SANITIZE($data){
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);
    return $data;
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $user=SANITIZE($_POST["user"]);
    $password=SANITIZE($_POST["password"]);

    $query=" Select * from users where user='$user' and password='$password' ";
    $result=mysqli_query($conn,$query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['user'] = $user;
        setcookie('user', $user, time() + 3600, "/"); 
        header("Location: home_after.php");
        exit();
    } else{
        $error_message = "Invalid username or password!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        .error{
            color:black;
        }
        body{
            background-image:url("https://miro.medium.com/v2/resize:fit:1200/1*OGqgHK1soFSMpjeM8Fq00w.png");
            background-repeat:no-repeat;
            background-size: 100%;
        }
        div{
            background-color:rgb(119, 5, 5);
            width:600px;
            height:200px;
            box-shadow:10px 10px 10px 10px black;
        }
        label{
            display:inline-block;
            width:150px;
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
        <h1>Login</h1>
        <div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <br><label for="user">Username:</label>&nbsp;&nbsp;&nbsp;<input type="text" id="user" name="user"><br>
                <label for="password">Password:</label>&nbsp;&nbsp;&nbsp;<input type="password" id="password" name="password"><br><br>
                <input type="submit" value="Login" style="width:100px">
            </form>
            <a href="sign_up.php" style="color:aquamarine" target="_blank"><h2>New User?Sign Up.</h2></a>
            <?php
                if(isset($error_message)){
                    echo '<p class="error">'. $error_message .'</p>';
                }
            ?>
        </div>
    </center>
</body>
</html>

<?php
mysqli_close($conn);
?>