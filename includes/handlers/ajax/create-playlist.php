<?php
    include('../../../core/init.php');

    if(isset($_POST['name']) && isset($_POST['username'])) {
        $name = $_POST['name'];
        $username = $_POST['username'];
        $date = date("Y-m-d");

        $query = mysqli_query($conn, "INSERT INTO playlists VALUES('', '$name', '$username', '$date')");

        return $query; 
    } else {
        echo "Name or username parameters not found.";
    }
?>
