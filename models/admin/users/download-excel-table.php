<?php 
    if(isset($_POST['send'])){
        include "functions.php";
        include "../../../config/connection.php";

        $users = getUsers();

        $excel_app = new COM("Excel.Application");
        $excel_app->Visible = true;
        $excel_file = $excel_app->Workbooks->Add();

        $worksheet = $excel_file->Worksheets("Sheet1");
        $worksheet->activate();

        $field_A1 = $worksheet->Range("A1");
        $field_A1->activate;
        $field_A1->Value = "No.";

        $field_B1 = $worksheet->Range("B1");
        $field_B1->activate;
        $field_B1->Value = "First Name";

        $field_C1 = $worksheet->Range("C1");
        $field_C1->activate;
        $field_C1->Value = "Last Name";

        $field_D1 = $worksheet->Range("D1");
        $field_D1->activate;
        $field_D1->Value = "E - mail";

        $field_E1 = $worksheet->Range("E1");
        $field_E1->activate;
        $field_E1->Value = "Role";

        $num = 1;
        $br = 2;
        foreach($users as $user){
            $field_A = $worksheet->Range("A".$br);
            $field_A->activate;
            $field_A->Value = $num++;
    
            $field_B = $worksheet->Range("B".$br);
            $field_B->activate;
            $field_B->Value = $user->first_name;
    
            $field_C = $worksheet->Range("C".$br);
            $field_C->activate;
            $field_C->Value = $user->last_name;
    
            $field_D = $worksheet->Range("D".$br);
            $field_D->activate;
            $field_D->Value = $user->email;
    
            $field_E = $worksheet->Range("E".$br);
            $field_E->activate;
            $field_E->Value = $user->role;

            $br++;
        }

        $fileName = "users.xlsx";
        $excel_file->SaveAs($fileName);
        $excel_file->Close(false);
        $excel_app->Workbooks->Close();
        unset($worksheet);
        $excel_app->Quit();
        $excel_app = null;

        http_response_code(204);
    }else {
        http_response_code(400);
    }