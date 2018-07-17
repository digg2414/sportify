<?php
    require_once('core/init.php');

    require_once('functions/sanitize.php');

    if(isset($_POST['register-button']))
    {
        $username = sanitizeFormName($_POST['username']);
        $firstname = sanitizeFormString($_POST['firstname']);
        $lastname = sanitizeFormString($_POST['lastname']);
        $email = sanitizeFormString($_POST['email']);
        $password = sanitizeFormPassword($_POST['password']);
        $confirm_password = sanitizeFormPassword($_POST['confirm-password']);

        $registration = $account->register($username, $firstname, $lastname, $email, $password, $confirm_password);

        if($registration == true)
        {
            $_SESSION['userLoggedIn'] = $username; 
            header("Location: index.php");
        }
    }
?>
