<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        include('core/init.php');

        if(isset($_GET['userLoggedIn'])) {
            $userLoggedIn = new User($conn, $_GET['userLoggedIn']);
        } else {
            echo "Username variable was not passed into the page. Check the openPage JS function.";
            exit(); 
        }

    } else {
        include('partials/header.php');
        include('partials/footer.php');

        $url = $_SERVER['REQUEST_URI'];
        echo "<script>openPage('$url');</script>";
        exit();
    }
?>
