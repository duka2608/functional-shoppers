<?php
    if(isset($_POST['send'])){
        include "functions.php";
        include "../../../config/connection.php";

        $author = getAuthor();


        $word = new COM("Word.Application");

        $word->Visible = 1;
        $word->Documents->Add();

        foreach($author as $a){
            $word->Selection->InlineShapes->AddPicture(ABSOLUTE_PATH."/assets/images/".$a->large);
            $word->Selection->TypeText("\n");
            $word->Selection->TypeText("{$a->first_name}\t");
            $word->Selection->TypeText("{$a->last_name}\n");
            $word->Selection->TypeText("{$a->intro}\n");
            $word->Selection->TypeText($a->description);
        }
        

        $fileName = "author.doc";
        $word->Documents[1]->SaveAs($fileName);
        $word->Quit();
        $word = null;

        http_response_code(204);
    }