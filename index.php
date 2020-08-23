<?php
    session_start();
    require_once "config/connection.php";

    include "views/fixed/head.php";
    include "views/fixed/header.php";
    if(!isset($_GET['page'])){
        include "views/content/home.php";
    }else {
        switch($_GET['page']){
            case 'about':
                include "views/content/about.php";
                break;
            case 'shop':
                include "views/content/shop.php";
                break;
            case 'contact':
                include "views/content/contact.php";
                break;
            case 'registration':
                include "views/content/registration.php";
                break;
            case 'author':
                include "views/content/author.php";
                break;
            case 'cart':
                include "views/content/cart.php";
                break;
            case 'admin':
            if(isset($_SESSION['user'])){
                if($_SESSION['user']->role == "administrator"){
                    include "views/content/admin.php";
                }else {
                    header("Location: views/content/404.php");
                }
            }else {
                header("Location: views/content/404.php");
            }
                break;
            case 'insert-product':
            if(isset($_SESSION['user'])){
                if($_SESSION['user']->role == "administrator"){
                    include "views/content/insert-product.php";
                }else {
                    header("Location: views/content/404.php");
                }
            }else {
                header("Location: views/content/404.php");
            }
                break;
            case 'home':
                include "views/content/home.php";
                break;
            case 'single_product':
                if(isset($_GET['id'])){
                    include "views/content/shop-single.php";
                    break;
                }else {
                    header("Location: views/content/404.php");
                }

            case 'checkout':
                include "views/content/checkout.php";
                break;
            default:
                include "views/content/home.php";
                break;
        }
    }
    include "views/fixed/footer.php";
?>
    