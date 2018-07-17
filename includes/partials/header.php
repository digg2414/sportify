<?php
    include('core/init.php');

    if(isset($_SESSION['userLoggedIn'])) {
        $userLoggedIn = new User($conn, $_SESSION['userLoggedIn']);
        $username = $userLoggedIn->getUsername();
        echo "<script>userLoggedIn = '$username';</script>";
    }
    else {
        header("Location: register.php");
    }

?>

<html>
    <head>
        <title>Sportify - Home</title>
        <link rel="stylesheet" type="text/css" href="assets/css/main.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="assets/js/audio_script.js"></script>
    </head>
    <body>
        <script>
            var audioElement = new Audio();
            audioElement.setTrack('assets/music/bensound-acousticbreeze.mp3');
            // audioElement.audio.play();


        </script>

        <div id="mainContainer">
            <div class="topContainer">
                <?php include("includes/partials/navbar.php"); ?>

                <div id="mainViewContainer">
                    <div id="mainContent">
