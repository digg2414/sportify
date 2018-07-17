<?php
    ob_start();
    session_start();

    $timezone = date_default_timezone_set('America/Chicago');

    $conn = mysqli_connect("localhost", "root", "root", "sportify");
    if(mysqli_connect_errno())
    {
        echo "Failed to connect: " . mysqli_connect_errno();
    }

    spl_autoload_register( 'autoload' );
    /**
    * autoload
    *
    * @param  string $class
    * @param  string $dir
    * @return bool
    */
    function autoload($class)
    {
        require_once('classes/' . $class . '.php');
    }
?>
