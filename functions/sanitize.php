<?php
    function sanitizeFormName($name)
    {
        $name = strip_tags(str_replace(" ", "", $name));
        return $name;
    }

    function sanitizeFormString($input)
    {
        $email = strip_tags(str_replace(" ", "", $input));
        $email = ucfirst(strtolower($email));
        return $email;
    }

    function sanitizeFormPassword($password)
    {
        $password = strip_tags($password);
        return $password;
    }

    function getInput($input)
    {
        if(isset($_POST[$input]))
        {
            echo $_POST[$input]; 
        }
    }
?>
