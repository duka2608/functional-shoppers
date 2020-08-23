<?php
    function getGenders(){
        global $conn;
        $query = "SELECT * FROM gender";
        return $conn->query($query)->fetchAll();
    }

    function allProducts(){
        global $conn;
        $query = "SELECT *, p.id AS product_id FROM products p INNER JOIN images i ON p.id_image = i.id INNER JOIN color c ON p.id_color = c.id ORDER BY date ASC";
        return $conn->query($query)->fetchAll();
    }

    function deleteProduct($p_id){
        global $conn;
        $query1 = $conn->prepare("DELETE FROM gender_product WHERE id_product = '$p_id'");
        $query2 = $conn->prepare("DELETE FROM sizes_products WHERE id_product = '$p_id'");
        $query3 = $conn->prepare("DELETE FROM products WHERE id = '$p_id'");
        
        $query1->execute();
        $query2->execute();
        $query3->execute();

        $result = $query3;
        return $result;
    }

    function genderProductCount($gender_id){
        return executeQueryOneRow("SELECT COUNT(*) AS gender_count FROM gender_product WHERE id_gender = '$gender_id'");
    }

    function sizeProductCount($size_id){
        return executeQueryOneRow("SELECT COUNT(*) AS size_count FROM sizes_products WHERE id_size = '$size_id'");
    }

    function colorProductCount($color_id){
        return executeQueryOneRow("SELECT COUNT(*) AS color_count FROM products WHERE id_color = '$color_id'");
    }

    function getColors(){
        global $conn;
        $query = "SELECT * FROM color";
        return $conn->query($query)->fetchAll();
    }

    function getCategories(){
        global $conn;
        $query = "SELECT * FROM categories";
        return $conn->query($query)->fetchAll();
    }

    function getSizes(){
        global $conn;
        $query = "SELECT * FROM sizes ORDER BY id ASC";
        return $conn->query($query)->fetchAll();
    }

    function insertImage($pathOriginal, $pathNew){
        global $conn;
        $insert = $conn->prepare("INSERT INTO images VALUES('null', ?, ?)");
        $isInserted = $insert->execute([$pathOriginal, $pathNew]);
        return $isInserted;
    }

    function insertProduct($title, $description, $price, $color, $category, $image_id){
        global $conn;
        $query = "INSERT INTO products(id, title, description, price, date, id_category, id_color, id_image) VALUES ('null','$title','$description','$price',CURRENT_TIMESTAMP,'$category','$color','$image_id')";
        $insert = $conn->prepare($query);
        // $insert->bindParam(":title", $title);
        // $insert->bindParam(":description", $description);
        // $insert->bindParam(":price", $price);
        // $insert->bindParam(":category", $category);
        // $insert->bindParam(":color", $color);
        // $insert->bindParam(":image", $image_id);
        $isInserted = $insert->execute();
        return $isInserted;
    }

    function insertIntoPG($p, $g){
        global $conn;
        $insert = $conn->prepare("INSERT INTO gender_product VALUES('null', ?, ?)");
        $query = $insert->execute([$g, $p]);
        return $query;
    }

    function insertIntoPS($p, $s){
        global $conn;
        $insert = $conn->prepare("INSERT INTO sizes_products VALUES('null', ?, ?)");
        $query = $insert->execute([$s, $p]);
        return $query;
    }

    define("OFFSET", 6);
    function getProducts($limit = 0){
        global $conn;
        try {
            $select = $conn->prepare("SELECT *, p.id AS product_id FROM products p INNER JOIN images i ON p.id_image = i.id LIMIT :limit, :offset");

            $limit = ((int) $limit) * OFFSET;
            
            $select->bindParam(":limit", $limit, PDO::PARAM_INT);
            $offset = OFFSET;
            $select->bindParam(":offset", $offset, PDO::PARAM_INT);
            $select->execute();
            $products = $select->fetchAll();
            return $products;
        }catch(PDOException $ex){
            return null;
        }
    }

    function numberOfProducts(){
        return executeQueryOneRow("SELECT COUNT(*) AS products_number FROM products");
    }

    function paginationCount(){
        $result = numberOfProducts();
        $numberOfProducts = $result->products_number;
    
        return ceil($numberOfProducts / OFFSET);
    }

    function singleProduct($product_id){
        global $conn;

        $select = $conn->prepare("SELECT *, p.id AS product_id FROM products p INNER JOIN images i ON p.id_image = i.id WHERE p.id = ?");
        $select->execute([$product_id]);
        $products = $select->fetch();
        return $products;
    }

    function featuredProducts(){
        global $conn;

        $select = "SELECT *, p.id AS product_id FROM products p INNER JOIN images i ON p.id_image = i.id LIMIT 5";
        return $conn->query($select)->fetchAll();
    }

    function searchProducts($input, $limit = 0){
        global $conn;
        try {
            $input = "%".strtolower($input)."%";
            $select = $conn->prepare("SELECT *, p.id AS product_id FROM products p INNER JOIN images i ON p.id_image = i.id WHERE p.title LIKE :input LIMIT :limit, :offset");

            $limit = ((int) $limit) * OFFSET;
            
            $select->bindParam(":input", $input);
            $select->bindParam(":limit", $limit, PDO::PARAM_INT);
            $offset = OFFSET;
            $select->bindParam(":offset", $offset, PDO::PARAM_INT);
            $select->execute();
            $products = $select->fetchAll();
            return $products;
        }catch(PDOException $ex){
            return null;
        }
    }

    function numberOfSearchedProducts($input){
        $input = "%".strtolower($input)."%";
        return executeQueryOneRow("SELECT COUNT(*) AS products_number FROM products WHERE title LIKE '$input'");
    }

    function searchPaginationCount($input){
        $result = numberOfSearchedProducts($input);
        $numberOfProducts = $result->products_number;
    
        return ceil($numberOfProducts / OFFSET);
    }

    function filterGender($gender_id, $limit = 0){
        global $conn;
        try{
            $select = $conn->prepare("SELECT *, p.id AS product_id FROM products p
            INNER JOIN images i ON p.id_image = i.id INNER JOIN gender_product gp ON p.id = gp.id_product WHERE id_gender = :gender_id LIMIT :limit, :offset");

            $limit = ((int) $limit) * OFFSET;

            $select->bindParam(":gender_id", $gender_id, PDO::PARAM_INT);
            $select->bindParam(":limit", $limit, PDO::PARAM_INT);
            $offset = OFFSET;
            $select->bindParam(":offset", $offset, PDO::PARAM_INT);
            $select->execute();
            $products = $select->fetchAll();
            return $products;
        }catch(PDOException $ex){
            return null;
        }
    }

    function numberOfFilteredProducts($gender_id){
        return executeQueryOneRow("SELECT COUNT(*) AS products_number FROM gender_product WHERE id_gender = '$gender_id'");
    }

    function filterPaginationCount($gender_id){
        $result = numberOfFilteredProducts($gender_id);
        $numberOfProducts = $result->products_number;
    
        return ceil($numberOfProducts / OFFSET);
    }

    function filterColor($color_id, $limit = 0){
        global $conn;
        try{
            $select = $conn->prepare("SELECT *, p.id AS product_id FROM products p
            INNER JOIN images i ON p.id_image = i.id INNER JOIN color c ON p.id_color = c.id WHERE id_color = :color_id LIMIT :limit, :offset");

            $limit = ((int) $limit) * OFFSET;

            $select->bindParam(":color_id", $color_id, PDO::PARAM_INT);
            $select->bindParam(":limit", $limit, PDO::PARAM_INT);
            $offset = OFFSET;
            $select->bindParam(":offset", $offset, PDO::PARAM_INT);
            $select->execute();
            $products = $select->fetchAll();
            return $products;
        }catch(PDOException $ex){
            return null;
        }
    }

    function numberOfFilteredProductsColor($color_id){
        return executeQueryOneRow("SELECT COUNT(*) AS products_number FROM products WHERE id_color = '$color_id'");
    }

    function filterPaginationCountColor($color_id){
        $result = numberOfFilteredProductsColor($color_id);
        $numberOfProducts = $result->products_number;
    
        return ceil($numberOfProducts / OFFSET);
    }
        

    function countProductsInCart($user_id){
        return executeQueryOneRow("SELECT COUNT(*) AS products_in_cart FROM cart WHERE id_user = '$user_id'");
    }

    function getCart($p_ids){
        $params = [];
        foreach($p_ids as $id){
            $params[] = "?";
        }
        $params_string = implode(", ", $params);


        global $conn;
        $select = $conn->prepare("SELECT p.id AS product_id, title, price, large, small FROM products p INNER JOIN images i ON p.id_image = i.id WHERE p.id IN ($params_string)");

        $select->execute($p_ids);
        $products = $select->fetchAll();
        return $products;
    }

    function sortQuery(){
        return "SELECT *, p.id AS product_id FROM products p INNER JOIN images i ON p.id_image = i.id";
    }