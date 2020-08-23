<?php
        function checkUsername($username){
            global $conn;
            $query = "SELECT * FROM `users` WHERE username LIKE '$username'";
            return $conn->query($query)->rowCount();
        }

        function checkEmail($email){
            global $conn;
            $query = "SELECT * FROM `users` WHERE email LIKE '$email'";
            return $conn->query($query)->rowCount();
        }

        function getLoginUser($username, $password){
            global $conn;
            $query = $conn->prepare("SELECT u.id AS user_id, u.first_name, u.last_name, r.title AS role FROM users u INNER JOIN roles r ON u.id_role = r.id WHERE u.username = ? AND u.password= ?");
            
            $query->execute([$username, $password]);
            return $query;
        }

        function online($id_user){
            global $conn;
            $query = $conn->prepare("UPDATE users SET is_active = 1 WHERE id = :id");

            $query->bindParam(":id", $id_user, PDO::PARAM_INT);
            $result = $query->execute();
            return $result;
        }

        function ofline($id_user){
            global $conn;
            $query = $conn->prepare("UPDATE users SET is_active = 0 WHERE id = :id");

            $query->bindParam(":id", $id_user, PDO::PARAM_INT);
            $result = $query->execute();
            return $result;
        }

