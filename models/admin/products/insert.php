<?php
    if(isset($_FILES['ip_file'])){
        header("Content-type: application/json");
        $title = $_POST['ip_title'];
        $description = $_POST['ip_description'];
        $price = $_POST['ip_price'];
        $gender = isset($_POST['chbGenders'])?$_POST['chbGenders']:null;
        $color = $_POST['ip_color'];
        $category = $_POST['ip_category'];
        $size = isset($_POST['chbSizes'])?$_POST['chbSizes']:null;
        $errors = [];

        if(empty($title)){
            array_push($errors, "Morate uneti naziv proizvoda");
        }
        if(empty($description)){
            array_push($errors, "Morate uneti opis proizvoda");
        }
        if(empty($price)){
            array_push($errors, "Morate uneti cenu proizvoda");
        }
        if(empty($gender)){
            array_push($errors, "Morate uneti pol");
        }
        if($color == 0){
            array_push($errors, "Morate uneti boju");
        }
        if($category == 0){
            array_push($errors, "Morate uneti kategoriju");
        }
        if(empty($size)){
            array_push($errors, "Morate uneti velicinu");
        }

        if(!empty($errors)){
            http_response_code(400);
            echo json_encode($errors);
        }else{
            $file_name = $_FILES['ip_file']['name'];
            $tmp_location = $_FILES['ip_file']['tmp_name'];
            $file_size = $_FILES['ip_file']['size'];
            $file_type = $_FILES['ip_file']['type'];

            $errors = [];

            $allowed_types = ['image/jpg', 'image/png', 'image/jpeg'];

            if(!in_array($file_type, $allowed_types)){
                array_push($errors, "Wrong file type.");
            }
            if($file_size > 3000000){
                array_push($errors, "Max file size is 3MB");
            }

            if(count($errors) == 0){
                list($width, $height) = getimagesize($tmp_location);

                $existingImage = null;
                switch($file_type){
                    case 'image/jpeg':
                        $existingImage = imagecreatefromjpeg($tmp_location);
                        break;
                    case 'image/png':
                        $existingImage = imagecreatefrompng($tmp_location);
                        break;
                }

                $newHeight = $height/1.3;
                $newWidth = ($height/$newHeight) * $width;

                $newImage = imagecreatetruecolor($newWidth, $newHeight);

                imagecopyresampled($newImage, $existingImage, 0, 0, 0, 0, $newWidth, $newWidth, $width, $height);

                $name = time().$file_name;
                $pathNewImage = 'assets/images/small/small_'.$small;

                switch($file_type){
                    case 'image/jpeg':
                        imagejpeg($newImage, '../../../'.$pathNewImage, 75);
                        break;
                    case 'image/png':
                        imagepng($newImage, '../../../'.$pathNewImage);
                        break;
                }

                $pathOriginal = 'assets/images/'.$name;

                if(move_uploaded_file($tmp_location, '../../../'.$pathOriginal)){
                    echo "Successful upload.";
                    include "../../../config/connection.php";
                    include "functions.php";
                    try {
                        $isInserted = insertImage($pathOriginal, $pathNewImage);

                        if($isInserted){
                            $image_id = $conn->lastInsertId();
                            $insertProduct = insertProduct($title, $description, $price, $color, $category, $image_id);
                            if($insertProduct){
                                $prod_id = $conn->lastInsertId();
                                foreach($gender as $key=>$value){
                                    $pg = insertIntoPG($prod_id, $value);
                                }
                                foreach($size as $key=>$value){
                                    $ps = insertIntoPS($prod_id, $value);
                                }

                                http_response_code(204);
                            }
                        }
                    } catch (PDOException $ex) {
                        echo $ex->getMessage();
                    }
                }

                imagedestroy($existingImage);
                imagedestroy($newImage);
            }else {
                var_dump($errors);
            }
        }


    }