<?php
    if(isset($_POST['send'])){
        $f_name = $_POST['f_name'];
        $l_name = $_POST['l_name'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $reg_fname = "/^[A-Z]\w{2,9}$/";
        $reg_lname = "/^[A-Z]\w{2,9}(\s[A-Z]\w{2,9})?$/";
        $reg_email = "/^([a-z0-9][-a-z0-9_\+\.]*[a-z0-9])@(ict\.edu|gmail|yahoo)\.(rs|com)$/";
        $reg_username = "/^((?=.*\d)(?=.*[a-z])).{8,}$/";
        $reg_password = "/^((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W])).{8,}$/";

        $errors = false;
        $data = [];

        if(!preg_match($reg_fname, $f_name)){
            $errors = true;
        }else {
            $data[] = $f_name;
        }
        if(!preg_match($reg_lname, $l_name)){
            $errors = true;
        }else {
            $data[] = $l_name;
        }
        if(!preg_match($reg_email, $email)){
            $errors = true;
        }else {
            $data[] = $email;
        }
        if(!preg_match($reg_username, $username)){
            $errors = true;
        }else {
            $data[] = $username;
        }
        if(!preg_match($reg_password, $password)){
            $errors = true;
        }else {
            $data[] = $password;
        }
        header("Content-type: application/json");
        if($errors){
            http_response_code(500);
        }else {
            require "../../config/connection.php";
            require "functions.php";
            try {
                $query =$conn->prepare("INSERT INTO users(id, first_name, last_name, email, username, password, is_active, id_role) VALUES (null,?,?,?,?,?,0,2)");
                $br = 1;
                foreach($data as $d){
                    $query->bindValue($br++, $d);
                }
                $result = $query->execute();
                if($result){
                    
                    echo json_encode("Uspesno");
                    http_response_code(201);
                }else {
                    http_response_code(400);
                }

            } catch (PDOException $ex) {
                http_response_code(500);
            }

        }

    }