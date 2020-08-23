$(document).ready(function(){
    $(document).on("click", ".delete", deleteUser);
    $(document).on("click", ".update", updateUser);
    $("#idUpdate").click(sendUserData);
    $(".close-form").click(closeForm);
    $(".excel-download").click(downloadExcelFile);
    $("#form").on('submit', insertProduct);
    $(".dlt-product").click(deleteProduct);
    $("#show_users").click(showUsersTable);
    $("#show_products").click(showProductsTable);
    $("#u_password").keyup(checkPasswordFields);
});
function checkPasswordFields(){
    let password = $("#u_password").val();
    let re_password = $("#u_password_repeat").val();

    let reg_password = /^((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W])).{8,}$/;


    if(!reg_password.test(password)){
        errors = true;
        $("#u_password").css("border", "1px solid red");
        $("#u_password_repeat").attr("disabled", "true");
    }else {
        $("#u_password").css("border", "");
        $("#u_password_repeat").removeAttr("disabled");
    }
}
function showUsersTable(e){
    e.preventDefault();
    $("#users_table").toggle("slow");
}
function showProductsTable(e){
    e.preventDefault();
    $("#products_table").toggle("slow");
}
function deleteProduct(e){
    e.preventDefault();
    let id = $(this).data("id");
    $.ajax({
        url: 'models/admin/products/delete.php',
        method: 'POST',
        dataType: 'json',
        data:{
            id: id
        },
        success: function(data, status, request){
            alert("Uspesno obrisan proizvod.");
            document.location.reload(true);
        },
        error: ajaxErrors
    });
}
function insertProduct(e){
    e.preventDefault(e);

        $.ajax({
            url: 'models/admin/products/insert.php',
            method: 'POST',
            dataType: 'json',
            data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
            success: function(data, status, request){
                alert("Uspesno unet proizvod.");
                document.location.reload(true);
            },
            error: ajaxErrors
        });
}
function downloadExcelFile(e){
    e.preventDefault(e);
    $.ajax({
        url: 'models/admin/users/download-excel-table.php',
        method: 'POST',
        dataType: 'json',
        data: {
            send: true
        },
        success: function(data, status, request){
            alert("Uspesno ste preuzeli spisak korisnika.");
        },
        error: ajaxErrors
    });
}
function closeForm(e){
    e.preventDefault();

    $(".admin-form").fadeOut();
}
function updateUser(e){
    e.preventDefault(e);
    let id = $(this).data("id");

    $.ajax({
        url: 'models/admin/users/update-user.php',
        method: 'POST',
        dataType: 'json',
        data: {
            id: id
        },
        success: function(data, status, request){
            $(".admin-form").fadeIn();
            fill(data);
        },
        error: ajaxErrors
    });
}
function fill(user){
    $("#usr_id_hdn").val(user.id);
    $("#u_fname").val(user.first_name);
    $("#u_lname").val(user.last_name);
    $("#u_email").val(user.email);
    $("#u_username").val(user.username);
    $("#u_password").val(user.password);
    $("#u_password_repeat").val(user.password);
}
function sendUserData(e){
    e.preventDefault();
    let id = $("#usr_id_hdn").val().trim();
    let f_name = $("#u_fname").val().trim();
    let l_name = $("#u_lname").val().trim();
    let email = $("#u_email").val().trim();
    let username = $("#u_username").val().trim();
    let password = $("#u_password").val().trim();
    let re_password = $("#u_password_repeat").val().trim();
    let data = [];

    let reg_f_name = /^[A-Z]\w{2,9}$/;
    let reg_l_name = /^[A-Z]\w{2,9}(\s[A-Z]\w{2,9})?$/;
    let reg_email = /^([a-z0-9][-a-z0-9_\+\.]*[a-z0-9])@(ict\.edu|gmail|yahoo)\.(rs|com)$/;
    let reg_username = /^((?=.*\d)(?=.*[a-z])).{8,}$/;
    let reg_password = /^((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W])).{8,}$/;


    //provera imena
    if(f_name == ""){
        errors = true;
        $("#u_fname").val("Morate uneti ime.");
        $("#u_fname").css("border", "1px solid red");
    }
    else if(!reg_f_name.test(f_name)){
        errors = true;
        $("#u_fname").val("Niste uneli ime kako treba.");
        $("#u_fname").css("border", "1px solid red");
    }else {
        errors = false;
        $("#u_fname").css("border", "");
    }
    //provera prezimena
    if(l_name == ""){
        errors = true;
        $("#u_lname").val("Morate uneti prezime.");
        $("#u_lname").css("border", "1px solid red");
    }
    else if(!reg_l_name.test(l_name)){
        errors = true;
        $("#u_lname").val("Niste uneli prezime kako treba.");
        $("#u_lname").css("border", "1px solid red");
    }else {
        errors = false;
        $("#u_lname").css("border", "");
    }
    //provera e-mail adrese
    if(email == ""){
        errors = true;
        $("#u_email").val("Morate uneti e-mail.");
        $("#u_email").css("border", "1px solid red");
    }
    else if(!reg_email.test(email)){
        errors = true;
        $("#u_email").val("Niste uneli e-mail kako treba.");
        $("#u_email").css("border", "1px solid red");
    }else {
        errors = false;
        $("#u_email").css("border", "");
    }
    //provera korisnickog imena
    if(username == ""){
        errors = true;
        $("#u_username").val("Morate uneti korisnicko ime.");
        $("#u_username").css("border", "1px solid red");
    }
    else if(!reg_username.test(username)){
        errors = true;
        $("#u_username").val("Niste uneli korisnicko ime kako treba.");
        $("#u_username").css("border", "1px solid red");
    }else {
        errors = false;
        $("#u_username").css("border", "");
    }
    //provera sifre
    if(password == ""){
        errors = true;
        alert("Morate uneti sifru.");
        $("#u_password").css("border", "1px solid red");
    }
    else {
        errors = false;
        $("#u_password").css("border", "");
    }
    if(re_password == ""){
        alert("Morate ponoviti sifru.");
    }
    else if(password != re_password){
        errors = true;
        alert("Sifre moraju biti iste.");
        $("#u_password_repeat").css("border", "1px solid red");
    }else {
        $("#u_password_repeat").css("border", "");
    }

    if(!errors){
        $.ajax({
            url: 'models/users/send-updated-data.php',
            method: 'POST',
            dataType: 'json',
            data: {
                f_name: f_name,
                l_name: l_name,
                email: email,
                username: username,
                password: password,
                id: id,
                send: true
            },
            success: function(data, status, request){
                let podaci = data;
                alert("Uspesan update !");
                document.location.reload(true);
            },
            error: ajaxErrors
        });
        }else {
            alert("Nisu uneti ispravni parametri.");
        }
}
function deleteUser(e){
    e.preventDefault();
    let id = $(this).data("id");
    
    $.ajax({
        url: 'models/admin/users/delete-user.php',
        method: 'POST',
        dataType: 'json',
        data: {
            id: id
        },
        success: function(data, status, request){
            alert(data);
            document.location.reload(true);
        },
        error: ajaxErrors
    });
}