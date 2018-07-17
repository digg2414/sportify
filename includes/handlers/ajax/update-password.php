<?php
include('../../../core/init.php');

if(!isset($_POST['username'])) {
    echo "Could not set username";
}

if(!isset($_POST['oldPassword']) || !isset($_POST['newPassword1']) || !isset($_POST['newPassword2'])) {
    echo "Not all passwords have been set.";
    exit();
}

if($_POST['oldPassword'] == "" || $_POST['newPassword1'] == "" || $_POST['newPassword2'] == "") {
    echo "Please fill in all fields.";
    exit();
}

$username = $_POST['username'];
$oldPassword = $_POST['oldPassword'];
$newPassword1 = $_POST['newPassword1'];
$newPassword2 = $_POST['newPassword2'];

$oldMD5 = md5($oldPassword);

$passwordCheck = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' AND password = '$oldMD5'");
if(mysqli_num_rows($passwordCheck) < 1) {
    echo "Password is incorrect";
    exit();
}

if($newPassword1 != $newPassword2) {
    echo "Your passwords do not match";
    exit();
}

if(preg_match('/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/', $newPassword1)) {
    echo "Your password must contain letters, numbers, and symbols";
    exit();
}

if(strlen($newPassword1) > 30 || strlen($newPassword1) < 5) {
    echo "Your passwords must be between 30 and 5 characters";
    exit();
}

$newMD5 = md5($newPassword1);

$query = mysqli_query($conn, "UPDATE users SET password = '$newMD5' WHERE username = '$username'");
echo "Update Successful";

?>
