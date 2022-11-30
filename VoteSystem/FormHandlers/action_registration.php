<?php
session_start();
$error = NULL;
require(dirname(__DIR__) . '/Connection.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){

$conn = new mysqli($server, $user, $pass, $dbname);

$id = $_POST['ID'];
$password = $_POST['pass'];
$conpass = $_POST['conpass'];
$erro = [];


//check if user already exist
$sql = "SELECT user FROM Logins WHERE user = '$id' ";
$query = mysqli_query($conn,$sql);

//Check that username is unique
if(mysqli_num_rows($query) != 0 || count_chars($id) == 0 ){
    $_SESSION['reg_err'][] = "User Invalid Username<br>";
    array_push($erro , $_SESSION['reg_err']);
}

//Compare passwords
if($password != $conpass){
   $_SESSION['reg_err'][] = "Passwords Did Not Match<br>";
   array_push($erro , $_SESSION['reg_err']);
}



if(count($erro) == 0){
    $sql = "INSERT INTO Logins (user, pass, permission ) VALUES ('$id' , '$password', 0)";
    if(mysqli_query($conn, $sql)){
    $_SESSION['registered'] = TRUE;
    echo "Data Entry Successful";
    header("Location:/VoteSystem/login.php");
    }
}

}

function err_display_reg(){

    if(isset($_SESSION['reg_err'])){
        $erro = $_SESSION['reg_err'];
        echo"<h3>Registration Failed</h3>";
        echo "<ul>";
        foreach($erro as $err){
            echo "<li> $err </li>";
        }
        echo "</ul>";
        unset($_SESSION['reg_err']);
    }    
}
