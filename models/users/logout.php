<?php
    session_start();
    include "../../config/connection.php";
    include "functions.php";
    $offline = ofline($_SESSION["user"]->user_id);
    unset($_SESSION["user"]);
    session_destroy();
    header("Location: ../../index.php?page=home");