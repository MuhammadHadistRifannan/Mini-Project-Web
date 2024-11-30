<?php

if (!isset($_POST['login']))return;

include_once "../crud/read.php";

$username = $_POST['username'];
$password = $_POST['password'];

if (ReadData($username , $password)){
    echo "Login berhasil";
    session_start();
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;
    header("Location:/dashboard/dashboard.php");
}
else {
    echo "<script>window.location.href = '../wrong_userpass/index.html';</script>";
}

?>