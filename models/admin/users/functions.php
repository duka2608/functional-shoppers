<?php
    function getUsers(){
        global $conn;
        $query = "SELECT *, u.id AS user_id, r.title AS role FROM users u INNER JOIN roles r ON u.id_role = r.id";
        return $conn->query($query)->fetchAll();
    }

    function getRole($id){
        global $conn;
        
        $query = $conn->prepare("SELECT r.title AS role FROM users u INNER JOIN roles r ON u.id_role = r.id WHERE u.id = :id");
        $query->bindParam(":id", $id);

        $query->execute();

        return $query->fetch();
    }

    function deleteUser($id){
        global $conn;
        $query = $conn->prepare("DELETE FROM users WHERE id = :id");
        $query->bindParam(":id", $id);

        return $query->execute();
    }

    function updateUser($id){
        global $conn;
        $query = $conn->prepare("SELECT * FROM users WHERE id = :id");
        $query->bindParam(":id", $id);
        $query->execute();

        return $query->fetch();
    }

    function getAuthor(){
        global $conn;
        $query = "SELECT * FROM author a INNER JOIN images i ON a.id_image = i.id";
        return $conn->query($query)->fetchAll();
    }
