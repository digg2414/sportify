<?php
include('../../../core/init.php');

if(isset($_POST['songId'])) {
    $songId = $_POST['songId'];

    $query = mysqli_query($conn, "UPDATE songs WITH plays = plays + 1 WHERE id = '$songId'");
}
?>