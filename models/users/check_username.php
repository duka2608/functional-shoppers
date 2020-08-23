<?php
    if(isset($_POST['send'])){
        header("Content-type: application/json");

        $username = $_POST['username_value'];
        require "../../config/connection.php";
        require "functions.php";
        $user = checkUsername($username);

        echo json_encode($user);
    }