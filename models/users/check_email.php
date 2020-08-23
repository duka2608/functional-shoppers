<?php
    if(isset($_POST['send'])){
        header("Content-type: application/json");

        $email = $_POST['email_value'];
        require "../../config/connection.php";
        require "functions.php";
        $user = checkEmail($email);

        echo json_encode($user);
    }